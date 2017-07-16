<?php
/**
 * test Xml
 *
 * @package     BlueData
 * @subpackage  Test
 * @author      Michał Adamiak    <chajr@bluetree.pl>
 * @copyright   bluetree-service
 */
namespace Test;

use BlueData\Data\Xml;
use PHPUnit\Framework\TestCase;

class XmlTest extends TestCase
{
    const XML_TEST_FILE = 'tests/data/test.xml';
    const XML_EXPECTED = 'tests/data/expected.xml';
    const XML_SOURCE = 'tests/data/source.xml';
    const XML_DTD = 'tests/data/source_dtd.xml';
    const XML_DTD_ID = 'tests/data/source_ID.xml';
    const XML_BROKEN = 'tests/data/source_broken.xml';
    const XML_NO_EXISTS = 'none_exists.xml';

    /**
     * @var string
     */
    protected $xmlTestFilePath;

    public function setUp()
    {
        $this->tearDown();
    }

    /**
     * test creating new xml object
     */
    public function testXmlCreation()
    {
        $xml = new Xml();
        $this->assertEquals('1.0', $xml->version);
        $this->assertEquals('UTF-8', $xml->encoding);

        $xml = new Xml([
            'version'   => '1.0',
            'encoding'  =>'iso-8859-1'
        ]);
        $this->assertEquals('1.0', $xml->version);
        $this->assertEquals('iso-8859-1', $xml->encoding);
    }

    /**
     * test search nodes by attribute name
     */
    public function testSearchByAttributeAccess()
    {
        $xml = $this->createSimpleXml();

        $list = $xml->searchByAttribute($xml->childNodes, 'attr');

        $this->assertArrayHasKey('a', $list);
        $this->assertArrayHasKey('b', $list);
        $this->assertArrayHasKey('c', $list);
    }

    /**
     * test loading xml data from file
     */
    public function testFileLoading()
    {
        $xml = new Xml;
        $loaded = $xml->loadXmlFile(self::XML_SOURCE);

        $this->assertTrue($loaded);
        $this->assertFalse($xml->hasErrors());

        $root = $xml->documentElement;
        $this->assertEquals(
            'lorem ipsum',
            $root->getElementsByTagName('sub')->item(0)->nodeValue
        );
    }

    public function testFileLoadingWithParse()
    {
        $xml = new Xml;
        $loaded = $xml->loadXmlFile(self::XML_DTD, true);

        $this->assertTrue($loaded);
        $this->assertFalse($xml->hasErrors());
    }

    public function testLoadingNoneExistingFile()
    {
        $this->assertFileNotExists(self::XML_NO_EXISTS, 'test file exists');

        $xml = new Xml;
        $loaded = $xml->loadXmlFile(self::XML_NO_EXISTS);

        $this->assertFalse($loaded);
        $this->assertTrue($xml->hasErrors());
        $this->assertEquals('file_not_exists', $xml->getError());
    }

    public function testLoadingBrokenXml()
    {
        $xml = new Xml;
        $loaded = $xml->loadXmlFile(self::XML_BROKEN);

        $this->assertFalse($loaded);
        $this->assertTrue($xml->hasErrors());
        $this->assertEquals('loading_file_error', $xml->getError());
    }

    public function testLoadingNoneValidXml()
    {
        $xml = new Xml;
        $loaded = $xml->loadXmlFile(self::XML_SOURCE, true);

        $this->assertFalse($loaded);
        $this->assertTrue($xml->hasErrors());
        $this->assertEquals('parse_file_error', $xml->getError());

        $this->assertFalse($xml->clearErrors()->hasErrors());
    }

    public function testSaveXmlAsString()
    {
        $xml = $this->createSimpleXml();
        $xmlString = $xml->saveXmlFile();

        $this->assertEquals(file_get_contents(self::XML_EXPECTED), $xmlString);

        ob_start(function ($output) {
            $this->assertEquals(file_get_contents(self::XML_EXPECTED), $output);
        });
        echo $xml;
        ob_end_flush();
    }

    public function testSaveXmlAsFile()
    {
        $val = $this->createSimpleXml()
            ->saveXmlFile(self::XML_TEST_FILE);

        $this->assertTrue($val);
        $this->assertFileExists(self::XML_TEST_FILE);
    }

    public function testSaveXmlWithError()
    {
        $xml = $this->createSimpleXml();
        $val = $xml->saveXmlFile(self::XML_NO_EXISTS . '/\\');

        $this->assertFalse($val);
        $this->assertEquals($xml->getError(), 'save_file_error');
        $this->assertTrue($xml->hasErrors());
        $this->assertFileNotExists(self::XML_NO_EXISTS . '/\\');
    }

    public function testThatIdExists()
    {
        $xml = new Xml;
        $loaded = $xml->loadXmlFile(self::XML_DTD_ID);

        $this->assertTrue($loaded);
        $this->assertFalse($xml->hasErrors());

        $this->assertTrue($xml->checkId('sub-id-2'));
        $this->assertFalse($xml->checkId('unknown'));
    }

    public function testGetElementById()
    {
        $xml = new Xml;
        $loaded = $xml->loadXmlFile(self::XML_DTD_ID);

        $this->assertTrue($loaded);
        $this->assertFalse($xml->hasErrors());

        $this->assertEquals('data 1', $xml->getId('sub-id-2')->nodeValue);
    }

    public function tearDown()
    {
        if (file_exists(self::XML_TEST_FILE)) {
            unlink(self::XML_TEST_FILE);
        }
    }

    /**
     * @return Xml
     */
    protected function createSimpleXml()
    {
        $xml = new Xml;
        $root = $xml->createElement('root');

        $testNode = $xml->createElement('test');
        $testNode->setAttribute('attr', 'a');
        $root->appendChild($testNode);

        $testNode = $xml->createElement('test');
        $testNode->setAttribute('attr', 'b');
        $root->appendChild($testNode);

        $testNode = $xml->createElement('test');
        $testNode->setAttribute('attr', 'c');
        $root->appendChild($testNode);

        $xml->appendChild($root);

        return $xml;
    }
}

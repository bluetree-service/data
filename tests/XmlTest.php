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
    const BASE_DIR = 'tests/data/';
    const XML_TEST_FILE = 'tmp/test.xml';
    const XML_EXPECTED = self::BASE_DIR . 'expected.xml';
    const XML_SOURCE = self::BASE_DIR . 'source.xml';
    const XML_DTD = self::BASE_DIR . 'source_dtd.xml';
    const XML_BROKEN = self::BASE_DIR . 'source_broken.xml';
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
        $this->assertFileExists(self::XML_SOURCE, 'test file don\'t exists');

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
        $this->assertFileExists(self::XML_DTD, 'test file don\'t exists');

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
        $this->assertFileExists(self::XML_BROKEN, 'test file don\'t exists');

        $xml = new Xml;
        $loaded = $xml->loadXmlFile(self::XML_BROKEN);

        $this->assertFalse($loaded);
        $this->assertTrue($xml->hasErrors());
        $this->assertEquals('loading_file_error', $xml->getError());
    }

    public function testLoadingNoneValidXml()
    {
        $this->assertFileExists(self::XML_SOURCE, 'test file don\'t exists');

        $xml = new Xml;
        $loaded = $xml->loadXmlFile(self::XML_SOURCE, true);

        $this->assertFalse($loaded);
        $this->assertTrue($xml->hasErrors());
        $this->assertEquals('parse_file_error', $xml->getError());

        $this->assertFalse($xml->clearErrors()->hasErrors());
    }

    public function testSaveXmlAsString()
    {
        $xmlString = $this->createSimpleXml()
            ->saveXmlFile();

        $this->assertEquals(file_get_contents(self::XML_EXPECTED), $xmlString);
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
        
    }

    public function testGenerateFreeId()
    {
        //has child nodes
        //don't have child nodes
    }

    public function testThatIdExists()
    {
        
    }

    public function testGetElementById()
    {
        
    }

    public function testToString()
    {
        
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

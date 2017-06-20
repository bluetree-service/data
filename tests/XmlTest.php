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
        $xml    = new Xml();
        $root   = $xml->createElement('root');

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
        $testFile = 'tests/data/source.xml';
        $this->assertFileExists($testFile, 'test file don\'t exists');

        $xml = new Xml;
        $loaded = $xml->loadXmlFile($testFile);

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
        $testFile = 'tests/data/source_dtd.xml';
        $this->assertFileExists($testFile, 'test file don\'t exists');

        $xml = new Xml;
        $loaded = $xml->loadXmlFile($testFile, true);

        $this->assertTrue($loaded);
        $this->assertFalse($xml->hasErrors());
    }

    public function testLoadingNoneExistingFile()
    {
        $testFile = 'tests/data/none_exists.xml';
        $this->assertFileNotExists($testFile, 'test file exists');

        $xml = new Xml;
        $loaded = $xml->loadXmlFile($testFile);

        $this->assertFalse($loaded);
        $this->assertTrue($xml->hasErrors());
        $this->assertEquals('file_not_exists', $xml->getError());
    }

    public function testLoadingBrokenXml()
    {
        $testFile = 'tests/data/source_broken.xml';
        $this->assertFileExists($testFile, 'test file don\'t exists');

        $xml = new Xml;
        $loaded = $xml->loadXmlFile($testFile);

        $this->assertFalse($loaded);
        $this->assertTrue($xml->hasErrors());
        $this->assertEquals('loading_file_error', $xml->getError());
    }

    public function testLoadingNoneValidXml()
    {
        $testFile = 'tests/data/source.xml';
        $this->assertFileExists($testFile, 'test file don\'t exists');

        $xml = new Xml;
        $loaded = $xml->loadXmlFile($testFile, true);

        $this->assertFalse($loaded);
        $this->assertTrue($xml->hasErrors());
        $this->assertEquals('parse_file_error', $xml->getError());

        $this->assertFalse($xml->clearErrors()->hasErrors());
    }

    public function testSaveXmlAsString()
    {
        
    }

    public function testSaveXmlAsFile()
    {
        
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
}

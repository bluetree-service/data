<?php
/**
 * extend DOMDocument to use framework xml configuration files
 *
 * @package     BlueData
 * @subpackage  Data
 * @author      Michał Adamiak    <chajr@bluetree.pl>
 * @copyright   bluetree-service
 * @link https://github.com/bluetree-service/data/wiki/BlueData_Data_Xml Xml class documentation
 */
namespace BlueData\Data;

use DOMDocument;
use DOMNodeList;
use DOMNode;
use DOMNamedNodeMap;
use DOMDocumentType;
use DOMImplementation;
use DomElement;

class Xml extends DOMDocument
{
    /**
     * Root element
     * @var DOMElement
     */
    public $documentElement;

    /**
     * node name
     * @var string
     */
    public $nodeName;

    /**
     * node type
     * ELEMENT_NODE                 (1) element
     * ATTRIBUTE_NODE               (2) attribute
     * TEXT_NODE                    (3) text node (element or attribute)
     * CDATA_SECTION_NODE           (4) CDATA section
     * ENTITY_REFERENCE_NODE        (5) entity reference
     * ENTITY_NODE                  (6) entity
     * PROCESSING_INSTRUCTION_NODE  (7) process instruction
     * COMMENT_NODE                 (8) comment
     * DOCUMENT_NODE                (9) main document element
     * @var integer
     */
    public $nodeType;

    /**
     * node value
     * @var mixed
     */
    public $nodeValue;

    /**
     * parent node
     * @var DOMNode
     */
    public $parentNode;

    /**
     * child nodes collection
     * @var DOMNodeList
     */
    public $childNodes;

    /**
     * first child node
     * @var DOMNode
     */
    public $firstChild;

    /**
     * last child node
     * @var DOMNode
     */
    public $lastChild;

    /**
     * collection of attributes
     * @var DOMNamedNodeMap
     */
    public $attributes;

    /**
     * next node in collection
     * @var DOMNode
     */
    public $nextSibling;

    /**
     * previous node in collection
     * @var DOMNode
     */
    public $previousSibling;

    /**
     * namespace fo current node
     * @var string
     */
    public $namespaceURI;

    /**
     * reference node object
     * @var DOMDocument
     */
    public $ownerDocument;

    /**
     * number of elements in collection
     * @var integer
     */
    public $length;

    /**
     * DTD, if return documentType object
     * @var DOMDocumentType
     */
    public $doctype;

    /**
     * document, implementation type, compatible with document mime type
     * @var DOMImplementation
     */
    public $implementation;

    /**
     * error information
     * @var string
     */
    public $_error = null;

    /**
     * last free id
     * @var string
     */
    protected $_idList;

    /**
     * default constructor options
     *
     * @var array
     */
    protected $_options = [
        'version'   => '1.0',
        'encoding'  => 'UTF-8'
    ];

    /**
     * start DOMDocument, optionally create new document
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->_options = array_merge($this->_options, $options);

        parent::__construct(
            $this->_options['version'],
            $this->_options['encoding']
        );
    }

    /**
     * load xml file, optionally check file DTD
     *
     * @param string $url xml file path
     * @param boolean $parse if true will check file DTD
     * @return boolean
     * @example loadXmlFile('cfg/config.xml', true)
     */
    public function loadXmlFile($url, $parse = false)
    {
        $this->preserveWhiteSpace    = false;
        $bool                        = @file_exists($url);

        if (!$bool) {
            $this->_error = 'file_not_exists';
            return false;
        }

        $bool = $this->load($url);
        if (!$bool) {
            $this->_error = 'loading_file_error';
            return false;
        }

        if ($parse && !@$this->validate()) {
            $this->_error = 'parse_file_error';
            return false;
        }

        return true;
    }

    /**
     * save xml file, optionally will return as string
     *
     * @param string $url xml file path
     * @param boolean $asString if true return as string
     * @return string|boolean
     * 
     * @example saveXmlFile('path/filename.xml'); save to file
     * @example saveXmlFile(false, true) will return as simple text
     */
    public function saveXmlFile($url, $asString = false)
    {
        $this->formatOutput = true;

        if ($url) {
            $bool = $this->save($url);
            if (!$bool) {
                $this->_error = 'save_file_error';
                return false;
            }
        }

        if ($asString) {
            return $this->saveXML();
        }

        return true;
    }

    /**
     * generate free numeric id
     *
     * @return integer|boolean return ID or null if there wasn't any node
     */
    public function getFreeId()
    {
        $root = $this->documentElement;

        if ($root->hasChildNodes()) {
            $tab    = $this->_searchByAttribute($root->childNodes, 'id');
            $tab[]  = 'create_new_free_id';
            $id     = array_keys($tab, 'create_new_free_id');

            unset($tab);
            $this->_idList = $id;
            return $id[0];
        }

        return null;
    }

    /**
     * search for all nodes with given attribute
     * return list of nodes with attribute value as key
     *
     * @param DOMNodeList $node
     * @param string $value attribute value to search
     * @param array|boolean $list list of find nodes for recurrence
     * @return array
     */
    protected function _searchByAttribute(
        DOMNodeList $node,
        $value,
        array $list = []
    ) {
        /** @var DomElement $child */
        foreach ($node as $child) {
            if($child->nodeType === 1){

                if ($child->hasChildNodes()) {
                    $list = $this->_searchByAttribute(
                        $child->childNodes,
                        $value,
                        $list
                    );
                }

                $id = $child->getAttribute($value);
                if ($id) {
                    $list[$id] = $child;
                }
            }
        }

        return $list;
    }

    /**
     * search node for elements that contains element with give attribute
     *
     * @param DOMNodeList $node
     * @param string $value attribute value to search
     * @return array
     */
    public function searchByAttribute(DOMNodeList $node, $value)
    {
        return $this->_searchByAttribute($node, $value);
    }

    /**
     * check that element with given id exists
     *
     * @param string $id
     * @return boolean return true if exists
     */
    public function checkId($id)
    {
        $id = $this->getElementById($id);

        if ($id) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * shorter version to return element with given id
     *
     * @param string $id
     * @return DOMElement
     */
    public function getId($id)
    {
        $id = $this->getElementById($id);
        return $id;
    }

    /**
     * check that Xml object has error
     * 
     * @return bool
     */
    public function hasErrors()
    {
        if ($this->_error) {
            return true;
        }

        return false;
    }

    /**
     * clear error information
     * 
     * @return Xml
     */
    public function clearErrors()
    {
        $this->_error = null;
        return $this;
    }

    /**
     * return error code
     * 
     * @return string
     */
    public function getError()
    {
        return $this->_error;
    }

    /**
     * return xml string
     * 
     * @return bool|string
     */
    public function __toString()
    {
        return $this->saveXmlFile(false, true);
    }
}

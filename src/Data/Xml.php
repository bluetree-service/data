<?php
/**
 * extend DOMDocument to use framework xml configuration files
 *
 * @package     BlueData
 * @subpackage  Data
 * @author      Michał Adamiak    <chajr@bluetree.pl>
 * @copyright   bluetree-service
 */
namespace BlueData\Data;

use DOMDocument;
use DOMNodeList;
use DomElement;

class Xml extends DOMDocument
{
    /**
     * Root element
     * @var DOMElement
     */
    public $documentElement;

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
     * child nodes collection
     * @var DOMNodeList
     */
    public $childNodes;

    /**
     * error information
     * @var string
     */
    public $error = null;

    /**
     * last free id
     * @var string
     */
    protected $idList;

    /**
     * default constructor options
     *
     * @var array
     */
    protected $options = [
        'version' => '1.0',
        'encoding' => 'UTF-8'
    ];

    /**
     * start DOMDocument, optionally create new document
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->options = array_merge($this->options, $options);

        parent::__construct(
            $this->options['version'],
            $this->options['encoding']
        );
    }

    /**
     * load xml file, optionally check file DTD
     *
     * @param string $path xml file path
     * @param boolean $parse if true will check file DTD
     * @return boolean
     * @example loadXmlFile('cfg/config.xml', true)
     */
    public function loadXmlFile($path, $parse = false)
    {
        $this->preserveWhiteSpace = false;
        $bool = file_exists($path);

        if (!$bool) {
            $this->error = 'file_not_exists';
            return false;
        }

        $bool = @$this->load($path);
        if (!$bool) {
            $this->error = 'loading_file_error';
            return false;
        }

        if ($parse && !@$this->validate()) {
            $this->error = 'parse_file_error';
            return false;
        }

        return true;
    }

    /**
     * save xml file, optionally will return as string
     *
     * @param string $path xml file path
     * @return string|boolean
     *
     * @example saveXmlFile('path/filename.xml'); save to file
     * @example saveXmlFile() will return as simple text
     */
    public function saveXmlFile($path = '')
    {
        $this->formatOutput = true;

        if ($path) {
            $bool = @$this->save($path);
            if (!$bool) {
                $this->error = 'save_file_error';
                return false;
            }

            return true;
        }

        return $this->saveXML();
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
    protected function searchByAttributeRecurrent(
        DOMNodeList $node,
        $value,
        array $list = []
    ) {
        /** @var DomElement $child */
        foreach ($node as $child) {
            if ($child->nodeType === 1) {
                if ($child->hasChildNodes()) {
                    $list = $this->searchByAttributeRecurrent(
                        $child->childNodes,
                        $value,
                        $list
                    );
                }

                $attribute = $child->getAttribute($value);
                if ($attribute) {
                    $list[$attribute] = $child;
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
        return $this->searchByAttributeRecurrent($node, $value);
    }

    /**
     * check that element with given id exists
     *
     * @param string $elementId
     * @return boolean return true if exists
     */
    public function checkId($elementId)
    {
        if ($this->getElementById($elementId)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * shorter version to return element with given id
     *
     * @param string $elementId
     * @return DOMElement
     */
    public function getId($elementId)
    {
        return $this->getElementById($elementId);
    }

    /**
     * check that Xml object has error
     *
     * @return bool
     */
    public function hasErrors()
    {
        if ($this->error) {
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
        $this->error = null;
        return $this;
    }

    /**
     * return error code
     *
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * return xml string
     *
     * @return bool|string
     */
    public function __toString()
    {
        return $this->saveXmlFile();
    }
}

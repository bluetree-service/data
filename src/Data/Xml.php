<?php

/**
 * extend DOMDocument to use framework xml configuration files
 *
 * @package     BlueData
 * @subpackage  Data
 * @author      Michał Adamiak    <chajr@bluetree.pl>
 * @copyright   bluetree-service
 */

declare(strict_types=1);

namespace BlueData\Data;

use DOMDocument;
use DOMNodeList;
use DomElement;

class Xml extends DOMDocument
{
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
     * error information
     * @var string
     */
    public $error = '';

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
        $this->options = \array_merge($this->options, $options);

        parent::__construct(
            $this->options['version'],
            $this->options['encoding']
        );
    }

    /**
     * load xml file, optionally check file DTD
     *
     * @param string $path xml file path
     * @param bool $parse if true will check file DTD
     * @return bool
     * @example loadXmlFile('cfg/config.xml', true)
     */
    public function loadXmlFile(string $path, bool $parse = false): bool
    {
        $this->preserveWhiteSpace = false;
        $bool = \file_exists($path);

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
     * @return string|bool
     *
     * @example saveXmlFile('path/filename.xml'); save to file
     * @example saveXmlFile() will return as simple text
     */
    public function saveXmlFile(string $path = '')
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
     * @param array|bool $list list of find nodes for recurrence
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

//    protected function processNode()
//    {
//        if ($child->hasChildNodes()) {
//            $list = $this->searchByAttributeRecurrent(
//                $child->childNodes,
//                $value,
//                $list
//            );
//        }
//
//        $attribute = $child->getAttribute($value);
//        if ($attribute) {
//            $list[$attribute] = $child;
//        }
//    }

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
     * @return bool return true if exists
     */
    public function checkId(string $elementId): bool
    {
        return (bool)$this->getElementById($elementId);
    }

    /**
     * shorter version to return element with given id
     *
     * @param string $elementId
     * @return DOMElement
     */
    public function getId(string $elementId): DOMElement
    {
        return $this->getElementById($elementId);
    }

    /**
     * check that Xml object has error
     *
     * @return bool
     */
    public function hasErrors(): bool
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
    public function clearErrors(): self
    {
        $this->error = null;
        return $this;
    }

    /**
     * return error code
     *
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * return xml string
     *
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->saveXmlFile();
    }
}

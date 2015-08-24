<?php
/**
 * create basically object to store data or models and allows to easily access to object
 *
 * @package     BlueData
 * @subpackage  Data
 * @author      Michał Adamiak    <chajr@bluetree.pl>
 * @copyright   bluetree-service
 * @link https://github.com/bluetree-service/data/wiki/BlueData_Base_BlueObject Object class documentation
 */
namespace BlueData\Data;

use BlueData\Base\BlueObject;
use Serializable;
use ArrayAccess;
use Iterator;

class Object implements Serializable, ArrayAccess, Iterator
{
    use BlueObject;
}

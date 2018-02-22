<?php
namespace App\Lib;

use Iterator;

/**
 * [ListObject a list object to represent an interable list type returned by the API]
 * Author: Drew Cronje
 * Contact: drew@silvertree.services
 * Date: 02-2018
 */

class ListObject implements Iterator
{

    /**
     * [$list the list of objects]
     * @type {Array}
     */
    public $list = [];

    /**
     * [$count the count of objects]
     * @type {Number}
     */
    public $count = 0;

    /**
     * [$skip objects skipped]
     * @type {Number}
     */
    public $skip = 0;

    /**
     * [$limit limit on return]
     * @type {Number}
     */
    public $limit = 1000;

    /**
     * [$index internal index used for iteration]
     * @type {Number}
     */
    private $index = 0;

    /**
     * [$propertyKeys internal array used for iterating object properties]
     * @type {Array}
     */
    private $propertyKeys = ['list', 'count', 'skip', 'limit'];

    function __construct($list = [], $count = 0, $skip = 0, $limit = 1000)
    {
        $this->list = $list;
        $this->count = $count;
        $this->skip = $skip;
        $this->limit = $limit;
    }

    /**
     * [current get value of curretn property]
     * @return {Any} The Value
     */
    public function current()
    {
        return $this->{$this->propertyKeys[$this->index]};
    }

    /**
     * [next increment the iterator]
     * @return {Void}
     */
    public function next()
    {
        $this->index ++;
    }

    /**
     * [key get the iterator index]
     * @return {Integer} the index
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * [valid check current index is valid]
     * @return {Boolean} validity
     */
    public function valid()
    {
        return isset($this->{$this->propertyKeys[$this->index]});
    }

    /**
     * [rewind reset iterator]
     * @return {Void}
     */
    public function rewind()
    {
        $this->index = 0;
    }

    /**
     * [reverse reverse iteration order]
     * @return {Void}
     */
    public function reverse()
    {
        $this->propertyKeys = array_reverse($this->propertyKeys);
        $this->rewind();
    }

}

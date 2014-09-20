<?php

namespace Sabre\VObject;

/**
 * A node is the root class for every element in an iCalendar of vCard object.
 *
 * @copyright Copyright (C) 2007-2014 fruux GmbH. All rights reserved.
 * @author Evert Pot (http://evertpot.com/)
 * @license http://sabre.io/license/ Modified BSD License
 */
abstract class Node implements \IteratorAggregate, \ArrayAccess, \Countable {

    /**
     * The following constants are used by the validate() method.
     */
    const REPAIR = 1;

    /**
     * Reference to the parent object, if this is not the top object.
     *
     * @var Node
     */
    public $parent;

    /**
     * Iterator override
     *
     * @var ElementList
     */
    protected $iterator = null;

    /**
     * The root document
     *
     * @var Component
     */
    protected $root;

    /**
     * Serializes the node into a mimedir format
     *
     * @return string
     */
    abstract function serialize();

    /**
     * This method returns an array, with the representation as it should be
     * encoded in json. This is used to create jCard or jCal documents.
     *
     * @return array
     */
    abstract function jsonSerialize();

    /* {{{ IteratorAggregator interface */

    /**
     * Returns the iterator for this object
     *
     * @return ElementList
     */
    function getIterator() {

        if (!is_null($this->iterator))
            return $this->iterator;

        return new ElementList([$this]);

    }

    /**
     * Sets the overridden iterator
     *
     * Note that this is not actually part of the iterator interface
     *
     * @param ElementList $iterator
     * @return void
     */
    function setIterator(ElementList $iterator) {

        $this->iterator = $iterator;

    }

    /**
     * Validates the node for correctness.
     *
     * The following options are supported:
     *   Node::REPAIR - May attempt to automatically repair the problem.
     *
     * This method returns an array with detected problems.
     * Every element has the following properties:
     *
     *  * level - problem level.
     *  * message - A human-readable string describing the issue.
     *  * node - A reference to the problematic node.
     *
     * The level means:
     *   1 - The issue was repaired (only happens if REPAIR was turned on)
     *   2 - An inconsequential issue
     *   3 - A severe issue.
     *
     * @param int $options
     * @return array
     */
    function validate($options = 0) {

        return [];

    }

    /* }}} */

    /* {{{ Countable interface */

    /**
     * Returns the number of elements
     *
     * @return int
     */
    function count() {

        $it = $this->getIterator();
        return $it->count();

    }

    /* }}} */

    /* {{{ ArrayAccess Interface */


    /**
     * Checks if an item exists through ArrayAccess.
     *
     * This method just forwards the request to the inner iterator
     *
     * @param int $offset
     * @return bool
     */
    function offsetExists($offset) {

        $iterator = $this->getIterator();
        return $iterator->offsetExists($offset);

    }

    /**
     * Gets an item through ArrayAccess.
     *
     * This method just forwards the request to the inner iterator
     *
     * @param int $offset
     * @return mixed
     */
    function offsetGet($offset) {

        $iterator = $this->getIterator();
        return $iterator->offsetGet($offset);

    }

    /**
     * Sets an item through ArrayAccess.
     *
     * This method just forwards the request to the inner iterator
     *
     * @param int $offset
     * @param mixed $value
     * @return void
     */
    function offsetSet($offset, $value) {

        $iterator = $this->getIterator();
        $iterator->offsetSet($offset,$value);

    // @codeCoverageIgnoreStart
    //
    // This method always throws an exception, so we ignore the closing
    // brace
    }
    // @codeCoverageIgnoreEnd

    /**
     * Sets an item through ArrayAccess.
     *
     * This method just forwards the request to the inner iterator
     *
     * @param int $offset
     * @return void
     */
    function offsetUnset($offset) {

        $iterator = $this->getIterator();
        $iterator->offsetUnset($offset);

    // @codeCoverageIgnoreStart
    //
    // This method always throws an exception, so we ignore the closing
    // brace
    }
    // @codeCoverageIgnoreEnd

    /* }}} */
}

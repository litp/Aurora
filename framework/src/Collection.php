<?php

class Collection implements \IteratorAggregate, \Countable
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getIterator()
    {
        return \ArrayIterator($this->data);
    }

    public function count()
    {
        return count($this->data);
    }

    public function __get($property)
    {
        if (array_key_exists($property)) {
            return $this->data[$property];
        }

        return null;
    }

    public function __set($property, $value)
    {
        $this->data[$property] = $value;
    }
}

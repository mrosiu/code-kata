<?php

class RecentlyUsed implements RecentlyUsedInterface, Countable
{
    protected $capacity;
    protected $container;

    public function __construct()
    {
        $this->container = array();
        $this->capacity = null;
    }

    public function push($value)
    {
        if (null === $value) {
            throw new Exception ('Nie pusty!');
        }

        $position = array_search($value, $this->container);
        if (false !== $position) {
            unset($this->container[$position]);
            $this->container = array_values($this->container);
        }

        array_unshift($this->container, $value);

        $this->processCapacityLimit();
    }

    protected function processCapacityLimit()
    {
        if (null != $this->capacity && count($this) > $this->capacity) {
            $this->container = array_slice($this->container, 0, $this->capacity);
        }
    }

    public function pop()
    {
        if (count($this) == 0) {
            throw new Exception('Pusto');
        }

        return array_shift($this->container);
    }

    public function lookup($index)
    {
        if (array_key_exists($index, $this->container)) {
            return $this->container[$index];
        }
        throw new Exception('Ni ma');
    }

    public function setCapacity($capacity)
    {
        if ((int) $capacity <= 0) {
            throw new InvalidArgumentException('Złe capacity');
        }
        $this->capacity = $capacity;
        $this->processCapacityLimit();
    }

    public function count()
    {
        return count($this->container);
    }
}

interface RecentlyUsedInterface
{
    public function push($value);
    public function pop();
    public function lookup($index);
    public function setCapacity($capacity);
}

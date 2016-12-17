<?php

namespace Miviskin\Visitor;

trait PropertyReadableTrait
{
    /**
     * Dynamically get property.
     *
     * @param string $property
     *
     * @return null|string
     */
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    /**
     * Dynamically isset property.
     *
     * @param string $property
     *
     * @return bool
     */
    public function __isset($property)
    {
        return property_exists($this, $property);
    }

    /**
     * Dynamically set property.
     *
     * @param string $property
     * @param string $value
     *
     * @throws \LogicException
     */
    public function __set($property, $value)
    {
        throw new \LogicException(
            sprintf('Unable to set property %s in %s', $property, get_class($this))
        );
    }

    /**
     * Dynamically delete property.
     *
     * @param string $property
     *
     * @throws \LogicException
     */
    public function __unset($property)
    {
        throw new \LogicException(
            sprintf('Unable to delete property %s in %s', $property, get_class($this))
        );
    }
}

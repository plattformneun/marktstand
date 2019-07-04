<?php

namespace Marktstand\Search;

use Marktstand\Contracts\Indexable;

abstract class Index implements Indexable
{
    /**
     * The entity that should be indexed.
     *
     * @var mixed
     */
    protected $entity;

    /**
     * Create a new index instance.
     *
     * @param mixed $entity
     */
    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    /**
     * Get the indexable key.
     *
     * @return string
     */
    abstract public function getKey();

    /**
     * Get the indexable attributes.
     *
     * @return array
     */
    abstract public function toArray();

    /**
     * Get the property from the entity.
     *
     * @param string $property
     *
     * @return mixed
     */
    public function __get($property)
    {
        return $this->entity->{$property};
    }

    /**
     * Get the json serializeable attributes.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Get the string represantion of the index.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) json_encode($this);
    }
}

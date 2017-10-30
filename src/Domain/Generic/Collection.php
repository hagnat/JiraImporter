<?php

namespace JiraImporter\Domain\Generic;

final class Collection extends \ArrayIterator
{
    private $collectionType;

    private $startAt;

    private $maxResults;

    private $total;

    private $isLast;

    /**
     * @param string $collectionType
     * @param array $data
     * @param int $flags
     * @throws \DomainException
     */
    public function __construct($collectionType, array $data = array(), int $flags = 0)
    {
        $this->validateCollectionType($collectionType);

        $this->collectionType = $collectionType;

        $this->startAt = 0;
        $this->maxResults = 10;
        $this->total = 0;
        $this->isLast = false;

        parent::__construct($data, $flags);
    }

    private function validateCollectionType($collectionType)
    {
        if (false == is_a($collectionType, \Serializable::class, true)) {
            var_dump(class_implements($collectionType));
            throw new \DomainException("$collectionType must implement \Serializable");
        }

        if (false == is_a($collectionType, Comparable::class, true)) {
            throw new \DomainException("$collectionType must implement ". Comparable::class);
        }
    }

    private function hydrated($data, ?int $key = null) : ?\Serializable
    {
        if (!$data) {
            return null;
        }

        if ($data instanceof $this->collectionType) {
            return $data;
        }

        $object = new $this->collectionType;
        $object->unserialize(serialize($data));

        if (null !== $key) {
            parent::offsetSet($key, $object);
        }

        return $object;
    }

    public function startAt() : int
    {
        return $this->startAt;
    }

    public function maxResults() : int
    {
        return $this->maxResults;
    }

    public function total() : int
    {
        return $this->total;
    }

    public function isLast() : bool
    {
        return $this->isLast;
    }

    public function accepts($object) : bool
    {
        return $object instanceof $this->collectionType;
    }

    public function append($value)
    {
        return parent::append($this->hydrated($value));
    }

    public function asort()
    {
        return $this->uasort(function(Comparable $a, Comparable $b) {
            return $a->compareTo($b);
        });
    }

    public function current()
    {
        return $this->hydrated(parent::current(), $this->key());
    }

    public function getArrayCopy()
    {
        return array_map(array($this, 'hydrated'), parent::getArrayCopy());
    }

    public function ksort()
    {
        return $this->uksort(function(Comparable $a, Comparable $b) {
            return $a->compareTo($b);
        });
    }

    public function natcasesort()
    {
        return $this->uksort(function(Comparable $a, Comparable $b) {
            return $a->compareTo($b, Comparable::NATURAL_COMPARISSON | Comparable::IGNORE_CASE);
        });
    }

    public function natsort()
    {
        return $this->uksort(function(Comparable $a, Comparable $b) {
            return $a->compareTo($b, Comparable::NATURAL_COMPARISSON);
        });
    }

    public function next()
    {
        return $this->hydrated(parent::next(), $this->key());
    }

    public function offsetGet($index)
    {
        return $this->hydrated(parent::offsetGet($index), $index);
    }

    public function offsetSet($index, $newval)
    {
        if ($this->accepts($newval)) {
            return parent::offsetSet($index, $newval);
        }

        throw new \DomainException('Object must implement ' . $this->collectionType);
    }

    public function rewind()
    {
        return $this->hydrated(parent::rewind(), $this->key());
    }

    public function seek($position)
    {
        return $this->hydrated(parent::seek($position), $position);
    }

    public function serialize()
    {
        return json_encode(array(
            'startAt' => $this->startAt(),
            'maxResults' => $this->maxResults(),
            'total' => $this->total(),
            'isLast' => $this->isLast(),
            'values' => array_map(function(\Serializable $object) {
                return $object->serialize();
            }, $this->getArrayCopy()),
        ));
    }

    public function unserialize($serialized)
    {
        $data = json_decode($serialized, true);

        $this->startAt = intval($data['startAt'] ?? 0);
        $this->maxResults = intval($data['maxResults'] ?? 10);
        $this->total = intval($data['total'] ?? 0);
        $this->isLast = boolval($data['isLast'] ?? false);

        $values = json_encode($data['values'] ?? array());

        parent::unserialize($values);
    }
}
<?php

namespace Tests\JiraImporter\Domain\Generic;

use JiraImporter\Domain\Generic\Comparable;

class ComparableMock implements \Serializable, Comparable
{
    public $value;

    public function __construct($value = null)
    {
        $this->value = $value;
    }

    public function compareTo(Comparable $compared, int $flags = 0) : int
    {
        $a = $this->value;
        $b = $compared->value;

        if ($flags & Comparable::IGNORE_CASE) {
            $a = strtolower($a);
            $b = strtolower($b);
        }

        if ($flags & Comparable::NATURAL_COMPARISSON) {
            return strnatcmp($a, $b);
        }

        return $a <=> $b;
    }

    public function serialize()
    {
        return json_encode(array(
            'value' => $this->value
        ));
    }

    public function unserialize($serialized)
    {
        $data = json_decode($serialized);

        $this->value = $data['value'] ?? null;
    }
}
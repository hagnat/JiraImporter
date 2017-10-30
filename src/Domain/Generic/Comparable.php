<?php

namespace JiraImporter\Domain\Generic;

interface Comparable
{
    /**
     * @var integer performs a natural comparisson
     */
    const NATURAL_COMPARISSON = 1;

    /**
     * @var integer case insensitive comparisson
     */
    const IGNORE_CASE = 2;

    /**
     * compares two objects of the same type
     *
     * returns 1 if this object is greater than the provided parameter,
     * 0 iuf they are equal, and -1 if this object is lower
     *
     * @see https://wiki.php.net/rfc/comparable
     *
     * @param self $compared
     * @param int $flags comparisson flags
     * @return int
     */
    public function compareTo(Comparable $compared, int $flags = 0) : int;
}
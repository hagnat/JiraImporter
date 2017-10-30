<?php

namespace Tests\JiraImporter\Domain\Generic;

use PHPUnit\Framework\TestCase;
use JiraImporter\Domain\Generic\Collection;

/**
 * @coversDefaultClass \JiraImporter\Domain\Generic\Collection
 */
class CollectionTest extends TestCase
{
    /**
     * @test
     * @covers ::__construct
     * @covers ::accept
     */
    public function it_should_accept_a_sortable_and_comparable_class()
    {
        $collection = new Collection(ComparableMock::class);

        $this->assertTrue($collection->accepts(new ComparableMock()));
        $this->assertFalse($collection->accepts(new \stdClass()));
    }

    /**
     * @test
     * @covers ::unserialize
     * @covers ::startAt
     * @covers ::maxResult
     * @covers ::total
     * @covers ::isLast
     */
    public function it_should_receive_a_serialized_object()
    {
        $serialized = $this->serialized(array(1,2,3,4,5), 10, 20, 30, true);

        $collection = new Collection(ComparableMock::class);
        $collection->unserialize($serialized);

        $this->assertEquals(10, $collection->startAt());
        $this->assertEquals(20, $collection->maxResults());
        $this->assertEquals(30, $collection->total());
        $this->assertTrue($collection->isLast());
    }

    private function serialized(
        array $values,
        int $startAt = 0,
        int $maxResults = 100,
        int $total = 100,
        bool $isLast = false
    ) : string {
        $values = array_map(function($value) {
            return array(
                'value' => $value,
            );
        }, $values);

        return json_encode(compact('startAt', 'maxResults', 'total', 'isLast', 'values'));
    }
}

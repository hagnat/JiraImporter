<?php declare(strict_types=1);

namespace Tests\JiraImporter\Domain;

use PHPUnit\Framework\TestCase;
use JiraImporter\Domain\Ticket;

/**
 * @coversDefaultClass \JiraImporter\Domain\Ticket
 */
class TicketTest extends TestCase
{
    /**
     * @test
     * @cover ::__construct
     */
    public function it_should_create_a_ticket()
    {
        $ticket = new Ticket('foo', 'lorem ipsum');
        $this->assertInstanceOf(Ticket::class, $ticket);
    }

    /**
     * @test
     * @cover ::__construct
     * @expectedException TypeError
     */
    public function it_should_only_accepts_strings()
    {
        new Ticket(123.4);
    }

    /**
     * @test
     * @covers ::__construct
     * @covers ::title
     */
    public function it_should_define_the_ticket_title()
    {
        $ticket = new Ticket('foo', 'lorem ipsum');
        $this->assertEquals('foo', $ticket->title());
    }

    /**
     * @test
     * @covers ::__construct
     * @covers ::description
     */
    public function it_should_define_the_ticket_description()
    {
        $ticket = new Ticket('foo', 'lorem ipsum');
        $this->assertEquals('lorem ipsum', $ticket->description());
    }

    /**
     * @test
     * @covers ::__construct
     * @covers ::description
     */
    public function it_should_allow_empty_descriptions()
    {
        $ticket = new Ticket('foo');
        $this->assertNull($ticket->description());
    }
}

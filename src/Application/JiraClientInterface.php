<?php declare(strict_types=1);

namespace JiraImporter\Application;

use JiraImporter\Domain\Ticket;

interface JiraClientInterface
{
    public function createTicket(Ticket $ticket) : Response;
}

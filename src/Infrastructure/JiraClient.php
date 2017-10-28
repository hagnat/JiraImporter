<?php declare(strict_types=1);

namespace JiraImporter\Infrastructure;

use JiraImporter\Application\JiraClientInterface;
use JiraImporter\Application\Response;
use JiraImporter\Domain\Ticket;

final class JiraClient implements JiraClientInterface
{
    public function createTicket(Ticket $ticket) : Response
    {
        return Response::ticketCreated($ticket);
    }
}

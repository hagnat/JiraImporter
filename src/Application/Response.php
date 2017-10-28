<?php declare(strict_types=1);

namespace JiraImporter\Application;

use JiraImporter\Domain\Ticket;

final class Response
{
    const TICKET_CREATED = 201;

    const TICKET_CREATION_EXCEPTION = 401;

    private $statusCode;

    private $statusMessage;

    private $additionalData;

    private function __construct(int $statusCode, string $statusMessage, array $additionalData = array())
    {
        $this->statusCode = $statusCode;
        $this->statusMessage = $statusMessage;
        $this->additionalData = $additionalData;
    }

    public static function ticketCreated(Ticket $ticket) : Response
    {
        return new self(self::TICKET_CREATED, 'Ticket created succesfully');
    }

    public static function ticketCreationFailure(Ticket $ticket, string $errorMessage)
    {
        return new self(self::TICKET_CREATION_EXCEPTION, 'There was an error while creating the ticket', array(
            'errorMessage' => $errorMessage,
        ));
    }
}

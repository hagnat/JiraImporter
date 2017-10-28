<?php declare(strict_types=1);

namespace JiraImporter\Domain;

final class Ticket
{
    private $title;

    private $description;

    public function __construct(
        string $title,
        ?string $description = null
    ) {
        $this->title = $title;
        $this->description = $description;
    }

    public function title() : string
    {
        return $this->title;
    }

    public function description() : ?string
    {
        return $this->description;
    }
}

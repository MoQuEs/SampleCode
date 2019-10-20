<?php

declare(strict_types = 1);

namespace App\Domain;


use DateTime;
use DateTimeImmutable;
use Exception;
use JsonSerializable;


/**
 * @Entity()
 * @Table(name="todos")
 */
class Todo implements JsonSerializable {
    /**
     * @var int
     *
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(type="string", length=60, nullable=false)
     */
    private $subject;

    /**
     * @var string
     *
     * @Column(type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var DateTimeImmutable
     *
     * @Column(type="datetimetz_immutable", nullable=false)
     */
    private $registeredAt;

    /**
     * @var bool
     *
     * @Column(type="boolean", nullable=false)
     */
    private $completed;

    /**
     * Todo constructor.
     * @param string $subject
     * @param string $description
     * @param bool $completed
     * @throws Exception
     */
    public function __construct(string $subject, string $description, bool $completed) {
        $this->subject = $subject;
        $this->description = $description;
        $this->registeredAt = new DateTimeImmutable('now');
        $this->completed = $completed;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array {
        return [
            'id' => $this->getId(),
            'subject' => $this->getSubject(),
            'description' => $this->getDescription(),
            'registered_at' => $this->getRegisteredAt()->format(DateTime::ATOM),
            'completed' => $this->getCompleted()
        ];
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSubject(): string {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject) {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description) {
        $this->description = $description;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getRegisteredAt(): DateTimeImmutable {
        return $this->registeredAt;
    }

    /**
     * @return bool
     */
    public function getCompleted(): bool {
        return $this->completed;
    }

    /**
     * @param bool $completed
     */
    public function setCompleted(bool $completed) {
        $this->completed = $completed;
    }
}

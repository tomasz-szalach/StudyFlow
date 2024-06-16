<?php

class Task
{
    private $id;
    private $name;
    private $description;
    private $dueDate;
    private $status;
    private $taskListId;

    public function __construct(string $name, string $description, string $dueDate, string $status, int $taskListId, int $id = 0)
    {
        $this->name = $name;
        $this->description = $description;
        $this->dueDate = $dueDate;
        $this->status = $status;
        $this->taskListId = $taskListId;
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDueDate(): string
    {
        return $this->dueDate;
    }

    public function setDueDate(string $dueDate): void
    {
        $this->dueDate = $dueDate;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getTaskListId(): int
    {
        return $this->taskListId;
    }

    public function setTaskListId(int $taskListId): void
    {
        $this->taskListId = $taskListId;
    }
}

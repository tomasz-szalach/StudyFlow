<?php

class TaskList
{
    private $id;
    private $name;
    private $userId;

    public function __construct(string $name, int $userId, int $id = 0)
    {
        $this->name = $name;
        $this->userId = $userId;
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

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }
}

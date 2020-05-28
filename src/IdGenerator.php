<?php

namespace Perfumer\Questions;

class IdGenerator
{
    private $index = 0;

    public function generateInitialIndex(): void
    {
        $this->index = random_int(1, 10000);
    }

    public function setInitialIndex(int $index): void
    {
        $this->index = $index;
    }

    public function getNextIndex(): int
    {
        return ++$this->index;
    }
}
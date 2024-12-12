<?php

namespace App\ValueObjects;

readonly class Page
{
    public int $offset;

    public function __construct(public int $current, public int $perPage)
    {
        $this->offset = ($this->current - 1) * $this->perPage;
    }
}

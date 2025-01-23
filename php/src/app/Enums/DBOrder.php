<?php

namespace App\Enums;

enum DBOrder: string
{
    case asc = 'asc';
    case desc = 'desc';

    public function invert(): self
    {
        return match ($this) {
            self::asc => self::desc,
            self::desc => self::asc,
        };
    }

    public function comparisonOperator(): string
    {
        return match ($this) {
            self::asc => '>',
            self::desc => '<',
        };
    }
}

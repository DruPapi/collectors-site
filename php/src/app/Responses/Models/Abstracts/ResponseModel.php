<?php

namespace App\Responses\Models\Abstracts;

use App\Models\Abstracts\Model;
use Arr;
use Illuminate\Contracts\Support\Arrayable;

abstract class ResponseModel implements Arrayable
{
    protected array $visible = ['*'];

    public function __construct(
        protected readonly Model $childModel
    ) {}

    public function toArray()
    {
        return (count($this->visible) === 1 && Arr::first($this->visible) === '*')
            ? $this->childModel->toArray()
            : $this->childModel->only($this->visible);
    }
}

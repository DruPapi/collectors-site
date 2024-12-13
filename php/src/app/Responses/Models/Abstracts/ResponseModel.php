<?php

namespace App\Responses\Models\Abstracts;

use Arr;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\JsonEncodingException;
use JsonException;
use JsonSerializable;

abstract class ResponseModel implements Arrayable, Jsonable, JsonSerializable
{
    protected array $visible = ['*'];

    public function __construct(protected $childModel) {}

    public function toArray()
    {
        return (count($this->visible) === 1 && Arr::first($this->visible) === '*')
            ? $this->childModel->toArray()
            : $this->childModel->only($this->visible);
    }

    public function toJson($options = 0)
    {
        try {
            $json = json_encode($this->jsonSerialize(), $options | JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw JsonEncodingException::forModel($this, $e->getMessage());
        }

        return $json;
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}

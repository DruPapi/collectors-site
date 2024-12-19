<?php

namespace App\Responses\Models\Abstracts;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\JsonEncodingException;
use JsonException;
use JsonSerializable;

abstract class ResponseModel implements Arrayable, Jsonable, JsonSerializable
{
    protected array $visible = ['*'];

    protected array $appends = [];

    public function __construct(protected $childModel) {}

    public function toArray()
    {
        $this->childModel
            ->setVisible($this->visible)
            ->makeVisible($this->appends)
            ->setAppends($this->appends);

        return $this->childModel->toArray();
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

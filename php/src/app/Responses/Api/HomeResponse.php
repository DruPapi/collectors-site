<?php

namespace App\Responses\Api;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use JustSteveKing\StatusCode\Http;

readonly class HomeResponse implements Responsable
{
    public function __construct(
        public int $numberOfExchanges,
        public Carbon $collectorsSiteStartedAt,
        public string $content,
        public Http $status = Http::OK,
    ) {}

    public function toResponse($request)
    {
        return new JsonResponse(
            data: [
                'content' => $this->content,
                'number_of_exchanges' => $this->numberOfExchanges,
                'collectors_site_started_at' => $this->collectorsSiteStartedAt->format('Y.m.d'),
            ],
            status: $this->status->value,
        );
    }
}

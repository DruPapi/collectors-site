<?php

namespace App\Responses\Api;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use JustSteveKing\StatusCode\Http;

class HomeResponse implements Responsable
{
    public function __construct(
        public readonly int $numberOfExchanges,
        public readonly Carbon $collectorsSiteStartedAt,
        public readonly string $content,
        public readonly Http $status = Http::OK,
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

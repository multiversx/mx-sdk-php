<?php

namespace MultiversX\Http\Api\Endpoints;

use GuzzleHttp\ClientInterface;
use Illuminate\Support\Collection;
use MultiversX\Http\Entities\DexPair;
use MultiversX\Http\Entities\DexToken;

class DexEndpoints
{
    public function __construct(
        private ClientInterface $client,
    ) {
    }

    public function getPairs(array $params = []): Collection
    {
        return DexPair::fromApiResponse(
            $this->client->request('GET', '/mex/pairs', [
                'query' => $params,
            ]),
            collection: true,
        );
    }

    public function getTokens(array $params = []): Collection
    {
        return DexToken::fromApiResponse(
            $this->client->request('GET', '/mex/tokens', [
                'query' => $params,
            ]),
            collection: true,
        );
    }
}

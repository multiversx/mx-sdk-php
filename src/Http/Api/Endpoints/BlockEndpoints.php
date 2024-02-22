<?php

namespace MultiversX\Http\Api\Endpoints;

use GuzzleHttp\ClientInterface;
use Illuminate\Support\Collection;
use MultiversX\Http\Entities\Block;

final class BlockEndpoints
{
    public function __construct(
        private ClientInterface $client,
    ) {
    }

    public function getBlocks(array $params = []): Collection
    {
        return Block::fromApiResponse(
            $this->client->request('GET', "/blocks", [
                'query' => $params,
            ]),
            collection: true,
        );
    }
}

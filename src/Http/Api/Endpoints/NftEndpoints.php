<?php

namespace MultiversX\Http\Api\Endpoints;

use GuzzleHttp\ClientInterface;
use Illuminate\Support\Collection;
use MultiversX\Http\Entities\Nft;
use MultiversX\Http\Entities\NftOwner;

class NftEndpoints
{
    public function __construct(
        private ClientInterface $client,
    ) {
    }

    public function getById(string $identifier, array $params = []): Nft
    {
        return Nft::fromApiResponse(
            $this->client->request('GET', "/nfts/{$identifier}", [
                'query' => $params,
            ]),
        );
    }

    public function getAccounts(string $identifier, array $params = []): Collection
    {
        return NftOwner::fromApiResponse(
            $this->client->request('GET', "/nfts/{$identifier}/accounts", [
                'query' => $params,
            ]),
            collection: true,
        );
    }
}

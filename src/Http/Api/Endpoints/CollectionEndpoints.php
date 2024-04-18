<?php

namespace MultiversX\Http\Api\Endpoints;

use GuzzleHttp\ClientInterface;
use Illuminate\Support\Collection;
use MultiversX\Http\Entities\CollectionAccount;
use MultiversX\Http\Entities\Nft;
use MultiversX\Http\Entities\NftCollection;

class CollectionEndpoints
{
    public function __construct(
        private ClientInterface $client,
    ) {
    }

    public function getById(string $identifier, array $params = []): NftCollection
    {
        return NftCollection::fromApiResponse(
            $this->client->request('GET', "collections/{$identifier}", [
                'query' => $params,
            ]),
        );
    }

    public function getNftsById(string $identifier, array $params = []): Collection
    {
        return Nft::fromApiResponse(
            $this->client->request('GET', "collections/{$identifier}/nfts", [
                'query' => $params,
            ]),
            collection: true,
        );
    }

    public function getAccounts(string $tokenId, array $params = []): Collection
    {
        return CollectionAccount::fromApiResponse(
            $this->client->request('GET', "collections/{$tokenId}/accounts", [
                'query' => $params,
            ]),
            collection: true,
        );
    }
}

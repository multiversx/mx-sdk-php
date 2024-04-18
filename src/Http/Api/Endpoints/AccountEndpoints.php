<?php

namespace MultiversX\Http\Api\Endpoints;

use GuzzleHttp\ClientInterface;
use Illuminate\Support\Collection;
use MultiversX\Http\Entities\Account;
use MultiversX\Http\Entities\Nft;
use MultiversX\Http\Entities\NftCollectionAccount;
use MultiversX\Http\Entities\NftCollectionRole;
use MultiversX\Http\Entities\TokenDetailedWithBalance;
use MultiversX\Http\Entities\Transaction;

class AccountEndpoints
{
    public function __construct(
        private ClientInterface $client,
    ) {
    }

    public function getByAddress(string $address, array $params = []): Account
    {
        return Account::fromApiResponse(
            $this->client->request('GET', "accounts/{$address}", [
                'query' => $params,
            ]),
        );
    }

    public function getNfts(string $address, array $params = []): Collection
    {
        return Nft::fromApiResponse(
            $this->client->request('GET', "accounts/{$address}/nfts", [
                'query' => $params,
            ]),
            collection: true,
        );
    }

    public function getTokens(string $address, array $params = []): Collection
    {
        return TokenDetailedWithBalance::fromApiResponse(
            $this->client->request('GET', "accounts/{$address}/tokens", [
                'query' => $params,
            ]),
            collection: true,
        );
    }

    public function getToken(string $address, string $token, array $params = []): TokenDetailedWithBalance
    {
        return TokenDetailedWithBalance::fromApiResponse(
            $this->client->request('GET', "accounts/{$address}/tokens/{$token}", [
                'query' => $params,
            ]),
        );
    }

    public function getCollections(string $address, array $params = []): Collection
    {
        return NftCollectionAccount::fromApiResponse(
            $this->client->request('GET', "accounts/{$address}/collections", [
                'query' => $params,
            ]),
            collection: true,
        );
    }

    public function getCollection(string $address, string $collection, array $params = []): NftCollectionAccount
    {
        return NftCollectionAccount::fromApiResponse(
            $this->client->request('GET', "accounts/{$address}/collections/{$collection}", [
                'query' => $params,
            ]),
        );
    }

    public function getRolesCollections(string $address, array $params = []): Collection
    {
        return NftCollectionRole::fromApiResponse(
            $this->client->request('GET', "accounts/{$address}/roles/collections", [
                'query' => $params,
            ]),
            collection: true,
        );
    }

    public function getRolesCollection(string $address, string $collection, array $params = []): NftCollectionRole
    {
        return NftCollectionRole::fromApiResponse(
            $this->client->request('GET', "accounts/{$address}/roles/collections/{$collection}", [
                'query' => $params,
            ]),
        );
    }

    public function getTransactions(string $address, array $params = []): Collection
    {
        return Transaction::fromApiResponse(
            $this->client->request('GET', "accounts/{$address}/transactions", [
                'query' => $params,
            ]),
            collection: true,
        );
    }
}

<?php

namespace MultiversX\Http\Api\Endpoints;

use GuzzleHttp\ClientInterface;
use Illuminate\Support\Collection;
use MultiversX\Http\Entities\TokenAccount;
use MultiversX\Http\Entities\TokenAddressRoles;
use MultiversX\Http\Entities\TokenDetailed;
use MultiversX\Http\Entities\Transaction;

class TokenEndpoints
{
    public function __construct(
        private ClientInterface $client,
    ) {
    }

    public function getById(string $tokenId, array $params = []): TokenDetailed
    {
        return TokenDetailed::fromApiResponse(
            $this->client->request('GET', "tokens/{$tokenId}", [
                'query' => $params,
            ]),
        );
    }

    public function getTokens(array $params = []): Collection
    {
        return TokenDetailed::fromApiResponse(
            $this->client->request('GET', "tokens", [
                'query' => $params,
            ]),
            collection: true,
        );
    }

    public function getAccounts(string $tokenId, array $params = []): Collection
    {
        return TokenAccount::fromApiResponse(
            $this->client->request('GET', "tokens/{$tokenId}/accounts", [
                'query' => $params,
            ]),
            collection: true,
        );
    }

    public function getAccountsCount(string $tokenId, array $params = []): int
    {
        return (int) $this->client->request('GET', "tokens/{$tokenId}/accounts/count", [
            'query' => $params,
        ])
            ->getBody()
            ->getContents();
    }

    public function getTransactions(string $tokenId, array $params = []): Collection
    {
        return Transaction::fromApiResponse(
            $this->client->request('GET', "tokens/{$tokenId}/transactions", [
                'query' => $params,
            ]),
            collection: true,
        );
    }

    public function getRoles(string $tokenId, array $params = []): Collection
    {
        return TokenAddressRoles::fromApiResponse(
            $this->client->request('GET', "tokens/{$tokenId}/roles", [
                'query' => $params,
            ]),
            collection: true,
        );
    }
}

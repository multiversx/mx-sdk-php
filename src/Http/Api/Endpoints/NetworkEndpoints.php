<?php

namespace MultiversX\Http\Api\Endpoints;

use GuzzleHttp\ClientInterface;
use MultiversX\Http\Entities\Economics;
use MultiversX\Http\Entities\NetworkConstants;

final class NetworkEndpoints
{
    public function __construct(
        private ClientInterface $client,
    ) {
    }

    public function getEconomics(array $params = []): Economics
    {
        return Economics::fromApiResponse(
            $this->client->request('GET', '/economics', [
                'query' => $params,
            ]),
        );
    }

    public function getNetworkConstants(array $params = []): NetworkConstants
    {
        return NetworkConstants::fromApiResponse(
            $this->client->request('GET', '/constants', [
                'query' => $params,
            ]),
        );
    }
}

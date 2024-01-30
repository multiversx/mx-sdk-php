<?php

namespace MultiversX\Http;

use GuzzleHttp\ClientInterface;
use MultiversX\Http\Api\ApiNetworkProvider;

class NetworkProvider
{
    public static function api(string $baseUrl, ?ClientInterface $client = null): ApiNetworkProvider
    {
        return new ApiNetworkProvider(
            $client ?? ClientFactory::create($baseUrl),
        );
    }
}

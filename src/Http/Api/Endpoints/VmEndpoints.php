<?php

namespace MultiversX\Http\Api\Endpoints;

use GuzzleHttp\ClientInterface;
use MultiversX\Utils\Encoder;
use MultiversX\Http\Entities\VmHexResult;
use MultiversX\Http\Entities\VmIntResult;
use MultiversX\Http\Entities\VmQueryResult;
use MultiversX\Http\Entities\VmStringResult;

class VmEndpoints
{
    public function __construct(
        private ClientInterface $client,
    ) {
    }

    public function query(string $contractAddress, string $func, array $args = [], array $params = []): VmQueryResult
    {
        return VmQueryResult::fromApiResponse(
            $this->client->request('POST', "/vm-values/query", [
                'json' => [
                    'scAddress' => $contractAddress,
                    'funcName' => $func,
                    'args' => collect($args)->map(fn ($a) => Encoder::toHex($a))->all(),
                    ...$params,
                ],
            ]),
            unwrapData: true,
        );
    }

    public function hex(string $contractAddress, string $func, array $args = [], array $params = []): VmHexResult
    {
        return VmHexResult::fromApiResponse(
            $this->client->request('POST', "/vm-values/hex", [
                'json' => [
                    'scAddress' => $contractAddress,
                    'funcName' => $func,
                    'args' => collect($args)->map(fn ($a) => Encoder::toHex($a))->all(),
                    ...$params,
                ]
            ]),
            unwrapData: true,
        );
    }

    public function string(string $contractAddress, string $func, array $args = [], array $params = []): VmStringResult
    {
        return VmStringResult::fromApiResponse(
            $this->client->request('POST', "/vm-values/string", [
                'json' => [
                    'scAddress' => $contractAddress,
                    'funcName' => $func,
                    'args' => collect($args)->map(fn ($a) => Encoder::toHex($a))->all(),
                    ...$params,
                ],
            ]),
            unwrapData: true,
        );
    }

    public function int(string $contractAddress, string $func, array $args = [], array $params = []): VmIntResult
    {
        return VmIntResult::fromApiResponse(
            $this->client->request('POST', "/vm-values/int", [
                'json' => [
                    'scAddress' => $contractAddress,
                    'funcName' => $func,
                    'args' => collect($args)->map(fn ($a) => Encoder::toHex($a))->all(),
                    ...$params,
                ],
            ]),
            unwrapData: true,
        );
    }
}

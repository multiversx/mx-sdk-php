<?php

namespace MultiversX\Http\Api;

use GuzzleHttp\ClientInterface;
use MultiversX\Http\Api\Endpoints\AccountEndpoints;
use MultiversX\Http\Api\Endpoints\BlockEndpoints;
use MultiversX\Http\Api\Endpoints\CollectionEndpoints;
use MultiversX\Http\Api\Endpoints\DexEndpoints;
use MultiversX\Http\Api\Endpoints\NetworkEndpoints;
use MultiversX\Http\Api\Endpoints\NftEndpoints;
use MultiversX\Http\Api\Endpoints\TokenEndpoints;
use MultiversX\Http\Api\Endpoints\TransactionEndpoints;
use MultiversX\Http\Api\Endpoints\VmEndpoints;

final class ApiNetworkProvider
{
    public function __construct(
        public readonly ClientInterface $client,
    ) {
    }

    public function accounts(): AccountEndpoints
    {
        return new AccountEndpoints($this->client);
    }

    public function network(): NetworkEndpoints
    {
        return new NetworkEndpoints($this->client);
    }

    public function blocks(): BlockEndpoints
    {
        return new BlockEndpoints($this->client);
    }

    public function collections(): CollectionEndpoints
    {
        return new CollectionEndpoints($this->client);
    }

    public function mex(): DexEndpoints
    {
        return new DexEndpoints($this->client);
    }

    public function nfts(): NftEndpoints
    {
        return new NftEndpoints($this->client);
    }

    public function tokens(): TokenEndpoints
    {
        return new TokenEndpoints($this->client);
    }

    public function transactions(): TransactionEndpoints
    {
        return new TransactionEndpoints($this->client);
    }

    public function vm(): VmEndpoints
    {
        return new VmEndpoints($this->client);
    }
}

<?php

use MultiversX\Http\Api\Endpoints\CollectionEndpoints;
use MultiversX\Http\Entities\NftCollection;

it('gets a collection by id', function () {
    $client = createMockedHttpClientWithResponse('collections/collection.json');

    $actual = (new CollectionEndpoints($client))
        ->getById('EBUDDIES-e18a04');

    assertMatchesResponseSnapshot($actual);

    expect($actual)->toBeInstanceOf(NftCollection::class);
});

it('gets nfts', function () {
    $client = createMockedHttpClientWithResponse('collections/nfts.json');

    $actual = (new CollectionEndpoints($client))
        ->getNftsById('VNFT-507997');

    assertMatchesResponseSnapshot($actual);
});

it('gets accounts', function () {
    $client = createMockedHttpClientWithResponse('collections/accounts.json');

    $actual = (new CollectionEndpoints($client))
        ->getAccounts('VNFT-507997');

    assertMatchesResponseSnapshot($actual);
});

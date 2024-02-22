<?php

use MultiversX\Http\Api\Endpoints\NetworkEndpoints;

it('gets economics', function () {
    $client = createMockedHttpClientWithResponse('network/economics.json');

    $actual = (new NetworkEndpoints($client))
        ->getEconomics();

    assertMatchesResponseSnapshot($actual);
});

it('gets constants', function () {
    $client = createMockedHttpClientWithResponse('network/constants.json');

    $actual = (new NetworkEndpoints($client))
        ->getNetworkConstants();

    assertMatchesResponseSnapshot($actual);
});

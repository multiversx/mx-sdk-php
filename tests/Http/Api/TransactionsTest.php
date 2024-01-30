<?php

use MultiversX\Http\Api\Endpoints\TransactionEndpoints;

it('gets a transaction by transaction hash', function () {
    $client = createMockedHttpClientWithResponse('transactions/tx.json');

    $actual = (new TransactionEndpoints($client))
        ->getByHash('01b94cb36f027bab9391414971c7feb348755c53f8ea27f19c18fb82db35ea7d');

    test()->assertMatchesSnapshot($actual);

    expect($actual->hasContractError())->toBeFalse();
});

it('getAllEvents - returns all events of a transaction', function () {
    $client = createMockedHttpClientWithResponse('transactions/tx-mixed-events.json');

    $actual = (new TransactionEndpoints($client))
        ->getByHash('5be5f3717595dc8b2bf462136fb95b60c0acb34aa8c8a4da62f57708cd24131f');

    expect($actual->getAllEvents())
        ->toHaveCount(76);
});

it('hasContractError - returns true when contract errors', function () {
    $client = createMockedHttpClientWithResponse('transactions/tx-contract-error.json');

    $actual = (new TransactionEndpoints($client))
        ->getByHash('c0a193c856ea07caeb15870711ed3e6a2852d8aa9c1b97d85333c1d5420e66b7');

    expect($actual->hasContractError())
        ->toBeTrue();
});

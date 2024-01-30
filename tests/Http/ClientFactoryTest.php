<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use MultiversX\Http\ClientFactory;

it('creates a client', function () {
    $client = ClientFactory::create('https://api.multiversx.com');

    expect($client)
        ->toBeInstanceOf(Client::class);
});

it('mocks an error response', function () {
    $error = new RequestException(
        'Some error message',
        new Request('GET', '/endpoint'),
        new Response(403, [], 'Forbidden')
    );

    $client = ClientFactory::mockError($error);

    $client->request('GET', '/endpoint');
})
    ->expectException(RequestException::class);

<?php

namespace MultiversX\Http;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Client\RequestExceptionInterface;
use Psr\Http\Message\ResponseInterface;

class ClientFactory
{
    public static function create(string $baseUrl, array $options = []): ClientInterface
    {
        if (! isset($options['base_uri'])) {
            $options['base_uri'] = $baseUrl;
        }

        $options['headers'] = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            ...$options['headers'] ?? [],
        ];

        return new Client($options);
    }

    public static function mock(array $responses, array &$transactions = [], array $options = []): ClientInterface
    {
        $mockHandler = new MockHandler($responses);
        $handlerStack = HandlerStack::create($mockHandler);
        $handlerStack->push(Middleware::history($transactions));

        return new Client(['handler' => $handlerStack, ...$options]);
    }

    public static function mockError(RequestExceptionInterface $error, array &$transactions = [], array $options = []): ClientInterface
    {
        $mockHandler = new MockHandler([$error]);
        $handlerStack = HandlerStack::create($mockHandler);
        $handlerStack->push(Middleware::history($transactions));

        return new Client(['handler' => $handlerStack, ...$options]);
    }
}

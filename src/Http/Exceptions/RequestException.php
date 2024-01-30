<?php

namespace MultiversX\Http\Exceptions;

use GuzzleHttp\Psr7\Message;
use GuzzleHttp\Psr7\Response;

class RequestException extends HttpClientException
{
    public Response $response;

    public function __construct(Response $response)
    {
        parent::__construct($this->prepareMessage($response), $response->getStatusCode());

        $this->response = $response;
    }

    protected function prepareMessage(Response $response)
    {
        $message = "HTTP request returned status code {$response->getStatusCode()}";
        $summary = Message::bodySummary($response);

        return is_null($summary) ? $message : $message .= ":\n{$summary}\n";
    }
}

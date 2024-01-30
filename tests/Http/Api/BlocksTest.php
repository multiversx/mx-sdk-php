<?php

use MultiversX\Http\Api\Endpoints\BlockEndpoints;

it('gets blocks', function () {
    $client = createMockedHttpClientWithResponse('blocks/blocks.json');

    $actual = (new BlockEndpoints($client))
        ->getBlocks();

    assertMatchesResponseSnapshot($actual);
});

<?php

namespace MultiversX\Tests\Http;

use Spatie\Snapshots\Driver;
use PHPUnit\Framework\Assert;

class ResponseSnapshotDriver implements Driver
{
    public function serialize($data): string
    {
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    public function extension(): string
    {
        return 'json';
    }

    public function match($expected, $actual)
    {
        Assert::assertEquals(json_encode($actual, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), $expected);
    }
}

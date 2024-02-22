<?php

namespace MultiversX\Tests\Http;

use Spatie\Snapshots\MatchesSnapshots as MatchesSnapshotsBase;

trait MatchesSnapshots
{
    use MatchesSnapshotsBase;

    protected function getSnapshotDirectory(): string
    {
        return __DIR__.DIRECTORY_SEPARATOR.'__snapshots__';
    }
}

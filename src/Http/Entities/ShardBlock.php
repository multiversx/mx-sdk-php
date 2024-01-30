<?php

namespace MultiversX\Http\Entities;

use MultiversX\Http\Api\HasApiResponses;

final class ShardBlock implements IEntity
{
    use HasApiResponses;

    public function __construct(
        public string $hash,
        public int $nonce,
        public int $round,
        public int $shard,
    ) {
    }
}

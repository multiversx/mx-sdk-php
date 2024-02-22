<?php

namespace MultiversX\Http\Entities;

use MultiversX\Http\Api\HasApiResponses;

final class DexToken implements IEntity
{
    use HasApiResponses;

    public function __construct(
        public string $id,
        public string $symbol,
        public string $name,
        public float $price,
    ) {
    }
}

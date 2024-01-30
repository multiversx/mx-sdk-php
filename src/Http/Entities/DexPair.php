<?php

namespace MultiversX\Http\Entities;

use MultiversX\Http\Api\HasApiResponses;

final class DexPair implements IEntity
{
    use HasApiResponses;

    public function __construct(
        public string $baseId,
        public float $basePrice,
        public string $baseSymbol,
        public string $baseName,
        public string $quoteId,
        public float $quotePrice,
        public string $quoteSymbol,
        public string $quoteName,
        public string $totalValue,
        public ?string $volume24h = null,
    ) {
    }
}

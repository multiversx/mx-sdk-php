<?php

namespace MultiversX\Http\Entities;

use MultiversX\Http\Api\HasApiResponses;

final class TokenAssets implements IEntity
{
    use HasApiResponses;

    public function __construct(
        public string $description,
        public string $status,
        public string $pngUrl,
        public string $svgUrl,
        public ?string $website = null,
        public array $social = [],
    ) {
    }
}

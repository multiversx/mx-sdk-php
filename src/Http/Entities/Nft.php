<?php

namespace MultiversX\Http\Entities;

use Brick\Math\BigInteger;
use MultiversX\Http\Api\HasApiResponses;
use MultiversX\Address;

final class Nft implements IEntity
{
    use HasApiResponses;

    const NonFungibleESDT = 'NonFungibleESDT';
    const SemiFungibleESDT = 'SemiFungibleESDT';
    const MetaESDT = 'MetaESDT';

    public function __construct(
        public string $identifier,
        public string $collection,
        public int|string $nonce,
        public string $type,
        public string $name,
        public string $creator,
        public int|string|null $timestamp = null,
        public string $attributes = '',
        public ?int $decimals = null,
        public ?int $royalties = null,
        public ?string $url = null,
        public ?string $ticker = null,
        public ?string $thumbnailUrl = null,
        public ?Address $owner = null,
        public ?BigInteger $supply = null,
        public array $tags = [],
        public ?string $description = null,
    ) {
    }

    public function getTags(): array
    {
        if (!empty($this->tags)) {
            return array_filter($this->tags);
        }

        preg_match('/tags:(?<tags>[\w\s\,]*)/', base64_decode($this->attributes), $matches);

        return array_filter(explode(',', $matches['tags'] ?? ''));
    }

    public function getIpfsContentId(): ?string
    {
        preg_match('/metadata:(?<metadata>[\w]*)/', base64_decode($this->attributes), $matches);

        return $matches['metadata'] ?? null;
    }

    protected static function transformResponse(array $res): array
    {
        return array_merge($res, [
            'description' => $res['metadata']['description'] ?? null,
            'owner' => isset($res['owner']) ? Address::newFromBech32($res['owner']) : null,
            'supply' => isset($res['supply']) ? BigInteger::of($res['supply']) : null,
        ]);
    }
}

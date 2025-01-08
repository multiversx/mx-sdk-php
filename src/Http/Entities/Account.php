<?php

namespace MultiversX\Http\Entities;

use Brick\Math\BigInteger;
use MultiversX\Address;
use MultiversX\Http\Api\HasApiResponses;

final class Account implements IEntity
{
    use HasApiResponses;

    public function __construct(
        public Address $address,
        public int $nonce,
        public BigInteger $balance,
        public int $shard,
        public ?int $txCount = null,
        public ?string $username = null,
        public ?string $rootHash = null,
    ) {
    }

    protected static function transformResponse(array $res): array
    {
        return array_merge($res, [
            'address' => Address::newFromBech32($res['address']),
            'balance' => BigInteger::of($res['balance'] ?? 0)
        ]);
    }
}

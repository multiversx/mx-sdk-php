<?php

namespace MultiversX\Http\Entities;

use Brick\Math\BigInteger;
use MultiversX\Address;
use MultiversX\Http\Api\HasApiResponses;

final class TokenAccount implements IEntity
{
    use HasApiResponses;

    public function __construct(
        public Address $address,
        public BigInteger $balance,
    ) {
    }

    public static function transformResponse(array $res): array
    {
        return array_merge($res, [
            'address' => Address::fromBech32($res['address']),
            'balance' => BigInteger::of($res['balance'] ?? 0),
        ]);
    }
}

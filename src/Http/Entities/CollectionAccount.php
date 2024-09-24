<?php

namespace MultiversX\Http\Entities;

use Brick\Math\BigInteger;
use MultiversX\Address;
use MultiversX\Http\Api\HasApiResponses;

final class CollectionAccount implements IEntity
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
            'address' => Address::newFromBech32($res['address']),
            'balance' => BigInteger::of($res['balance'] ?? 1),
        ]);
    }
}

<?php

namespace MultiversX\Http\Entities;

use MultiversX\Address;
use MultiversX\Http\Api\HasApiResponses;

final class NftOwner implements IEntity
{
    use HasApiResponses;

    public function __construct(
        public Address $address,
        public int $balance,
    ) {
    }

    protected static function transformResponse(array $res): array
    {
        return array_merge($res, [
            'address' => Address::newFromBech32($res['address']),
            'balance' => (int) $res['balance'],
        ]);
    }
}

<?php

namespace MultiversX\Http\Entities;

use MultiversX\Address;
use MultiversX\Http\Api\HasApiResponses;

final class TokenAddressRoles implements IEntity
{
    use HasApiResponses;

    public function __construct(
        public Address $address,
        public array $roles = [],
    ) {
    }

    public static function transformResponse(array $res): array
    {
        return array_merge($res, [
            'address' => Address::newFromBech32($res['address']),
        ]);
    }
}

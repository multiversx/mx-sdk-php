<?php

namespace MultiversX\Http\Entities;

use Illuminate\Support\Collection;
use MultiversX\Http\Api\HasApiResponses;
use MultiversX\Address;

final class TransactionLogEvent implements IEntity
{
    use HasApiResponses;

    public function __construct(
        public Address $address,
        public string $identifier,
        public Collection $topics,
        public ?string $data = null,
    ) {
    }

    protected static function transformResponse(array $res): array
    {
        return array_merge($res, [
            'address' => isset($res['address']) ? Address::newFromBech32($res['address']) : null,
            'topics' => isset($res['topics']) ? collect($res['topics']) : [],
        ]);
    }
}

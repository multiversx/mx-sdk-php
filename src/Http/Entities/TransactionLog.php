<?php

namespace MultiversX\Http\Entities;

use Illuminate\Support\Collection;
use MultiversX\Http\Api\HasApiResponses;
use MultiversX\Http\Entities\TransactionLogEvent;
use MultiversX\Address;

final class TransactionLog implements IEntity
{
    use HasApiResponses;

    public function __construct(
        public string $id,
        public Address $address,
        public Collection $events,
    ) {
    }

    protected static function transformResponse(array $res): array
    {
        return array_merge($res, [
            'address' => isset($res['address']) ? Address::fromBech32($res['address']) : null,
            'events' => isset($res['events']) ? TransactionLogEvent::fromArrayMultiple($res['events']) : collect(),
        ]);
    }
}

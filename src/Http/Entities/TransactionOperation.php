<?php

namespace MultiversX\Http\Entities;

use Brick\Math\BigInteger;
use MultiversX\Http\Api\HasApiResponses;
use MultiversX\Address;

final class TransactionOperation implements IEntity
{
    use HasApiResponses;

    public function __construct(
        public string $id,
        public string $action,
        public string $type,
        public BigInteger $value,
        public Address $sender,
        public Address $receiver,
        public ?string $name = null,
        public ?string $collection = null,
        public ?string $identifier = null,
        public ?string $esdtType = null,
        public ?string $data = null,
    ) {
    }

    protected static function transformResponse(array $res): array
    {
        return array_merge($res, [
            'value' => isset($res['value']) ? BigInteger::of($res['value']) : BigInteger::zero(),
            'sender' => isset($res['sender']) ? Address::fromBech32($res['sender']) : null,
            'receiver' => isset($res['receiver']) ? Address::fromBech32($res['receiver']) : null,
        ]);
    }
}

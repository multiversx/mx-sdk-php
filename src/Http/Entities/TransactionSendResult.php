<?php

namespace MultiversX\Http\Entities;

use MultiversX\Http\Api\HasApiResponses;
use MultiversX\Address;

final class TransactionSendResult implements IEntity
{
    use HasApiResponses;

    public function __construct(
        public Address $receiver,
        public int $receiverShard,
        public Address $sender,
        public int $senderShard,
        public string $status,
        public string $txHash,
    ) {
    }

    protected static function transformResponse(array $res): array
    {
        return array_merge($res, [
            'receiver' => Address::newFromBech32($res['receiver']),
            'sender' => Address::newFromBech32($res['sender']),
        ]);
    }
}

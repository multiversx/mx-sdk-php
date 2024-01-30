<?php

namespace MultiversX\Http\Entities;

use Carbon\Carbon;
use MultiversX\Http\Api\HasApiResponses;

final class Transaction implements IEntity
{
    use HasApiResponses;

    public function __construct(
        public string $txHash,
        public int $nonce,
        public string $receiver,
        public string $sender,
        public string $status,
        public string $value,
        public ?int $gasLimit = null,
        public ?int $gasPrice = null,
        public ?int $gasUsed = null,
        public ?string $miniBlockHash = null,
        public ?int $receiverShard = null,
        public ?string $senderShard = null,
        public ?string $signature = null,
        public ?string $fee = null,
        public ?Carbon $timestamp = null,
        public ?string $data = null,
        public ?string $function = null,
        public ?string $tokenIdentifier = null,
        public ?string $tokenValue = null,
    ) {
    }

    protected static function transformResponse(array $res): array
    {
        return array_merge($res, [
            'data' => isset($res['data']) ? base64_decode($res['data']) : null,
            'timestamp' => isset($res['timestamp']) ? Carbon::createFromTimestampUTC($res['timestamp']) : null,
        ]);
    }
}

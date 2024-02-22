<?php

namespace MultiversX\Http\Entities;

use Carbon\Carbon;
use Brick\Math\BigInteger;
use MultiversX\Address;
use MultiversX\Http\Api\HasApiResponses;

final class SmartContractResult implements IEntity
{
    use HasApiResponses;

    public function __construct(
        public string $hash = '',
        public ?Carbon $timestamp = null,
        public int $nonce = 0,
        public int $gasLimit = 0,
        public int $gasPrice = 0,
        public ?BigInteger $value = null,
        public ?Address $sender = null,
        public ?Address $receiver = null,
        public ?string $relayedValue = '',
        public ?string $data = null,
        public ?string $prevTxHash = '',
        public ?string $originalTxHash = '',
        public ?string $callType = '',
        public ?string $miniBlockHash = '',
        public ?TransactionLog $logs = null,
        public ?string $returnMessage = '',
    ) {
    }

    protected static function transformResponse(array $res): array
    {
        return array_merge($res, [
            'timestamp' => isset($res['timestamp']) ? Carbon::createFromTimestampUTC($res['timestamp']) : null,
            'data' => isset($res['data']) ? base64_decode($res['data']) : null,
            'value' => isset($res['value']) ? BigInteger::of($res['value']) : null,
            'sender' => isset($res['sender']) ? Address::fromBech32($res['sender']) : null,
            'receiver' => isset($res['receiver']) ? Address::fromBech32($res['receiver']) : null,
            'logs' => isset($res['logs']['id']) ? TransactionLog::fromArray($res['logs']) : null,
        ]);
    }
}

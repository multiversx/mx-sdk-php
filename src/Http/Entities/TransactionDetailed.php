<?php

namespace MultiversX\Http\Entities;

use Brick\Math\BigInteger;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use MultiversX\Http\Api\HasApiResponses;
use MultiversX\Address;

final class TransactionDetailed implements IEntity
{
    use HasApiResponses;

    public function __construct(
        public string $txHash,
        public int $nonce,
        public Address $receiver,
        public Address $sender,
        public string $status,
        public BigInteger $value,
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
        public Collection $results = new Collection,
        public ?TransactionLog $logs = null,
        public Collection $operations =  new Collection,
    ) {
    }

    protected static function transformResponse(array $res): array
    {
        return array_merge($res, [
            'value' => isset($res['value']) ? BigInteger::of($res['value']) : BigInteger::zero(),
            'sender' => isset($res['sender']) ? Address::newFromBech32($res['sender']) : null,
            'receiver' => isset($res['receiver']) ? Address::newFromBech32($res['receiver']) : null,
            'data' => isset($res['data']) ? base64_decode($res['data']) : null,
            'timestamp' => isset($res['timestamp']) ? Carbon::createFromTimestampUTC($res['timestamp']) : null,
            'results' => isset($res['results']) ? SmartContractResult::fromArrayMultiple($res['results']) : collect(),
            'logs' => isset($res['logs']) && isset($res['logs']['id']) ? TransactionLog::fromArray($res['logs']) : null,
            'operations' => isset($res['operations']) ? TransactionOperation::fromArrayMultiple($res['operations']) : collect(),
        ]);
    }

    public function getAllEvents(): Collection
    {
        return $this->logs
            ?->events
            ->concat($this->results->map(fn (SmartContractResult $result) => $result->logs?->events))
            ->flatten()
            ->filter() ?? new Collection;
    }

    public function hasContractError(): bool
    {
        $errorEventIdentifier = 'signalError';

        return $this->getAllEvents()
            ->contains(fn (TransactionLogEvent $event) => $event->identifier === $errorEventIdentifier);
    }
}

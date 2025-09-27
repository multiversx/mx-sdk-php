<?php

namespace MultiversX;

use Brick\Math\BigInteger;
use MultiversX\Interfaces\ISignable;

class Transaction implements ISignable
{
    const MIN_GAS_PRICE = 1_000_000_000;
    const VERSION_DEFAULT = 1;
    const OPTIONS_DEFAULT = 0;

    public ?Signature $signature = null;
    public ?Signature $guardianSignature = null;
    public ?Signature $relayerSignature = null;

    public function __construct(
        public int $nonce,
        public BigInteger $value,
        public Address $sender,
        public Address $receiver,
        public int $gasLimit,
        public int $gasPrice = self::MIN_GAS_PRICE,
        public ?TransactionPayload $data = null,
        public string $chainID = '1',
        public int $version = self::VERSION_DEFAULT,
        public int $options = self::OPTIONS_DEFAULT,
        public string $senderUsername = '',
        public string $receiverUsername = '',
        public ?Address $guardian = null,
        public ?Address $relayer = null,
    ) {
    }

    public function serializeForSigning(): string
    {
        $plain = collect($this->toArray())
            ->reject(fn ($field) => $field === null)
            ->toArray();

        unset($plain['signature'], $plain['guardianSignature'], $plain['relayerSignature']);

        return bin2hex(json_encode($plain));
    }

    public function toArray(): array
    {
        return [
            'nonce' => $this->nonce,
            'value' => (string) $this->value,
            'receiver' => $this->receiver->bech32(),
            'sender' => $this->sender->bech32(),
            'senderUsername' => $this->senderUsername ? base64_encode($this->senderUsername) : null,
            'receiverUsername' => $this->receiverUsername ? base64_encode($this->receiverUsername) : null,
            'gasPrice' => $this->gasPrice,
            'gasLimit' => $this->gasLimit,
            'data' => $this->data?->toBase64(),
            'chainID' => $this->chainID,
            'version' => $this->version,
            'options' => $this->options === 0 ? null : $this->options,
            'guardian' => $this->guardian?->bech32(),
            'relayer' => $this->relayer?->bech32(),
            'signature' => $this->signature?->hex(),
            'guardianSignature' => $this->guardianSignature?->hex(),
            'relayerSignature' => $this->relayerSignature?->hex(),
        ];
    }

    public function applySignature(Signature $signature): void
    {
        $this->signature = $signature;
    }

    public function applyGuardianSignature(Signature $signature): void
    {
        $this->guardianSignature = $signature;
    }

    public function applyRelayerSignature(Signature $signature): void
    {
        $this->relayerSignature = $signature;
    }

    public function toSendable(): array
    {
        return $this->toArray();
    }

    public function isGuardedTransaction(): bool
    {
        $hasGuardian = $this->guardian !== null && !$this->guardian->isZero();
        $hasGuardianSignature = $this->guardianSignature !== null;

        return $this->hasOptionsSetForGuardedTransaction() && $hasGuardian && $hasGuardianSignature;
    }

    private function hasOptionsSetForGuardedTransaction(): bool
    {
        return ($this->options & 0b0001) !== 0;
    }
}

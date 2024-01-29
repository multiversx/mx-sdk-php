<?php

namespace MultiversX;

final class GasLimit
{
    const MIN_GAS_LIMIT = 50_000;
    const GAS_PER_DATA_BYTE = 1_500;

    public function __construct(
        public int $value,
    ) {
    }

    public static function forTransfer(?TransactionPayload $payload = null): GasLimit
    {
        $value = $payload !== null
            ? static::GAS_PER_DATA_BYTE * strlen($payload->data)
            : static::MIN_GAS_LIMIT;

        return new static($value);
    }

    public static function min(): GasLimit
    {
        return new GasLimit(static::MIN_GAS_LIMIT);
    }
}

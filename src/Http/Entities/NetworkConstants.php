<?php

namespace MultiversX\Http\Entities;

use MultiversX\Http\Api\HasApiResponses;

final class NetworkConstants implements IEntity
{
    use HasApiResponses;

    public function __construct(
        public string $chainId,
        public int $gasPerDataByte,
        public int $minGasLimit,
        public int $minGasPrice,
        public int $minTransactionVersion,
    ) {
    }
}

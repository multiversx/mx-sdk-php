<?php

namespace MultiversX\Http\Entities;

use MultiversX\Http\Api\HasApiResponses;

final class VmQueryResult extends VmResultBase
{
    use HasApiResponses;

    public function __construct(
        public $data,
        public string $code,
    ) {
    }

    protected static function transformResponse(array $res): array
    {
        return array_merge($res, [
            'data' => $res['data']['returnData'] ?? [],
            'code' => $res['data']['returnCode'] ?? 'error',
        ]);
    }
}

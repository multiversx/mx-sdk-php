<?php

namespace MultiversX\Http\Entities;

use MultiversX\Http\Api\HasApiResponses;

class VmResultBase implements IEntity
{
    use HasApiResponses;

    public function __construct(
        public $data,
    ) {
    }
}

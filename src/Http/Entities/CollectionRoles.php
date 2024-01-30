<?php

namespace MultiversX\Http\Entities;

use MultiversX\Http\Api\HasApiResponses;

final class CollectionRoles implements IEntity
{
    use HasApiResponses;

    public function __construct(
        public bool $canTransferRole = false,
        public bool $canCreate = false,
        public bool $canBurn = false,
    ) {
    }
}

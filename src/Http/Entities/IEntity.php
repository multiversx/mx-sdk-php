<?php

namespace MultiversX\Http\Entities;

use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface;

interface IEntity
{
    public static function fromApiResponse(ResponseInterface $res, bool $collection = false, bool $unwrapData = false): IEntity|Collection;
}

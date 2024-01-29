<?php

namespace MultiversX\Interfaces;

use MultiversX\Bytes;

interface IPublicKey
{
    public function getBytes(): Bytes;
}

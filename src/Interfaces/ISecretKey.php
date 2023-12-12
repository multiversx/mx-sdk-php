<?php

namespace MultiversX\Interfaces;

use MultiversX\Bytes;

interface ISecretKey
{
    public function getBytes(): Bytes;
}

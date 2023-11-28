<?php

use MultiversX\TokenTransfer;

it('has the desired precision given an integer', fn () =>
    expect((string) TokenTransfer::egldFromAmount(12)->amountAsBigInteger)
        ->toBe('12000000000000000000'));

it('has the desired precision given a non-precise float', fn () =>
    expect((string) TokenTransfer::egldFromAmount(12.12345)->amountAsBigInteger)
        ->toBe('12123450000000000000'));

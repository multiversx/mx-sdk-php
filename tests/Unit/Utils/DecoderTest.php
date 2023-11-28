<?php

use MultiversX\Utils\Decoder;

it('fromBase64ToInt - decodes base64 encoded integers', fn ($base64, $dec) => expect(Decoder::fromBase64ToInt($base64))->toBe($dec))
    ->with([
        ['Ag===', 2],
        ['Jjg=', 9784],
    ]);

it('fromBase64ToBigInteger - decodes base64 encoded integers', fn ($base64, $val) => expect((string) Decoder::fromBase64ToBigInteger($base64))->toBe($val))
    ->with([
        ['LBKkOIqYlAAA', '813000000000000000000'],
    ]);

it('bchexdec - decodes a hex encoded bignumber', fn ($hex, $val) => expect((string) Decoder::bchexdec($hex))->toBe($val))
    ->with([
        ['015af1d78b58c40000', '25000000000000000000'],
        ['1569b9e733474c0000', '395000000000000000000'],
    ]);

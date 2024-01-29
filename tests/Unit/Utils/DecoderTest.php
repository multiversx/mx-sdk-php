<?php

use MultiversX\Utils\Decoder;

it('fromBase64ToInt - decodes base64 encoded integers', function ($base64, $dec) {
    expect(Decoder::fromBase64ToInt($base64))->toBe($dec);
})->with([
    ['Ag===', 2],
    ['Jjg=', 9784],
]);

it('fromBase64ToBigInteger - decodes base64 encoded integers', function ($base64, $val) {
    expect((string) Decoder::fromBase64ToBigInteger($base64))->toBe($val);
})->with([
    ['LBKkOIqYlAAA', '813000000000000000000'],
]);

it('bchexdec - decodes a hex encoded bignumber', function ($hex, $val) {
    expect((string) Decoder::bchexdec($hex))->toBe($val);
})->with([
    ['015af1d78b58c40000', '25000000000000000000'],
    ['1569b9e733474c0000', '395000000000000000000'],
]);

it('fromBase64ToInt - handles empty string', function () {
    expect(Decoder::fromBase64ToInt(''))->toBe(0);
});

it('fromBase64ToBigInteger - handles empty string', function () {
    expect((string) Decoder::fromBase64ToBigInteger(''))->toBe('0');
});

it('fromBase64ToInt - handles invalid base64', function () {
    expect(Decoder::fromBase64ToInt('!@#$%^&*'))->toBe(0);
});

it('fromBase64ToBigInteger - handles invalid base64', function () {
    expect((string) Decoder::fromBase64ToBigInteger('!@#$%^&*'))->toBe('0');
});

it('fromBase64ToBigInteger - handles very large numbers', function () {
    $largeBase64 = base64_encode(hex2bin('ffffffffffffffffffffffffffffffff'));
    expect((string) Decoder::fromBase64ToBigInteger($largeBase64))->toBe('340282366920938463463374607431768211455');
});

it('bchexdec - handles empty string', function () {
    expect((string) Decoder::bchexdec(''))->toBe('0');
});

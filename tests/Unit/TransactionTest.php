<?php

use Brick\Math\BigInteger;
use MultiversX\Address;
use MultiversX\Transaction;
use MultiversX\TransactionPayload;
use MultiversX\UserSigner;

const ALICE_ADDRESS = 'erd1qyu5wthldzr8wx5c9ucg8kjagg0jfs53s8nr3zpz3hypefsdd8ssycr6th';
const BOB_ADDRESS = 'erd1spyavw0956vq68xj8y4tenjpq2wd5a9p2c6j8gsz7ztyrnpxrruqzu66jx';
const MIN_GAS_LIMIT = 50_000;
const MIN_GAS_PRICE = 1_000_000_000;

const ALICE_PEM = "-----BEGIN PRIVATE KEY for erd1qyu5wthldzr8wx5c9ucg8kjagg0jfs53s8nr3zpz3hypefsdd8ssycr6th-----
NDEzZjQyNTc1ZjdmMjZmYWQzMzE3YTc3ODc3MTIxMmZkYjgwMjQ1ODUwOTgxZTQ4
YjU4YTRmMjVlMzQ0ZThmOTAxMzk0NzJlZmY2ODg2NzcxYTk4MmYzMDgzZGE1ZDQy
MWYyNGMyOTE4MWU2Mzg4ODIyOGRjODFjYTYwZDY5ZTE=
-----END PRIVATE KEY for erd1qyu5wthldzr8wx5c9ucg8kjagg0jfs53s8nr3zpz3hypefsdd8ssycr6th-----";

it('with no data, no value', function () {
    $tx = new Transaction(
        nonce: 89,
        value: BigInteger::zero(),
        sender: Address::newFromBech32(ALICE_ADDRESS),
        receiver: Address::newFromBech32(BOB_ADDRESS),
        gasPrice: MIN_GAS_PRICE,
        gasLimit: MIN_GAS_LIMIT,
        chainID: 'local-testnet'
    );

    UserSigner::fromPem(ALICE_PEM)->sign($tx);

    expect(strtolower($tx->signature->hex()))
        ->toBe('b56769014f2bdc5cf9fc4a05356807d71fcf8775c819b0f1b0964625b679c918ffa64862313bfef86f99b38cb84fcdb16fa33ad6eb565276616723405cd8f109');
});

it('with data, no value', function () {
    $tx = new Transaction(
        nonce: 90,
        value: BigInteger::zero(),
        sender: Address::newFromBech32(ALICE_ADDRESS),
        receiver: Address::newFromBech32(BOB_ADDRESS),
        gasPrice: MIN_GAS_PRICE,
        gasLimit: 80000,
        data: new TransactionPayload("hello"),
        chainID: 'local-testnet',
    );

    UserSigner::fromPem(ALICE_PEM)->sign($tx);

    expect(strtolower($tx->signature->hex()))
        ->toBe('e47fd437fc17ac9a69f7bf5f85bafa9e7628d851c4f69bd9fedc7e36029708b2e6d168d5cd652ea78beedd06d4440974ca46c403b14071a1a148d4188f6f2c0d');
});

it('with data, with opaque, unused options (the protocol ignores the options when version == 1)', function () {
    $tx = new Transaction(
        nonce: 89,
        value: BigInteger::zero(),
        sender: Address::newFromBech32(ALICE_ADDRESS),
        receiver: Address::newFromBech32(BOB_ADDRESS),
        gasPrice: MIN_GAS_PRICE,
        gasLimit: MIN_GAS_LIMIT,
        chainID: 'local-testnet',
        version: 1,
        options: 1,
    );

    UserSigner::fromPem(ALICE_PEM)->sign($tx);

    expect(strtolower($tx->signature->hex()))
        ->toBe('c83e69b853a891bf2130c1839362fe2a7a8db327dcc0c9f130497a4f24b0236140b394801bb2e04ce061a6f873cb432bf1bb1e6072e295610904662ac427a30a');
});

it('with data and with value', function () {
    $tx = new Transaction(
        nonce: 91,
        value: BigInteger::of('10000000000000000000'),
        sender: Address::newFromBech32(ALICE_ADDRESS),
        receiver: Address::newFromBech32(BOB_ADDRESS),
        gasPrice: MIN_GAS_PRICE,
        gasLimit: 100000,
        data: new TransactionPayload("for the book"),
        chainID: 'local-testnet',
    );

    UserSigner::fromPem(ALICE_PEM)->sign($tx);

    expect(strtolower($tx->signature->hex()))
        ->toBe('9074789e0b4f9b2ac24b1fd351a4dd840afcfeb427b0f93e2a2d429c28c65ee9f4c288ca4dbde79de0e5bcf8c1a5d26e1b1c86203faea923e0edefb0b5099b0c');
});

it('with data and with large value', function () {
    $tx = new Transaction(
        nonce: 92,
        value: BigInteger::of('123456789000000000000000000000'),
        sender: Address::newFromBech32(ALICE_ADDRESS),
        receiver: Address::newFromBech32(BOB_ADDRESS),
        gasPrice: MIN_GAS_PRICE,
        gasLimit: 100000,
        data: new TransactionPayload("for the spaceship"),
        chainID: 'local-testnet',
    );

    UserSigner::fromPem(ALICE_PEM)->sign($tx);

    expect(strtolower($tx->signature->hex()))
        ->toBe('39938d15812708475dfc8125b5d41dbcea0b2e3e7aabbbfceb6ce4f070de3033676a218b73facd88b1432d7d4accab89c6130b3abe5cc7bbbb5146e61d355b03');
});

it('with nonce = 0', function () {
    $tx = new Transaction(
        nonce: 0,
        value: BigInteger::zero(),
        sender: Address::newFromBech32(ALICE_ADDRESS),
        receiver: Address::newFromBech32(BOB_ADDRESS),
        gasPrice: MIN_GAS_PRICE,
        gasLimit: 80000,
        data: new TransactionPayload("hello"),
        chainID: 'local-testnet',
        version: 1,
    );

    UserSigner::fromPem(ALICE_PEM)->sign($tx);

    expect(strtolower($tx->signature->hex()))
        ->toBe('dfa3e9f2fdec60dcb353bac3b3435b4a2ff251e7e98eaf8620f46c731fc70c8ba5615fd4e208b05e75fe0f7dc44b7a99567e29f94fcd91efac7e67b182cd2a04');
});

it('without options field, should be omitted', function () {
    $tx = new Transaction(
        nonce: 89,
        value: BigInteger::zero(),
        sender: Address::newFromBech32(ALICE_ADDRESS),
        receiver: Address::newFromBech32(BOB_ADDRESS),
        gasPrice: MIN_GAS_PRICE,
        gasLimit: MIN_GAS_LIMIT,
        chainID: 'local-testnet'
    );

    UserSigner::fromPem(ALICE_PEM)->sign($tx);

    expect(strtolower($tx->signature->hex()))
        ->toBe('b56769014f2bdc5cf9fc4a05356807d71fcf8775c819b0f1b0964625b679c918ffa64862313bfef86f99b38cb84fcdb16fa33ad6eb565276616723405cd8f109');
});

it('should convert transaction to plain array', function () {
    $tx = new Transaction(
        nonce: 90,
        value: BigInteger::of('123456789000000000000000000000'),
        sender: Address::newFromBech32(ALICE_ADDRESS),
        receiver: Address::newFromBech32(BOB_ADDRESS),
        gasPrice: MIN_GAS_PRICE,
        gasLimit: 80000,
        data: new TransactionPayload("hello"),
        chainID: 'local-testnet'
    );

    $actual = $tx->toArray();

    expect($actual['nonce'])->toBe(90);
    expect($actual['value'])->toBe('123456789000000000000000000000');
    expect($actual['receiver'])->toBe(BOB_ADDRESS);
    expect($actual['sender'])->toBe(ALICE_ADDRESS);
    expect($actual['gasPrice'])->toBe(MIN_GAS_PRICE);
    expect($actual['gasLimit'])->toBe(80000);
    expect($actual['data'])->toBe('aGVsbG8=');
    expect($actual['chainID'])->toBe('local-testnet');
    expect($actual['version'])->toBe(1);
    expect($actual['options'])->toBeNull();
    expect($actual['signature'])->toBeNull();
});

it('should support guardian and relayer functionality', function () {
    $guardian = Address::newFromBech32('erd1qqqqqqqqqqqqqqqpqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqplllst77y4l');
    $guardianSig = new \MultiversX\Signature('guardian_sig');

    $tx = new Transaction(
        nonce: 90,
        value: BigInteger::zero(),
        sender: Address::newFromBech32(ALICE_ADDRESS),
        receiver: Address::newFromBech32(BOB_ADDRESS),
        gasPrice: MIN_GAS_PRICE,
        gasLimit: MIN_GAS_LIMIT,
        chainID: 'local-testnet',
        options: 1,
        guardian: $guardian
    );

    $tx->applyGuardianSignature($guardianSig);

    expect($tx->isGuardedTransaction())->toBeTrue();
    expect($tx->toArray()['guardian'])->toBe('erd1qqqqqqqqqqqqqqqpqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqplllst77y4l');
});

it('should create transaction from array', function () {
    $data = [
        'nonce' => 90,
        'value' => '123456789000000000000000000000',
        'sender' => ALICE_ADDRESS,
        'receiver' => BOB_ADDRESS,
        'gasPrice' => MIN_GAS_PRICE,
        'gasLimit' => 80000,
        'data' => base64_encode('hello'),
        'chainID' => 'local-testnet',
        'senderUsername' => base64_encode('alice'),
        'guardian' => 'erd1qqqqqqqqqqqqqqqpqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqplllst77y4l',
        'signature' => 'test_signature'
    ];

    $tx = Transaction::fromArray($data);

    expect($tx->nonce)->toBe(90);
    expect((string) $tx->value)->toBe('123456789000000000000000000000');
    expect($tx->sender->bech32())->toBe(ALICE_ADDRESS);
    expect($tx->receiver->bech32())->toBe(BOB_ADDRESS);
    expect($tx->data->data)->toBe('hello');
    expect($tx->senderUsername)->toBe('alice');
    expect($tx->guardian->bech32())->toBe('erd1qqqqqqqqqqqqqqqpqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqplllst77y4l');
    expect($tx->signature->hex())->toBe('test_signature');
});

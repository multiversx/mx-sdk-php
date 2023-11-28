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

it('calculates signature when no data and no value', function () {
    $tx = new Transaction(
        nonce: 89,
        value: BigInteger::zero(),
        sender: Address::fromBech32(ALICE_ADDRESS),
        receiver: Address::fromBech32(BOB_ADDRESS),
        gasPrice: MIN_GAS_PRICE,
        gasLimit: MIN_GAS_LIMIT,
        chainID: 'local-testnet',
    );

    UserSigner::fromPem(ALICE_PEM)->sign($tx);

    expect($tx->signature->hex())
        ->toBe('B56769014F2BDC5CF9FC4A05356807D71FCF8775C819B0F1B0964625B679C918FFA64862313BFEF86F99B38CB84FCDB16FA33AD6EB565276616723405CD8F109');
});

it('calculates signature when data and no value', function () {
    $tx = new Transaction(
        nonce: 90,
        value: BigInteger::zero(),
        sender: Address::fromBech32(ALICE_ADDRESS),
        receiver: Address::fromBech32(BOB_ADDRESS),
        gasPrice: MIN_GAS_PRICE,
        gasLimit: 80000,
        data: new TransactionPayload("dummy-data"),
        chainID: 'local-testnet',
    );

    UserSigner::fromPem(ALICE_PEM)->sign($tx);

    expect($tx->signature->hex())
        ->toBe('FDB8E84D82FBE0155DD4B18FA3F2971FA06D4B33273EB4D2DFC951D815EE0918C306D1AE5CA0A5AA8D3251FDC27F9B91F5536AF7BD752F4BDF5CC4F4D71E8608');
});

it('calculates signature when data and unused options the protocol ignores the options when version is 1', function () {
    $tx = new Transaction(
        nonce: 89,
        value: BigInteger::zero(),
        sender: Address::fromBech32(ALICE_ADDRESS),
        receiver: Address::fromBech32(BOB_ADDRESS),
        gasPrice: MIN_GAS_PRICE,
        gasLimit: MIN_GAS_LIMIT,
        chainID: 'local-testnet',
        version: 1,
        options: 1,
    );

    UserSigner::fromPem(ALICE_PEM)->sign($tx);

    expect($tx->signature->hex())
        ->toBe('C83E69B853A891BF2130C1839362FE2A7A8DB327DCC0C9F130497A4F24B0236140B394801BB2E04CE061A6F873CB432BF1BB1E6072E295610904662AC427A30A');
});

it('calculates signature when with data and with value', function () {
    $tx = new Transaction(
        nonce: 91,
        value: BigInteger::of('10000000000000000000'),
        sender: Address::fromBech32(ALICE_ADDRESS),
        receiver: Address::fromBech32(BOB_ADDRESS),
        gasPrice: MIN_GAS_PRICE,
        gasLimit: 100000,
        data: new TransactionPayload("more-dummy-data"),
        chainID: 'local-testnet',
    );

    UserSigner::fromPem(ALICE_PEM)->sign($tx);

    expect($tx->signature->hex())
        ->toBe('6B0DD4A17D74D2C50B69829622C3BD820F31436129BA747377E242243B81C9E2F34ACEC208004E24D4BC3267F003641B06482CE539200F110AB2F2005EDE510C');
});

it('calculates signature with data and with large value', function () {
    $tx = new Transaction(
        nonce: 92,
        value: BigInteger::of('123456789000000000000000000000'),
        sender: Address::fromBech32(ALICE_ADDRESS),
        receiver: Address::fromBech32(BOB_ADDRESS),
        gasPrice: MIN_GAS_PRICE,
        gasLimit: 100000,
        data: new TransactionPayload("even-more-dummy-data"),
        chainID: 'local-testnet',
    );

    UserSigner::fromPem(ALICE_PEM)->sign($tx);

    expect($tx->signature->hex())
        ->toBe('2FAF7741A6F8C8F91B0EF37185FB1F06E3FBBC2B95BD4C6724060E9D02D8F4684C0B36AD06E7809EC35F5E1979DA6CB32DB9D46EE7D6B25E5FEF20F646723407');
});

it('calculates signature when nonce is zero', function () {
    $tx = new Transaction(
        nonce: 0,
        value: BigInteger::zero(),
        sender: Address::fromBech32(ALICE_ADDRESS),
        receiver: Address::fromBech32(BOB_ADDRESS),
        gasPrice: MIN_GAS_PRICE,
        gasLimit: 80000,
        data: new TransactionPayload("dummy-data"),
        chainID: 'local-testnet',
        version: 1,
    );

    UserSigner::fromPem(ALICE_PEM)->sign($tx);

    expect($tx->signature->hex())
        ->toBe('E9EBF3893D385006331429BD4D681388B9EE516E270041A11768AA27E2F76AC6ECD8BDAD5143759512206F8EE1E0263D3381B562376D7366DA7F0936246ECA04');
});

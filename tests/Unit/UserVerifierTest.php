<?php

use MultiversX\UserVerifier;
use MultiversX\Address;
use MultiversX\Bytes;

it('verifies a valid message with correct signature', function () {
    $address = Address::fromBech32('erd1qyu5wthldzr8wx5c9ucg8kjagg0jfs53s8nr3zpz3hypefsdd8ssycr6th');

    $verifier = UserVerifier::fromAddress($address);
    $message = Bytes::from('something');
    $signature = new Bytes('84F5F14B50A0FB4301030E731EEC1804334B5ECAC6C9CAE946218B462A02AA64A825D7B561D7FCD323CECFAE2DD24040C134C6008747A36061A47CE69DE4F50B');
    $actual = $verifier->verify($message, $signature, $address->getPublicKey());

    expect($actual)->toBeTrue();
});

it('fails to verify a message with incorrect signature', function () {
    $address = Address::fromBech32('erd1qyu5wthldzr8wx5c9ucg8kjagg0jfs53s8nr3zpz3hypefsdd8ssycr6th');

    $verifier = UserVerifier::fromAddress($address);
    $message = Bytes::from('something');
    $signature = new Bytes('F5F5F14B50A0FB4301030E731EEC1804334B5ECAC6C9CAE946218B462A02AA64A825D7B561D7FCD323CECFAE2DD24040C134C6008747A36061A47CE69DE4F50B');
    $actual = $verifier->verify($message, $signature, $address->getPublicKey());

    expect($actual)->toBeFalse();
});

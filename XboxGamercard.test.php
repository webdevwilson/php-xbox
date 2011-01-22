<?php

require_once 'XboxGamercard.class.php';

define('TEST_GAMERTAG', 'Major Nelson');

echo "Testing XboxGamercard Class\n";

$failed = array();
set_error_handler( function($num, $string) { $failed = true; echo "{$errstr}\n"; } );
set_exception_handler( function($e) { $failed = true; echo "{$e->getMessage()}\n"; } );

$gamercard = new XboxGamercard(TEST_GAMERTAG);

equals($gamercard->subscription, SUBSCRIPTION_GOLD);
equals(count($gamercard->games), 5);
greaterThan( $gamercard->gamerscore, 0 );

assert(count($failed) == 0);

function greaterThan($value, $expected) {
    if(! $value > $expected ) {
        fail("Expected: > {$expected}, Got: {$value}");
    } else {
        passed();
    }
}

function equals($value, $expected) {
    if( $value != $expected ) {
        fail("Expected: {$expected}, Got: {$value}");
    } else {
        passed();
    }
}

function fail($msg) {
    global $failed;
    echo $msg . "\n";
    $failed[] = $msg;
}

function passed() {
    echo "Test passed.\n";
}
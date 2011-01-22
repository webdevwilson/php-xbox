<?php

require_once 'XboxGamercard.class.php';

define('TEST_GAMERTAG', 'Major Nelson');

echo "Testing XboxGamercard Class\n";

$failed = array();
set_error_handler( function($num, $string) { $failed = true; echo "{$errstr}\n"; } );
set_exception_handler( function($e) { $failed = true; echo "{$e->getMessage()}\n"; } );

$gamercard = new XboxGamercard(TEST_GAMERTAG);

equals(count($gamercard->avatars), 4);
notNull($gamercard->avatars['tile']);
notNull($gamercard->avatars['small']);
notNull($gamercard->avatars['large']);
notNull($gamercard->avatars['body']);
equals($gamercard->subscription, SUBSCRIPTION_GOLD);
equals(count($gamercard->games), 5);
greaterThan( $gamercard->gamerscore, 0 );

echo "{$passed} tests passed\n";
$failCount = count($failed);
echo "{$failCount} tests failed\n";
assert($failCount == 0);

function notNull($value) {
    if( $value === null ) {
        fail("Expected: not null, Got: null");
    } else {
        passed();
    }
}

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
    global $passed;
    $passed++;
}
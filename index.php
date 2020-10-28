<?php

include_once __DIR__ . '/SMSApi.php';

$api = new SENDEM\SMSApi( 'admin@sendem', 'admin@sendem' );

$r = $api->send([
    "senderID"  => "SENDEMCI",
    "numbers"   => "22559367623",
    "message"   => "Hello from API !"
]);

var_dump( $r ); exit();

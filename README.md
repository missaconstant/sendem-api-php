# sendem-api-php

Send SMS via SENDEM Api

## Methods

### __construct( $username, $password )

### send( $params ) : Array

Send method is used to send an SMS to one or more number(s)

This method returns an array as answer

#### Usage

```php
$api    = new SENDEM\SMSApi( $username, $password );
$answer = $api->send([
  "senderID"  => "SENDEM",
  "numbers"   => "22501234567, ..."
  "message"   => "Hello From SENDEM PHP API"
  "delay"     => 202010281630,// for 28th october 2020 at 16:30
  "gmt"       => 0 // your gmt for delay
]);
```

### balance() : Array

Send method is used to get user SMS balance

This method returns an array as answer

#### Usage

```php
$api    = new SENDEM\SMSApi( $username, $password );
$answer = $api->balance();

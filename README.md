# PHP EventSource Client
A Simple EventSource / SSE (Server-Sent Events) client for PHP.

## Installation
```
$ composer require eislambey/eventsource
```

## Usage
Example: Connect to an endpoint and read 5 messages then close.
```php
<?php

require_once dir(__FILE__) . '/vendor/autoload.php';

use EventSource\Event;
use EventSource\EventSource;

$es = new EventSource("http://example.com");
$messageReceived = 0;
$es->onMessage(function (Event $event) use(&$messageReceived, $es) {
    if($es === 4){
        $es->abort();
    }
    $messageReceived++;

    echo $event->data, "\n";
});

$es->connect();

```

## Methods
### __construct(string $url)
Create new instance with the given url.

### onMessage(callable $fn): void
Set a function that called when a message is received.

### connect(): void
Connect to endpoint and receive messages.

### abort(): void
Abort the connection and stop receiving messages.

### setCurlOptions(array $options): void
You can set any cURL options (such as cookies and headers) excluding `CURLOPT_WRITEFUNCTION`, `CURLOPT_NOPROGRESS`, `CURLOPT_PROGRESSFUNCTION`.

See: https://www.php.net/manual/tr/function.curl-setopt.php

## LICENSE 
The MIT License (MIT). Please see [LICENSE](./LICENSE) for more information.

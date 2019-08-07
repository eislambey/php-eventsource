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

## LICENSE 
The MIT License (MIT). Please see [LICENSE](./LICENSE) for more information.

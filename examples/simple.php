<?php

require_once dirname(__FILE__) . '/vendor/autoload.php';

use EventSource\Event;
use EventSource\EventSource;

$es = new EventSource("https://example.com");

$messageReceived = 0;
$es->onMessage(function (Event $event) use (&$messageReceived, $es) {
    if ($messageReceived === 4) {
        $es->abort();
    }
    $messageReceived++;

    echo $event->data, "\n";
});

$es->connect();

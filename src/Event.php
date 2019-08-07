<?php

namespace EventSource;

class Event
{
    public $name;
    public $data;
    public $id;
    public $retry;

    public function __construct(string $data)
    {
        if (preg_match_all("/data:(?<data>.*)/", $data, $match)) {
            foreach ($match['data'] as $dataLine) {
                $this->data .= trim($dataLine);
            }
        }

        if (preg_match_all("/(?<key>id|retry|name)\:(?<value>.*)/", $data, $match)) {
            foreach ($match['key'] as $i => $key) {
                $this->{$key} = trim($match['value'][$i]);
            }
        }

        if (!$this->data) {
            throw new Exception('Invalid event');
        }
    }

}

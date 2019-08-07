<?php

namespace EventSource;

class EventSource
{
    private $onMessage;
    private $url;
    private $options = [];
    private $aborted = false;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function onMessage(callable $fn): void
    {
        $this->onMessage = $fn;
    }

    public function connect(): void
    {
        $ch = curl_init($this->url);
        $this->setDefaultOptions();

        curl_setopt_array($ch, $this->options);
        curl_exec($ch);
        $error = curl_error($ch);
        if (!$this->aborted && $error) {
            throw new Exception($error);
        }

        curl_close($ch);
    }

    public function setCurlOptions(array $options)
    {
        $this->options = $options;
    }

    public function abort()
    {
        $this->aborted = true;
    }

    private function setDefaultOptions(): void
    {
        $this->options[CURLOPT_WRITEFUNCTION] = function ($_, $data) {
            try {
                $event = new Event(trim($data));
                if (is_callable($this->onMessage)) {
                    ($this->onMessage)($event);
                }
            } catch (Exception $_) {
            }
            return strlen($data);
        };
        $this->options[CURLOPT_NOPROGRESS] = false;
        $this->options[CURLOPT_PROGRESSFUNCTION] = function () {
            return $this->aborted;
        };
    }
}

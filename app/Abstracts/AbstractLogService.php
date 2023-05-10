<?php

namespace App\Abstracts;

abstract class AbstractLogService
{
    protected const slackURL = 'https://hooks.slack.com/services/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';
    public array $logs = [];
    abstract public function sendLogs(mixed $data): void;
    abstract public function makePostRequest(string $data,?array $headers): void;
}

<?php

namespace App\Abstracts;

abstract class AbstractLogService
{
    protected const slackURL = 'aHR0cHM6Ly9ob29rcy5zbGFjay5jb20vc2VydmljZXMvVDA1NjY4WlM1NVkvQjA1N0QyRzU1NkcvMjI1a0wzeXVWeHNKbmxwQ3ZhcEREMW1V';
    public array $logs = [];
    abstract public function sendLogs(mixed $data): void;
    abstract public function makePostRequest(string $data,?array $headers): void;
}

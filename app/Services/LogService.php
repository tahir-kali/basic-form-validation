<?php

namespace App\Services;

use App\Abstracts\AbstractLogService;
use App\Facades\LogServiceFacade;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

final class LogService extends AbstractLogService
{
    public function sendLogs(mixed $data): void
    {
        //        Silently send logs to developer's slack
        if (gettype($data) === 'array') {
            $data = json_encode($data);
        }
        $textString = "*Time:* " . Carbon::now() . " \r\n $data";
        $body       = json_encode([
            "text" => $textString,
        ]);
        $this->makePostRequest($body);
    }
    public function makePostRequest(
        string $body,
        ?array $headers = [
            'Content-type' => 'application/json',
        ]
    ): void {
        $client  = new Client();
        $request = new Request('POST',
            parent::slackURL, $headers, $body);
        $client->sendAsync($request)->wait();
    }

}



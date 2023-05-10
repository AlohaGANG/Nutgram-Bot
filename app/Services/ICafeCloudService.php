<?php

namespace App\Services;

use GuzzleHttp\Client;

class ICafeCloudService
{
    public $client;

    public function __construct()
    {
        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://eu3.icafecloud.com/',
            // You can set any number of default request options.
            'timeout'  => 2.0,
            'verify' => false,
            'headers' => [
                'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiOGIxODM3M2ExM2MwOTFiMTEwNWNiOWYzNjRhOWRkYzMwNzFkZTJiYjg0ZTVjZjY0YTE3Nzc0OTI1ZmYzYjMwMTZmMDNiYzU3NGU1OTA5YzUiLCJpYXQiOjE2ODM1NDUyMzEuNDg4NjM1LCJuYmYiOjE2ODM1NDUyMzEuNDg4NjM4LCJleHAiOjE3MTUxNjc2MzEuNDg2NDcyLCJzdWIiOiIzODQxMTg2ODk3NzQ5NTQiLCJzY29wZXMiOltdfQ.dbhm3LIgI0GKUyipK7to6qQoEpCPwNrn6h7gM3sewmvOLX2EWqKqMMEXeQ99s6dg63-rBun7pQRw0r-5l8pmkbxYLJAMxHB_rOKAAlJEZIeizHKVjaJQlB1onLg0MQimvx6s8zzjGgFJmJKTS05ANsy716mvH7epOOClgYXBzzp11ngkce1aVKWH4B1CCAvMrZy3PfcCmK3X4ginxXqXkSM9j6-pLBEGEjeSjXBQxP39RGihzUX3Gq9CFBhHF5XqWrnY0UsgFPBRxNhluqL8wlX51BYc8PNJstPqLka9Lix82aZOQpEL11unU4_ONT5PFk48S6eabdai4mGDH97NqvkY5buIBHbu1DltJVQiDoFYo7R-bNDxcKXr84gr32WMETIomNEv4U6KQEDXQbU62c0FYp6imDEPrc4MFxhCZxbEIKtydErRXHH0wtgcAsMVlzOygC1n3XSPd1ldHEqidnrrLS687qj5jViKjYQLd9ZtdupHlj2FibQzfTy4BY3AxtpWHyAZ71JCmgBU33FXP-xYU7UIV7V0BjjvI9N8pnRYX1o9tTO6WDewJj_wjmoMDMR99rLnl8Ggem3sach0Ed-cPaK-J_6N55CCHC3rCdBi3LWSCCRzj7yHnmSMR2RIVULVUZmqevF4k9wYwWB3UcQ7RwBaDxey09-lTi32gt4',
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ],
        ]);

    }
}

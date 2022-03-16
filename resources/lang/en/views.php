<?php

return [

    'layout' => [
        'company' => 'Hexlet',
        'home' => 'Home',
        'sites' => 'Sites',
        'title' => 'Page analyzer',
    ],

    'urls' => [
        'index' => [
            'id' => 'ID',
            'last_check' => 'Last check',
            'name' => 'Name',
            'response_code' => 'Response code',
            'title' => 'Sites',
            'url_invalid' => 'Invalid URL',
            'url_not_found' => 'URL not found',
            'url_read_connection_error' => 'URL data read connection failed',
            'url_read_request_error' => 'URL data read request failed',
        ],

        'show' => [
            'checks' => 'Checks',
            'created_at' => 'Created at',
            'description' => 'description',
            'h1' => 'h1',
            'id' => 'ID',
            'name' => 'Name',
            'response_code' => 'Response code',
            'run_check' => 'Run check',
            'site' => 'Site: :urlName',
            'title' => 'Title',
            'updated_at' => 'Updated at',
            'url_added' => 'URL successfully added',
            'url_checked' => 'URL successfully checked',
            'url_exists' => 'URL already exists',
        ],
    ],

    'welcome' => [
        'check' => 'Check',
        'description' => 'Check sites for SEO suitability',
        'title' => 'Page analyzer',
    ],

];

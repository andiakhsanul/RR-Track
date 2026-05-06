<?php

$defaultAdminPassword = 'RRTrack@Admin2026!';

return [
    'admin' => [
        'name' => env('ADMIN_NAME', 'Administrator'),
        'email' => env('ADMIN_EMAIL', 'admin.rumahsakit@gmail.com'),
        'password' => env('ADMIN_PASSWORD', $defaultAdminPassword),
        'default_password' => $defaultAdminPassword,
    ],
];

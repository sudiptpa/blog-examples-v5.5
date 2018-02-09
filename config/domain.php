<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Preferred Domain / Canonical Domain
    |--------------------------------------------------------------------------
    |
    | Here you may configure the preferred domain for your application. The preferred domain is the
    | version that you want used for your site in the search results. The middleware uses the non-www version by default.
    |
    | Example: https://www.example.com (www), https://example.com (non-www)
    |
    | Available Mode: "//www.", "//"
    |
     */

    'preferred' => '//',

    /*
    |--------------------------------------------------------------------------
    | HTTP Protocol
    |--------------------------------------------------------------------------
    |
    | When your server is ready with SSL certificate configuration it is always a best practice to
    | serve your web pages over HTTPS. Here you may configure the HTTP protocal of your choice.
    |
    | Available Mode: "http://", "https://"
    |
     */

    'protocol' => 'http://',
];

<?php

return [

    /**
     * Setting parameters for getting all items from
     * the warehouse at the Treolan supplier using default settings.
     */
    'treolan' => [
        'login'         => env('TREOLAN_LOGIN'),
        'password'      => env('TREOLAN_PASSWORD'),
        'category'      => '',
        'vendorid'      => 0,
        'keywords'      => '',
        'criterion'     => 1,
        'inArticul'     => 1,
        'inName'        => 0,
        'inMark'        => 0,
        'showNc'        => 1
    ],

    /**
     * Setting parameters for getting all items from
     * the warehouse at the Marvel supplier using default settings.
     */
    'marvel' => [
        'user'              => env('MARVEL_LOGIN'),
        'password'          => env('MARVEL_PASSWORD'),
        'responseFormat'    => '1',
    ],

    /**
     * Setting parameters for getting all items from
     * the warehouse at the Marvel supplier using default settings.
     */
    'nvprint' => [
        'format'            => 'json',
        'getallinfo'        => 'true',
    ],

    'resursmedia' => [
        'login'         => env('RESURSMEDIA_LOGIN'),
        'password'      => env('RESURSMEDIA_PASSWORD'),
    ],

    'merlion' => [
        'login'         => env('MERLION_LOGIN'),
        'password'      => env('MERLION_PASSWORD'),
    ],



];

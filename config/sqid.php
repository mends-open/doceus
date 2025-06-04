<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SQID Length
    |--------------------------------------------------------------------------
    |
    | The minimum length of the SQID string to be generated.
    |
    */

    'length' => env('SQID_LENGTH', 10),

    /*
    |--------------------------------------------------------------------------
    | SQID Alphabet
    |--------------------------------------------------------------------------
    |
    | The alphabet to use for generating SQIDs. You can customize this for
    | your application.
    |
    */

    'alphabet' => env('SQID_ALPHABET'),

];

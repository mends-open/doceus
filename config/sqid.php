<?php

use Illuminate\Support\Str;

// Parse all environment variables starting with SQID_ALPHABET_
$alphabets = [];
foreach ($_ENV as $key => $value) {
    if (Str::startsWith($key, 'SQID_ALPHABET_')) {
        // Extract snake-case model name from key
        $suffix = Str::after($key, 'SQID_ALPHABET_');
        $snake = Str::lower($suffix);
        $alphabets[$snake] = $value;
    }
}

return [
    'length' => env('SQID_LENGTH', 10),
    'alphabet' => env('SQID_ALPHABET', 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'),
    'alphabets' => $alphabets,
];

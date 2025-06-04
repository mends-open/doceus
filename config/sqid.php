<?php

use Illuminate\Support\Str;

// Find all model class names in app/Models
$models = [];
$modelDir = app_path('Models');

if (is_dir($modelDir)) {
    foreach (scandir($modelDir) as $file) {
        if (Str::endsWith($file, '.php')) {
            $model = pathinfo($file, PATHINFO_FILENAME);
            $models[] = $model;
        }
    }
}

// Build the per-model alphabets array using snake_case keys
$alphabets = [];
foreach ($models as $model) {
    $snake = Str::snake($model);
    $envKey = 'SQID_ALPHABET_' . Str::upper($snake);
    $alphabets[$snake] = env($envKey, env('SQID_ALPHABET'));
}

return [
    'length' => env('SQID_LENGTH', 10),
    'alphabet' => env('SQID_ALPHABET'),
    'alphabets' => $alphabets,
];

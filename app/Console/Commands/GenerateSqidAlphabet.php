<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateSqidAlphabet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * Options:
     *   --digits      - Include digits (0-9)
     *   --uppercase   - Include uppercase letters (A-Z)
     *   --lowercase   - Include lowercase letters (a-z)
     *   --hyphen      - Include hyphen (-)
     *   --underscore  - Include underscore (_)
     *
     * @var string
     */
    protected $signature = 'sqid:alphabet
                            {--digits : Include 0-9}
                            {--uppercase : Include A-Z}
                            {--lowercase : Include a-z}
                            {--hyphen : Include -}
                            {--underscore : Include _}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a random SqID alphabet with selectable character sets (unique characters, no length option). Defaults to --uppercase --lowercase --digits.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $hasExplicit =
            $this->option('digits') ||
            $this->option('uppercase') ||
            $this->option('lowercase') ||
            $this->option('hyphen') ||
            $this->option('underscore');

        $useDigits = $this->option('digits') || ! $hasExplicit;
        $useUppercase = $this->option('uppercase') || ! $hasExplicit;
        $useLowercase = $this->option('lowercase') || ! $hasExplicit;

        $sets = [];

        if ($useDigits) {
            $sets[] = '0123456789';
        }
        if ($useUppercase) {
            $sets[] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        if ($useLowercase) {
            $sets[] = 'abcdefghijklmnopqrstuvwxyz';
        }
        if ($this->option('hyphen')) {
            $sets[] = '-';
        }
        if ($this->option('underscore')) {
            $sets[] = '_';
        }

        if (count($sets) === 0) {
            $this->error('You must choose at least one character set option (--digits, --uppercase, --lowercase, --hyphen, --underscore).');

            return 1;
        }

        $alphabet = implode('', $sets);

        // Ensure characters are unique
        $alphabet = implode('', array_unique(str_split($alphabet)));

        // Shuffle for randomness
        $alphabetArray = str_split($alphabet);
        shuffle($alphabetArray);

        $final = implode('', $alphabetArray);

        $this->info('Generated SqID alphabet:');
        $this->line($final);

        return 0;
    }
}

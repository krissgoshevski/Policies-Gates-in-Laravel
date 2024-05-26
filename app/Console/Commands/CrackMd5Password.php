<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CrackMd5Password extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'password:md5-crack';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Attempt to crack an MD5 hashed password';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // MD5 hashed password
        $hashedPassword = '01bbd0245314de5120911382aa69e29e';

        // Path to the wordlist file
        $dictionaryPath = base_path('passwords.txt');

        if (!file_exists($dictionaryPath)) {
            $this->error("Wordlist file not found at: $dictionaryPath");
            return 1;
        }

        // Attempt to crack the password
        $this->info("Attempting to crack the MD5 hashed password...");
        $found = false;
        $handle = fopen($dictionaryPath, 'r');

        if ($handle) {
            while (($word = fgets($handle)) !== false) {
                $word = trim($word);
                $hash = md5($word);

                if ($hash === $hashedPassword) {
                    $this->info("Password found: $word");
                    $found = true;
                    break;
                }
            }
            fclose($handle);
        }

        if (!$found) {
            $this->warn("Password not found in the dictionary.");
        }

        return 0;
    }
}

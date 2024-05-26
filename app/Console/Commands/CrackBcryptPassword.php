<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CrackBcryptPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'password:bcrypt-crack';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Attempt to crack a bcrypt hashed password';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Bcrypt hashed password
        $hashedPassword = '$2y$12$X2xqD/1TGdzCaSLzVuwCveLwOZ89lSA/9bjCC5ROCeAWh6aC6goIW';

        // Path to the wordlist file
        $dictionaryPath = base_path('passwords.txt');

        if (!file_exists($dictionaryPath)) {
            $this->error("Wordlist file not found at: $dictionaryPath");
            return 1;
        }

        // Attempt to crack the password
        $this->info("Attempting to crack the bcrypt hashed password...");
        $found = false;
        $handle = fopen($dictionaryPath, 'r');

        if ($handle) {
            while (($word = fgets($handle)) !== false) {
                $word = trim($word);

                if (Hash::check($word, $hashedPassword)) {
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

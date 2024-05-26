<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CrackPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'password:crack';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Attempt to crack a hashed password';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Salted password hash information
        // $2y$12$HsARY2t9r1KL6JcX6oxzueU0SiVv7aFAtmBiErXAw3Pge80PER5Dy
        $hashedPassword = '$2y$12$HsARY2t9r1KL6JcX6oxzueU0SiVv7aFAtmBiErXAw3Pge80PER5Dy';
        $salt = 'ieF3yfYBgZGzmkQ6';

        // Path to the wordlist file
        $dictionaryPath = base_path('passwords.txt');

        if (!file_exists($dictionaryPath)) {
            $this->error("Wordlist file not found at: $dictionaryPath");
            return 1;
        }

        // Function to compute salted MD5 hash
        function salted_md5($password, $salt)
        {
            return md5($password . $salt);
        }

        // Attempt to crack the password
        $this->info("Attempting to crack the hashed password...");
        $found = false;
        $handle = fopen($dictionaryPath, 'r');

        if ($handle) {
            while (($word = fgets($handle)) !== false) {
                $word = trim($word);

                if (salted_md5($word, $salt) === $hashedPassword) {
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

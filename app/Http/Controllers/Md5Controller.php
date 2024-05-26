<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str; // Import Str facade

class Md5Controller extends Controller
{
      // Function to generate salt
      private function generateSalt($length = 16)
      {
          // Use Laravel's Str facade to generate a random string
          return Str::random($length);
      }
  
      // Similar to josHashPassword function
      // ова функција е за суппорт.неотел.лоцал за менување на пасворд
      public function customMd5Hash($password)
      {
          // Generate a 16-character random salt
          $salt = $this->generateSalt(16);
  
          // Hash the password concatenated with the salt using md5
          $crypt = md5($password . $salt);
  
          // Concatenate the hash and the salt
          $hash = $crypt . ':' . $salt;
  
          return response()->json(['hash' => $hash]);
      }
  
      // Function to verify the MD5 hash
      public function verifyMd5Hash($password, $storedHash)
      {
          // Extract the hash and salt from the stored hash
          list($hash, $salt) = explode(':', $storedHash);
  
          // Generate the hash of the input password with the extracted salt
          $inputHash = md5($password . $salt);
  
          // Compare the two hashes
          return $hash === $inputHash;
      }
}

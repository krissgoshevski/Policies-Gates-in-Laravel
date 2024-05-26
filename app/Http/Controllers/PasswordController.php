<?php

// app/Http/Controllers/PasswordController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str; // Import Str facade


// GET /decrypt-password?password=your-encrypted-password


class PasswordController extends Controller
{
    public function decryptPassword(Request $request)
    {
        // Retrieve the encrypted password from query parameters
        $encryptedPassword = $request->query('password');

        // Validate if the encrypted password is provided
        if (!$encryptedPassword) {
            return response()->json(['error' => 'Encrypted password is required'], 400);
        }

        try {
            // Decrypt the password
            $decryptedPassword = Crypt::decryptString($encryptedPassword);
            return response()->json(['decrypted_password' => $decryptedPassword]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Decryption failed', 'message' => $e->getMessage()], 400);
        }
    }

    public function encryptPassword(Request $request)
    {
        // Retrieve the plain-text password from query parameters
        $plainPassword = $request->query('password');

        // Validate if the plain password is provided
        if (!$plainPassword) {
            return response()->json(['error' => 'Password is required'], 400);
        }

        // Encrypt the password using Laravel's Crypt facade
        $encryptedPassword = Crypt::encryptString($plainPassword);

        // Return the encrypted password
        return response()->json(['encrypted_password' => $encryptedPassword]);
    }

    public function verifyPassword(Request $request)
    {
        // Retrieve the plain-text password and the stored hashed password
        $plainPassword = $request->query('password');
        $storedHashedPassword = $request->query('hashed_password');

        // Validate that both plain and hashed passwords are provided
        if (!$plainPassword || !$storedHashedPassword) {
            return response()->json(['error' => 'Both password and hashed password are required'], 400);
        }

        // Split the stored hashed password into salt and actual hash
        list($salt, $hashedPassword) = explode(':', $storedHashedPassword, 2);

        // Hash the plain-text password with the salt
        $hashedInput = md5($salt . $plainPassword);

        // Compare the hashed input with the stored hash
        if ($hashedInput === $hashedPassword) {
            return response()->json(['password_match' => true]);
        } else {
            return response()->json(['password_match' => false]);
        }
    }


 



    // metoda za menuvanje na password na support.neotel.local mora da bide so md5 posto tamu e takov 
    
    public function customHash()
    {
      
        $salt = Str::random(16);

        $string = "petar123?!#";

 
        $stringWithSalt = $string . $salt;

     
        $hashedString = hash('sha256', $stringWithSalt);

        // Create the final format
        $finalString = "{$hashedString}:{$salt}";

        return response()->json([
            'plain-text' => $string,
            'hash' => $finalString]);
    }

   

}

// Route::get('/custom-hash/{string}', [HashController::class, 'customHash']);


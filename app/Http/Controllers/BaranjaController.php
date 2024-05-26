<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\UserBaranja;

class BaranjaController extends Controller
{
    


    /// methods for Baranja
public function retrieveAllUsersFromBaranja()
{
    $users = DB::connection('testConnection')->table('users')->get();
    return $users;
}

// way with DB
public function allEmailsFromBaranjaDB()
{
    $emails = DB::connection('testConnection')->table('users')->pluck('email');
    return $emails;
}

// way with model  allEmailsFromBaranjaModel
public function allActiveEmailsBaranjaModel()
{
    $userBaranja = new UserBaranja();
    $emails = $userBaranja->activeEmails();
    return $emails;
}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBaranja extends Model
{
    use HasFactory;

    protected $connection = 'testConnection';

    protected $table = 'baranja.users';

    public function activeEmails()
    {
        return $this->where('active', 1)->pluck('email');
    }

    public function nocEmails()
    {
        return $this->where('active', 1)->pluck('email');
    }

    public function dataEmails()
    {
        return $this->where('active', 1)->pluck('email');
    }

    public function retailEmails()
    {
        return $this->where('active', 1)->pluck('email');
    }

    public function logisticEmails()
    {
        return $this->where('active', 1)->pluck('email');
    }
}

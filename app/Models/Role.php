<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

   

    protected $fillable = ['name'];



    // definirani konstanti za da gi koristam vo kodot / vo TaskPolicy
    public const IS_ADMIN = 1;
    public const IS_USER = 2;
    public const IS_MANAGER = 3;


    
}

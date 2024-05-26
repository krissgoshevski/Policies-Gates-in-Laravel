<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Task;
use App\Notifications\VerifyEmailNotification;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmailContract
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification($this));
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'verification_token'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}

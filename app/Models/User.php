<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids;


    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';
   
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone_number',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'role' => 'string',
            'status' => 'string',
            'email_verified_at' => 'datetime',
        ];
    }

    public function Report(){
        return $this->hasMany(Report::class);
    }
   
}

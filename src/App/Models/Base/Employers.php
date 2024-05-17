<?php

namespace Amerhendy\Employers\App\Models\Base;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
class Employers extends Authenticatable
{
  use HasApiTokens,HasFactory, Notifiable;
  protected $table="Employers";
    protected $guard = 'Employers';    
    protected $fillable = [
        'uid','nid',
    ];
    protected $hidden = [];
}

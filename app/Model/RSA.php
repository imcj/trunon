<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;

class RSA extends Model
{
    protected $table = 'rsa';
    protected $fillable = ['private_key', 'public_key', 'title', 'user_id'];
}

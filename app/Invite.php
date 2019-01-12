<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    /**
     * The attrubutes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'email', 'code', 'role'
    ];
}

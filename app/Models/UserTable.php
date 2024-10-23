<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTable extends Model
{
    use HasFactory;
    protected $fillable = ['name','email','phone','description','role_id','profile_image'];
    public function role() {
        return $this->belongsTo('App\Models\Role');
    }
}

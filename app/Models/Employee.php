<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'contracted_hours', 'wage_type', 'wage_amount'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mtypefield extends Model
{
    use HasFactory;
    protected $table = 'm_type_field';
    protected $guarded = ['id'];
    public $timestamps = false;
    
}

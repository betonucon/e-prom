<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchemaService extends Model
{
    use HasFactory;
    protected $table = 'c_service_schemas';
    protected $guarded = ['id'];
    public $timestamps = false;
    
}

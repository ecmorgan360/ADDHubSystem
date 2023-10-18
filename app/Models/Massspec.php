<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Massspec extends Model
{
    use HasFactory;

    protected $primaryKey = "massspec_id";
    public $timestamps = false;
}

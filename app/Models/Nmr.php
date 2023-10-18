<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nmr extends Model
{
    use HasFactory;

    protected $primaryKey = "nmr_id";
    public $timestamps = false;
}

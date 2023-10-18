<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metagenome extends Model
{
    use HasFactory;

    protected $table = "metagenomeraw";
    protected $primaryKey = "metagenome_id";
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemporaryFile extends Model
{
    protected $table = 'temporary_files';
    protected $guarded = [];

    protected $primaryKey = 'id';
}

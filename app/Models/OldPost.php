<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldPost extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = "posts";

    protected $primaryKey = 'id';

}

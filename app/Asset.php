<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{

    protected $table = 'asset';

    protected $primaryKey = 'aid';

    public $timestamps = false;

    protected $fillable = ['title', 'mime_type','size','public','ref'];
}
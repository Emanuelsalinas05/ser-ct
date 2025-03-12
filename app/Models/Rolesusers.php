<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rolesusers extends Model
{
    use HasFactory;

    protected $table = 'g1roles';

    protected $fillable=[
                            'id',
                            'orol',
                            'odescripcion',
                            'status',
                        ];
}

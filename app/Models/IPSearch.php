<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IPSearch extends Model
{
    use HasFactory;

    protected $table = 'ipsearches';

    protected $fillable = [
        'searchValue',
        'response',
    ];
}

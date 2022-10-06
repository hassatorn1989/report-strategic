<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_year extends Model
{
    use HasFactory;
    protected $table = 'tbl_year';

    public function get_year_strategic()
    {
        return $this->hasMany(view_year_strategic::class, 'year_id', 'id');
    }
}

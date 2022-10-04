<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class view_year_strategic extends Model
{
    use HasFactory;

    protected $table = 'view_year_strategic';

    public function get_result_analysis()
    {
        return $this->hasOne(tbl_result_analysis::class, 'year_strategic_id', 'id');
    }
}

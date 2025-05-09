<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptionCategory extends Model
{
    protected $table = 'option_categories';

    protected $primaryKey = 'option_category_id';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'status',
    ];
}

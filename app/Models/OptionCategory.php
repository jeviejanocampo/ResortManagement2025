<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OptionCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'option_categories';

    protected $primaryKey = 'option_category_id';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'name',
        'status',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class, 'option_category_id', 'option_category_id');
    }
}

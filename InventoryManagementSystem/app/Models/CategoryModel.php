<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    use HasFactory;
    protected $table = "category";
    protected $fillable = ['category_name', 'category_desc'];

    public function items()
    {
        return $this->belongsToMany(CategoryModel::class,'item_cateogry','category_id','item_id');
    }
}

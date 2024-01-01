<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemModel extends Model
{
    use HasFactory;
    protected $table = "items";
    protected $fillable = ['item_name','item_desc','price','quantity'];

    public function category(){
        return $this->belongsToMany(ItemModel::class,'item_cateogry','item_id','category_id');
    }
}

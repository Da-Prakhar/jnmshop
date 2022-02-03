<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{

    // protected $fillable = [
    //     'complain_ref_no', 'complain_by_user_id', 'complain_by_name', 'mobile', 'title', 'brand_proof', 'is_requested',
    // ];

    protected $table = 'complaints';

    // protected $casts = [
    //     'category_id' => 'array',
    // ];

    // public function products()
    // {
    //     return $this->hasMany('App\Product', 'brand_id', 'id');
    // }

}

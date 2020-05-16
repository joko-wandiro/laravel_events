<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;
use Storage;

/**
 * App\Models\Category
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder
 * @mixin \Eloquent
 *  ^-----------------------
 */
class OrderDetail extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_detail';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array(
        'id_order',
        'name',
        'phone',
        'address',
    );

}

//// Checking Model
//$model       = new \App\Models\Category;
//$model->name = "PHP";
//$model->save();
//$model         = \App\Models\Category::get()->first()->toArray();

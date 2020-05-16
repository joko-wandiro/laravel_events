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
class IncomingGoodsDetail extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'incoming_goods_detail';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array(
    	'incoming_goods_id',
    	'product_id',
    	'price',
    	'quantity',
    );
    
    /**
     * Get detail of incoming goods
     *
     * @return array
     */
    function getDetail($incomingGoodsId)
    {
        $model= $this->join('products', 'products.id', '=', 'incoming_goods_detail.product_id', 
        'INNER')->join('measurements', 'measurements.id', '=', 'products.measurement_id', 
        'INNER')->where("incoming_goods_detail.incoming_goods_id", "=", $incomingGoodsId);
        $records = $model->get(array('incoming_goods_detail.*', 'products.name', 
        'measurements.name as measurement_name'))->all();
        return $records;
    }
}
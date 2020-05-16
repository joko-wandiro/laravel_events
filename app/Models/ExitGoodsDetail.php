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
class ExitGoodsDetail extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exit_goods_detail';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array(
    	'exit_goods_id',
    	'product_id',
    	'price',
    	'quantity',
    );
    
    /**
     * Get detail of exit goods
     *
     * @return array
     */
    function getDetail($exitGoodsId)
    {
    	$model= clone $this;
        $model= $model->join('products', 'products.id', '=', 'exit_goods_detail.product_id', 'INNER')
        ->join('measurements', 'measurements.id', '=', 'products.measurement_id', 'INNER')
        ->join(DB::raw('( SELECT incoming_goods_detail.product_id, 
		SUM(incoming_goods_detail.quantity) AS quantity FROM incoming_goods_detail 
		GROUP BY incoming_goods_detail.product_id ) AS igd'), 
		'igd.product_id', '=', 'products.id', 'LEFT')
		->join(DB::raw('( SELECT exit_goods_detail.product_id, 
		SUM(exit_goods_detail.quantity) AS quantity FROM exit_goods_detail 
		GROUP BY exit_goods_detail.product_id ) AS egd'), 
		'egd.product_id', '=', 'products.id', 'LEFT');
		$model= $model->where("exit_goods_detail.exit_goods_id", "=", $exitGoodsId);
        $records = $model->get(array('exit_goods_detail.*', 'products.name', 
        'measurements.name as measurement_name', DB::raw('IFNULL(igd.quantity,0) - IFNULL(egd.quantity,0) AS stock')))->all();
        return $records;
    }
}
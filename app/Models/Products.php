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
class Products extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    public static function gets()
    {
        $Model = new self;
        $columns = array(
            DB::raw('categories.name AS category_name'),
            'products.id',
            'products.name',
            'products.image',
            'products.price',
        );
        $records = $Model->join('categories', 'categories.id', '=', 'products.id_category', 'INNER')
                        ->orderBy('products.id')->get($columns)->toArray();
        $result = array();
        foreach ($records as $key => $record) {
            $id_product = $record['id'];
            $record['price_format'] = getThousandFormat($record['price']);
            $result[$id_product] = $record;
        }
        return $result;
    }
    
}

//// Checking Model
//$model       = new \App\Models\Category;
//$model->name = "PHP";
//$model->save();
//$model         = \App\Models\Category::get()->first()->toArray();

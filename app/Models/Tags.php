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
class Tags extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tags';

    public static function get_list()
    {
        $Model = new self;
//        $list = array("" => trans('main.select.default'));
        $result = $Model->get()->pluck("name", "id")->all();
//        $list = $list + $result;
        return $result;
    }

}

//// Checking Model
//$model       = new \App\Models\Tags;
//$model->name = "PHP";
//$model->save();
//$model         = \App\Models\Tags::get()->first()->toArray();

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
class Organizers extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'organizers';

    public static function gets()
    {
        $Model = new self;
        $records = $Model->get()->toArray();
        return $records;
    }

    public static function get_list()
    {
        $Model = new self;
        $list = array("" => trans('main.select.default'));
        $result = $Model->get()->pluck("name", "id")->all();
        $list = $list + $result;
        return $list;
    }

    public static function get_total_organizers()
    {
        $Model = new self;
        $columns = array(
            DB::raw("COUNT(id) AS total_organizer"),
        );
        $query = $Model->select($columns);
        $record = $query->get()->first()->toArray();
        return $record;
    }

}

//// Checking Model
//$model       = new \App\Models\Category;
//$model->name = "PHP";
//$model->save();
//$model         = \App\Models\Category::get()->first()->toArray();

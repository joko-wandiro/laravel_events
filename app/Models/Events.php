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
class Events extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'events';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array(
        'id_user',
        'title',
        'description',
        'image',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'location',
    );
    
    public static function get_total_events()
    {
        $Model = new self;
        $columns = array(
            DB::raw("COUNT(id) AS total_event"),
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

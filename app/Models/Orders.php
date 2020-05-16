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
class Orders extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array(
        'id_user',
        'date',
        'subtotal',
        'ppn',
        'total',
        'paid',
        'change',
    );

    public static function gets($id)
    {
        $Model = new self;
        $columns = array(
            'orders.*',
            'order_detail.name',
            'order_detail.phone',
            'order_detail.address',
        );
        $record = $Model->join('order_detail', 'order_detail.id_order', '=', 'orders.id', 'INNER')
                        ->where('orders.id', '=', $id)->get($columns)->first();
        if ($record) {
            return $record->toArray();
        }
        return FALSE;
    }

    public static function get_products($id)
    {
        $Model = new self;
        $columns = array(
            'order_products.*',
        );
        $query = $Model->join('order_products', 'order_products.id_order', '=', 'orders.id', 'INNER')
                        ->where('id', '=', $id)->select($columns);
        $records = $query->get()->toArray();
        return $records;
    }

    public static function get_total_sales()
    {
        $Model = new self;
        $columns = array(
            DB::raw("COUNT(orders.id) AS total_order"),
            DB::raw("SUM(orders.total) AS total"),
        );
        $query = $Model->select($columns);
        $record = $query->get()->first()->toArray();
        return $record;
    }

    public static function get_daily_orders($year, $month)
    {
        $monthyear = $year . "-" . $month;
        $Model = new self;
        $columns = array(
            DB::raw("DATE_FORMAT(date, '%Y-%m') AS monthyear"),
            DB::raw("DATE_FORMAT(orders.date, '%d') AS date"),
            "users.name",
            DB::raw("COUNT(orders.id) AS total_order"),
            DB::raw("SUM(orders.total) AS total"),
        );
        $query = $Model->join('users', 'users.id', '=', 'orders.id_user', 'INNER')
                        ->groupBy(DB::raw("DATE_FORMAT(orders.date, '%Y-%m-%d')"))
                        ->having('monthyear', '=', $value = $monthyear)->select($columns);
//        dd($query->toSql(), $query->getBindings());
        $records = $query->get()->toArray();
//        dd($records);
        $result = array();
        foreach ($records as $record) {
            $date = $record['date'];
            $result[$date] = $record;
        }
        return $result;
    }

    public static function get_monthly_orders($year)
    {
        $Model = new self;
        $columns = array(
            DB::raw("DATE_FORMAT(date, '%Y') AS year"),
            DB::raw("DATE_FORMAT(orders.date, '%m') AS month"),
            "users.name",
            DB::raw("COUNT(orders.id) AS total_order"),
            DB::raw("SUM(orders.total) AS total"),
        );
        $query = $Model->join('users', 'users.id', '=', 'orders.id_user', 'INNER')
                        ->groupBy(DB::raw("DATE_FORMAT(orders.date, '%Y-%m')"))
                        ->having('year', '=', $year)->select($columns);
//        dd($query->toSql(), $query->getBindings());
        $records = $query->get()->toArray();
        $result = array();
        foreach ($records as $record) {
            $month = $record['month'];
            $result[$month] = $record;
        }
        return $result;
    }

}

//// Checking Model
//$model       = new \App\Models\Category;
//$model->name = "PHP";
//$model->save();
//$model         = \App\Models\Category::get()->first()->toArray();

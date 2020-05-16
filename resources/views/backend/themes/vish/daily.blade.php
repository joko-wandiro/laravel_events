@extends('backend.themes.vish.default')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="report-content">
                <?php
                $month_int = (int) $month;
                $previous_month = ($month_int <= 1) ? 12 : $month_int - 1;
                $previous_month = sprintf('%02d', $previous_month);
                $previous_year = ($month_int <= 1) ? $year - 1 : $year;
                $next_month = ($month_int == 12) ? 1 : $month_int + 1;
                $next_month = sprintf('%02d', $next_month);
                $next_year = ($month_int == 12) ? $year + 1 : $year;
                // Get title
                $first_month = $year . "-" . $month . "-01";
                $title = date("F Y", strtotime($first_month));
                ?>
                <div class="navigation-month">
                    <div class="buttons">
                        <a href="<?php echo action(config('app.backend_namespace') . 'ReportsController@daily', array('year' => $previous_year, 'month' => $previous_month)); ?>" class="btn btn-prev-year btn-year">&lt;</a>
                        <a href="<?php echo action(config('app.backend_namespace') . 'ReportsController@daily', array('year' => $next_year, 'month' => $next_month)); ?>" class="btn btn-prev-year btn-year">&gt;</a>
                    </div>
                    <div class="title"><?php echo $title; ?></div>
                </div>
                <?php
                $days = array(
                    'sunday',
                    'monday',
                    'tuesday',
                    'wednesday',
                    'thursday',
                    'friday',
                    'saturday',
                );
                ?>
                <div class="table-responsive">
                    <table class="table report-daily-table calendar">
                        <thead>
                            <tr>
                                <?php
                                foreach ($days as $day) {
                                    ?>
                                    <th width="14.28%"><?php echo trans('main.' . $day); ?></th>
                                    <?php
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $first_month = $year . "-" . $month . "-01";
                            $number_of_days = date("t", strtotime($first_month));
                            $first_day = date("w", strtotime($first_month)) + 1;
                            $loop = ceil($number_of_days / 7);
                            $date = 1;
                            for ($i = 0; $i < $loop; $i++) {
                                ?>
                                <tr>
                                    <?php
                                    for ($j = 1; $j <= 7; $j++) {
                                        $number = $i * 7 + $j;
                                        if ($number >= $first_day && $date <= $number_of_days) {
                                            $id_date = sprintf('%02d', $date);
                                            ?>
                                            <td class="date">
                                                <div class="title"><?php echo $date; ?></div>
                                                <div class="content">
                                                    <?php
                                                    if (isset($orders[$id_date])) {
                                                        $order = $orders[$id_date];
                                                        ?>
                                                        <div>
                                                            <span class="label label-info"><?php echo $order['total_order']; ?> <?php echo trans('main.sales'); ?></span>
                                                        </div>
                                                        <div>
                                                            <span class="label label-info"><?php echo getThousandFormat($order['total']); ?></span>
                                                        </div>                                            
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                            <?php
                                            $date++;
                                        } else {
                                            ?>
                                            <td>&nbsp;</td>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
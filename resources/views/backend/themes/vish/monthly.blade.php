@extends('backend.themes.vish.default')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="report-content">
                <?php
                $previous_year = $year - 1;
                $next_year = $year + 1;
                ?>
                <div class="navigation-month">
                    <div class="buttons">
                        <a href="<?php echo action(config('app.backend_namespace') . 'ReportsController@monthly', array('year' => $previous_year)); ?>" class="btn btn-prev-year btn-year">&lt;</a>
                        <a href="<?php echo action(config('app.backend_namespace') . 'ReportsController@monthly', array('year' => $next_year)); ?>" class="btn btn-prev-year btn-year">&gt;</a>
                    </div>
                    <div class="title"><?php echo $year; ?></div>
                </div>
                <div class="table-responsive">
                    <table class="table report-monthly-table">
                        <thead>
                            <tr>
                                <?php
                                for ($i = 0; $i <= 11; $i++) {
                                    $month = date("F", strtotime($year . "-01-01 +" . $i . " month"));
                                    ?>
                                    <th width="8.33%"><?php echo trans('main.' . strtolower($month)); ?></th>
                                    <?php
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                for ($i = 0; $i <= 11; $i++) {
                                    $month = sprintf('%02d', $i + 1);
                                    if (isset($orders[$month])) {
                                        $order = $orders[$month];
                                        ?>
                                        <td>
                                            <div class="label-content">
                                                <span class="label label-info"><?php echo $order['total_order']; ?> <?php echo trans('main.sales'); ?></span>
                                            </div>
                                            <div class="label-content">
                                                <span class="label label-info"><?php echo getThousandFormat($order['total']); ?></span>
                                            </div>
                                        </td>
                                        <?php
                                    } else {
                                        ?>
                                        <td>&nbsp;</td>
                                        <?php
                                    }
                                }
                                ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('backend.themes.vish.default')

@section('content')
<div class="container">
    <div id="dashboard-content">
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="dashboard-info">
                    <p class="di-total"><?php echo getThousandFormat($events['total_event']); ?></p>
                    <p class="di-description"><?php echo trans('main.events'); ?></p>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="dashboard-info">
                    <p class="di-total"><?php echo getThousandFormat($organizers['total_organizer']); ?></p>
                    <p class="di-description"><?php echo trans('main.organizers'); ?></p>
                </div>
            </div>
            <div class="col-sm-6">&nbsp;</div>
        </div>
    </div>
</div>
@endsection
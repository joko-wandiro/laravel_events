<div id="content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="event">
                    <?php
                    $Model = $Scaffolding->getModel();
                    $pathinfos = pathinfo($Model['image']);
                    ?>
                    <div id="event-image"><img src="<?php echo eventsImageUrl($Model['image']); ?>" title="<?php echo $Model->title; ?>" alt="<?php echo $Model->title; ?>" class="img-fluid"/></div>
                    <h1 id="event-title"><?php echo $Model->title; ?></h1>
                    <div id="event-description">
                        <div><?php echo trans('main.organizer') . " : " . $Model->name; ?></div>
                        <div><?php echo date("d F Y", strtotime($Model->start_date)) . " - " . date("d F Y", strtotime($Model->end_date)); ?></div>
                        <div><?php echo date('h:i A', strtotime($Model->start_time)) . " - " . date('h:i A', strtotime($Model->end_time)); ?></div>
                        <div><?php echo $Model->location; ?></div>
                    </div>
                    <div id="event-content"><?php echo $Model->description; ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

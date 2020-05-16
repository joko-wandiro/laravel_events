<?php
$identifier = $Scaffolding->getIdentifier();
$extraAttributes = ' id=dk-scaffolding-' . $identifier;
$visibility = $Scaffolding->getVisibilityListElements();
$Request = $Scaffolding->getRequest();
$attributes = array(
    'class' => 'form-control',
);
$records = $Scaffolding->getListRecords();
//dd($records);
?>
<div id="content">
    <div class="container">
        <?php
        $number_of_records = count($records);
        if ($number_of_records) {
            $ct = 1;
            foreach ($records as $record) {
                if ($ct % 4 == 1) {
                    ?>
                    <div class="row event-row">
                        <?php
                    }
                    ?>
                    <div class="col-sm-3">
                        <div class="event">
                            <?php
                            if ($record['events.image']) {
                                ?>
                                <div class="event-image"><img src="<?php echo eventsImageUrl($record['events.image']); ?>" class="img-fluid"/></div>
                                <?php
                            }
                            ?>
                            <h3 class="event-title"><a href="<?php echo url(to_url_component($record['events.title'])); ?>"><?php echo $record['events.title']; ?></a></h3>
                            <div class="event-content">
                                <div><?php echo get_date_indonesian_format($record['events.start_date']) . " - " . get_date_indonesian_format($record['events.start_date']); ?></div>
                                <div><?php echo get_time_indonesian_format($record['events.start_time']) . " - " . get_time_indonesian_format($record['events.end_time']); ?></div>
                            </div>

                        </div>
                    </div>
                    <?php
                    if ($ct % 4 == 0 || $ct == $number_of_records) {
                        ?>
                    </div>
                    <?php
                }
                $ct++;
            }
            $baseUrl = url('');
            $replacementUrl = url('page');
            // Display pagination
            $pagination = $Scaffolding->getPagination();
//                $pagination = $posts->links();
            $currentUrl = request()->getUri();
            $currentUrl = ( $currentUrl == $baseUrl . '/' ) ? $baseUrl : $currentUrl;
            $pattern = '#' . preg_quote($currentUrl) . '\?identifier=events\&amp\;page=(\d+)#';
            $replacement = $replacementUrl . '/' . '$1';
            $pagination = preg_replace($pattern, $replacement, $pagination);
//                dd($pattern, $replacement, $pagination);
            echo $pagination;
        } else {
            echo trans('dkscaffolding.no.item');
        }
        ?>
    </div>
</div>
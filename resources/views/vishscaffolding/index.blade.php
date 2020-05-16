<?php
$identifier = $Scaffolding->getIdentifier();
$extraAttributes = ' id=dk-scaffolding-' . $identifier;
$visibility = $Scaffolding->getVisibilityListElements();
$Request = $Scaffolding->getRequest();
$attributes = array(
    'class' => 'form-control',
);
?>
<?php
$createButton = "";
if ($visibility['create_button']) {
    ob_start();
    ?>
    <a href="<?php echo $Scaffolding->getCreateButtonUrl(); ?>" class="btn btn-new btn-blue"><?php echo trans('dkscaffolding.btn.create.text'); ?></a>
    <?php
    $createButton = ob_get_contents();
    ob_end_clean();
}
?>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header">
                <h1><?php echo $Scaffolding->getTitle(); ?><?php echo $createButton; ?></h1>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="dk-scaffolding"<?php echo $extraAttributes; ?> data-action="list">
                @include($Scaffolding->getTemplate().'.flash', ['Scaffolding'=>$Scaffolding])
                {!! Form::open(['method'=>'POST', 'url'=>$Scaffolding->getFormAction(), 'enctype'=>'multipart/form-data', 'class'=>'form-horizontal']) !!}
                {!! Form::hidden('identifier', $identifier, array()) !!}
                {!! Form::hidden('filetype', null, array()) !!}
                <?php
                // Hook Action listFormStart
                $Scaffolding->doHooks("listFormStart", array($Scaffolding));
                // Hook Action listBeforeTable
                $Scaffolding->doHooks("listBeforeTable", array($Scaffolding));
                $columns = $Scaffolding->getListColumns();
                $searchColumns = $Scaffolding->getListSearchColumns();
                $records = $Scaffolding->getListRecords();
                $columnsOrder = $Scaffolding->getColumnsOrder();
                unset($columnsOrder['products.image']);
                $columnProperties = $Scaffolding->getColumnProperties();
                //    dd($columnsOrder, $columns, $columnProperties);
                ?>
                <div class="table-responsive">
                    <table class="table table-hover table-condensed">
                        <thead>
                            <tr class="dk-table-row-multiple-search">
                                <th colspan="<?php echo count($columns); ?>">
                                    <div class="dk-section-multiple-search">
                                        <?php
                                        if ($visibility['multi_search'] || $visibility['submit_button']) {
                                            $searchAttributes = array(
                                                'class' => 'form-control',
                                                'placeholder' => trans('dkscaffolding.search.placeholder'),
                                            );
                                            if ($visibility['multi_search']) {
                                                echo Form::text('search[multiple]', $Request['search']['multiple'], $searchAttributes);
                                            }
                                        }
                                        ?>
                                    </div>
                                </th>
                            </tr>
                            <tr class="dk-table-row-order">
                                <?php
                                foreach ($columns as $columnIndex => $column) {
                                    $widthAttribute = isset($columnProperties[$columnIndex]['width']) ?
                                            ' width="' . $columnProperties[$columnIndex]['width'] . '"' : '';
                                    $orderActive = (isset($columnProperties[$columnIndex]['order']) && $columnProperties[$columnIndex]['order'] == FALSE) ? FALSE : TRUE;
                                    if (array_key_exists($columnIndex, $columnsOrder) && $orderActive) {
                                        $columnOrder = $columnsOrder[$columnIndex];
                                        $orderTypeClass = ( $columnOrder['orderType'] == "ASC" ) ? "headerSortUp" : "headerSortDown";
                                        $status = ( $columnOrder['active'] ) ? " active" : "";
                                        ?>
                                        <th<?php echo $widthAttribute; ?> class="<?php echo $orderTypeClass . $status; ?>">
                                            <a href="<?php echo $columnOrder['url']; ?>" class="sortable">
                                                <?php echo $column; ?>
                                            </a>
                                        </th>
                                        <?php
                                    } else {
                                        ?>
                                        <th<?php echo $widthAttribute; ?>><div><?php echo $column; ?></div></th>
                                        <?php
                                    }
                                }
                                ?>
                            </tr>
                            <?php
                            if ($visibility['single_search']) {
                                ?>
                                <tr class="dk-table-row-search">
                                    <?php
                                    foreach ($columns as $columnIndex => $column) {
                                        $searchActive = (isset($columnProperties[$columnIndex]['search']) && $columnProperties[$columnIndex]['search'] == FALSE) ? FALSE : TRUE;
                                        ?>
                                        <th><?php echo ($searchActive) ? $searchColumns[$columnIndex] : ""; ?></th>
                                        <?php
                                    }
                                    ?>
                                </tr>
                                <?php
                            }
                            ?>
                        </thead>
                        <tbody>
                            <?php
                            if (count($records)) {
                                foreach ($records as $record) {
                                    ?>
                                    <tr>
                                        <?php
                                        foreach ($columns as $columnIndex => $column) {
                                            $class = isset($columnProperties[$columnIndex]['class']) ?
                                                    ' class="' . $columnProperties[$columnIndex]['class'] . '"' : '';
                                            ?>
                                            <td<?php echo $class; ?>>
                                                <?php echo $record[$columnIndex]; ?>
                                            </td>
                                            <?php
                                        }
                                        ?>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="<?php echo count($columns); ?>"><?php echo trans('dkscaffolding.no.item'); ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="<?php echo count($columns); ?>" class="pagination-wrapper">
                                    <div class="xrow">
                                        <div class="col-3">
                                            <?php
                                            if ($visibility['pagination_info']) {
                                                // Display pagination info
                                                echo $Scaffolding->getPaginationInfo();
                                            }
                                            ?>                                            
                                        </div>
                                        <div class="col-6">
                                            <?php
                                            if ($visibility['pagination']) {
                                                ?>
                                                <div class="dk-section-pagination">
                                                    <div class="dk-container-pagination">
                                                        <?php
                                                        // Display pagination
                                                        echo $Scaffolding->getPagination();
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>                                            
                                        </div>
                                        <div class="col-3">
                                            <?php
                                            if ($visibility['records_per_page']) {
                                                ?>
                                                <div class="dk-entries-per-page">
                                                    <?php
                                                    echo trans('dkscaffolding.rows.per.page') . " " .
                                                    Form::select('recordsPerPage', $Scaffolding->getListOfRecordsPerPage(), $Request['recordsPerPage'], $attributes);
                                                    ?>
                                                </div>
                                                <?php
                                            }
                                            ?>                                            
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
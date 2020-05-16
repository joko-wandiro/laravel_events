<?php
$Model = $Scaffolding->getModel();
?>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header">
                <h1><?php echo $Scaffolding->getTitle(); ?></h1>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="dk-scaffolding dk-scaffolding-form" data-action="form">
                @include($Scaffolding->getTemplate().'.flash', ['Scaffolding'=>$Scaffolding])
                {!! Form::model($Model, ['method'=>'PUT', 'url'=>$Scaffolding->getFormAction(),'enctype'=>'multipart/form-data']) !!}
                <?php
                echo Form::hidden('idx_old', serialize($Model->getAttributes()));
                ?>
                @include($Scaffolding->getTemplate().'.form', ['submit'=>trans('dkscaffolding.btn.submit.update'), 'cancel'=>trans('dkscaffolding.btn.cancel')])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
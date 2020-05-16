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
                {!! Form::model($Model, ['url'=>$Scaffolding->getFormAction(),'enctype'=>'multipart/form-data']) !!}
                @include($Scaffolding->getTemplate().'.form', ['submit'=>trans('dkscaffolding.btn.submit.create'), 'cancel'=>trans('dkscaffolding.btn.cancel')])
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

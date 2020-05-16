@extends('backend.themes.vish.default')

@section('content')
<?php echo $scaffolding; ?>
@endsection

@push('styles')
<link href="<?php echo url('css/bootstrap-datetimepicker.min.css'); ?>" rel="stylesheet">
<link href="<?php echo url('css/select2.min.css'); ?>" rel="stylesheet">
@endpush

@push('scripts')
<script type="text/javascript" src="<?php echo url('js/moment.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo url('js/bootstrap-datetimepicker.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo url('js/select2.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo url('js/tinymce/tinymce.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo url('js/backend/event.js'); ?>"></script>
@endpush
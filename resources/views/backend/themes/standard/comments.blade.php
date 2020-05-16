@extends('backend.themes.standard.index')

@push('scripts')
<script>
	Site= <?php echo json_encode($jsParameters); ?>
</script>
<script type="text/javascript" src="<?php echo url('js/themes/standard/comments.js'); ?>"></script>
@endpush
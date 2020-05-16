@extends('backend.themes.standard.default')

@section('content')
<?php echo $scaffolding; ?>
<table id="template-product" class="hide">
<tbody>
<tr class="row-empty">
	<td colspan="4"><?php echo trans('main.products.empty'); ?></td>
</tr>
<?php
$attributes= array('class'=>'form-control');
?>
<tr class="row-product">
	<td>
	<?php
	echo Form::hidden('incoming_goods_detail[][id]', null, $attributes);
	echo Form::text('incoming_goods_detail[][product]', null, $attributes);
	echo Form::hidden('incoming_goods_detail[][product_id]', null, $attributes);
	?>
	</td>
	<td>
	<?php
	echo Form::text('incoming_goods_detail[][price]', null, $attributes);
	?>
	</td>
	<td>
	<?php
	echo Form::text('incoming_goods_detail[][quantity]', null, $attributes);
	?>
	</td>
	<td class="unit">
	<span>&nbsp;</span>
	<?php echo Form::hidden('incoming_goods_detail[][measurement_name]', null, $attributes); ?>
	</td>
	<td><button class="btn btn-default btn-in-goods-remove" type="button"><?php echo trans('main.remove'); ?></button></td>
</tr>
</tbody>
</table>
@endsection
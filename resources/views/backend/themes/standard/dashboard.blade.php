@extends('backend.themes.standard.default')

@section('content')
<p><?php echo $incomingGoods['total']; ?></p>
<p><?php echo $exitGoods['total']; ?></p>
<?php echo $scaffolding; ?>
@endsection
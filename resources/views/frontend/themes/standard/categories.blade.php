@extends('frontend.themes.standard.index')

@section('page_title')
Category Page
@endsection

@section('content')
<div class="row">
	<div class="col-sm-12">
	@include('frontend.themes.standard.posts')
	</div>
</div>
@endsection
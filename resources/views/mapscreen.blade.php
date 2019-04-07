@extends('layout')

@section('head')
@endsection

@section('body')
	<div id="map-container">
		<map-handler :token="token"></map-handler>
	</div>
@endsection

@section('scripts')
	<script>
		$(function () {
			const mapContainer = new Vue({
				el: '#map-container',
				data: function () {
					return {
						token: "{!! csrf_token() !!}",
					};
				}
			});
		})
	</script>
@endsection
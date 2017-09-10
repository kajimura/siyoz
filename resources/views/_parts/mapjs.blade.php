<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYWMBB4Zom5YHMpN8Yg6GttjeD2IGOcI8 "></script>
<style>
#map-canvas {
    width: 100%;
    height: 600px;
}
</style>
<script type="text/javascript">
var map = new google.maps.Map(document.getElementById('map-canvas'), {
    center: new google.maps.LatLng({{{ $meet->lat }}}, {{{ $meet->lng }}}),
    zoom: 15
});
var icon0 = new google.maps.MarkerImage('/assets/img/red-dot.png',
  new google.maps.Size(32,32),
  new google.maps.Point(0,0)
  );
var _marker;
var _infoWindow;
_marker = new google.maps.Marker({
    position: new google.maps.LatLng({{{ $meet->lat }}}, {{{ $meet->lng }}}),
    map: map,
	title: '{{{ $meet->location_name }}}\n所在地:{{{ $meet->location_address }}}',
{{--
	icon: icon{{{ $meet->rating_int }}}
--}}
});
_infoWindow = new google.maps.InfoWindow({
    content: '<div class="sample">{{{ $meet->location_name }}}<br />所在地:{{{ $meet->location_address }}}<div>'
});
_marker.addListener('click', function() {
    _infoWindow.open(map, _marker);
});
</script>

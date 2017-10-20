/**
 * Created by lucasweijers on 16-08-17.
 */

var dolphiqMapLoaded = false;
var loadingMaps = [];

// This function will be called by google maps
function initDolphiqMap(){
  dolphiqMapLoaded = true;
}

// This function will be called from script and keeps checking if google maps js is loaded
function loadDolphiqMap(id, locations){
  loadingMaps[id] = setInterval(function() {
    if(dolphiqMapLoaded === true) {
      clearInterval(loadingMaps[id]);
      dolphiqMap(id,locations);
    }
  }, 10);
}

// This function will be called from above function if google maps js is loaded. it will render the map
function dolphiqMap(id,locations){
  var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  var bounds = new google.maps.LatLngBounds();
  var initialMaxZoom = 4;
  var style = (id in dolphiqMapStyles) ? dolphiqMapStyles[id] : dolphiqMapStyles.default;

  var map = new google.maps.Map(document.getElementById(id), {
    styles: style
  });


  //Set listener to make sure that when we view the map for the first time we won't be zoomed in to much
  google.maps.event.addListenerOnce(map, 'bounds_changed', function() {
    if (initialMaxZoom < map.getZoom()) {
      map.setZoom(initialMaxZoom);
    }
  });


  // Add the markers to the map.
  // Note: The code uses the JavaScript Array.prototype.map() method to
  // create an array of markers based on a given "locations" array.
  // The map() method here has nothing to do with the Google Maps API.
  var markers = locations.map(function(location, i) {
    if(location.lat !== undefined && location.long !== undefined) {
      var marker = new google.maps.Marker({
        position: {lat: parseFloat(location.lat), lng: parseFloat(location.long)},
        label: labels[i % labels.length]
      });

      bounds.extend(marker.position);
      return marker;
    }
  });

  var markerCluster = new MarkerClusterer(map, markers, {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});

  map.fitBounds(bounds);
}


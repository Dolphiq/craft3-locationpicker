/**
 * Created by lucasweijers on 16-08-17.
 */
$(function() {

  var locationField_modals = [];

  $('.locationField').on('change', function () {
    resolveAddress($(this).parent());
  });

  $('.locationFieldButton').on('click', function(){
    resolveAddress($(this).parent());
  });

  $('.locationField_modaltoggle').on('click', function(){
    var p = $(this).parent();
    if(p.data('modal-id') !== undefined){
      locationField_modals[p.data('modal-id')].show();
    }else{
      var m = p.find('.locationField_modal');
      var modal = new Craft.LocationSelectorModal(m, p, {onSelect: function(location){
        console.log(location);
      }});
      locationField_modals.push(modal);
      p.data('modal-id', locationField_modals.length -1);
    }
  });

  $('document').on('click', '.locationField_modal_close', function(){
    console.log('closing modal');
    Garnish.Modal.visibleModal.hide();
  });

  /*function resolveAddress(field){
    // Location field variables
    var locationField_parent = field;
    var locationField_input = $(field).find('.locationField');
    var locationField_apiKey = locationField_input.data('apikey');
    var locationField_value = locationField_input.val();

    var locationField_msg = locationField_parent.find('.locationField_msg');
    var locationField_address = locationField_parent.find('.locationField_address');
    var locationField_long = locationField_parent.find('.locationField_long');
    var locationField_lat = locationField_parent.find('.locationField_lat');

    // Remove earlier found result
    locationField_address.val('');
    locationField_lat.val('');
    locationField_long.val('');
    locationField_msg.text('');

    // Search address of input is not empty
    if(locationField_value !== '') {

      $.get('https://maps.googleapis.com/maps/api/geocode/json?address=' + locationField_value + '&key=' + locationField_apiKey, function (response) {
        console.log(response);
        if (response.status === 'OK') {

          var locationField_result = response.results[0];

          locationField_msg.removeClass('error');
          locationField_msg.text(locationField_result.formatted_address);

          locationField_address.val(locationField_result.formatted_address);
          locationField_long.val(locationField_result.geometry.location.lng);
          locationField_lat.val(locationField_result.geometry.location.lat);

        } else {

          locationField_msg.addClass('error');

          switch (response.status) {
            default:
            case 'UNKNOWN_ERROR':
              locationField_msg.text(response.error_message !== undefined ? response.error_message : 'An error occurd ');
              break;

            case 'ZERO_RESULTS':
              locationField_msg.text('Address not found');
              break;

            case 'OVER_QUERY_LIMIT':
              locationField_msg.text('The quota for your google API Key has been reached');
          }
        }
      });
    }
  }*/
});
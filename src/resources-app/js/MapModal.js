/**
 * Created by lucasweijers on 18-08-17.
 */
/** global: Craft */
/** global: Garnish */
/**
 * Map location selector modal class
 */
Craft.LocationSelectorModal = Garnish.Modal.extend(
  {

    map: null,
    mapElm: null,
    searchElm: null,
    location: null,
    locationField: null,

    $selectBtn: null,
    $primaryButtons: null,
    $cancelBtn: null,

    init: function(container, field, settings) {
      this.locationField = field;
      this.setSettings(settings, Craft.LocationSelectorModal.defaults);

      // Build the modal
      this.base(container, this.settings);

      //this.$primaryButtons = $('<div class="buttons right"/>').appendTo($footer);
      this.$cancelBtn = $(container).find('.locationField_modal_close');
      this.$selectBtn = $(container).find('.locationField_modal_select');
      console.log(this.$selectBtn);

      this.mapElm = $(this.$container[0]).find('.locationField_map')[0];
      this.searchElm = $(this.$container[0]).find('.locationField_search')[0];

      this.addListener(this.$cancelBtn, 'activate', 'cancel');
      this.addListener(this.$selectBtn, 'activate', 'selectLocation');
    },

    onFadeIn: function() {
      if(this.map === null) {
        this.initMap();
      }
    },

    initMap: function(){
      var initialMaxZoom = 4;

      if(locationField_map_enabled === true) {

        this.map = new google.maps.Map(this.mapElm, {
          styles: dolphiqMapStyles,
          zoom: initialMaxZoom,
          center: {lat: -33.8688, lng: 151.2195},
        });

        this.on('updateSizeAndPosition', {map: this.map}, this.onResize);

        // Create the search box and link it to the UI element.
        var locationField_search = new google.maps.places.Autocomplete(this.searchElm);

        var marker = new google.maps.Marker({
          map: this.map
        });

        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        var self = this;

        locationField_search.addListener('place_changed', function(e) {
          marker.setVisible(false);
          var place = locationField_search.getPlace();

          if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            self.disableSelectBtn();
            return;
          }

          // If the place has a geometry, then present it on a map.
          if (place.geometry.viewport) {
            self.map.fitBounds(place.geometry.viewport);
          } else {
            self.map.setCenter(place.geometry.location);
            self.map.setZoom(17);  // Why 17? Because it looks good.
          }

          marker.setPosition(place.geometry.location);
          marker.setVisible(true);

          //Set fields
          self.location = place;


          self.enableSelectBtn();
        });

      }
    },

    onResize: function(e) {
      if(e.data.map !== null) {
        google.maps.event.trigger(e.data.map, "resize");
      }
    },

    enableSelectBtn: function() {
      this.$selectBtn.removeClass('disabled');
    },

    disableSelectBtn: function() {
      this.$selectBtn.addClass('disabled');
    },

    cancel: function() {
        this.hide();
    },

    selectLocation: function(){
      $(this.locationField).find('.locationField_lat').val(this.location.geometry.location.lat);
      $(this.locationField).find('.locationField_long').val(this.location.geometry.location.lng);
      $(this.locationField).find('.locationField_address').val(this.location.formatted_address);
      $(this.locationField).find('.locationField_msg').text(this.location.formatted_address);
      this.hide();
    },
  },
  {
    defaults: {
      resizable: true,
      hideOnSelect: true,
      onCancel: $.noop,
      onSelect: $.noop,
    }
  });

# Locationpicker plugin for Craft CMS 3.x

A location field that lets you pick a location and shows it on google maps.
You also have the possibility to group multiple chosen locations.

**Note**: This plugin may become a paid add-on when the Craft Plugin store becomes available.

## Requirements
* Craft 3.0 (beta 28)+
* PHP 7.0+
* Google Maps API Key

## Installation

1. Install with Composer
    
       composer require dolphiq/craf3-locationpicker
       
2. Install plugin in the Craft Control Panel under Settings > Plugins
3. The Location Field type will be available when adding a new field - Settings > Fields > Add new field

## Creating a field with the location field type
1. Choose the `Location Field` type
2. Save the field

## Using the location field type
1. Add the field to a field layout (for example to a section)
2. You can now choose an location when creating or updating a section by clicking on the `Pick location` button
3. When clicking this button you will get a popup. Type the adress to search for a location.
4. You will now get a dropdown list. Click on one of the options in the dropdownlist to choose a location.
4. The location will be shown on the map below
5. Click on the red `Select` button in the bottom right corner of the popup to use the choosen location in the entry.
6. If you click cancel or dismiss the popup the choosen location will not be set in the entry.

## Usage sample to display a map with one location 
Display a google map with the choosen location in a twig template
```twig
{{ entry.fieldName.getMap() }}
```

##### Properties of the icon field
1. Get the location address (string) 
    
       {{ entry.fieldName.address }}
    
2. Get the location latitude 

       {{ entry.fieldName.lat }}   
        
2. Get the location longitude 

       {{ entry.fieldName.long }}
       
3. Display a map with the location. Options is an array, see [options part](#map-options)

       {{ entry.fieldName.getMap()|raw }}
       
    
## Usage sample to display a map with more locations
To display more locations on the same map (a marker for every location), we use the twig function `dolphiqMap`
Lets say we have a structure called `hospitals` with entries that each have a location field. 
To display a map with all locations do the following in a twig template:

```twig
{% set hospitals = craft.entries.section('hospitals').all() %}
{% set locations = {} %}

{% for hospital in hospitals %}

    {% set locations = locations|merge({(loop.index) : hospital.location}) %}
    
{% endfor %}

{{ dolphiqMap(locations, {width:'100%', height:'500px'})|raw }}
```

## Properties and options
Properties of the `dolphiqMap(locations, options)` function

###### Properties
| Property      | Type  | Description                                                                                                                    |
| ------------- | ----- | ------------------------------------------------------------------------------------------------------------------------------ |
| locations     | array | Should be an array or a multidemensional array for more locations with at least a `lat` and `long` attribute for each location |
| options       | array | An array with one of the following options                                                                                     |

###### Map Options
| Option        | Type          | Default | Description                                                                            |
| ------------- | ------------- | ------- | -------------------------------------------------------------------------------------- |
| width         | string        | 100%    | The width of the google map. In css units. So you can use percentage as wel as pixels  |
| height        | string        | 500px   | The height of the google map. In css units. So you can use percentage as wel as pixels |


## Contributors & Developers
   
Lucas Weijers - Original developer 

Brought to you by Dolphiq: info@dolphiq.nl
<?php
/**
 * Created by PhpStorm.
 * User: lucasweijers
 * Date: 16-08-17
 * Time: 13:17
 *
 * @var string $name
 * @var \plugins\dolphiq\locationPicker\models\LocationModel $value
 * @var \plugins\dolphiq\locationPicker\fields\Location $field
 * @var \craft\base\Plugin $plugin
 */


?>
<?php if(!empty($plugin->getSettings()->apiKey)){ ?>

  <input type="hidden" name="<?= $name; ?>[long]" class="locationField_long" value="<?= $value->long; ?>">
  <input type="hidden" name="<?= $name; ?>[lat]" class="locationField_lat" value="<?= $value->lat; ?>">
  <input type="hidden" name="<?= $name; ?>[address]" class="locationField_address" value="<?= $value->address; ?>">
  <!--<input class="text nicetext locationField" type="text" id="<?= $name; ?>" value="<?= $value->address; ?>" placeholder="<?= Craft::t('site', $field->placeholder) ?>" data-apikey="<?= $plugin->getSettings()->apiKey; ?>">
  <button class="locationFieldButton btn" type="button">Validate</button>-->
  <p class="locationField_msg"><?= $value->address; ?></p>
  <button class="locationField_modaltoggle btn" type="button">Pick location</button>

  <div class="modal locationField_modal elementselectormodal" style="display: none" id="<?= $name; ?>_modal">
    <div class="body">
      <div class="content">
        <div class="main">
          <div class="toolbar">
            <div class="flex">
              <div class="flex-grow texticon search icon clearable">
                <input class="text fullwidth locationField_search" id="<?= $name; ?>-search" placeholder="<?= Craft::t('app', 'Search address'); ?>"/>
                <div class="clear hidden" title="Verwijderen"></div>
              </div>
            </div>
          </div>
          <div class="locationField_map" id="<?= $name; ?>-map"></div>
        </div>
      </div>
    </div>
    <div class="footer">
      <div class="buttons right">
        <div class="btn locationField_modal_close" tabindex="0"><?= Craft::t('app', 'Cancel'); ?></div>
        <div class="btn disabled submit locationField_modal_select"><?= Craft::t('app', 'Select'); ?></div>
      </div>
    </div>
    <div class="resizehandle"></div>
  </div>

<?php }else{ ?>

  <p class="error">Please fill in your google maps API Key first</p>

<?php } ?>
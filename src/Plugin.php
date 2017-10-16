<?php
/**
 * Created by PhpStorm.
 * User: lucasweijers
 * Date: 19-05-17
 * Time: 15:23
 */


namespace plugins\dolphiq\locationPicker;

use Craft;
use plugins\dolphiq\locationPicker\fields\Location;
use plugins\dolphiq\locationPicker\twigextensions\YiiTwigExtension;
use craft\events\RegisterComponentTypesEvent;
use craft\services\Fields;
use yii\base\Event;
use yii\web\View;

class Plugin extends \craft\base\Plugin
{
    public $hasCpSettings = true;

    public function init()
    {
        parent::init();

        // Register twig extention
        Craft::$app->view->twig->addExtension(new YiiTwigExtension());

        // Register field type
        Event::on(Fields::class, Fields::EVENT_REGISTER_FIELD_TYPES, function(RegisterComponentTypesEvent $event) {
          $event->types[] = Location::class;
        });
    }

    protected function createSettingsModel()
    {
        return new \plugins\dolphiq\locationPicker\models\Settings();
    }

    protected function settingsHtml()
    {
        return \Craft::$app->getView()->renderTemplate('dolphiq-craft3-locationpicker/settings', [
            'settings' => $this->getSettings()
        ]);
    }
}

?>
<?php
/**
 * @link      https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license   https://craftcms.com/license
 */

namespace plugins\dolphiq\locationPicker\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\Model;
use craft\base\PreviewableFieldInterface;
use craft\helpers\Db;
use plugins\dolphiq\locationPicker\models\LocationModel;
use yii\db\Schema;
use yii\web\View;

/**
 * PlainText represents a Plain Text field.
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since  3.0
 */
class Location extends Field implements PreviewableFieldInterface
{
    // Static
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('app', 'Location');
    }

    // Properties
    // =========================================================================

    /**
     * @var string|null The input’s placeholder text
     */
    public $placeholder;

    /**
     * @var int|null The maximum number of characters allowed in the field
     */
    public $charLimit;

    private $values = [
        'value' => '',
        'lat' => '',
        'long' => ''
    ];

    /**
     * @var string The type of database column the field should have in the content table
     */
    public $columnType = Schema::TYPE_TEXT;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    /*public function rules()
    {
        $rules = parent::rules();
        return $rules;
    }*/

    /**
     * @inheritdoc
     */
    /*public function getSettingsHtml()
    {
        return Craft::$app->getView()->renderTemplate('_components/fieldtypes/PlainText/settings',
            [
                'field' => $this
            ]);
    }*/

    /**
     * @inheritdoc
     */
    public function getContentColumnType(): string
    {
        return $this->columnType;
    }

    /**
     * @inheritdoc
     * @TODO Display the choosen location in the map again when closing and opening the popup. Has to work when the entry is not saved and also when it is saved
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        $script = <<<JS
var locationField_map_enabled = false;

function enableLocationFieldMap(){
  locationField_map_enabled = true;
}
JS;
        Craft::$app->view->registerJs($script, View::POS_HEAD);
        Craft::$app->view->registerAssetBundle(\plugins\dolphiq\locationPicker\assets\appAsset::class);
        Craft::$app->view->registerJsFile('https://maps.googleapis.com/maps/api/js?key='.\plugins\dolphiq\locationPicker\Plugin::getInstance()->getSettings()->apiKey.'&libraries=places&callback=enableLocationFieldMap', ['defer' => 'defer', 'async' => 'async']);

        return Craft::$app->getView()->render('@vendor/dolphiq/craft3-locationpicker/src/views/main/_field', [
            'name' => $this->handle,
            'value' => $value,
            'field' => $this,
            'plugin' => \plugins\dolphiq\locationPicker\Plugin::getInstance(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getElementValidationRules(): array
    {
        return [
            ['validateLocation'],
        ];
    }

    /**
     * @param $element
     * @return void
     */
    public function validateLocation(Model $element){
        //$element->addError($this->handle, Craft::t('app', 'Not correct'));
    }

    /**
     * @inheritdoc
     */
    public function normalizeValue($value, ElementInterface $element = null)
    {
        $model = new LocationModel();

        /**
         * Serialised value from the DB
         */
        if (is_string($value)) {
            $value = json_decode($value, true);
        }

        /**
         * Array value from post or unserialised array
         */
        if (is_array($value) && !empty(array_filter($value))) {
            $model->load($value, '');
        }

        return $model;
    }
}

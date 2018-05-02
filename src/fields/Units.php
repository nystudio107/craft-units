<?php
/**
 * Units plugin for Craft CMS 3.x
 *
 * A plugin for handling physical quantities and the units of measure in which
 * they're represented.
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\units\fields;

use nystudio107\units\assetbundles\unitsfield\UnitsFieldAsset;

use nystudio107\units\helpers\ClassHelper;
use nystudio107\units\models\Settings;
use nystudio107\units\models\UnitsData;
use nystudio107\units\Units as UnitsPlugin;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\helpers\Json;

use PhpUnitsOfMeasure\AbstractPhysicalQuantity;
use PhpUnitsOfMeasure\PhysicalQuantity\Length;
use PhpUnitsOfMeasure\UnitOfMeasure;
use yii\base\InvalidConfigException;

/**
 * @author    nystudio107
 * @package   Units
 * @since     1.0.0
 */
class Units extends Field
{
    // Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('units', 'Units');
    }

    // Public Properties
    // =========================================================================

    /**
     * @var string The default fully qualified class name of the unit of measure
     */
    public $defaultUnitsClass = Length::class;

    /**
     * @var float The default value of the unit of measure
     */
    public $defaultValue = 0.0;

    /**
     * @var string The default units that the unit of measure is in
     */
    public $defaultUnits = 'ft';

    /**
     * @var bool Whether the units the field can be changed
     */
    public $changeableUnits = true;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        /** @var Settings $settings */
        $settings = UnitsPlugin::$plugin->getSettings();
        $this->defaultUnitsClass = $settings->defaultUnitsClass;
        $this->defaultValue = $settings->defaultValue;
        $this->defaultUnits = $settings->defaultUnits;
        $this->changeableUnits = $settings->defaultChangeableUnits;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules = array_merge($rules, [
            ['defaultUnitsClass', 'string'],
            ['defaultUnitsClass', 'default', 'value' => Length::class],
            ['defaultValue', 'number'],
            ['defaultValue', 'default', 'value' => 0.0],
            ['defaultUnits', 'string'],
            ['defaultUnits', 'default', 'value' => 'feet'],
            ['changeableUnits', 'boolean'],
            ['changeableUnits', 'default', 'value' => true],
        ]);

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function normalizeValue($value, ElementInterface $element = null)
    {
        if ($value instanceof AbstractPhysicalQuantity) {
            return $value;
        }

        // Default config
        $config = [
            'unitsClass' => $this->defaultUnitsClass,
            'value' => $this->defaultValue,
            'units' => $this->defaultUnits,
        ];
        // Handle incoming values potentially being JSON, an array, or an object
        if (!empty($value)) {
            if (\is_string($value)) {
                $config = Json::decodeIfJson($value);
            }
            if (\is_array($value)) {
                $config = $value;
            }
            if (\is_object($value) && $value instanceof UnitsData) {
                $config = $value->toArray();
            }
        }
        // Create and validate the model
        $unitsData = new UnitsData($config);
        if (!$unitsData->validate()) {
            Craft::error(
                Craft::t('units', 'UnitsData failed validation: ')
                .print_r($unitsData->getErrors(), true),
                __METHOD__
            );
        }

        return new $unitsData->unitsClass($unitsData->value, $unitsData->units);
    }

    /**
     * @inheritdoc
     */
    public function serializeValue($value, ElementInterface $element = null)
    {
        if ($value instanceof AbstractPhysicalQuantity) {
            list($originalValue, $originalUnit) = explode(' ', (string)$value);
            $config = [
                'unitsClass' => \get_class($value),
                'value' => $originalValue,
                'units' => $originalUnit,
            ];
            $value = new UnitsData($config);
        }

        return parent::serializeValue($value, $element);
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        $availableUnits = [];
        $units = Length::getUnitDefinitions();
        /** @var UnitOfMeasure $unit */
        foreach ($units as $unit) {
            $name = $unit->getName();
            $aliases = $unit->getAliases();
            $availableUnits[$name] = $aliases[0] ?? $name;
        }
        $unitsClassMap = array_flip(ClassHelper::getClassesInNamespace(Length::class));
        // Render the settings template
        return Craft::$app->getView()->renderTemplate(
            'units/_components/fields/Units_settings',
            [
                'field' => $this,
                'unitsClassMap' => $unitsClassMap,
                'availableUnits' => $availableUnits,
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        // Register our asset bundle
        try {
            Craft::$app->getView()->registerAssetBundle(UnitsFieldAsset::class);
        } catch (InvalidConfigException $e) {
            Craft::error($e->getMessage(), __METHOD__);
        }

        // Get our id and namespace
        $id = Craft::$app->getView()->formatInputId($this->handle);
        $namespacedId = Craft::$app->getView()->namespaceInputId($id);

        // Variables to pass down to our field JavaScript to let it namespace properly
        $jsonVars = [
            'id' => $id,
            'name' => $this->handle,
            'namespace' => $namespacedId,
            'prefix' => Craft::$app->getView()->namespaceInputId(''),
        ];
        $jsonVars = Json::encode($jsonVars);
        Craft::$app->getView()->registerJs("$('#{$namespacedId}-field').UnitsUnits(".$jsonVars.");");

        if ($value instanceof AbstractPhysicalQuantity) {
            $unitsClassMap = array_flip(ClassHelper::getClassesInNamespace(Length::class));
            list($originalValue, $originalUnit) = explode(' ', (string)$value);
            $availableUnits = $value::getUnitDefinitions();
        }

        // Render the input template
        return Craft::$app->getView()->renderTemplate(
            'units/_components/fields/Units_input',
            [
                'name' => $this->handle,
                'field' => $this,
                'id' => $id,
                'namespacedId' => $namespacedId,
                'unitsClassMap' => $unitsClassMap,
                'availableUnits' => $availableUnits,
                'unitsClass' => \get_class($value),
                'value' => $originalValue,
                'units' => $originalUnit,
            ]
        );
    }
}

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

use Craft;
use craft\base\ElementInterface;
use craft\base\PreviewableFieldInterface;
use craft\fields\Number;
use craft\helpers\Json;
use craft\i18n\Locale;

use nystudio107\units\assetbundles\unitsfield\UnitsFieldAsset;
use nystudio107\units\helpers\ClassHelper;
use nystudio107\units\models\Settings;
use nystudio107\units\models\UnitsData;
use nystudio107\units\Units as UnitsPlugin;
use nystudio107\units\validators\EmbeddedUnitsDataValidator;

use PhpUnitsOfMeasure\PhysicalQuantity\Length;

use yii\base\InvalidConfigException;
use yii\db\Schema;

/**
 * @author    nystudio107
 * @package   Units
 * @since     1.0.0
 */
class Units extends Number implements PreviewableFieldInterface
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
    public $defaultUnitsClass;

    /**
     * @var string The default units that the unit of measure is in
     */
    public $defaultUnits;

    /**
     * @var bool Whether the units the field can be changed
     */
    public $changeableUnits = true;

    /**
     * @var array|null Filtered array of allowed units
     */
    public $allowedUnits = null;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->allowedUnits === '*') {
            $this->allowedUnits =  null;
        }

        if (UnitsPlugin::$plugin !== null) {
            /** @var Settings $settings */
            $settings = UnitsPlugin::$plugin->getSettings();

            // TODO: do we really need this?
            if (!empty($settings)) {
                $this->defaultUnitsClass = $this->defaultUnitsClass ?? $settings->defaultUnitsClass;
                $this->defaultUnits = $this->defaultUnits ?? $settings->defaultUnits;
                $this->changeableUnits = $this->changeableUnits ?? $settings->defaultChangeableUnits;
                $this->min = $this->min ?? $settings->defaultMin;
                $this->max = $this->max ?? $settings->defaultMax;
                $this->decimals = $this->decimals ?? $settings->defaultDecimals;

                if ($this->defaultValue !== null && !$this->defaultValue) {
                    $this->defaultValue = $settings->defaultValue;
                }

                if ($this->size !== null && !$this->size) {
                    $this->size = $settings->defaultSize;
                }
            }
        }
    }

    public static function valueType(): string
    {
        return UnitsData::class;
    }

    public function getContentColumnType(): string
    {
        return Schema::TYPE_TEXT;
    }

    /**
     * @inheritdoc
     */
    public function getContentGqlType()
    {
        // TODO:
        // return NumberType::getType();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules = array_merge($rules, [
            ['defaultUnitsClass', 'string'],
            ['defaultUnits', 'string'],
            ['changeableUnits', 'boolean'],
        ]);

        if ($this->allowedUnits !== null) {
            $rules[] = ['defaultUnits', 'in', 'range' => $this->allowedUnits];
        }

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function normalizeValue($value, ElementInterface $element = null)
    {
        $value = parent::normalizeValue($value, $element);

        if ($value instanceof UnitsData || $value === null) {
            return $value;
        }
        // Default config
        $config = [
            'unitsClass' => $this->defaultUnitsClass,
            'value' => $this->defaultValue,
            'units' => $this->defaultUnits,
        ];

        // Handle incoming values potentially being JSON or an array
        if (!empty($value)) {
            // Handle a numeric value coming in (perhaps from a Number field)
            if (\is_numeric($value)) {
                $config['value'] = $value;
            } elseif (\is_string($value)) {
                $config = Json::decodeIfJson($value);
            }
            if (\is_array($value)) {
                $config = array_merge($config, $value);
            }
        }

        // Create and validate the model
        $unitsData = new UnitsData($config);

        // We don't save field data for this, just get from settings
        $unitsData->allowedUnits = $this->allowedUnits;

        if (!$unitsData->validate()) {
            Craft::error(
                Craft::t('units', 'UnitsData failed validation: ')
                .print_r($unitsData->getErrors(), true),
                __METHOD__
            );
        }

        return $unitsData;
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        $unitsClassMap = array_flip(ClassHelper::getClassesInNamespace(Length::class));

        // Render the settings template
        $html = Craft::$app->getView()->renderTemplate(
            'units/_components/fields/Units_settings',
            [
                'field' => $this,
                'unitsClassMap' => $unitsClassMap,
            ]
        );

        $html .=  parent::getSettingsHtml();

        return $html;
    }

    /**
     * @inheritdoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        if ($value instanceof UnitsData) {
            // Register our asset bundle
            try {
                Craft::$app->getView()->registerAssetBundle(UnitsFieldAsset::class);
            } catch (InvalidConfigException $e) {
                Craft::error($e->getMessage(), __METHOD__);
            }
            $model = $value;
            $value = $model->value;
            $decimals = $this->decimals;
            // If decimals is 0 (or null, empty for whatever reason), don't run this
            if ($decimals) {
                $decimalSeparator = Craft::$app->getLocale()->getNumberSymbol(Locale::SYMBOL_DECIMAL_SEPARATOR);
                $value = number_format($value, $decimals, $decimalSeparator, '');
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

            // Render the input template
            return Craft::$app->getView()->renderTemplate(
                'units/_components/fields/Units_input',
                [
                    'name' => $this->handle,
                    'field' => $this,
                    'id' => $id,
                    'namespacedId' => $namespacedId,
                    'value' => $value,
                    'model' => $model,
                ]
            );
        }

        return '';
    }

    /**
     * @inheritdoc
     */
    public function getElementValidationRules(): array
    {
        return [
            [
                EmbeddedUnitsDataValidator::class,
                'units' => $this->defaultUnits,
                'integerOnly' => $this->decimals ? false : true,
                'min' => $this->min,
                'max' => $this->max,
            ],
        ];
    }
}

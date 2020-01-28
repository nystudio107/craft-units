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
use nystudio107\units\helpers\UnitsHelper;
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
    public $unitsClass = Length::class;

    /**
     * @var string The default units that the unit of measure is in
     */
    public $defaultUnits = 'ft';

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
            $this->allowedUnits = null;
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
            ['unitsClass', 'string'],
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
            'unitsClass' => $this->unitsClass,
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

        // Should we?
        // $unitsData->field = $this;

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
        try {
            Craft::$app->getView()->registerAssetBundle(UnitsFieldAsset::class);
        } catch (InvalidConfigException $e) {
            Craft::error($e->getMessage(), __METHOD__);
        }

        // If decimals is 0 (or null, empty for whatever reason), don't run this
        if ($this->decimals) {
            $decimalseparator = Craft::$app->getLocale()->getNumberSymbol(Locale::SYMBOL_DECIMAL_SEPARATOR);
            $value = number_format($value, $this->decimals, $decimalSeparator, '');
        }

        // Get our id and namespace
        $id = Craft::$app->getView()->formatInputId($this->handle);
        $namespacedId = Craft::$app->getView()->namespaceInputId($id);

        // Variables to pass down to our field JavaScript to let it namespace properly
        $jsonVars = Json::encode([
            'id' => $id,
            'name' => $this->handle,
            'namespace' => $namespacedId,
            'prefix' => Craft::$app->getView()->namespaceInputId(''),
        ]);

        Craft::$app->getView()->registerJs("$('#{$namespacedId}-field').UnitsUnits(".$jsonVars.");");

        return Craft::$app->getView()->renderTemplate(
            'units/_components/fields/Units_input',
            [
                'name' => $this->handle,
                'field' => $this,
                'id' => $id,
                'namespacedId' => $namespacedId,
                'value' => $value,
            ]
        );
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

    /**
     * Return a filtered array of allowed units
     *
     * @param  bool $includeAliases
     * @return string
     */
    public function getAllowedUnits(): array
    {
        return array_filter($this->getAvailableUnits(), function ($key) {
            return $this->allowedUnits === null ? true : in_array($key, $this->allowedUnits);
        }, ARRAY_FILTER_USE_KEY);
    }

    public function getAllowedUnitsOptions(): array
    {
        $options = $this->getAllowedUnits();

        // TODO: only if not required, or if value not in allowed?
        // Or add a null option to defaultUnits
        // array_unshift($options, [
        //     'label' => Craft::t('units', 'Select One…'),
        //     'value' => null,
        // ]);

        return $options;
    }

    /**
     * Return the available units for a given AbstractPhysicalQuantity
     *
     * @param string $unitsClass
     * @param bool   $includeAliases whether to include aliases or not
     *
     * @return array
     */
    public function getAvailableUnits($includeAliases = false): array
    {
        return UnitsHelper::getAvailableUnits($this->unitsClass, $includeAliases);
    }
}

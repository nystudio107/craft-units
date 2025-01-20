<?php
/**
 * Units plugin for Craft CMS
 *
 * A plugin for handling physical quantities and the units of measure in which
 * they're represented.
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c) nystudio107
 */

namespace nystudio107\units\fields;

use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;
use craft\helpers\Html;
use craft\helpers\Json;
use craft\i18n\Locale;
use GraphQL\Type\Definition\Type;
use nystudio107\units\assetbundles\unitsfield\UnitsFieldAsset;
use nystudio107\units\gql\types\generators\UnitsDataGenerator;
use nystudio107\units\helpers\ClassHelper;
use nystudio107\units\models\Settings;
use nystudio107\units\models\UnitsData;
use nystudio107\units\Units as UnitsPlugin;
use nystudio107\units\validators\EmbeddedUnitsDataValidator;
use PhpUnitsOfMeasure\PhysicalQuantity\Length;
use yii\base\InvalidConfigException;

/**
 * @author    nystudio107
 * @package   Units
 * @since     1.0.0
 */
class Units extends Field implements PreviewableFieldInterface
{
    // Static Methods
    // =========================================================================

    /**
     * @var string The default fully qualified class name of the unit of measure
     */
    public string $defaultUnitsClass;

    // Public Properties
    // =========================================================================
    /**
     * @var ?float The default value of the unit of measure
     */
    public ?float $defaultValue = null;
    /**
     * @var ?string The default units that the unit of measure is in
     */
    public ?string $defaultUnits = null;
    /**
     * @var ?bool Whether the units the field can be changed
     */
    public ?bool $changeableUnits = null;
    /**
     * @var int|float|null The minimum allowed number
     */
    public int|float|null $min = null;
    /**
     * @var int|float|null The maximum allowed number
     */
    public int|float|null $max = null;
    /**
     * @var ?int The number of digits allowed after the decimal point
     */
    public ?int $decimals = null;
    /**
     * @var ?int The size of the field
     */
    public ?int $size = null;

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('units', 'Units');
    }

    /**
     * @inheritdoc
     */
    public static function icon(): string
    {
        return 'scale-balanced';
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();
        if (UnitsPlugin::$plugin !== null) {
            /** @var Settings $settings */
            $settings = UnitsPlugin::$plugin->getSettings();
            if ($settings !== null) {
                $this->defaultUnitsClass = $this->defaultUnitsClass ?? $settings->defaultUnitsClass;
                $this->defaultValue = $this->defaultValue ?? $settings->defaultValue;
                $this->defaultUnits = $this->defaultUnits ?? $settings->defaultUnits;
                $this->changeableUnits = $this->changeableUnits ?? $settings->defaultChangeableUnits;
                $this->min = $this->min ?? $settings->defaultMin;
                $this->max = $this->max ?? $settings->defaultMax;
                $this->decimals = $this->decimals ?? $settings->defaultDecimals;
                $this->size = $this->size ?? $settings->defaultSize;
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        $rules = parent::rules();
        $rules = array_merge($rules, [
            ['defaultUnitsClass', 'string'],
            ['defaultValue', 'number'],
            ['defaultUnits', 'string'],
            ['changeableUnits', 'boolean'],
            [['min', 'max'], 'number'],
            [['decimals', 'size'], 'integer'],
            [
                ['max'],
                'compare',
                'compareAttribute' => 'min',
                'operator' => '>=',
            ],
        ]);

        if (!$this->decimals) {
            $rules[] = [['min', 'max'], 'integer'];
        }

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function normalizeValue(mixed $value, ?ElementInterface $element = null): mixed
    {
        if ($value instanceof UnitsData) {
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
            if (is_numeric($value)) {
                $config['value'] = (float)$value;
            } elseif (is_string($value)) {
                $config = Json::decodeIfJson($value);
            }
            if (is_array($value)) {
                $config = array_merge($config, array_filter($value));
            }
        }
        // Typecast it to a float
        $config['value'] = (float)$config['value'];
        // Create and validate the model
        $unitsData = new UnitsData($config);
        if (!$unitsData->validate()) {
            Craft::error(
                Craft::t('units', 'UnitsData failed validation: ')
                . print_r($unitsData->getErrors(), true),
                __METHOD__
            );
        }

        return $unitsData;
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml(): ?string
    {
        $unitsClassMap = array_flip(ClassHelper::getClassesInNamespace(Length::class));

        // Render the settings template
        return Craft::$app->getView()->renderTemplate(
            'units/_components/fields/Units_settings',
            [
                'field' => $this,
                'unitsClassMap' => $unitsClassMap,
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getInputHtml(mixed $value, ?ElementInterface $element = null): string
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
            $id = Html::id($this->handle);
            $namespacedId = Craft::$app->getView()->namespaceInputId($id);

            // Variables to pass down to our field JavaScript to let it namespace properly
            $jsonVars = [
                'id' => $id,
                'name' => $this->handle,
                'namespace' => $namespacedId,
                'prefix' => Craft::$app->getView()->namespaceInputId(''),
            ];
            $jsonVars = Json::encode($jsonVars);
            Craft::$app->getView()->registerJs("$('#{$namespacedId}-field').UnitsUnits(" . $jsonVars . ");");

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
    public function getContentGqlType(): Type|array
    {
        $typeArray = UnitsDataGenerator::generateTypes($this);

        return [
            'name' => $this->handle,
            'description' => 'Units field',
            'type' => array_shift($typeArray),
        ];
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
                'integerOnly' => !$this->decimals,
                'min' => $this->min,
                'max' => $this->max,
            ],
        ];
    }
}

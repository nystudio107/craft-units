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

namespace nystudio107\units\models;

use Craft;
use craft\base\Model;

use nystudio107\units\Units;

use PhpUnitsOfMeasure\AbstractPhysicalQuantity;

use PhpUnitsOfMeasure\PhysicalQuantityInterface;
use PhpUnitsOfMeasure\UnitOfMeasure;
use PhpUnitsOfMeasure\UnitOfMeasureInterface;
use yii\base\InvalidArgumentException;

/**
 * @author    nystudio107
 * @package   Units
 * @since     1.0.0
 *
 * @property string         $valueFraction
 * @property array|float[]  $valueParts
 * @property array|string[] $valuePartsFraction
 */
class UnitsData extends Model implements PhysicalQuantityInterface
{
    // Public Properties
    // =========================================================================

    /**
     * @var string The fully qualified class name of the unit of measure
     */
    public $unitsClass;

    /**
     * @var float|null The value of the unit of measure
     */
    public $value = null;

    /**
     * @var string The units that the unit of measure is in
     */
    public $units;

    /**
     * @var AbstractPhysicalQuantity
     */
    public $unitsInstance;

    /**
     * @var array|null Filtered array of allowed units
     */
    public $allowedUnits = null;

    // Public Methods
    // =========================================================================

    /**
     * Call through to the appropriate method in the AbstractPhysicalQuantity
     * class in $unitsInstance, if it exists
     *
     * @param string $method
     * @param array  $args
     *
     * @return mixed
     * @throws InvalidArgumentException
     * @throws \PhpUnitsOfMeasure\Exception\NonNumericValue
     * @throws \PhpUnitsOfMeasure\Exception\NonStringUnitName
     */
    public function __call($method, $args)
    {
        $unitsInstance = $this->unitsInstance;
        if (method_exists($unitsInstance, $method)) {
            return \call_user_func_array([$unitsInstance, $method], $args);
        }

        throw new InvalidArgumentException("Method {$method} doesn't exist");
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        /** @var Settings $settings */
        $settings = Units::$plugin->getSettings();
        $this->unitsClass = $this->unitsClass ?? $settings->defaultUnitsClass;
        $this->value = $this->value ?? $settings->defaultValue;
        $this->units = $this->units ?? $settings->defaultUnits;

        if ($this->unitsClass !== null && $this->value !== null) {
            $this->unitsInstance = new $this->unitsClass($this->value, $this->units);
        }
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        $rules = parent::rules();
        $rules = array_merge($rules, [
            ['unitsClass', 'string'],
            ['value', 'number'],
            ['units', 'string'],
        ]);

        if ($this->allowedUnits !== null) {
            $rules[] = ['units', 'in', 'range' => $this->allowedUnits];
        }

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();
        $fields = array_diff_key(
            $fields,
            array_flip([
                'unitsInstance',
            ])
        );

        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function toUnit($unit)
    {
        return $this->unitsInstance->toUnit($unit);
    }

    /**
     * @inheritdoc
     */
    public function toNativeUnit()
    {
        return $this->unitsInstance->toNativeUnit();
    }

    /**
     * @inheritdoc
     */
    public function __toString(): string
    {
        return $this->unitsInstance->__toString();
    }

    /**
     * @inheritdoc
     */
    public function add(PhysicalQuantityInterface $quantity)
    {
        /** @var UnitsData $quantity */
        return $this->physicalQuantityToUnitsData($this->unitsInstance->add($quantity->unitsInstance));
    }

    /**
     * @inheritdoc
     */
    public function subtract(PhysicalQuantityInterface $quantity)
    {
        /** @var UnitsData $quantity */
        return $this->physicalQuantityToUnitsData($this->unitsInstance->subtract($quantity->unitsInstance));
    }

    /**
     * @inheritdoc
     */
    public function isEquivalentQuantity(PhysicalQuantityInterface $testQuantity)
    {
        /** @var UnitsData $testQuantity */
        return $this->unitsInstance->isEquivalentQuantity($testQuantity->unitsInstance);
    }

    /**
     * Return an array of available units
     *
     * @param  bool $includeAliases
     * @return string
     */
    public function availableUnits(bool $includeAliases = true)
    {
        $availableUnits = [];
        /** @var AbstractPhysicalQuantity $unitsClass */
        $units = $this->unitsInstance::getUnitDefinitions();
        /** @var UnitOfMeasure $unit */
        foreach ($units as $unit) {
            $name = $unit->getName();
            $aliases = $unit->getAliases();
            $availableUnits[$name] = $includeAliases ? $aliases : $aliases[0] ?? $name;
        }

        return $availableUnits;
    }

    /**
     * Return a filtered array of allowed units
     *
     * @param  bool $includeAliases
     * @return string
     */
    public function allowedUnits(bool $includeAliases = true)
    {
        return array_filter($this->availableUnits($includeAliases), function ($key) {
            return $this->allowedUnits === null ? true : in_array($key, $this->allowedUnits);
        }, ARRAY_FILTER_USE_KEY);
    }

    public function allowedUnitsOptions(): array
    {
        $options = $this->allowedUnits(false);

        array_unshift($options, [
            'label' => Craft::t('units', 'Select One…'),
            'value' => null,
        ]);

        return $options;
    }

    /**
     * Return the measurement as a fraction, with the units appended
     *
     * @return string
     */
    public function toFraction(): string
    {
        return trim(Units::$variable->fraction($this->value) . ' ' . $this->units);
    }
    /**
     * Return the measurement as a fraction, in the given unit of measure
     *
     * @param  UnitOfMeasureInterface|string $unit The desired unit of measure,
     *                                             or a string name of one
     *
     * @return string The measurement cast in the requested units, as a
     *                fraction
     */
    public function toUnitFraction($unit): string
    {
        $value = $this->toUnit($unit);

        return Units::$variable->fraction($value);
    }

    /**
     * Return the value as a fraction
     *
     * @return string
     */
    public function getValueFraction(): string
    {
        return Units::$variable->fraction($this->value);
    }

    /**
     * Return an array of the whole number and decimal number ports of the value
     * [0] has the whole number part, and [1] has the decimal part
     *
     * @return float[]
     */
    public function getValueParts(): array
    {
        return Units::$variable->float2parts($this->value);
    }

    /**
     * Return an array of the whole number and decimal number ports of the
     * value with the decimal part converted to a fraction. [0] has the whole
     * number part, and [1] has the fractional part
     *
     * @return string[]
     */
    public function getValuePartsFraction(): array
    {
        $parts = Units::$variable->float2parts($this->value);
        $parts[0] = (string)$parts[0];
        $parts[1] = Units::$variable->float2ratio($parts[1]);

        return $parts;
    }

    // Protected Methods
    // =========================================================================

    /**
     * Convert a PhysicalQuantity object into a UnitsData object
     *
     * @param PhysicalQuantityInterface $quantity
     *
     * @return UnitsData
     */
    protected function physicalQuantityToUnitsData(PhysicalQuantityInterface $quantity): UnitsData
    {
        $unitsClass = \get_class($quantity);
        list($value, $units) = explode(' ', (string)$quantity);
        $config = [
            'unitsClass' => $unitsClass,
            'value' => $value,
            'units' => $units,
        ];

        return new UnitsData($config);
    }
}

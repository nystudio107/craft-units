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

use nystudio107\units\Units;

use craft\base\Model;

use PhpUnitsOfMeasure\UnitOfMeasureInterface;
use yii\base\InvalidArgumentException;

use PhpUnitsOfMeasure\AbstractPhysicalQuantity;
use PhpUnitsOfMeasure\PhysicalQuantityInterface;

/**
 * @author    nystudio107
 * @package   Units
 * @since     1.0.0
 *
 * @method float toUnit(UnitOfMeasureInterface|string $unit)
 * @method float toNativeUnit()
 * @method float add(PhysicalQuantityInterface $quantity)
 * @method float subtract(PhysicalQuantityInterface $quantity)
 * @method bool isEquivalentQuantity(PhysicalQuantityInterface $testQuantity)
 */
class UnitsData extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string The fully qualified class name of the unit of measure
     */
    public $unitsClass;

    /**
     * @var float The value of the unit of measure
     */
    public $value;

    /**
     * @var string The units that the unit of measure is in
     */
    public $units;

    // Private Properties
    // =========================================================================

    /**
     * @var AbstractPhysicalQuantity
     */
    private $unitsInstance;

    // Public Methods
    // =========================================================================

    /**
     * Call through to the appropriate method in the AbstractPhysicalQuantity class
     * in $unitsInstance, if it exists
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
     * Return the AbstractPhysicalQuantity's __toString() result, which will be
     * the value and units as a string
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->unitsInstance->__toString();
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

        if ($this->unitsClass !== null) {
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

        return $rules;
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
     * Return an array of the whole number and decimal number ports of the value
     * with the decimal part converted to a fraction. [0] has the whole number part,
     * and [1] has the fractional part
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

    /**
     * Fetch the measurement as a fraction, in the given unit of measure
     *
     * @param  UnitOfMeasureInterface|string $unit The desired unit of measure, or a string name of one
     *
     * @return string The measurement cast in the requested units, as a fraction
     */
    public function toUnitFraction($unit): string
    {
        $value = $this->toUnit($unit);

        return Units::$variable->fraction($value);
    }

}

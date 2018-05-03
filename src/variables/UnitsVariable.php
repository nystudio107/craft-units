<?php
/**
 * Units plugin for Craft CMS 3.x
 *
 * A plugin for handling physical quantities and the units of measure in which they're represented.
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\units\variables;

use nystudio107\units\helpers\ClassHelper;

use PhpUnitsOfMeasure\AbstractPhysicalQuantity;
use PhpUnitsOfMeasure\PhysicalQuantityInterface;
use PhpUnitsOfMeasure\PhysicalQuantity\Acceleration;
use PhpUnitsOfMeasure\PhysicalQuantity\Angle;
use PhpUnitsOfMeasure\PhysicalQuantity\Area;
use PhpUnitsOfMeasure\PhysicalQuantity\ElectricCurrent;
use PhpUnitsOfMeasure\PhysicalQuantity\Energy;
use PhpUnitsOfMeasure\PhysicalQuantity\Length;
use PhpUnitsOfMeasure\PhysicalQuantity\LuminousIntensity;
use PhpUnitsOfMeasure\PhysicalQuantity\Mass;
use PhpUnitsOfMeasure\PhysicalQuantity\Pressure;
use PhpUnitsOfMeasure\PhysicalQuantity\Quantity;
use PhpUnitsOfMeasure\PhysicalQuantity\SolidAngle;
use PhpUnitsOfMeasure\PhysicalQuantity\Temperature;
use PhpUnitsOfMeasure\PhysicalQuantity\Time;
use PhpUnitsOfMeasure\PhysicalQuantity\Velocity;
use PhpUnitsOfMeasure\PhysicalQuantity\Volume;

use yii\base\InvalidArgumentException;

/**
 * @author    nystudio107
 * @package   Units
 * @since     1.0.0
 *
 * @method Acceleration acceleration($value, string $units)
 * @method Angle angle($value, string $units)
 * @method Area area($value, string $units)
 * @method ElectricCurrent electricCurrent($value, string $units)
 * @method Energy energy($value, string $units)
 * @method Length length($value, string $units)
 * @method LuminousIntensity luminousIntensity($value, string $units)
 * @method Mass mass($value, string $units)
 * @method Pressure pressure($value, string $units)
 * @method Quantity quantity($value, string $units)
 * @method SolidAngle solidAngle($value, string $units)
 * @method Temperature temperature($value, string $units)
 * @method Time time($value, string $units)
 * @method Velocity velocity($value, string $units)
 * @method Volume volume($value, string $units)
 */
class UnitsVariable
{
    // Public Properties
    // =========================================================================

    /**
     * @var array
     */
    public $unitsClassMap;

    // Public Methods
    // =========================================================================

    /**
     * If the passed in class exists in PhpUnitsOfMeasure\PhysicalQuantity
     * return a new instance of the unit of measure
     *
     * @param $method
     * @param $args
     *
     * @return PhysicalQuantityInterface
     * @throws InvalidArgumentException
     * @throws \PhpUnitsOfMeasure\Exception\NonNumericValue
     * @throws \PhpUnitsOfMeasure\Exception\NonStringUnitName
     */
    public function __call($method, $args): PhysicalQuantityInterface
    {
        if (empty($this->unitsClassMap)) {
            $this->unitsClassMap = ClassHelper::getClassesInNamespace(Length::class);
        }
        $unitsClassKey = ucfirst($method);
        if (isset($this->unitsClassMap[$unitsClassKey])) {
            /** @var AbstractPhysicalQuantity $unitsClassName */
            $unitsClassName = $this->unitsClassMap[$unitsClassKey];
            list($value, $units) = $args;

            return new $unitsClassName($value, $units);
        }

        throw new InvalidArgumentException("Method {$method} doesn't exist");
    }
}

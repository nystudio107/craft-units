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
use nystudio107\units\models\UnitsData;

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

use PhpUnitsOfMeasure\UnitOfMeasure;
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
     * @return UnitsData
     * @throws InvalidArgumentException
     */
    public function __call($method, $args): UnitsData
    {
        if (empty($this->unitsClassMap)) {
            $this->unitsClassMap = ClassHelper::getClassesInNamespace(Length::class);
        }
        $unitsClassKey = ucfirst($method);
        if (isset($this->unitsClassMap[$unitsClassKey])) {
            list($value, $units) = $args;
            $config = [
                'unitsClass' =>$this->unitsClassMap[$unitsClassKey],
                'value' => $value,
                'units' => $units,
            ];

            return new UnitsData($config);
        }

        throw new InvalidArgumentException("Method {$method} doesn't exist");
    }

    /**
     * Outputs a floating point number as a fraction
     *
     * @param float $value
     *
     * @return string
     */
    public function fraction(float $value): string
    {
        list($whole, $decimal) = $this->float2parts($value);

        return $whole.' '.$this->float2ratio($decimal);
    }

    /**
     * Convert a floating point number to the whole and the decimal
     *
     * @param float $number
     * @param bool  $returnUnsigned
     *
     * @return array
     */
    public function float2parts(float $number, bool $returnUnsigned = false): array
    {
        $negative = 1;
        if ($number < 0) {
            $negative = -1;
            $number *= -1;
        }

        if ($returnUnsigned) {
            return [
                floor($number),
                $number - floor($number),
            ];
        }

        return [
            floor($number) * $negative,
            ($number - floor($number)) * $negative,
        ];
    }

    /**
     * Convert a floating point number to a ratio
     *
     * @param float $n
     * @param float $tolerance
     *
     * @return string
     */
    public function float2ratio(float $n, float $tolerance = 1.e-6): string
    {
        if ($n === 0.0) {
            return '';
        }
        $h1 = 1;
        $h2 = 0;
        $k1 = 0;
        $k2 = 1;
        $b = 1 / $n;
        do {
            $b = 1 / $b;
            $a = floor($b);
            $aux = $h1;
            $h1 = $a * $h1 + $h2;
            $h2 = $aux;
            $aux = $k1;
            $k1 = $a * $k1 + $k2;
            $k2 = $aux;
            $b -= $a;
        } while (abs($n - $h1 / $k1) > $n * $tolerance);

        return "$h1/$k1";
    }

    /**
     * Return all of the available units
     *
     * @param bool   $includeAliases whether to include aliases or not
     *
     * @return array
     */
    public function allAvailableUnits(bool $includeAliases = false): array
    {
        $unitsList = [];
        $units = ClassHelper::getClassesInNamespace(Length::class);
        foreach ($units as $key => $value) {
            /** @var AbstractPhysicalQuantity $value */
            $unitsList[$key] = $this->availableUnits($value, $includeAliases);
        }
        ksort($unitsList);

        return $unitsList;
    }

    /**
     * Return the available units for a given AbstractPhysicalQuantity
     *
     * @param string $unitsClass
     * @param bool   $includeAliases whether to include aliases or not
     *
     * @return array
     */
    public function availableUnits(string $unitsClass, bool $includeAliases = false): array
    {
        $availableUnits = [];
        if (is_subclass_of($unitsClass, AbstractPhysicalQuantity::class)) {
            /** @var array $units */
            /** @var AbstractPhysicalQuantity $unitsClass */
            $units = $unitsClass::getUnitDefinitions();
            /** @var UnitOfMeasure $unit */
            foreach ($units as $unit) {
                $name = $unit->getName();
                $aliases = $unit->getAliases();
                $availableUnits[$name] = $includeAliases ? $aliases : $aliases[0] ?? $name;
            }
        }

        return $availableUnits;
    }
}

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

use yii\base\InvalidArgumentException;

use PhpUnitsOfMeasure\AbstractPhysicalQuantity;
use PhpUnitsOfMeasure\PhysicalQuantity\Length;

/**
 * @author    nystudio107
 * @package   Units
 * @since     1.0.0
 *
 * @method float toUnit($toUnit)
 * @method float toNativeUnit()
 * @method float add()
 * @method float subtract()
 * @method bool isEquivalentQuantity()
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

    public function toFraction()
    {

    }
    
    // Protected Methods
    // =========================================================================

    /**
     * Convert a floating point number to the whole and the decimal
     *
     * @param float $number
     * @param bool  $returnUnsigned
     *
     * @return array
     */
    protected function float2parts(float $number, bool $returnUnsigned = false): array
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
    protected function float2rat(float $n, float $tolerance = 1.e-6): string
    {
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
            $b = $b - $a;
        } while (abs($n - $h1 / $k1) > $n * $tolerance);

        return "$h1/$k1";
    }
}

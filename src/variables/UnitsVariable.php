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

use PhpUnitsOfMeasure\PhysicalQuantityInterface;
use PhpUnitsOfMeasure\PhysicalQuantity\Length;

use yii\base\InvalidArgumentException;

/**
 * @author    nystudio107
 * @package   Units
 * @since     1.0.0
 *
 * @method acceleration
 * @method angle
 * @method area
 * @method electricCurrent
 * @method energy
 * @method length
 * @method luminousIntensity
 * @method mass
 * @method pressure
 * @method quantity
 * @method solidAngle
 * @method temperature
 * @method time
 * @method velocity
 * @method volume
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
     */
    public function __call($method, $args): PhysicalQuantityInterface
    {
        if (empty($this->unitsClassMap)) {
            $this->unitsClassMap = ClassHelper::getClassesInNamespace(Length::class);
        }
        $unitsClassKey = ucfirst($method);
        if (isset($this->unitsClassMap[$unitsClassKey])) {
            $unitsClassName = $this->unitsClassMap[$unitsClassKey];
            list($value, $units) = $args;

            return new $unitsClassName($value, $units);
        }

        throw new InvalidArgumentException("Method {$method} doesn't exist");
    }
}

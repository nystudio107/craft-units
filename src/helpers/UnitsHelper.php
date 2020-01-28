<?php
/**
 * Units plugin for Craft CMS 3.x
 *
 * A plugin for handling physical quantities and the units of measure in which they're represented.
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\units\helpers;

use Craft;


use PhpUnitsOfMeasure\AbstractPhysicalQuantity;
use PhpUnitsOfMeasure\UnitOfMeasure;

/**
 * @author    nystudio107
 * @package   Units
 * @since     1.0.0
 */
class UnitsHelper
{
    /**
     * Return the available units for a given AbstractPhysicalQuantity
     *
     * @param string $unitsClass
     * @param bool   $includeAliases whether to include aliases or not
     *
     * @return array
     */
    public static function getAvailableUnits(string $unitsClass, bool $includeAliases = false): array
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

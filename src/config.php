<?php
/**
 * Units plugin for Craft CMS 3.x
 *
 * A plugin for handling physical quantities and the units of measure in which they're represented.
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c) 2018 nystudio107
 */

use PhpUnitsOfMeasure\PhysicalQuantity\Length;

/**
 * Units config.php
 *
 * This file exists only as a template for the Units settings.
 * It does nothing on its own.
 *
 * Don't edit this file, instead copy it to 'craft/config' as 'units.php'
 * and make your changes there to override default settings.
 *
 * Once copied to 'craft/config', this file will be multi-environment aware as
 * well, so you can have different settings groups for each environment, just as
 * you do for 'general.php'
 */
return [
    // The default fully qualified class name of the unit of measure
    'defaultUnitsClass' => Length::class,

    // The default value of the unit of measure
    'defaultValue' => 0.0,

    // The default units that the unit of measure is in
    'defaultUnits' => 'ft',

    // Whether the units the field can be changed
    'defaultChangeableUnits' => true,
];

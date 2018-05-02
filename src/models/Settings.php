<?php
/**
 * Units plugin for Craft CMS 3.x
 *
 * A plugin for handling physical quantities and the units of measure in which they're represented.
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\units\models;

use PhpUnitsOfMeasure\PhysicalQuantity\Length;

use craft\base\Model;

/**
 * @author    nystudio107
 * @package   Units
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string The default fully qualified class name of the unit of measure
     */
    public $defaultUnitsClass = Length::class;

    /**
     * @var float The default value of the unit of measure
     */
    public $defaultValue = 0.0;

    /**
     * @var string The default units that the unit of measure is in
     */
    public $defaultUnits = 'ft';

    /**
     * @var bool Whether the units the field can be changed
     */
    public $defaultChangeableUnits = true;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            ['defaultUnitsClass', 'string'],
            ['defaultUnitsClass', 'default', 'value' => Length::class],
            ['defaultValue', 'number'],
            ['defaultValue', 'default', 'value' =>  0.0],
            ['defaultUnits', 'string'],
            ['defaultUnits', 'default', 'value' => 'feet'],
            ['defaultChangeableUnits', 'boolean'],
            ['defaultChangeableUnits', 'default', 'value' => true],
        ];
    }
}

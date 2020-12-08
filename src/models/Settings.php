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

use craft\base\Model;

use PhpUnitsOfMeasure\PhysicalQuantity\Length;

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
     * @var int|float|null The default value of the unit of measure
     */
    public $defaultValue;

    /**
     * @var string The default units that the unit of measure is in
     */
    public $defaultUnits = 'ft';

    /**
     * @var bool Whether the units the field can be changed
     */
    public $defaultChangeableUnits = true;

    /**
     * @var int|float The default minimum allowed number
     */
    public $defaultMin = 0;

    /**
     * @var int|float|null The default maximum allowed number
     */
    public $defaultMax;

    /**
     * @var int The default number of digits allowed after the decimal point
     */
    public $defaultDecimals = 0;

    /**
     * @var int|null The default size of the field
     */
    public $defaultSize;

    // Public Methods
    // =========================================================================

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
            ['defaultChangeableUnits', 'boolean'],
            [['defaultMin', 'defaultMax'], 'number'],
            [
                ['defaultMax'],
                'compare',
                'compareAttribute' => 'defaultMin',
                'operator' => '>='
            ],
            [['defaultDecimals', 'defaultSize'], 'integer'],
        ]);

        if (!$this->defaultDecimals) {
            $rules[] = [['defaultMin', 'defaultMax'], 'integer'];
        }

        return $rules;
    }
}

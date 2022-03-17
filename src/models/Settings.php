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
    public string $defaultUnitsClass = Length::class;

    /**
     * @var float The default value of the unit of measure
     */
    public float $defaultValue = 0.0;

    /**
     * @var string The default units that the unit of measure is in
     */
    public string $defaultUnits = 'ft';

    /**
     * @var bool Whether the units the field can be changed
     */
    public bool $defaultChangeableUnits = true;

    /**
     * @var int|float The default minimum allowed number
     */
    public int|float $defaultMin = 0;

    /**
     * @var int|float|null The default maximum allowed number
     */
    public int|null|float $defaultMax;

    /**
     * @var int The default number of digits allowed after the decimal point
     */
    public int $defaultDecimals = 3;

    /**
     * @var int|null The default size of the field
     */
    public ?int $defaultSize = 6;

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
            ['defaultUnitsClass', 'default', 'value' => Length::class],
            ['defaultValue', 'number'],
            ['defaultValue', 'default', 'value' => 0.0],
            ['defaultUnits', 'string'],
            ['defaultUnits', 'default', 'value' => 'ft'],
            ['defaultChangeableUnits', 'boolean'],
            ['defaultChangeableUnits', 'default', 'value' => true],
            [['defaultMin', 'defaultMax'], 'number'],
            [
                ['defaultMax'],
                'compare',
                'compareAttribute' => 'defaultMin',
                'operator' => '>='
            ],
            ['defaultMin', 'default', 'value' => 0],
            ['defaultMax', 'default', 'value' => null],
            [['defaultDecimals', 'defaultSize'], 'integer'],
            ['defaultDecimals', 'default', 'value' => 3],
            ['defaultSize', 'default', 'value' => 6],
        ]);

        if (!$this->defaultDecimals) {
            $rules[] = [['defaultMin', 'defaultMax'], 'integer'];
        }

        return $rules;
    }
}

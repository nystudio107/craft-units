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

namespace nystudio107\units\validators;

use Craft;
use nystudio107\units\models\UnitsData;
use yii\base\Model;
use yii\validators\NumberValidator;
use yii\validators\Validator;
use function is_object;

/**
 * @author    nystudio107
 * @package   Units
 * @since     1.0.0
 */
class EmbeddedUnitsDataValidator extends Validator
{
    // Public Properties
    // =========================================================================

    /**
     * @var string the base units
     */
    public $units;

    /**
     * @var bool whether the attribute value can only be an integer. Defaults
     *      to false.
     */
    public $integerOnly = false;
    /**
     * @var int|float upper limit of the number. Defaults to null, meaning no
     *      upper limit.
     * @see tooBig for the customized message used when the number is too big.
     */
    public $max;
    /**
     * @var int|float lower limit of the number. Defaults to null, meaning no
     *      lower limit.
     * @see tooSmall for the customized message used when the number is too
     *      small.
     */
    public $min;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        /** @var Model $model */
        $value = $model->$attribute;

        if ($value !== null && is_object($value) && $value instanceof UnitsData) {
            // Validate the model
            $value->validate();
            // Normalize the min/max value
            $this->normalizeMinMax($value);
            // Do a min/max validation, too
            $config = [
                'integerOnly' => $this->integerOnly,
                'min' => $this->min,
                'max' => $this->max,
            ];
            $numberValidator = new NumberValidator($config);
            $numberValidator->validateAttribute($value, 'value');
            // Add any errors to the parent model
            $errors = $value->getErrors();
            foreach ($errors as $attributeError => $valueErrors) {
                /** @var array $valueErrors */
                foreach ($valueErrors as $valueError) {
                    $model->addError(
                        $attribute,
                        $valueError
                    );
                }
            }
        } else {
            $model->addError($attribute, Craft::t('units', 'Is not a Model object.'));
        }
    }

    // Protected Methods
    // =========================================================================

    /**
     * Normalize the min/max values using the base units
     *
     * @param UnitsData $unitsData
     */
    protected function normalizeMinMax(UnitsData $unitsData)
    {
        $config = [
            'unitsClass' => $unitsData->unitsClass,
            'units' => $this->units
        ];
        // Normalize the min
        if (!empty($this->min)) {
            $config['value'] = (float)$this->min;
            $baseUnit = new UnitsData($config);
            $this->min = $baseUnit->toUnit($unitsData->units);
        } else {
            $this->min = null;
        }
        // Normalize the max
        if (!empty($this->max)) {
            $config['value'] = (float)$this->max;
            $baseUnit = new UnitsData($config);
            $this->max = $baseUnit->toUnit($unitsData->units);
        } else {
            $this->max = null;
        }
    }
}

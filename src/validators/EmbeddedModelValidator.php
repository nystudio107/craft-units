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

use yii\base\Model;
use yii\validators\Validator;

/**
 * @author    nystudio107
 * @package   Units
 * @since     1.0.0
 */
class EmbeddedModelValidator extends Validator
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        /** @var Model $model */
        $value = $model->$attribute;

        if ($value !== null && \is_object($value) && $value instanceof Model) {
            if (!$value->validate()) {
                $errors = $value->getErrors();
                foreach ($errors as $attributeError => $valueErrors) {
                    /** @var array $valueErrors */
                    foreach ($valueErrors as $valueError) {
                        $model->addError(
                            $attribute,
                            Craft::t('units', 'Object failed to validate')
                            .'-'.$attributeError.' - '.$valueError
                        );
                    }
                }
            }
        } else {
            $model->addError($attribute, Craft::t('units', 'Is not a Model object.'));
        }
    }
}

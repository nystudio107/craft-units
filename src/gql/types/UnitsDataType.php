<?php
/**
 * Units plugin for Craft CMS
 *
 * A plugin for handling physical quantities and the units of measure in which they're represented.
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c) nystudio107
 */

namespace nystudio107\units\gql\types;

use craft\gql\base\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use nystudio107\units\models\UnitsData;

/**
 * @author    nystudio107
 * @package   CodeField
 * @since     5.0.0
 */
class UnitsDataType extends ObjectType
{
    /**
     * @inheritdoc
     */
    protected function resolve(mixed $source, mixed $arguments, mixed $context, ResolveInfo $resolveInfo): mixed
    {
        /** @var UnitsData $source */
        $fieldName = $resolveInfo->fieldName;
        // Special-case to `toString` since __ prefixes are reserved in GQL
        if ($fieldName === 'toString') {
            $fieldName = '__toString';
        }
        // If the method exists, call it with the passed in args. Otherwise try to retur a property
        if (method_exists($source, $fieldName)) {
            return $source->$fieldName(...$arguments);
        } else {
            return $source->$fieldName;
        }
    }
}

<?php
/**
 * Units plugin for Craft CMS
 *
 * A plugin for handling physical quantities and the units of measure in which they're represented.
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c) nystudio107
 */

namespace nystudio107\units\gql\types\generators;

use craft\gql\base\GeneratorInterface;
use craft\gql\GqlEntityRegistry;
use craft\gql\TypeLoader;
use GraphQL\Type\Definition\Type;
use nystudio107\units\fields\Units;
use nystudio107\units\gql\types\UnitsDataType;

/**
 * @author    nystudio107
 * @package   CodeField
 * @since     5.0.0
 */
class UnitsDataGenerator implements GeneratorInterface
{
    // Public Static methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function generateTypes($context = null): array
    {
        /** @var Units $context */
        $typeName = self::getName($context);

        $unitsDataFields = [
            // static fields
            'toString' => [
                'name' => 'toString',
                'description' => 'The unit value & label',
                'type' => Type::string(),
            ],
            'units' => [
                'name' => 'units',
                'description' => 'The units of measurement',
                'type' => Type::string(),
            ],
            'value' => [
                'name' => 'value',
                'description' => 'The unit value',
                'type' => Type::string(),
            ],
            'toUnit' => [
                'name' => 'toUnit',
                'description' => 'Convert to another unit of measurement',
                'type' => Type::string(),
                'args' => [
                    'unit' => [
                        'name' => 'unit',
                        'description' => 'The unit to convert to',
                        'type' => Type::nonNull(Type::string()),
                    ],
                ],
            ],
            'toNativeUnit' => [
                'name' => 'toNativeUnit',
                'description' => 'The unit value as a fraction',
                'type' => Type::string(),
            ],
            'toFraction' => [
                'name' => 'toFraction',
                'description' => 'The unit value as a fraction',
                'type' => Type::string(),
            ],
            'toUnitFraction' => [
                'name' => 'toUnitFraction',
                'description' => 'Convert to another unit of measurement as a fraction',
                'type' => Type::string(),
                'args' => [
                    'unit' => [
                        'name' => 'unit',
                        'description' => 'The unit to convert to',
                        'type' => Type::nonNull(Type::string()),
                    ],
                ],
            ],
            'getValueFraction' => [
                'name' => 'getValueFraction',
                'description' => 'Return the value as a fraction',
                'type' => Type::string(),
            ],
        ];
        $unitsDataType = GqlEntityRegistry::getEntity($typeName)
            ?: GqlEntityRegistry::createEntity($typeName, new UnitsDataType([
                'name' => $typeName,
                'description' => 'This entity has all the UnitsData properties',
                'fields' => function() use ($unitsDataFields) {
                    return $unitsDataFields;
                },
            ]));

        TypeLoader::registerType($typeName, static function() use ($unitsDataType) {
            return $unitsDataType;
        });

        return [$unitsDataType];
    }

    /**
     * @inheritdoc
     */
    public static function getName($context = null): string
    {
        /** @var Units $context */
        return $context->handle . '_UnitsData';
    }
}

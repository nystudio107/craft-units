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
use ReflectionClass;
use ReflectionException;
use function dirname;

/**
 * @author    nystudio107
 * @package   Units
 * @since     1.0.0
 */
class ClassHelper
{
    // Public Static Methods
    // =========================================================================

    /**
     * Return an array of classes in the same namespace as $className, in an
     * array of shortName => fullyQualifiedName
     *
     * @param string $className
     *
     * @return array
     */
    public static function getClassesInNamespace(string $className): array
    {
        $result = [];
        $loader = include Craft::getAlias('@vendor/autoload.php');
        $filePath = $loader->findFile($className);
        if ($filePath) {
            $dir = realpath(dirname($filePath));
            $classesMap = ClassMapGenerator::createMap($dir);
            foreach ($classesMap as $class => $path) {
                try {
                    $reflect = new ReflectionClass($class);
                    $shortName = $reflect->getShortName();
                    $result[$shortName] = $class;
                } catch (ReflectionException $e) {
                    Craft::error($e->getMessage(), __METHOD__);
                }
            }
        }
        ksort($result);

        return $result;
    }
}

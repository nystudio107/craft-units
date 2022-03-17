<?php
/**
 * Units plugin for Craft CMS 3.x
 *
 * A plugin for handling physical quantities and the units of measure in which they're represented.
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\units\controllers;

use nystudio107\units\Units;

use craft\web\Controller;

use yii\web\Response;

/**
 * @author    nystudio107
 * @package   Units
 * @since     1.0.0
 */
class UnitsController extends Controller
{
    // Properties
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected array|bool|int $allowAnonymous = [
        'all-available-units',
        'available-units',
    ];

    // Public Methods
    // =========================================================================

    /**
     * Return all of the available units as JSON
     *
     * @param bool   $includeAliases whether to include aliases or not
     *
     * @return Response
     */
    public function actionAllAvailableUnits(bool $includeAliases = false): Response
    {
        return $this->asJson(Units::$variable->allAvailableUnits($includeAliases));
    }

    /**
     * Return the available units for a given AbstractPhysicalQuantity as JSON
     *
     * @param string $unitsClass
     * @param bool   $includeAliases whether to include aliases or not
     *
     * @return Response
     */
    public function actionAvailableUnits(string $unitsClass, bool $includeAliases = false): Response
    {
        return $this->asJson(Units::$variable->availableUnits($unitsClass, $includeAliases));
    }
}

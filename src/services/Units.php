<?php
/**
 * Units plugin for Craft CMS 3.x
 *
 * A plugin for handling physical quantities and the units of measure in which they're represented.
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\units\services;

use nystudio107\units\Units;

use Craft;
use craft\base\Component;

/**
 * @author    nystudio107
 * @package   Units
 * @since     1.0.0
 */
class Units extends Component
{
    // Public Methods
    // =========================================================================

    /*
     * @return mixed
     */
    public function exampleService()
    {
        $result = 'something';
        // Check our Plugin's settings for `someAttribute`
        if (Units::$plugin->getSettings()->someAttribute) {
        }

        return $result;
    }
}

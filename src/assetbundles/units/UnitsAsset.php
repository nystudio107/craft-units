<?php
/**
 * Units plugin for Craft CMS 3.x
 *
 * A plugin for handling physical quantities and the units of measure in which they're represented.
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\units\assetbundles\units;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    nystudio107
 * @package   Units
 * @since     1.0.0
 */
class UnitsAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@nystudio107/units/assetbundles/units/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/Units.js',
        ];

        $this->css = [
            'css/Units.css',
        ];

        parent::init();
    }
}

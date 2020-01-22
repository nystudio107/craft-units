<?php
/**
 * Units plugin for Craft CMS 3.x
 *
 * A plugin for handling physical quantities and the units of measure in which they're represented.
 *
 * @link      https://nystudio107.com/
 * @copyright Copyright (c) 2018 nystudio107
 */

namespace nystudio107\units;

use Craft;
use craft\base\Plugin;
use craft\events\PluginEvent;
use craft\events\RegisterComponentTypesEvent;

use craft\services\Fields;
use craft\services\Plugins;
use craft\web\twig\variables\CraftVariable;
use nystudio107\units\fields\Units as UnitsField;
use nystudio107\units\helpers\ClassHelper;
use nystudio107\units\models\Settings;
use nystudio107\units\variables\UnitsVariable;

use PhpUnitsOfMeasure\PhysicalQuantity\Length;

use yii\base\Event;

/**
 * Class Units
 *
 * @author    nystudio107
 * @package   Units
 * @since     1.0.0
 */
class Units extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var Units
     */
    public static $plugin;

    /**
     * @var UnitsVariable
     */
    public static $variable;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = UnitsField::class;
            }
        );

        self::$variable = new UnitsVariable();
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('units', self::$variable);
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Event::on(
            UnitsField::class,
            'craftQlGetFieldSchema',
            function ($event) {
                $field = $event->sender;

                if (!$field instanceof UnitsField) {
                  return;
                }

                $object = $event->schema->createObjectType(ucfirst($field->handle) . 'Units');
                $object->addFloatField('value');
                $object->addStringField('units');

                $event->schema->addField($field)->type($object);
                $event->handled = true;
            }
        );

        Craft::info(
            Craft::t(
                'units',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        $unitsClassMap = array_flip(ClassHelper::getClassesInNamespace(Length::class));
        return Craft::$app->view->renderTemplate(
            'units/settings',
            [
                'settings' => $this->getSettings(),
                 'unitsClassMap' => $unitsClassMap,
           ]
        );
    }
}

/**
 * Units plugin for Craft CMS
 *
 * Units JS
 *
 * @author    nystudio107
 * @copyright Copyright (c) 2018 nystudio107
 * @link      https://nystudio107.com/
 * @package   Units
 * @since     1.0.0
 */

/**
 * Fill a dynamic schema.org type menu with the units data
 *
 * @param menuId
 * @param menuValue
 * @param unitsClass
 * @param callback
 */
function fillDynamicUnitsMenu(menuId, menuValue, unitsClass, callback) {
    var menu = $('#' + menuId);

    if (menu.length) {
        menu.empty();
        $.ajax({
                url: Craft.getActionUrl('units/units/available-units?unitsClass=' + unitsClass)
            })
            .done(function(data) {
                var newValue = Object.keys(data)[0];
                for (var k in data) {
                    if (data.hasOwnProperty(k)) {
                        if (k === menuValue) {
                            newValue = menuValue;
                        }
                        $('<option />')
                            .attr('value', k)
                            .html(data[k])
                            .appendTo(menu);
                    }
                }
                menu.val(newValue);
                if (callback !== undefined) {
                    callback();
                }
            })
            .fail(function(data) {
                console.log('Error loading units data');
            })
    }
}

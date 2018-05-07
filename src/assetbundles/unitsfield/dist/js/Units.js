/**
 * Units plugin for Craft CMS
 *
 * Units Field JS
 *
 * @author    nystudio107
 * @copyright Copyright (c) 2018 nystudio107
 * @link      https://nystudio107.com/
 * @package   Units
 * @since     1.0.0UnitsUnits
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
                if (blankItem) {
                    $('<option />')
                        .attr('value', 'none')
                        .html('')
                        .appendTo(menu);
                }
                $.each(data, function() {
                    $('<option />')
                        .attr('value', this)
                        .html(this)
                        .appendTo(menu);
                });
                menu.val(menuValue);
                if (callback !== undefined) {
                    callback();
                }
            })
            .fail(function(data) {
                console.log('Error loading units data');
            })
    }
}

 ;(function ( $, window, document, undefined ) {

    var pluginName = "UnitsUnits",
        defaults = {
        };

    // Plugin constructor
    function Plugin( element, options ) {
        this.element = element;

        this.options = $.extend( {}, defaults, options) ;

        this._defaults = defaults;
        this._name = pluginName;

        this.init();
    }

    Plugin.prototype = {

        init: function(id) {
            var _this = this;

            $(function () {

/* -- _this.options gives us access to the $jsonVars that our FieldType passed down to us */

            });
        }
    };

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function ( options ) {
        return this.each(function () {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" + pluginName,
                new Plugin( this, options ));
            }
        });
    };

})( jQuery, window, document );

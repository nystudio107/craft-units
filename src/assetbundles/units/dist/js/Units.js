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
 *`
 * @param menuId
 * @param menuValue
 * @param unitsClass
 * @param callback
 */
function fillUnits($inputs, unitsClass, callback) {

    if (!$inputs.length) {
        return;
    }

    callback = function(data) {
        $inputs.each(function() {
            var $input = $(this);
            var $inputContainer = $input.parent();
            var $checkboxesContainer = $inputContainer.parent('.checkbox-select');

            if ($checkboxesContainer.length) {
                var $allChecked = $input.is(':checked');
                var $containerModel = $checkboxesContainer.children().eq(1);

                $checkboxesContainer.children().not($inputContainer).remove();
                $checkboxesContainer.append($.map(data, function(text, value) {
                    var $container = $containerModel.clone();
                    var $input = $container.find('input');
                    var newId = Craft.formatInputId($input.attr('name')) + value;

                    $container.find('label')
                    .html(text)
                    .attr('for', newId);
                    $input
                    .prop('disabled', $allChecked)
                    .prop('checked', $allChecked)
                    .attr('id', newId)
                    .val(value);

                    return $container;
                }));

                if ($checkboxesContainer.data('checkboxSelect')) {
                    $checkboxesContainer.checkboxselect();
                }

            } else {
                $input.empty().append($.map(data, function(text, value) {
                    return '<option value="' + value + '">' + text +  '</option>';
                }));
            }
        });
    }

    $.ajax({
        url: Craft.getActionUrl('units/units/available-units?unitsClass=' + unitsClass)
    })
    .done(callback)
    .fail(function(data) {
        console.log('Error loading units data');
    });
}

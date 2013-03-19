/**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2013
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */

function ComplianceCalculator(properties) {
	this._properties = properties;
	
	this.update = update;
	
	function update() {
		// go through the values of the form, and show the relevant form elements
		// and possibly outcome
		console.log('updating');
	}
}

function OphCoTherapyapplication_ComplianceCalculator_init() {
	calc_obj = new ComplianceCalculator({
		container: $('#OphCoTherapyapplication_ComplianceCalculator'),
	});
	$('#OphCoTherapyapplication_ComplianceCalculator').data('calc_obj', calc_obj);
	calc_obj.update();
}

function OphCoTherapyapplication_ComplianceCalculator_update() {
	$('#OphCoTherapyapplication_ComplianceCalculator').data('calc_obj').update();
}
$(document).ready(function() {
	// standard stuff
	handleButton($('#et_save'),function() {
			});
	
	handleButton($('#et_cancel'),function(e) {
		if (m = window.location.href.match(/\/update\/[0-9]+/)) {
			window.location.href = window.location.href.replace('/update/','/view/');
		} else {
			window.location.href = baseUrl+'/patient/episodes/'+et_patient_id;
		}
		e.preventDefault();
	});

	handleButton($('#et_deleteevent'));

	handleButton($('#et_canceldelete'),function(e) {
		if (m = window.location.href.match(/\/delete\/[0-9]+/)) {
			window.location.href = window.location.href.replace('/delete/','/view/');
		} else {
			window.location.href = baseUrl+'/patient/episodes/'+et_patient_id;
		}
		e.preventDefault();
	});

	$('select.populate_textarea').unbind('change').change(function() {
		if ($(this).val() != '') {
			var cLass = $(this).parent().parent().parent().attr('class').match(/Element.*/);
			var el = $('#'+cLass+'_'+$(this).attr('id'));
			var currentText = el.text();
			var newText = $(this).children('option:selected').text();

			if (currentText.length == 0) {
				el.text(ucfirst(newText));
			} else {
				el.text(currentText+', '+newText);
			}
		}
	});
	
	// handle treatment selection when editing
	$('#event_content').delegate('#Element_OphCoTherapyapplication_PatientSuitability_treatment_id', 'change', function() {
		selected = $(this).val();
		$(this).find('option').each( function() {
			if ($(this).val() == selected) {
				// this is the option that has been switched to
				if ($(this).attr('data-treeid')) {
					var params = {
						'patient_id': OE_patient_id,
						'treatment_id': $(this).val()
					};
					
					//TODO: check if there are any answers on a current tree
					// if there are, should confirm before blowing them away
					$.ajax({
						'type': 'GET',
						'url': decisiontree_url + '?' + $.param(params),
						'success': function(html) {
							if (html.length > 0) {
								$('#OphCoTherapyapplication_ComplianceCalculator').replaceWith(html);
								OphCoTherapyapplication_ComplianceCalculator_init();
							}
						}
					});
				}
				else {
					// TODO: reset the workflow to neutral?
				}
			}
		})
		
		
	});
	
	// various inputs that we need to react to changes on for the compliance calculator
	$('#OphCoTherapyapplication_ComplianceCalculator').delegate('input select', 'change', function() {
		OphCoTherapyapplication_ComplianceCalculator_update();
	});
	
});

function ucfirst(str) { str += ''; var f = str.charAt(0).toUpperCase(); return f + str.substr(1); }

function eDparameterListener(_drawing) {
	if (_drawing.selectedDoodle != null) {
		// handle event
	}
}

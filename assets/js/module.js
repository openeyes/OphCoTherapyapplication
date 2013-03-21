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

function ComplianceCalculator(elem, properties) {
	
	this._elem = elem;
	this._properties = properties;
	this._nodes = {};
	this._nodes_by_parent = {};
	
	this.init()
}

ComplianceCalculator.prototype.init = function()
{
	var self = this;
	if (this._elem.data('defn')) {
		self._root_node_id = this._elem.data('defn').root_id;
	}
	else {
		console.log('ERROR: need root id');
	}
	
	
	self._elem.find('.dt-node').each(function() {
		var defn = $(this).data('defn');
		self._nodes[defn.id] = $(this).data('defn');
		if (defn.parent_id) {
			if (self._nodes_by_parent[defn.parent_id]) {
				self._nodes_by_parent[defn.parent_id].push(defn.id);
			}
			else {
				self._nodes_by_parent[defn.parent_id] = [defn.id];
			}
		}
	});
	
	self.showNode(self._root_node_id);
};

/*
 * internal method that to show the appropriate outcome and set the form value when an outcome is reached
 */
ComplianceCalculator.prototype.showOutcome = function(outcome_id)
{
	this._elem.find('div.outcome').hide();
	this._elem.find('#outcome_' + outcome_id).show();
	this._elem.find('#Element_OphCoTherapyapplication_PatientSuitability_nice_compliance').val(outcome_id);
}

/*
 * show the specified node - the node is then checked to see whether an outcome should be shown, or a child node
 */
ComplianceCalculator.prototype.showNode = function(node_id)	
{
	this._elem.find('#node_' + node_id).show();
	// TODO: this should probably be part of checkNode
	if (this._nodes[node_id].outcome_id) {
		this.showOutcome(this._nodes[node_id].outcome_id);
	}
	else {
		this.checkNode(node_id);
	}
};

/*
 * check the given node to determine if a child should be shown because it has an answer
 */
ComplianceCalculator.prototype.checkNode = function(node_id)
{
	var node_elem = this._elem.find('#node_' + node_id);
	var node_defn = this._nodes[node_id];
	if (node_defn.question) {
		// has a value to check against
		// TODO: need to vary this selector depending on the type of form input is used for the node
		// at the moment assuming all are input
		var value = undefined;
		if (node_elem.find('select').length) {
			value = node_elem.find('select option:selected').val();
		}
		else {
			value = node_elem.find('input').val();
		}
		
		// TODO: if the value is null, then we need to hide children
		if (value !== undefined && value.length && value != node_elem.data('prev-val')) {
			node_elem.data('prev-val', value);
			// go through each child node to see if it has rules that match the value
			// if it does, show it. 
			if (this._nodes_by_parent[node_id]) {
				for (var i = 0; i < this._nodes_by_parent[node_id].length; i++) {
					var child_id = this._nodes_by_parent[node_id][i];
					if (this.checkNodeRule(child_id, value)) {
						this.showNode(child_id);
						break;
					}
				}
			}
		}
	}
	
};

ComplianceCalculator.prototype.checkNodeRule = function(node_id, value) {
	if (this._nodes[node_id]['rules'].length) {
		var res = true;
		
		for (var i = 0; i < this._nodes[node_id]['rules'].length; i++) {
			var cmp =  this._nodes[node_id]['rules'][i]['parent_check'];
			var chk_val = this._nodes[node_id]['rules'][i]['parent_check_value'];
			switch (cmp)
			{
				case "eq":
					res = (res && value == chk_val) ? true : false;
					break;
				case "lt":
					res = (res && value < chk_val) ? true : false;
					break;
				case "gt":
					res = (res && value > chk_val) ? true : false;
					break;
				default:
					res = false;
			}
		}
		return res;
	}
	else {
		// if there are no rules on the node, then it is considered to be the default child node and so should return true
		return true;
	}
};

ComplianceCalculator.prototype.update = function update(node_id) 
{
	// go through the values of the form, and show the relevant form elements
	// and possibly outcome
	console.log('updating');
	if (!node_id) {
		node_id = this._root_node_id;
	}
	this.checkNode(node_id);
}
	

function OphCoTherapyapplication_ComplianceCalculator_init() {
	calc_obj = new ComplianceCalculator($('#OphCoTherapyapplication_ComplianceCalculator'), {});
	$('#OphCoTherapyapplication_ComplianceCalculator').data('calc_obj', calc_obj);
	calc_obj.update();
}

function OphCoTherapyapplication_ComplianceCalculator_update(elem) {
	var node = elem.parents('.dt-node');
	var id = node.data('defn').id;
	$('#OphCoTherapyapplication_ComplianceCalculator').data('calc_obj').update(id);
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
	$('#nice_compliance').delegate('input, select', 'change', function() {
		OphCoTherapyapplication_ComplianceCalculator_update($(this));
	});
	
});

function ucfirst(str) { str += ''; var f = str.charAt(0).toUpperCase(); return f + str.substr(1); }

function eDparameterListener(_drawing) {
	if (_drawing.selectedDoodle != null) {
		// handle event
	}
}

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
	this._side = properties.side;
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
 * stores the source_node_id against the outcome to keep track of what node is defining the outcome
 */
ComplianceCalculator.prototype.showOutcome = function(outcome_id, source_node_id)
{
	var node_elem = this._elem.find('#' + this._side + '_outcome_' + outcome_id); 
	this._elem.find('div.outcome').hide().each(function() {$(this).data('source-node-id', null); });
	node_elem.show().data('source-node-id', source_node_id);
	this._elem.find('#Element_OphCoTherapyapplication_PatientSuitability_' + this._side + '_nice_compliance').val(node_elem.data('comp-val'));
}

/*
 * internal method to hide outcome and reset the form value - will only hide the outcome if the source_node_id matches
 * the data attribute on the outcome being hidden (the outcome may now be being displayed because of a different source
 * node)
 */
ComplianceCalculator.prototype.hideOutcome = function(outcome_id, source_node_id)
{
	var node_elem = this._elem.find('#' + this._side + '_outcome_' + outcome_id); 
	if (node_elem.is(":visible") && node_elem.data('source-node-id') == source_node_id) {
		node_elem.hide();
		node_elem.data('source-node-id', null);
		this._elem.find('#Element_OphCoTherapyapplication_PatientSuitability_' + this._side + '_nice_compliance').val('');
	}
	
}

/*
 * show the specified node - if the node is an outcome then we show the outcome result, otherwise display node and check children or a child node
 */
ComplianceCalculator.prototype.showNode = function(node_id)	
{
	if (this._nodes[node_id].outcome_id) {
		this.showOutcome(this._nodes[node_id].outcome_id, node_id);
	}
	else {
		this._elem.find('#' + this._side + '_node_' + node_id).show();
		this.checkNode(node_id);
	}
};

/*
 * hide the specified node - will hide its children as well
 */
ComplianceCalculator.prototype.hideNode = function(node_id)	
{
	// clear the outcome if this was defining what the outcome was
	if (this._nodes[node_id]['outcome_id']) {
		this.hideOutcome(this._nodes[node_id]['outcome_id'], node_id);
	}
	var node_elem = this._elem.find('#' + this._side + '_node_' + node_id);
	if (node_elem.is(":visible") ) {
		node_elem.hide();
		// remove prev value attribute so that this node will be checked fresh if it is redisplayed
		node_elem.data('prev-val',null);
		
		// hide the children
		if (this._nodes_by_parent[node_id]) {
			for (var i =0; i < this._nodes_by_parent[node_id].length; i++) {
				this.hideNode(this._nodes_by_parent[node_id][i]);
			}
		}
	}
};

/*
 * check the given node to determine if a child should be shown because it has an answer
 */
ComplianceCalculator.prototype.checkNode = function(node_id)
{
	var node_elem = this._elem.find('#' + this._side + '_node_' + node_id);
	var node_defn = this._nodes[node_id];
	if (node_defn.question) {
		// has a value to check against
		var value = undefined;
		if (node_elem.find('select').length) {
			value = node_elem.find('select').val();
		}
		else {
			value = node_elem.find('input').val();
		}
		
		// if the value has changed and the node has children
		if (value != node_elem.data('prev-val') && this._nodes_by_parent[node_id]) {
			// set the store of the previous value
			node_elem.data('prev-val', value);
			// if it's an actual value
			if (value !== undefined && value.length) {
				// go through each child node to see if it has rules that match the value
				// if it does, show it.
				// FIXME: ensure we check nodes with rules before we check any without
				notMatched = true;
				for (var i = 0; i < this._nodes_by_parent[node_id].length; i++) {
					var child_id = this._nodes_by_parent[node_id][i];
					if (this.checkNodeRule(child_id, value) && notMatched) {
						this.showNode(child_id);
						notMatched = false;
					}
					else {
						this.hideNode(child_id);
					}
				}
			}
			else {
				// hide the child nodes
				for (var i = 0; i < this._nodes_by_parent[node_id].length; i++) {
					var child_id = this._nodes_by_parent[node_id][i];
					this.hideNode(child_id);
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
	if (!node_id) {
		node_id = this._root_node_id;
	}
	this.checkNode(node_id);
}
	

function OphCoTherapyapplication_ComplianceCalculator_init(side) {
	calc_obj = new ComplianceCalculator($('#OphCoTherapyapplication_ComplianceCalculator_' + side), {'side': side});
	$('#OphCoTherapyapplication_ComplianceCalculator_' + side).data('calc_obj', calc_obj);
	calc_obj.update();
}

function OphCoTherapyapplication_ComplianceCalculator_update(elem) {
	var node = elem.parents('.dt-node');
	var id = node.data('defn').id;
	var side = node.closest('.side').data('side');
	
	$('#OphCoTherapyapplication_ComplianceCalculator_' + side).data('calc_obj').update(id);
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
	$('#event_content').delegate('#Element_OphCoTherapyapplication_PatientSuitability_left_treatment_id, ' +
			'#Element_OphCoTherapyapplication_PatientSuitability_right_treatment_id', 'change', function() {
		var selected = $(this).val();
		var side = $(this).closest('.side').data('side');
		
		$(this).find('option').each( function() {
			if ($(this).val() == selected) {
				// this is the option that has been switched to
				if ($(this).attr('data-treeid')) {
					var params = {
						'patient_id': OE_patient_id,
						'treatment_id': $(this).val(),
						'side': side
					};
					
					//TODO: check if there are any answers on a current tree
					// if there are, should confirm before blowing them away
					$.ajax({
						'type': 'GET',
						'url': decisiontree_url + '?' + $.param(params),
						'success': function(html) {
							if (html.length > 0) {
								$('#OphCoTherapyapplication_ComplianceCalculator_' + side).replaceWith(html);
								OphCoTherapyapplication_ComplianceCalculator_init(side);
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
	console.log('setting up change');
	$('#nice_compliance_left, #nice_compliance_right').delegate('input, select', 'change', function() {
		console.log('yo');
		OphCoTherapyapplication_ComplianceCalculator_update($(this));
	});
	
	console.log('should be done');
	
	if ($('#Element_OphCoTherapyapplication_PatientSuitability_left_treatment_id').val()) {
		// there should be a tree to initialise given that a treatment has been chosen
		// TODO: work out what to do if the treatment is no longer available (i.e. we are editing a now redundant application)
		OphCoTherapyapplication_ComplianceCalculator_init('left');
	}
	
	if ($('#Element_OphCoTherapyapplication_PatientSuitability_right_treatment_id').val()) {
		// there should be a tree to initialise given that a treatment has been chosen
		// TODO: work out what to do if the treatment is no longer available (i.e. we are editing a now redundant application)
		OphCoTherapyapplication_ComplianceCalculator_init('right');
	}
	
});

function ucfirst(str) { str += ''; var f = str.charAt(0).toUpperCase(); return f + str.substr(1); }

function eDparameterListener(_drawing) {
	if (_drawing.selectedDoodle != null) {
		// handle event
	}
}

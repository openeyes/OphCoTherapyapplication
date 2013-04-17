<?php
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
?>

<?php 
$name_stub = $element_name . '[' . $side . '_previnterventions]'; 
$all_treatments = OphCoTherapyapplication_Treatment::model()->with('drug')->findAll();

/*
 * Am using a bit of a bastardisation of different form field approaches here as this many to many model form is not something that is supported well
 * by the OpenEyes extensions for forms. Will be worth tidying up as and when feasible (off the back of OE-2522)
 */

?>

<tr class="previousintervention" data-key="<?php echo $key ?>">
	<td>
	<?php if($previntervention && $previntervention->id) { ?>
		<input type="hidden"
			name="<?php echo $name_stub; ?>[<?php echo $key ?>][id]"
			value="<?php echo $previntervention->id?>" />
	<?php } ?>
	
	<?php 
		$d_name = $name_stub . "[$key][treatment_date]";
		$d_id = preg_replace('/\[/', '_', substr($name_stub, 0, -1)) . "_". $key ."_treatment_date";
		
		// using direct widget call to allow custom name for the field
		$form->widget('application.widgets.DatePicker',array(
			'element' => $previntervention, 
			'name' => $d_name, 
			'field' => 'treatment_date', 
			'options' => array('maxDate' => 'today'), 
			'htmlOptions' => array('id' => $d_id, 'nowrapper' => true, 'style'=>'width: 90px;')));
	?>
	</td>
	<td>
	<?php 
	echo CHtml::activeDropDownList($previntervention, 'treatment_id', CHtml::listData($all_treatments,'id','name'),array('name' => $name_stub . "[$key][treatment_id]", 'nowrapper' => true));
	?>	
	</td>
	<td>
	<?php 
	echo CHtml::activeDropDownList($previntervention, 'stopreason_id', 
		CHtml::listData(OphCoTherapyapplication_ExceptionalCircumstances_PrevIntervention_StopReason::model()->findAll(),'id','name'),
		array('name' => $name_stub . "[$key][stopreason_id]"));
	 ?>
	</td>
	<td class="previnterventionActions"><a class="removePrevintervention" href="#">Remove</a></td>
</tr>
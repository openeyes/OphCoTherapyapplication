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
$all_treatments = OphCoTherapyapplication_Treatment::model()->findAll();
$show_stop_other = false;
if (@$_POST[$element_name] && @$_POST[$element_name][$side . '_previnterventions']) {
	if (@$_POST[$element_name][$side . '_previnterventions'][$key]) {
		if ($stop_id = $_POST[$element_name][$side . '_previnterventions'][$key]['stopreason_id']) {
			$stopreason = OphCoTherapyapplication_ExceptionalCircumstances_PrevIntervention_StopReason::model()->findByPk((int)$stop_id);
			if ($stopreason->other) {
				$show_stop_other = true;
			}
		}
	}
} else {
	if ($previntervention->stopreason && $previntervention->stopreason->other) {
		$show_stop_other = true;
	}
}

/*
 * Am using a bit of a bastardisation of different form field approaches here as this many to many model form is not something that is supported well
 * by the OpenEyes extensions for forms. Will be worth tidying up as and when feasible (off the back of OE-2522)
 */

?>

<div class="previousintervention" data-key="<?php echo $key ?>">
	<a class="removePrevintervention removeElementForm" href="#">Remove</a>
	<?php if ($previntervention && $previntervention->id) { ?>
		<input type="hidden"
			name="<?php echo $name_stub; ?>[<?php echo $key ?>][id]"
			value="<?php echo $previntervention->id?>" />
	<?php } ?>

	<div>
		<div class="label"><?php echo $previntervention->getAttributeLabel('treatment_date'); ?></div>
		<div class="data">
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
		</div>
	</div>
	<div>
		<div class="label"><?php echo $previntervention->getAttributeLabel('treatment_id');?></div>
		<div class="data">
	<?php
	echo CHtml::activeDropDownList($previntervention, 'treatment_id', CHtml::listData($all_treatments,'id','name'),
		array('empty'=>'- Please select -', 'name' => $name_stub . "[$key][treatment_id]", 'nowrapper' => true));
	?>
		</div>
	</div>
	<div>
		<div class="label"><?php echo $previntervention->getAttributeLabel('stopreason_id')?></div>
		<div class="data">
		<?php

		$reasons = OphCoTherapyapplication_ExceptionalCircumstances_PrevIntervention_StopReason::model()->findAll();
		$html_options = array(
				'class' => 'stop-reasons',
				'empty' => '- Please select -',
				'name' => $name_stub . "[$key][stopreason_id]",
				'options' => array(),
		);
		// get the previous injection counts for each of the drug options for this eye
		foreach ($reasons as $reason) {
			$html_options['options'][$reason->id] = array(
					'data-other' => $reason->other,
			);
		}

		echo CHtml::activeDropDownList($previntervention, 'stopreason_id',
			CHtml::listData($reasons,'id','name'),
			$html_options);
		 ?>
		</div>
	</div>

	<div class="<?php if (!$show_stop_other) { echo "hidden "; } ?>stop-reason-other">
		<div class="label"><?php echo $previntervention->getAttributeLabel('stopreason_other'); ?></div>
		<div class="data">
		<?php echo CHtml::activeTextArea($previntervention, 'stopreason_other',array('name' => $name_stub . "[$key][stopreason_other]", 'rows' => 2, 'cols' => 25, 'nowrapper' => true))?>
		</div>
	</div>
	<div>
		<div class="label"><?php echo $previntervention->getAttributeLabel('comments')?></div>
		<div class="data comments">
		<?php echo CHtml::activeTextArea($previntervention, 'comments',array('name' => $name_stub . "[$key][comments]", 'rows' => 3, 'cols' => 25, 'nowrapper' => true))?>
		</div>
	</div>
</div>

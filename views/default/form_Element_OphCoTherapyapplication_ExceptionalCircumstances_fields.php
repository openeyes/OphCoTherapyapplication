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
	
	<div class="elementField standard_intervention_exists">
		<div class="label" style="vertical-align: top;"><?php echo $element->getAttributeLabel($side . '_standard_intervention_exists'); ?></div>
		<div class="data"><?php echo $form->radioBoolean($element, $side . '_standard_intervention_exists', array('nowrapper' => true))?></div>
	</div>
	
	<span id="<?php echo get_class($element) . "_" . $side ?>_standard_intervention_details"
		<?php if (!$element->{$side . '_standard_intervention_exists'}) { 
			echo ' class="hidden"'; 
		}?>
	>
		<div class="elementField">
			<div class="label"><?php echo $element->getAttributeLabel($side . '_standard_intervention_id'); ?></div>
			<div class="data">
				<?php 
				echo $form->dropDownList(
					$element, 
					$side . '_standard_intervention_id', 
					CHtml::listData($element->getStandardInterventionsForSide($side), 'id', 'name'),
					array('empty'=>'- Please select -', 'nowrapper' => true)) ?></div>
		</div>

		<div class="elementField standard_previous" id="<?php echo get_class($element) . "_" . $side; ?>_standard_previous">
			<div class="label"><?php echo $element->getAttributeLabel($side . '_standard_previous'); ?></div>
			<div class="data"><?php echo $form->radioBoolean($element, $side . '_standard_previous', array('nowrapper' => true))?></div>
		</div>

		<?php 
			$opts = array('nowrapper' => true, 
				'options' => array()				
			);
			foreach (Element_OphCoTherapyapplication_ExceptionalCircumstances_Intervention::model()->findAll() as $intervention) {
				$opts['options'][$intervention->id] = array('data-description-label' => $intervention->description_label, 'data-is-deviation' => $intervention->is_deviation);
			}
		?>
			
		<div class="elementField intervention" id="<?php echo get_class($element) . "_" . $side;?>_intervention">
			<div class="label" style="vertical-align: top;"><?php echo $element->getAttributeLabel($side . '_intervention_id'); ?></div>
			<div class="data" style="display: inline-block;"><?php echo $form->radioButtons($element, $side . '_intervention_id', 'et_ophcotherapya_exceptional_intervention', $element->{$side . '_intervention_id'}, 1, false, false, false, $opts)?></div>
		</div>
	
		<div class="elementField" <?php if (!$element->{$side . '_intervention_id'}) { echo ' style="display: none;"'; } ?>>
			<div class="label"><?php echo $element->getAttributeLabel($side . '_description'); ?></div>
			<div class="data"><?php echo $form->textArea($element, $side . '_description',array('rows' => 4, 'cols' => 30, 'nowrapper' => true))?></div>
		</div>
		
		<span id="<?php echo get_class($element) . "_" . $side;?>_deviation_fields"
			<?php if (!$element->needDeviationReasonForSide($side)) {?>
			class="hidden"
			<?php } ?>
		>
			<?php 
				$html_options = array(
					'options' => array(),	
					'empty' => '- Please select -',
					'div_id' =>  get_class($element) . '_' . $side . '_deviationreasons',
					'div_class' => 'elementField',
					'label' => $element->getAttributeLabel($side . '_deviationreasons'));
				
				echo $form->multiSelectList(
					$element, 
					get_class($element) . '[' . $side . '_deviationreasons]', 
					$side . '_deviationreasons', 'id', 
					CHtml::listData($element->getDeviationReasonsForSide($side),'id','name'), 
					array(), 
					$html_options);
			?>
		</span>
		
	</span>

	<span id="<?php echo get_class($element) . "_" . $side; ?>_standard_intervention_not_exists"
		<?php if (!$element->{$side . '_standard_intervention_exists'}
			|| $element->{$side . '_standard_previous'}) { 
			echo ' class="hidden"'; 
		}?>>
		<div class="elementField">
			<div class="label"><?php echo $element->getAttributeLabel($side . '_condition_rare'); ?></div>
			<div class="data"><?php echo $form->radioBoolean($element, $side . '_condition_rare', array('nowrapper' => true))?></div>
		</div>

		<div class="elementField">
			<div class="label"><?php echo $element->getAttributeLabel($side . '_incidence'); ?></div>
			<div class="data"><?php echo $form->textArea($element, $side . '_incidence', array('rows' => 4, 'cols' => 30, 'nowrapper' => true))?></div>
		</div>
	</span>
	
	<div class="elementField">
		<div class="label"><?php echo $element->getAttributeLabel($side . '_patient_different'); ?></div>
		<div class="data"><?php echo $form->textArea($element, $side . '_patient_different', array('rows' => 4, 'cols' => 30, 'nowrapper' => true))?></div>
	</div>

	<div class="elementField">
		<div class="label"><?php echo $element->getAttributeLabel($side . '_patient_gain'); ?></div>
		<div class="data"><?php echo $form->textArea($element, $side . '_patient_gain', array('rows' => 4, 'cols' => 30, 'nowrapper' => true))?></div>
	</div>

	<div class="elementField">
		<div class="label"><?php echo $element->getAttributeLabel($side . '_previnterventions') ?></div>
		<div class="data">
			<table>
				<thead>
					<th>Date</th>
					<th>Treatment</th>
					<th>Reason For Stopping</th>
				</thead>
				<tbody>
					<?php
						if (empty($_POST)) {
							$previnterventions = $element->{$side . '_previnterventions'};
						} else {
							$previnterventions = array();
							if (isset($_POST[get_class($element)][$side . '_previnterventions'])) {
								foreach ($_POST[get_class($element)][$side . '_previnterventions'] as $attrs) {
									$prev = new OphCoTherapyapplication_ExceptionalCircumstances_PrevIntervention();
									$prev->attributes = $attrs;
									$previnterventions[] = $prev;
								}
							}
						}
						
						$key = 0;
						foreach ($previnterventions as $prev) {
							$this->renderPartial('form_OphCoTherapyapplication_ExceptionalCircumstances_PrevIntervention', array(
								'key' => $key,
								'previntervention' => $prev,
								'side' => $side,
								'element_name' => get_class($element),
								'form' => $form,
							));
							$key++;
						}
					?>
				</tbody>				
			</table>
			<button class="addPrevintervention classy green mini" type="button">
				<span class="button-span button-span-green">Add</span>
			</button>
		</div>
	</div>
	
	<div class="elementField patient_factors">
		<div class="label"><?php echo $element->getAttributeLabel($side . '_patient_factors'); ?></div>
		<div class="data"><?php echo $form->radioBoolean($element, $side . '_patient_factors', array('nowrapper' => true))?></div>
	</div>
	
	<div class="elementField"<?php if (!$element->{$side . '_patient_factors'}) { echo ' style="display: none;"'; } ?>>
		<div class="label"><?php echo $element->getAttributeLabel($side . '_patient_factor_details'); ?></div>
		<div class="data"><?php echo $form->textArea($element, $side . '_patient_factor_details', array('rows' => 4, 'cols' => 30, 'nowrapper' => true))?></div>
	</div>
	
	<?php 
		// get all the start periods and get data attribute for urgency requirements
		$start_periods = $element->getStartPeriodsForSide($side);
		$html_options = array('empty'=>'- Please select -', 'nowrapper' => true, 'options' => array());
		foreach ($start_periods as $sp) {
			$html_options['options'][$sp->id] = array('data-urgent' => $sp->urgent);
		}
	
	?>
	<div class="elementField start_period">
			<div class="label"><?php echo $element->getAttributeLabel($side . '_start_period_id'); ?></div>
			<div class="data">
				<?php 
					echo $form->dropDownList(
						$element, 
						$side . '_start_period', 
						CHtml::listData($start_periods, 'id', 'name'),
						$html_options
					); 
				?>
			</div>
		</div>

	<div id="<?php echo get_class($element) . '_' . $side ?>_urgency_reason"
		class="elementField<?php if (!($element->{$side . '_start_period'} && $element->{$side . '_start_period'}->urgent) ) { 
		echo ' hidden';} ?>">
		<div class="label"><?php echo $element->getAttributeLabel($side . '_urgency_reason'); ?></div>
		<div class="data"><?php echo $form->textArea($element, $side . '_urgency_reason', array('rows' => 4, 'cols' => 30, 'nowrapper' => true))?></div>
	</div>

<?php 
	$html_options = array(
		'options' => array(),	
		'empty' => '- Please select -',
		'div_id' =>  get_class($element) . '_' . $side . '_filecollections',
		'div_class' => 'elementField',
		'label' => 'File Attachments');
	$collections = OphCoTherapyapplication_FileCollection::model()->findAll();
	//TODO: have sorting with display_order when implemented
	/*
	$collections = OphCoTherapyapplication_FileCollection::::model()->findAll(array('order'=>'display_order asc'));
	foreach ($collections as $collection) {
		$html_options['options'][(string)$collection->id] = array('data-order' => $collection->display_order); 
	}
	*/
	echo $form->multiSelectList($element, get_class($element) . '[' . $side . '_filecollections]', $side . '_filecollections', 'id', CHtml::listData($collections,'id','name'), array(), $html_options)
?>
	
	

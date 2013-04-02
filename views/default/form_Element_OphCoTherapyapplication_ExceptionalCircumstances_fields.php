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
		<div class="label"><?php echo $element->getAttributeLabel($side . '_standard_intervention_exists'); ?></div>
		<div class="data"><?php echo $form->radioBoolean($element, $side . '_standard_intervention_exists', array('nowrapper' => true))?></div>
	</div>
	
	<div class="elementField"<?php if (!$element->{$side . '_standard_intervention_exists'}) { echo ' style="display: none;"'; } ?>>
		<div class="label"><?php echo $element->getAttributeLabel($side . '_details'); ?></div>
		<div class="data"><?php echo $form->textArea($element, $side . '_details', array('rows' => 4, 'cols' => 30, 'nowrapper' => true))?></div>
	</div>
	
	<?php 
		$opts = array('nowrapper' => true, 
			'options' => array()				
		);
		foreach (Element_OphCoTherapyapplication_ExceptionalCircumstances_Intervention::model()->findAll() as $intervention) {
			$opts['options'][$intervention->id] = array('data-description-label' => $intervention->description_label);
		}
			
	?>
		
	<div class="elementField intervention">
		<div class="label"><?php echo $element->getAttributeLabel($side . '_intervention_id'); ?></div>
		<div class="data"><?php echo $form->radioButtons($element, $side . '_intervention_id', 'et_ophcotherapya_exceptional_intervention', $element->{$side . '_intervention_id'}, false, false, false, false, $opts)?></div>
	</div>
	<div class="elementField" <?php if (!$element->{$side . '_intervention_id'}) { echo ' style="display: none;"'; } ?>>
		<div class="label"><?php echo $element->getAttributeLabel($side . '_description'); ?></div>
		<div class="data"><?php echo $form->textArea($element, $side . '_description',array('rows' => 4, 'cols' => 30, 'nowrapper' => true))?></div>
	</div>
	<div class="elementField patient_factors">
		<div class="label"><?php echo $element->getAttributeLabel($side . '_patient_factors'); ?></div>
		<div class="data"><?php echo $form->radioBoolean($element, $side . '_patient_factors', array('nowrapper' => true))?></div>
	</div>
	
	<div class="elementField"<?php if (!$element->{$side . '_patient_factors'}) { echo ' style="display: none;"'; } ?>>
		<div class="label"><?php echo $element->getAttributeLabel($side . '_patient_factor_details'); ?></div>
		<div class="data"><?php echo $form->textArea($element, $side . '_patient_factor_details', array('rows' => 4, 'cols' => 30, 'nowrapper' => true))?></div>
	</div>
	

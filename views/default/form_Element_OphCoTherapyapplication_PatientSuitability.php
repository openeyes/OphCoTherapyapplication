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

<div class="element <?php echo $element->elementType->class_name?>"
	data-element-type-id="<?php echo $element->elementType->id?>"
	data-element-type-class="<?php echo $element->elementType->class_name?>"
	data-element-type-name="<?php echo $element->elementType->name?>"
	data-element-display-order="<?php echo $element->elementType->display_order?>">
	<h4 class="elementTypeName"><?php echo $element->elementType->name; ?></h4>

	<?php 
	// only want treatments that are marked as available, and have been configured 
	// with a decision tree for determining compliance
	$criteria = new CDbCriteria();
	$criteria->addCondition('available = :avail');
	$criteria->addCondition('decisiontree_id IS NOT NULL');
	$criteria->params = array(':avail' => true);
	$criteria->order = 'display_order asc';
	
	$treatments = OphCoTherapyapplication_Treatment::model()->findAll($criteria);
	
	$html_options = array(
			'options' => array(),
			'empty'=>'- Please select -',
	);
	foreach ($treatments as $treatment) {
		$html_options['options'][(string)$treatment->id] = array('data-treeid' => $treatment->decisiontree_id);
	}
	
		
	echo $form->dropDownList($element, 'treatment_id', CHtml::listData($treatments,'id','name'),$html_options)?>
	<?php echo $form->datePicker($element, 'angiogram_baseline_date', array('maxDate' => 'today'), array('style'=>'width: 110px;'))?>
	
	<div id="nice_compliance" class="eventDetail">
		<div class="label">NICE Compliance</div>
		<div class="data">
			<?php $this->renderPartial(
				'form_OphCoTherapyapplication_DecisionTree',
				array('element' => $element, 'data' => $data, 'form' => $form),
				false, false
			)?>	
		
		</div>
		
	</div>
</div>

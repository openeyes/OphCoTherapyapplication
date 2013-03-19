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
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row question">
		<?php echo $form->labelEx($model,'question'); ?>
		<?php echo $form->textField($model,'question',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'question'); ?>
	</div>

	<div class="row outcome">
		<?php echo $form->labelEx($model,'outcome_id'); ?>
		<?php echo $form->dropdownlist($model,'outcome_id',CHtml::listData(OphCoTherapyapplication_DecisionTreeOutcome::model()->findAll(),'id','name'),array('empty'=>'- Please select -')); ?>
		<?php echo $form->error($model,'outcome_id'); ?>
	</div>

	<div class="row default">
		<?php echo $form->labelEx($model,'default_function'); ?>
		<?php echo $form->textField($model,'default_function',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'default_function'); ?>
	</div>

	<div class="row default">
		<?php echo $form->labelEx($model,'default_value'); ?>
		<?php echo $form->textField($model,'default_value',array('size'=>16,'maxlength'=>16)); ?>
		<?php echo $form->error($model,'default_value'); ?>
	</div>

	<div class="row response_type">
		<?php echo $form->labelEx($model,'response_type'); ?>
		<?php echo $form->dropdownlist($model,'response_type_id',CHtml::listData(OphCoTherapyapplication_DecisionTreeNode_ResponseType::model()->findAll(),'id','label'),array('empty'=>'- Please select -')); ?>
		<?php echo $form->error($model,'response_type'); ?>
	</div>

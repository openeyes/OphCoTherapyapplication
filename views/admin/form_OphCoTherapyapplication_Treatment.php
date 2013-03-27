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


<h3><?php echo $model->isNewRecord ? 'Create' : 'Edit'; ?> Treatment</h3>

<?php echo $form->errorSummary($model); ?>

<div class="row">
	<?php echo $form->labelEx($model,'name'); ?>
	<?php echo $form->textField($model,'name',array('size'=>40,'maxlength'=>40)); ?>
	<?php echo $form->error($model,'name'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model, 'decisiontree_id')?>
	<?php echo $form->dropdownlist($model, 'decisiontree_id', CHtml::listData(OphCoTherapyapplication_DecisionTree::model()->findAll(),'id','name'),array('empty'=>'- Please select -'))?>
	<?php echo $form->error($model,'decisiontree_id'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model, 'available')?>
	<?php echo $form->checkBox($model, 'available')?>
	<?php echo $form->error($model,'available'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model, 'contraindications_required')?>
	<?php echo $form->radioButtonList($model, 'contraindications_required', array(1 => 'Yes', 0 => 'No'), array('separator' => '&nbsp;')); ?>
	<?php echo $form->error($model,'contraindications_required'); ?>
</div>

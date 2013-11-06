<?php /* DEPRECATED */ ?>
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
<h1><?php echo $title ?></h1>

<?php
$this->renderPartial('//base/_messages');
?>
<div class="hidden" id="add-new-form" style="margin-bottom: 10px">
<?php
$form = $this->beginWidget('BaseEventTypeCActiveForm', array(
		'id'=>'clinical-create',
		'enableAjaxValidation'=>false,
		'htmlOptions' => array('class'=>'sliding'),
		'action' => Yii::app()->createURL($this->module->getName() . '/admin/addDiagnosis')
));

if ($parent_id) {
	echo CHtml::hiddenField('parent_id', $parent_id);
}

$form->widget('application.widgets.DiagnosisSelection',array(
		'field' => 'new_disorder_id',
		'layout' => 'minimal',
		'default' => false,
		'callback' => 'OphCoTherapyapplication_AddDiagnosis',
		'placeholder' => 'type the first few characters to search',
));

echo CHtml::hiddenField('disorder_id', '', array('id' => 'disorder_id'));

$this->endWidget();
?>
</div>

<button class="classy green mini"><span class="button-span button-span-green" id="add-new">Add New</span></button>

<div>
	<ul class="grid reduceheight">
		<li class="header">
			<span class="column_name">Name</span>
			<span class="column_actions">Actions</span>
		</li>
		<div class="sortable">
			<?php
			foreach ($model_list as $i => $model) {?>
				<li class="<?php if ($i%2 == 0) {?>even<?php } else {?>odd<?php }?>" data-attr-id="<?php echo $model->id ?>">
					<span class="column_name">
						<?php if (!$parent_id) { ?>
							<a href="<?php echo Yii::app()->createUrl($this->module->getName() . '/admin/viewDiagnoses', array('parent_id'=> $model->id)) ?>">
						<?php } ?>
						<?php echo $model->disorder->term ?>
						<?php if (!$parent_id) { ?>
							</a>
						<?php } ?>
					</span>
					<span class="column_actions">
						<a href="<?php echo Yii::app()->createUrl($this->module->getName() . '/admin/deleteDiagnosis', array('diagnosis_id' => $model->id)); ?>" title="Delete">[X]</a>
					</span>
				</li>
			<?php }?>
		</div>
	</ul>
</div>

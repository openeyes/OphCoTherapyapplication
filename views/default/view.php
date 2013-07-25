<?php
/**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2012
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2012, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */
?>

<?php
	$this->header();
?>

<?php
$this->renderPartial('//base/_messages');

$service = new OphCoTherapyapplication_Processor();
$warnings = array();

if ($service->canProcessEvent($this->event->id)) {
	$this->event_actions[] = EventAction::link('Submit Application', Yii::app()->createUrl($this->event->eventType->class_name.'/default/processApplication/?event_id='.$this->event->id));
} else {
	$warnings = $service->getProcessWarnings($this->event->id);
}

?>

<?php  $this->renderPartial('//patient/event_actions'); ?>

<h3 class="withEventIcon" style="background:transparent url(<?php echo $this->assetPath?>/img/medium.png) center left no-repeat;"><?php echo $this->event_type->name?></h3>

<div>
	<?php
	if (count($warnings)) {
		echo "Application cannot be submitted for the following reasons:<ul>";
		foreach ($warnings as $warning) {
			echo "<li>" . $warning . "</li>";
		}
		echo "</ul>";
	}
	?>

	<?php $this->renderDefaultElements($this->action->id)?>
	<?php $this->renderOptionalElements($this->action->id)?>
	<div class="cleartall"></div>
</div>

<?php $this->footer()?>

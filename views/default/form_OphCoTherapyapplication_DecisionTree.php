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
$decisiontree = null;
if ($element->treatment && $element->treatment->decisiontree) {
	$decisiontree = $element->treatment->decisiontree;
}
?>

<div id="OphCoTherapyapplication_ComplianceCalculator"<?php if ($decisiontree) { echo " data-defn='" . CJSON::encode($decisiontree->getDefinition()) . "'"; }?>>
	<?php if ($element->treatment && $element->treatment->decisiontree) {?>
	<div>
	<?php foreach ($element->treatment->decisiontree->nodes as $node) { ?>
		<div class="dt-node" id="node_<?php echo $node->id ?>" style="display: none;" data-defn='<?php echo CJSON::encode($node->getDefinition()); ?>'>
		<?php if ($node->question) {?>
		<!--  TODO: check responsetype and render appropriate form element type -->
			<div class="label"><?php echo $node->question ?></div>
			<div class="data"><input type="text" name="OphCoTherapyapplication_PatientSuitability[DecisionTreeResponse][<?php echo $node->id; ?>]" value="<?php echo $node->getDefaultValue(); ?>" /></div>
		<?php } ?>
		</div>
	<?php } ?>
	</div>
	<?php } else {?>
	<div>Please select a treatment to determine compliance</div>
	<?php } ?>
	<?php foreach (OphCoTherapyapplication_DecisionTreeOutcome::model()->findAll() as $outcome) { ?>
		<div id="outcome_<?php echo $outcome->id ?>" style="display: none;" class="outcome"><?php echo $outcome->name; ?></div>
	<?php }?>
	<?php echo $form->hiddenInput($element, 'nice_compliance')?>
</div>
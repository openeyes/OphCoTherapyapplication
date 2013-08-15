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


<div class="previntervention-view">
	<div>
		<div class="label"><?php echo $previntervention->getAttributeLabel('start_date'); ?>:</div>
		<div class="data"><?php echo Helper::convertMySQL2NHS($previntervention->start_date) ?></div>
	</div>

	<div>
		<div class="label"><?php echo $previntervention->getAttributeLabel('end_date'); ?>:</div>
		<div class="data"><?php echo Helper::convertMySQL2NHS($previntervention->end_date) ?></div>
	</div>

	<div>
		<div class="label"><?php echo $previntervention->getAttributeLabel('treatment_id'); ?>:</div>
		<div class="data"><?php echo $previntervention->treatment->drug->name ?></div>
	</div>

	<div>
		<div class="label"><?php echo $previntervention->getAttributeLabel('start_va'); ?>:</div>
		<div class="data"><?php echo $previntervention->start_va ?></div>
	</div>

	<div>
		<div class="label"><?php echo $previntervention->getAttributeLabel('end_va'); ?>:</div>
		<div class="data"><?php echo $previntervention->end_va ?></div>
	</div>


	<div>
		<div class="label"><?php echo $previntervention->getAttributeLabel('stopreason_id'); ?>:</div>
		<div class="data">
			<?php if ($previntervention->stopreason_other) {
				echo $previntervention->stopreason_other;
			} else {
				echo $previntervention->stopreason->name;
			} ?>
		</div>
	</div>

	<div>
		<div class="label"><?php echo $previntervention->getAttributeLabel('comments'); ?>:</div>
		<div class="data comments">
		<?php if ($previntervention->comments) {
			echo $previntervention->comments;
		} else {
			echo "None";
		}
		?></div>
	</div>
</div>

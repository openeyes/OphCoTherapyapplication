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
* @copyright Copyright (c) 2011-2012, OpenEyes Foundation
* @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
*/
?>

<style>

h2 {
	margin-bottom: 20px;
}

h5 {
	text-align: center;
}

body {
	font-size: 16px;
}

p {
	font-size: 24px;
}

.large {
	font-size: 36px;
}

table.clinical-urgency {
	width: 500px;
	border: 1px solid #000;
}

table.clinical-urgency > td {
	height: 170px;
}

.form-text {
	color: #666;
}

table.urgency td {
	border: 1px solid #000;
}

table.urgency td.label {
	width: 450px;
	font-size:30px;
}

table.urgency td.selector {
	width: 50px;
	font-size: 30pt;
	text-align: center;
}

table.layout {
	width: 650px;
}

table.layout th,
table.layout td {
	border: 1px solid #999;
}

td.header {
	border: 1px solid #999;
	background-color: #ccffff;
}

td.table-title {
	width: 650px;
}

td.row-title {
	background-color: #ccffcc;
	width: 180px;
	font-size: 24px;
}

table.inner td,
table.inner th {
	border-bottom: 1px solid #ccc;
}

.inner th {
	color: #666;
}

table.inner tr.last td,
table.inner tr.last th {
	border-bottom: none;
}

</style>

<body></body>
<?php
$exam_api = Yii::app()->moduleAPI->get('OphCiExamination');
$ccg = $patient->getCommissioningBodyOfType($cbody_type);
?>

<h5>Individual Treatment Funding Request (IFR) Application</h5>

<table nobr="true" class="urgency" cellpadding="5">
<?php
	foreach (OphCoTherapyapplication_ExceptionalCircumstances_StartPeriod::model()->findAll() as $period) {
?>
	<tr>
		<td class="label">&nbsp;<?php echo $period->application_description ?></td>
		<td class="selector"><?php if ($exceptional->{$side . '_start_period_id'} == $period->id) { echo "X"; } else {echo "&nbsp;";} ?></td>
	</tr>

<?php
	}
?>

</table>
<br />&nbsp;<br />
Please provide further information below relating to the clinical urgency and / or proposed treatment dates below:
<br />&nbsp;<br />
<table class="clinical-urgency">
	<tr>
		<td>
			<?php
				if ($exceptional->{$side . '_urgency_reason'}) {
					echo $exceptional->{$side . '_urgency_reason'};
				}
			?>
			&nbsp;
		</td>
	</tr>
</table>
<tcpdf method="AddPage" />
<table nobr="true">
	<tr>
		<td class="header"><h2>&nbsp;Contact Information</h2></td>
	</tr>
	<tr>
		<td>
		<table class="layout">
			<tr nobr="true">
				<td class="row-title">&nbsp;1. <?php echo $cbody_type->shortname ?> Code &amp; Name</td>
				<td class="row-data">
				<?php if ($ccg) {
					echo '<span class="form-text">' . $cbody_type->shortname . " Code:</span> " . $ccg->code . "<br />";
					echo '<span class="form-text">' . $cbody_type->shortname . " Name:</span> " . $ccg->name;
				} else {
					echo " Unknown";
				}?>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>

<table class="layout">
	<tbody>
		<tr nobr="true">
			<td class="row-title">2. <?php echo $cbody_type->shortname ?> Address</td>
			<td class="row-data">
			<?php if ($ccg) {
				echo $ccg->getLetterAddress(array('delimiter' => ', '));
			} else {
				echo "Unknown";
			}?>
			</td>
		</tr>
		<tr nobr="true">
			<td class="row-title">3. Trust Applicant Details</td>
			<td class="row-data">
				<table class="inner">
					<tbody>
						<tr>
							<th>Name of Doctor:</th>
							<td><?php echo $diagnosis->user->getReportDisplay() ?></td>
						</tr>
						<tr>
							<th>Designation</th>
							<td><?php echo $diagnosis->user->role ?></td>
						</tr>
						<tr>
							<th>Telephone No.</th>
							<td>
								<?php if ($contact = $diagnosis->user->contact) {
									echo $contact->primary_phone;
								} else {
									echo "Unavailable";
								}?>
							</td>
						</tr>
						<tr class="last">
							<th>Email</th>
							<td><?php echo Yii::app()->params['OphCoTherapyapplication_applicant_email'] ?></td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
		<tr nobr="true">
			<td class="row-title">4. Patient Details</td>
			<td class="row-data">
				<table class="inner">
					<tbody>
						<tr>
							<th>NHS No.</th>
							<td><?php echo $patient->nhs_num ?></td>
						</tr>
						<tr>
							<th>Hospital ID No.</th>
							<td><?php echo $patient->hos_num ?></td>
						</tr>
						<tr>
							<th>Gender</th>
							<td><?php echo $patient->getGenderString() ?></td>
						</tr>
						<tr>
							<th>Moorfield Consultant</th>
							<td><?php echo $service_info->consultant->getConsultantName() ?></td>
						</tr>
						<tr>
							<th>Registered GP Name</th>
							<td><?php echo ($patient->gp) ? $patient->gp->contact->fullName : 'Unknown'; ?></td>
						</tr>
						<tr>
							<th>Registered GP Address</th>
							<td><?php echo ($patient->practice &&
									$address = $patient->practice->getLetterAddress(array('delimiter' => ', '))) ?
									$address :
									'Unknown';
							?></td>
						</tr>
						<tr>
							<th>Referred By (other than GP)</th>
							<td>TBD</td>
						</tr>
						<tr>
							<th>Referred From</th>
							<td>TBD</td>
						</tr>
						<tr class="last">
							<th>Date of Referral</th>
							<td>TBD</td>
						</tr>

					</tbody>
				</table>
			</td>
		</tr>

		<tr>
			<td class="row-title">5. Application reviewed by Chief Pharmacist or nominated deputy e.g. relevant specialist pharmacist (in the case of a drug intervention)</td>
			<td>
				<table class="inner">
					<tbody>
						<tr nobr="true">
							<th>Chief Pharmacist / Deputy Name</th>
							<td><?php echo preg_replace('/\n/', '<br />', Yii::app()->params['OphCoTherapyapplication_chief_pharmacist']) ?></td>
						</tr>
						<tr nobr="true">
							<th>Chief Pharmacist / Deputy email &amp; contact number:</th>
							<td><?php echo preg_replace('/\n/', '<br />', Yii::app()->params['OphCoTherapyapplication_chief_pharmacist_contact']) ?></td>
						</tr>
						<tr nobr="true">
							<th>Pharmacist name for any queries if different to above</th>
							<td><?php echo preg_replace('/\n/', '<br />', Yii::app()->params['OphCoTherapyapplication_chief_pharmacist_alternate']) ?></td>
						</tr>
						<tr nobr="true" class="last">
							<th>Pharmacist email and contact number:</th>
							<td><?php echo preg_replace('/\n/', '<br />', Yii::app()->params['OphCoTherapyapplication_chief_pharmacist_alternate_contact']) ?></td>
						</tr>

						</tbody>
				</table>
			</td>
		</tr>

	</tbody>
</table>
<tcpdf method="AddPage" />
<table nobr="true">
	<tbody>
	<tr class="header">
		<td class="header"><h2>&nbsp;Request Details</h2></td>
	</tr>
	<tr>
		<td>
		<table class="layout">
				<tr nobr="true">
				<td class="row-title">&nbsp;Patient Diagnosis (for which intervention is requested)</td>
				<td>
				<span class="form-text">Eye affected:</span> <?php echo ucfirst($side) ?><br />
				<span class="form-text">Diagnosis:</span> <?php echo $diagnosis->getDiagnosisStringForSide($side); ?><br />
				<span class="form-text">Visual Acuity:</span> <?php echo ($exam_api && ($va = $exam_api->getLetterVisualAcuityBoth($patient)) ) ? $va : "Not measured"; ?><br />
				<span class="form-text">OCT Thickness:</span>
				<?php
					$oct_str = "Not measured";
					if ($exam_api && $oct = $exam_api->getOCTForSide($patient, $event->episode, $side)) {
						$oct_str = "Maximum CRT: " . $oct[0] . "&micro;m, Central SFT: " . $oct[1] . "&micro;m";
					}
					echo $oct_str;
				?>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	</tbody>
</table>

<table class="layout">
	<tbody>
		<tr nobr="true">
			<td class="row-title">&nbsp;Details of intervention for which funding is requested</td>
			<td>
			<table class="inner">
				<tr>
					<th>Name of intervention:</th>
					<td><?php echo $treatment->intervention_name ?></td>
				</tr>
				<tr>
					<th>Dose and frequency:</th>
					<td><?php echo $treatment->dose_and_frequency ?></td>
				</tr>
				<tr>
					<th>Route of administration:</th>
					<td><?php echo $treatment->administration_route ?></td>
				</tr>
				<tr>
					<th>Planned duration:</th>
					<td><?php echo $treatment->duration ?></td>
				</tr>
			</table>
			</td>
		</tr>
		<tr nobr="true">
			<td class="row-title">&nbsp;What are the exceptional circumstances that make the standard intervention inappropriate for this patient?</td>
			<td><?php echo $exceptional->{$side . '_patient_different'} ?><br /><br />
				<?php echo $exceptional->{$side . '_patient_gain'}?></td>
		</tr>

		<tr nobr="true">
			<td class="row-title">&nbsp;Are there any patient factors (clinical or personal) that need to be considered?</td>
			<td><?php
				if ($exceptional->{$side . '_patient_factors'}) {
					echo "Yes <br /><br />" . $exceptional->{$side . '_patient_factor_details'};
				} else {
					echo "No";
				}
				?></td>
		</tr>

		<tr nobr="true">
			<td class="row-title">10. Is requested intervention part of a clinical trial?</td>
			<td>&nbsp;No</td>
		</tr>

		<tr nobr="true">
			<td class="row-title">&nbsp;Is requested intervention licensed in the UK for use in the requested indication?</td>
			<td>&nbsp;NO<br /><br />&nbsp;<span class="form-text">If No, is it licensed for use in another indication:</span> YES.</td>
		</tr>

		<tr nobr="true">
			<td class="row-title">&nbsp;Details of the papers submitted</td>
			<td>
				<?php if ($exceptional->{$side . '_filecollections'}) {
					echo "Please see attached papers and supporting documents.<br /><br />";
					foreach ($exceptional->{$side . '_filecollections'} as $fc) {
						echo $fc->summary;
						echo "<ul>";
						foreach ($fc->files as $f) {
							echo "<li>" . $f->name . "</li>";
						}
						echo "</ul>";
					}
				} else {
					echo "None";
				}?>
			</td>
		</tr>

		<tr nobr="true">
			<td class="row-title">&nbsp; Has the Trust Drugs and Therapeutics Committee or equivalent Committee approved the requested intervention for use? (if drug or medical device)</td>
			<td><span class="form-text">If No, Committee Chair or Chief Pharmacist who approved?<br />
			Evidence must be supplied e.g. D&amp;TC minutes, Chairs actions, etc<br />
			<b>NB: the PCT cannot consider the case in the absence of this evidence.</b></span><br /><br />
				YES.
			</td>
		</tr>

		<tr nobr="true">
			<td class="row-title">&nbsp;Is there a standard intervention at this stage?</td>
			<td>
				<?php if ($exceptional->{$side . '_standard_intervention_exists'}) {?>
					The standard intervention is <?php echo $exceptional->{$side . '_standard_intervention'}->name;?>.<br /><br />
					This intervention has <?php if (!$exceptional->{$side . '_standard_previous'}) { echo "not"; }?> been applied previously.<br /><br />
				<?php } else { ?>
					There is no standard intervention<br /><br />
					This is <?php if (!$exceptional->{$side . '_condition_rare'}) { echo 'not'; }?> a rare condition.<br />
					The incidence of it is: <?php echo $exceptional->{$side . '_incidence'}; ?>
				<?php }?></td>
		</tr>

		<tr nobr="true">
			<td class="row-title">&nbsp;Is the requested intervention additional to the standard intervention(s) or a deviation from the standard?</td>
			<td>(b)
				<?php if ($exceptional->{$side . '_standard_intervention_exists'}) {
					echo $exceptional->getAttributeLabel($side . '_intervention_id') . " " . $exceptional->{$side . '_intervention'}->name;?><br /><br />
					<?php echo $exceptional->{$side . '_description'};?>
					<?php if ($exceptional->needDeviationReasonForSide($side)) {?>
						<br /><br />The standard intervention cannot be used because of
						<?php
						$reason_count = count($exceptional->{$side . '_deviationreasons'});
						foreach ($exceptional->{$side . '_deviationreasons'} as $i => $dr) {
							echo $dr->name;
							if ($i == $reason_count - 1) {
								echo ".";
							} elseif ($i == $reason_count - 2) {
								echo " and ";
							} else {
								echo ", ";
							}
						}?>
					<?php } ?>
				<?php } ?>
			</td>
		</tr>

		<tr nobr="true">
			<td class="row-title">&nbsp;What is the anticipated benefit of the intervention compared to the standard?</td>
			<td><span class="form-text">In case of intervention for cancer please provide details of expected survival benefit.</span><br />
			</td>
		</tr>

		<tr nobr="true">
			<td class="row-title">&nbsp;Summary of previous intervention(s) this patient has received for the condition.<br />
				* Reasons for stopping may include:
				<ul>
					<li>Course completed</li>
					<li>No or poor response</li>
					<li>Disease progression</li>
					<li>Adverse effects/poorly tolerated</li>
				</ul></td>
			<td>
				<?php
				if ($exceptional->{$side . '_previnterventions'}) {
					?>
					<table>
						<thead>
						<tr class="inner">
							<th>Start date</th>
							<th>End date</th>
							<th>Intervention</th>
							<th>Reason for stopping / Response acheived</th>
							<th>Comments</th>
						</tr>
						</thead>
						<tbody>
						<?php
						foreach ($exceptional->{$side . '_previnterventions'} as $previntervention) {
							?>
							<tr>
								<td><?php echo Helper::convertDate2NHS($previntervention->start_date) ?></td>
								<td><?php echo Helper::convertDate2NHS($previntervention->end_date) ?></td>
								<td><?php echo $previntervention->treatment->name ?></td>
								<td><?php echo $previntervention->getStopReasonText() ?></td>
								<td><?php
									echo "Start VA: " . $previntervention->start_va . "<br />";
									echo "End VA: " . $previntervention->end_va . "<br />";
									if ($previntervention->comments) { echo $previntervention->comments; } ?></td>
							</tr>
						<?php
						}
						?>
						</tbody>
					</table>
				<?php
				} else {
					echo "None";
				}
				?>
			</td>
		</tr>

		<tr nobr="true">
			<td class="row-title">&nbsp;Please provide details of other relevant treatment</td>
			<td>
				<?php
				if ($exceptional->{$side . '_relevantinterventions'}) {
					?>
					<table>
						<thead>
						<tr class="inner">
							<th>Dates</th>
							<th>Intervention</th>
							<th>Reason for stopping / Response acheived</th>
							<th>Comments</th>
						</tr>
						</thead>
						<tbody>
						<?php
						foreach ($exceptional->{$side . '_relevantinterventions'} as $relevantintervention) {
							?>
							<tr>
								<td><?php echo Helper::convertDate2NHS($relevantintervention->start_date) ?></td>
								<td><?php echo Helper::convertDate2NHS($relevantintervention->end_date) ?></td>
								<td><?php echo $relevantintervention->getTreatmentName() ?></td>
								<td><?php echo $relevantintervention->getStopReasonText() ?></td>
								<td><?php
									echo "Start VA: " . $relevantintervention->start_va . "<br />";
									echo "End VA: " . $relevantintervention->end_va . "<br />";
									if ($relevantintervention->comments) { echo $relevantintervention->comments; } ?></td>
							</tr>
						<?php
						}
						?>
						</tbody>
					</table>
				<?php
				} else {
					echo "None";
				}
				?>
			</td>
		</tr>

		<tr nobr="true">
			<td class="row-title">&nbsp;In case of intervention for NON-CANCER</td>
			<td>
				<table class="inner">
					<tr>
						<th>What is the patient's clinical severity? (Where possible use standard scoring systems e.g. WHO, DAS scores, walk test, cardiac index etc)</th>
						<td>Visual Acuity in the affected eye is:
							<?php if ($exam_api) {
								if ($side == 'left') {
									$va = $exam_api->getLetterVisualAcuityLeft($patient);
								} else {
									$va = $exam_api->getLetterVisualAcuityRight($patient);
								}
								echo $va ? $va : "Not measured";
							}
							?></td>
					</tr>
				</table>
			</td>
		</tr>

		<tr nobr="true">
			<td class="row-title">&nbsp;In case of intervention for CANCER</td>
			<td><table class="inner">
					<tr>
						<th>Please indicate whether the intervention is for:
							<ul>
								<li>Adjuvant / Neoadjuvant</li>
								<li>1st line relapse (or metastatic)</li>
								<li>2nd line relapse</li>
								<li>Other (please specify)</li>
							</ul>
						</th>
						<td>Not applicable</td>
					</tr>
					<tr>
						<th>What is the WHO performance status?</th>
						<td>Not applicable</td>
					</tr>
					<tr>
						<th>How advanced is the cancer? (stage)</th>
						<td>Not applicable</td>
					</tr>
					<tr>
						<th>Describe any metastases:</th>
						<td>Not applicable</td>
					</tr>
				</table></td>
		</tr>


		<tr nobr="true">
			<td class="row-title">&nbsp;What is the anticipated toxicity of the intervention for this patient?</td>
			<td><?php echo nl2br($treatment->toxicity) ?></td>
		</tr>

		<tr nobr="true">
			<td class="row-title">&nbsp;What are the criteria for stopping treatment</td>
			<td><ol>
					<li>Failure of treatment indicated by persistent deterioration in visual acuity</li>
					<li>Absence of disease activity</li>
					<li>Adverse effects related to the drug</li>
					<li>Hypersensitivity to the drug </li>
				</ol>
			</td>
		</tr>

		<tr nobr="true">
			<td class="row-title">&nbsp;How will you monitor the effectiveness of the intervention?</td>
			<td>Visual acuity, Clinical examination, OCT, and when necessary, FFA and ICG</td>
		</tr>

		<tr nobr="true">
			<td class="row-title">&nbsp;What would you consider to be a successful outcome for this intervention in this patient?</td>
			<td><ol>
				<li>Stabilisation / improvement in visual acuity</li>
				<li>Resolution of subretinal fluid on OCT</li>
				<li>Absence of leak on FFA/ICG</li>
			</ol></td>
		</tr>

		<tr>
			<td class="row-title">What are the patient expectations for the outcome of the treatment? Have these been discussed with the patient and their family?</td>
			<td><?php echo $exceptional->{$side . '_patient_expectations'} ?></td>
		</tr>

		<tr nobr="true">
			<td class="row-title">&nbsp;Costing information</td>
			<td>
				<table class="inner">
					<tr>
						<th>Anticipated monthly cost, or cost per cycle (inc VAT) (Seek advice from Pharmacy)</th>
						<td>&pound;<?php echo $treatment->displayCost ?></td>
					</tr>
					<tr>
						<th>Related monitoring costs</th>
						<td>Outpatient follow up appointment at national tariff<br />FFA: &pound;71</td>
					</tr>
					<tr>
						<th>Related monitoring frequency</th>
						<td><?php echo $treatment->displayMonitoringFrequency ?></td>
					</tr>
					<tr>
						<th>Any other additional on costs including reasons</th>
						<td>NIL</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr nobr="true">
			<td class="row-title">&nbsp;Date form completed:</td>
			<td><?php echo $event->NHSDate('last_modified_date') ?></td>
		</tr>
		<tr nobr="true">
			<td class="row-title">&nbsp;Trust reference number</td>
			<td>&nbsp;</td>
		</tr>

		<tr nobr="true">
			<td class="row-title">&nbsp;Form completed by:</td>
			<td><?php echo $event->usermodified->getFullname() ?></td>
		</tr>

	</tbody>
</table>


</body>
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

body {
	font-size: 24px;
}

.header {
	width: 650px;
	background-color: #ccffff;
	border-style: solid solid none solid;
	border-color: #999 #999 #999 #999;
	border-width: 1px 1px 0px 1px;
}

table.layout {
	width: 650px;
	margin-bottom: 30px;
}
	
table.layout th,
table.layout td {
	border: 1px solid #999;
}

table.layout tr {
	nobr: true;
}

td.row-title {
	background-color: #ccffcc;
	width: 180px;
}

table.inner td,
table.inner th {
	border-bottom: 1px solid #ccc;
}

table.inner tr.last td,
table.inner tr.last th {
	border-bottom: none;
}

</style>

<?php 
$exam_api = Yii::app()->moduleAPI->get('OphCiExamination');
?>

<h1>Individual Treatment Funding Request Form</h1>

<div class="header">
<h2>&nbsp;Contact Information</h2>
</div>
<table class="layout">
	<tbody>
		<tr>
			<td class="row-title">1. PCT Name</td>
			<td class="row-data">TBD</td>
		</tr>
		<tr>
			<td class="row-title">2. PCT Address</td>
			<td class="row-data">TBD</td>
		</tr>
		<tr>
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
								<?php if ($contact = $diagnosis->user->getContact()) {
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
		<tr>
			<td class="row-title">4. Patient Details</td>
			<td class="row-data">
				<table class="inner">
					<tbody>
						<tr>
							<th>Patient Name</th>
							<td>
								<?php echo $patient->getFullName() ?><br />
								<?php 
								if ($address = $patient->address) {
									echo $address->getLetterHtml();
								}
								else {
									echo "Unknown";
								}
								?>
							</td>
						</tr>
						<tr>
							<th>NHS No.</th>
							<td><?php echo $patient->nhs_num ?></td>
						</tr>
						<tr>
							<th>Hospital ID No.</th>
							<td><?php echo $patient->hos_num ?></td>
						</tr>
						<tr>
							<th>DoB</th>
							<td><?php echo $patient->NHSDate('dob') ?></td>
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
							<td><?php echo ($patient->practice && $patient->practice->address) ? $patient->practice->address->letterLine : 'Unknown'; ?></td>
						</tr>
						<tr>
							<th>PCT</th>
							<td>TBD</td>
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
						<tr>
							<th>Chief Pharmacist / Deputy Name</th>
							<td><?php echo preg_replace('/\n/', '<br />', Yii::app()->params['OphCoTherapyapplication_chief_pharmacist']) ?></td>
						</tr>
						<tr>
							<th>Chief Pharmacist / Deputy email &amp; contact number:</th>
							<td><?php echo preg_replace('/\n/', '<br />', Yii::app()->params['OphCoTherapyapplication_chief_pharmacist_contact']) ?></td>
						</tr>
						<tr>
							<th>Pharmacist name for any queries if different to above</th>
							<td><?php echo preg_replace('/\n/', '<br />', Yii::app()->params['OphCoTherapyapplication_chief_pharmacist_alternate']) ?></td>
						</tr>
						<tr class="last">
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

<div class="header">
<h2>&nbsp;Intervention Requested</h2>
<p>NB: Intervention refers to requested treatment, investigation, etc)</p>
</div>
<table class="layout">
	<tbody>
		<tr>
			<td class="row-title">6. Patient Diagnosis (for which intervention is requested)</td>
			<td>
			Eye affected: <?php echo $side ?><br />
			Diagnosis: <?php echo $diagnosis->{$side . '_diagnosis'}->term ?><br />
			Visual Acuity: <?php echo ($va = $exam_api->getLetterVisualAcuity($patient, $event->episode, $side)) ? $va : "Not measured"; ?><br />
			OCT Thickness: TBD
			</td>
		</tr>
		<tr>
			<td class="row-title">7. Details of intevention (for which funding is requested)</td>
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
			</table>
			</td>
		</tr>
		<tr>
			<td class="row-title">8. Costing information</td>
			<td>
				<table class="inner">
					<tr>
						<th>Anticpated monthly cost, or cost per cycle (inc VAT) (Seek advice from Pharmacy)</th>
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
		<tr>
			<td class="row-title">9. (a) Planned duration of intervention?<br /><br />
(b) How will you monitor the effectiveness of the intervention?<br />	
(c) What are the criteria for stopping treatment<br /><br /><br /><br />
(d) What would you consider to be a successful outcome for this intervention in this patient?</td>
			<td>(a)<?php echo $treatment->duration ?><br /><br />
			(b) Visual acuity, Clinical examination, OCT, and when necessary, FFA and ICG<br /><br />
			(c) 1. Failure of treatment indicated by persistent deterioration in visual acuity<br />
2. Absence of disease activity<br />
3. Adverse effects related to the drug<br />
4. Hypersensitivity to the drug<br /><br />
(d) 1. Stabilisation / improvement in visual acuity<br />
2. Resolution of subretinal fluid on OCT<br />
3. Absence of leak on FFA/ICG
			</td>
		</tr>
		<tr>
			<td class="row-title">10. Is requested intervention part of a clinical trial?</td>
			<td>(e.g. name of trial, is it an MRC/National trial?)<br />(Not Applicable)</td>
		</tr>
		<tr>
			<td class="row-title">11. (a) Is there a standard intervention at this stage?<br /><br />
(b) Is the requested intervention additional to the standard intervention(s) or a deviation from the standard?<br /><br />
(c) What are the exceptional circumstances that make the standard intervention inappropriate for this patient?</td>
			<td>(a) 
				<?php if ($exceptional->{$side . '_standard_intervention_exists'}) {
					echo $exceptional->{$side . '_details'};
				} else {
					echo "No current standard deviation<br />";
				}?>
				
				<br /><br />(b) Intervention is: <?php echo $exceptional->{$side . '_intervention'}->name?><br />
				(c) <?php echo $exceptional->{$side . '_description'} ?>
				
			</td>
		</tr>
		<tr>
			<td class="row-title">12. In case of intervention for CANCER</td>
			<td>N/A</td>
		</tr>
		<tr>
			<td class="row-title">13. In case of intervention for NON-CANCER</td>
			<td>
			<table class="inner">
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
			</table>
			</td>
		</tr>
		<tr nobr="true">
			<td class="row-title">14. Summary of previous intervention(s) this patient has received for the condition.<br />
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
					<tr>
						<th>Dates</th>
						<th>Intervention</th>
						<th>Reason for stopping / Response acheived</th>
					</tr>
					</thead>
					<tbody>
				<?php 
				foreach ($exceptional->{$side . '_previnterventions'} as $previntervention) {
					?>
					<tr>
						<td><?php echo Helper::convertDate2NHS($previntervention->treatment_date) ?></td>
						<td><?php echo $previntervention->treatment->name ?></td>
						<td><?php echo $previntervention->stopreason->name ?></td>
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
		<tr>
			<td class="row-title">15. Anticipated Start Date</td>
			<td>Processing requests can take up to 2-4 weeks (from the date received by the PCT). <br />If the case is more urgent than this, please state clinical reason why:<br />
4 Weeks.</td>
		</tr>
			
	</tbody>
</table>

<div class="header">
<h2>&nbsp;Clinical Evidence</h2>
</div>
<table class="layout">
	<tbody>
		<tr>
			<td class="row-title">16. Is requested intervention licensed in the UK for use in the requested indication? NO.</td>
			<td>If No, is it licensed for use in another indication: YES.</td>
		</tr>
		<tr>
			<td class="row-title">17. Has the Trust Drugs and Therapeutics Committee or equivalent Committee approved the requested intervention for use? (if drug or medical device)</td>
			<td>If No, Committee Chair or Chief Pharmacist who approved?<br />
			Evidence must be supplied e.g. D&amp;TC minutes, Chairs actions, etc<br /> 
			<b>NB: the PCT cannot consider the case in the absence of this evidence.</b><br /><br />
			YES.</td>
		</tr>
		<tr>
			<td class="row-title">18. In case of intervention for CANCER has it been approved by any of the following:</td>
			<td>Mark as appropriate:
			<ol>
			<li>N/A</li>
			<li>London Cancer Drugs Group</li>
			<li>London Cancer prioritisation process (LCP)</li>
			</ol> 
(Not applicable)</td>
		</tr>
		<tr>
			<td class="row-title">19. Give details of National, Cancer Network or Local Guidelines/ recommendations or other published data supporting the use of the requested intervention for this condition?</td>
			<td>PUBLISHED trials/data<br />
(Full published papers, rather than abstracts, should be submitted, unless the application relates to the use of an intervention in a rare disease where published data are not available. Electronic copies of the papers/web links for peer-reviewed papers must be supplied, where available.)<br /><br />
(Please see attached papers and supporting documents.)</td>
		</tr>
		<tr>
			<td class="row-title">20. What is the anticipated benefit of the intervention compared to the standard?</td>
			<td>In case of intervention for cancer please provide details of expected survival benefit.<br /> 
(Not applicable)</td>
		</tr>
		<tr>
			<td class="row-title">21. What is the anticipated toxicity of the intervention for this patient?</td>
			<td><?php echo nl2br($treatment->toxicity) ?></td>
		</tr>
		<tr>
			<td class="row-title">22. Are there any patient factors (clinical or personal) that need to be considered?</td>
			<td><?php  
				if ($exceptional->{$side . '_patient_factors'}) {
					echo $exceptional->{$side . '_patient_factor_details'};
				}
				else {
					echo "No";
				}
			?></td>
		</tr>
		<tr>
			<td class="row-title">Date form completed:</td>
			<td><?php echo $event->NHSDate('last_modified_date') ?></td>
		</tr>
		<tr>
			<td class="row-title">Trust reference number</td>
			<td>&nbsp;</td>
		</tr>	
	</tbody>
</table>
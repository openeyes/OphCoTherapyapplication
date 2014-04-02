<?php
/**
 * Created by PhpStorm.
 * User: msmith
 * Date: 01/04/2014
 * Time: 09:13
 */

class ReportController extends BaseController {
	public function accessRules()
	{
		return array(
				array('deny'),
		);
	}

	protected function array2Csv(array $data)
	{
		if (count($data) == 0) {
			return null;
		}
		ob_start();
		$df = fopen("php://output", 'w');
		fputcsv($df, array_keys(reset($data)));
		foreach ($data as $row) {
			fputcsv($df, $row);
		}
		fclose($df);
		return ob_get_clean();
	}

	protected function sendCsvHeaders($filename)
	{
		header("Content-type: text/csv");
		header("Content-Disposition: attachment; filename=$filename");
		header("Pragma: no-cache");
		header("Expires: 0");
	}

	public function actionIndex()
	{
		if (isset($_GET['yt0'])) {
			$firm = null;
			$date_from = date('Y-m-d', strtotime("-1 year"));
			$date_to = date('Y-m-d');

			if (@$_GET['firm_id'] && (int)$_GET['firm_id']) {
				$firm_id = (int)$_GET['firm_id'];
				if(!$firm = Firm::model()->findByPk($firm_id)) {
					throw new CException("Unknown firm $firm_id");
				}
			}

			$results = $this->getApplications($date_from, $date_to, $firm);

			$filename = 'therapyapplication_report_' . date('YmdHis') . '.csv';
			$this->sendCsvHeaders($filename);

			echo $this->array2Csv($results);
		}
		else {
			$subspecialty = Subspecialty::model()->find('ref_spec=:ref_spec', array(':ref_spec' => 'MR'));

			$context['firms'] = Firm::model()->getList($subspecialty->id);
			$this->render('index', $context);
		}
	}

	protected function getApplications($date_from, $date_to, $firm = null)
	{
		$command = Yii::app()->db->createCommand()
				->select(
						"diag.left_diagnosis1_id, diag.left_diagnosis2_id, diag.right_diagnosis1_id, diag.right_diagnosis2_id, e.id,
						c.first_name, c.last_name, e.created_date, p.hos_num,p.gender, p.dob, eye.name AS eye, site.name as site_name,
						firm.name as firm_name, ps.left_treatment_id, ps.right_treatment_id, ps.left_nice_compliance, ps.right_nice_compliance"
				)
				->from("et_ophcotherapya_therapydiag diag")
				->join("event e", "e.id = diag.event_id")
				->join("episode ep", "e.episode_id = ep.id")
				->join("patient p", "ep.patient_id = p.id")
				->join("contact c", "p.contact_id = c.id")
				->join("eye", "eye.id = diag.eye_id")
				->join("et_ophcotherapya_mrservicein mrinfo", "mrinfo.event_id = diag.event_id")
				->join("site", "mrinfo.site_id = site.id")
				->join("firm", "mrinfo.consultant_id = firm.id")
				->join("et_ophcotherapya_patientsuit ps", "diag.event_id = ps.event_id")
				->where("e.deleted = 0 and ep.deleted = 0 and e.created_date >= :from_date and e.created_date < :to_date + interval 1 day");
		$params = array(':from_date' => $date_from, ':to_date' => $date_to);

		if ($firm) {
			$command->andWhere(
					"(mrinfo.consultant_id = :consultant_id)"
			);
			$params[':consultant_id'] = $firm->id;
		}

		$results = array();
		$cache = array();
		foreach ($command->queryAll(true, $params) as $row) {
			$record = array(
					"application_date" => date('j M Y', strtotime($row['created_date'])),
					"patient_hosnum" => $row['hos_num'],
					"patient_firstname" => $row['first_name'],
					"patient_surname" => $row['last_name'],
					"patient_gender" => $row['gender'],
					"patient_dob" => date('j M Y', strtotime($row['dob'])),
					"eye" => $row['eye'],
					"site_name" => $row['site_name'],
					"consultant" => $row['firm_name'],
					'left_diagnosis' => $this->getDiagnosisString($row['left_diagnosis1_id']),
					'left_secondary_to' => $this->getDiagnosisString($row['left_diagnosis2_id']),
					'right_diagnosis' => $this->getDiagnosisString($row['right_diagnosis1_id']),
					'right_secondary_to' => $this->getDiagnosisString($row['right_diagnosis2_id']),
					'left_treatment' => $this->getTreatmentString($row['left_treatment_id']),
					'right_treatment' => $this->getTreatmentString($row['right_treatment_id']),
					'left_compliant' => $this->sideCompliance('left', $row),
					'right_compliant' => $this->sideCompliance('right', $row),
			);

			$this->appendSubmissionValues($record, $row['id']);

			$results[] = $record;
		}

		return $results;
	}

	/**
	 * Get the compliance string for the given side on the data $row
	 *
	 * @param $side
	 * @param $row
	 * @return string
	 */
	protected function sideCompliance($side, $row)
	{
		if ($row[$side . '_treatment_id']) {
			return $row[$side . '_nice_compliance'] ? "Y" : "N";
		}
		else {
			return 'N/A';
		}
	}

	protected $_diagnosis_cache = array();

	/**
	 * @param $diagnosis_id
	 * @return string
	 */
	protected function getDiagnosisString($diagnosis_id)
	{
		if (!$diagnosis_id) {
			return 'N/A';
		}
		if (!@$this->_diagnosis_cache[$diagnosis_id]) {
			$disorder = Disorder::model()->findByPk($diagnosis_id);
			if ($disorder) {
				$this->_diagnosis_cache[$diagnosis_id] = $disorder->term;
			}
			else {
				$this->_diagnosis_cache[$diagnosis_id] = "REMOVED DISORDER";
			}
		}

		return $this->_diagnosis_cache[$diagnosis_id];
	}

	protected $_treatment_cache = array();

	/**
	 * @param $treatment_id
	 * @return string
	 */
	protected function getTreatmentString($treatment_id)
	{
		if (!$treatment_id) {
			return "N/A";
		}
		if (!@$this->_treatment_cache[$treatment_id]) {
			$treatment = OphCoTherapyapplication_Treatment::model()->findByPk($treatment_id);
			if ($treatment) {
				$this->_treatment_cache[$treatment_id] = $treatment->getName();
			}
			else {
				$this->_treatment_cache[$treatment_id] = "REMOVED TREATMENT";
			}
		}
		return $this->_treatment_cache[$treatment_id];
	}

	/**
	 * Appends information about the submission of the application to the $record
	 *
	 * @param array $record
	 * @param integer $event_id
	 */
	protected function appendSubmissionValues(&$record, $event_id)
	{
		if (@$_GET['submission']) {
			$event = Event::model()->findByPk($event_id);
			$svc = new OphCoTherapyapplication_Processor($event);
			$record['submission_status'] = $svc->getApplicationStatus();
			if ($record['submission_status'] == OphCoTherapyapplication_Processor::STATUS_SENT) {
				$most_recent = OphCoTherapyapplication_Email::model()->forEvent($event)->unarchived()->findAll(array('limit' => 1));
				$record['submission_date'] = Helper::convertDate2NHS($most_recent[0]->created_date);
			}
			else {
				$record['submission_date'] = 'N/A';
			}
		}

	}
}

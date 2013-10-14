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

/**
 * This is the model class for table "et_ophcotherapya_mrservicein".
*
* The followings are the available columns in table:
* @property string $id
* @property integer $event_id
* @property integer $eye_id
* @property string $left_email_text
* @property string $right_email_text
* The followings are the available model relations:
*
* @property ElementType $element_type
* @property EventType $eventType
* @property Event $event
* @property User $user
* @property User $usermodified
* @property OphCoTherapyapplication_Email_Attachment[] $attachments
* @property ProtectedFile[] $left_attachments
* @property ProtectedFile[] $right_attachments
*
*/

class Element_OphCoTherapyapplication_Email extends SplitEventTypeElement
{
	public $service;

	// internal store to related Element_OphCoTherapyapplication_PatientSuitability object
	protected $_suitability;

	/**
	 * Returns the static model of the specified AR class.
	 * @return the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'et_ophcotherapya_email';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
				array('event_id, eye_id,', 'safe'),
				array('event_id, eye_id', 'required'),
				array('left_email_text','requiredIfSide', 'side' => 'left'),
				array('right_email_text','requiredIfSide', 'side' => 'right'),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('id, event_id, eye_id, left_email_text, left_application_id, right_email_text, right_application_id', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
				'element_type' => array(self::HAS_ONE, 'ElementType', 'id','on' => "element_type.class_name='".get_class($this)."'"),
				'eventType' => array(self::BELONGS_TO, 'EventType', 'event_type_id'),
				'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
				'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
				'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
				'eye' => array(self::BELONGS_TO, 'Eye', 'eye_id'),
				'attachments' => array(self::HAS_MANY, 'OphCoTherapyapplication_Email_Attachment', 'element_id'),
				'left_attachments' => array(self::HAS_MANY, 'ProtectedFile', 'file_id', 'through' => 'attachments', 'on' => 'attachments.eye_id = ' . SplitEventTypeElement::LEFT),
				'right_attachments' => array(self::HAS_MANY, 'ProtectedFile', 'file_id', 'through' => 'attachments', 'on' => 'attachments.eye_id = ' . SplitEventTypeElement::RIGHT),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
				'id' => 'ID',
				'event_id' => 'Event',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('event_id', $this->event_id, true);
		$criteria->compare('consultant_id', $this->consultant_id);

		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
		));
	}

	public function isEditable()
	{
		// the existence of the email element indicates that the application is considered to be complete
		// so we don't allow it to be edited. This may well become more sophisticated if we start allowing status
		// change and the like.
		return false;
	}

	protected function beforeSave()
	{
		return parent::beforeSave();
	}

	protected function afterSave()
	{

		return parent::afterSave();
	}

	protected function beforeValidate()
	{
		return parent::beforeValidate();
	}

	/**
	 * abstracted method to update a ManyToMany sided relationship
	 * TODO: set this as a behaviour that can be attached to the appropriate models and used.
	 *
	 * @param string $side left or right
	 * @param string $side_relation field that defines which side the m2m model belongs to
	 * @param unknown $m2m_relation field that holds the relationship to the assignment model of the m2m model
	 * @param unknown $m2m_model assignment model class for the m2m
	 * @param unknown $id_fld the id field in the assignment model that relates to the actual m2m model
	 * @param unknown $ids the ids that the relationship should be set to.
	 */
	protected function updateManyToMany($side, $side_relation, $m2m_relation, $m2m_model, $id_fld, $ids)
	{
		$curr_by_id = array();
		$save = array();

		foreach ($this->$m2m_relation as $c) {
			if ($c->$side_relation == $side) {
				$curr_by_id[$c->id] = $c;
			}
		}

		foreach ($ids as $id) {
			if (!array_key_exists($id, $curr_by_id)) {
				$ass = new $m2m_model();
				$ass->attributes = array('element_id' => $this->id, $side_relation => $side, $id_fld => $id);
				$save[] = $ass;
			} else {
				// keep the assignment
				unset($curr_by_id[$id]);
			}
		}

		foreach ($save as $s) {
			$s->save();
		}

		foreach ($curr_by_id as $curr) {
			$curr->delete();
		}
	}

	public function updateAttachments($side, $attachment_ids)
	{
		$this->updateManyToMany($side, "eye_id", "attachments", "OphCoTherapyapplication_Email_Attachment", "file_id", $attachment_ids);
	}

	/**
	 * sends the application for email for the specified side. Returns boolean to indicate email
	 * success or failure
	 *
	 * @param string $side
	 * @return boolean
	 */
	protected function sendEmailForSide($side)
	{
		$message = Yii::app()->mailer->newMessage();
		$message->setSubject('Therapy Application');
		$message->setFrom(Yii::app()->params['OphCoTherapyapplication_sender_email']);

		if ($this->isSideCompliant($side)) {
			$message->setTo(Yii::app()->params['OphCoTherapyapplication_compliant_recipient_email']);
		} else {
			$message->setTo(Yii::app()->params['OphCoTherapyapplication_noncompliant_recipient_email']);
		}

		$message->setBody($this->{$side . '_email_text'});
		if ($attach = $this->{$side . '_attachments'}) {
			// need to ensure that we are not going to go over the limits of file sizes on the mail server
			// (note that the text changes in the email body are manipulated in the processor for this)
			$size = 0;
			foreach ($attach as $att) {
				$size += $att->size;
			}
			if ($size <= Helper::convertToBytes(Yii::app()->params['OphCoTherapyapplication_email_size_limit'])) {
				foreach ($attach as $att) {
					$message->attach(Swift_Attachment::fromPath($att->getPath())->setFilename($att->name) );
				}
			}
		}

		return Yii::app()->mailer->sendMessage($message);
	}

	/**
	 * Determines if the given side is a compliant application or not
	 *
	 * NOTE: if we wind up with an event object, this should make use of that rather than performing its
	 * own query on a sibling element
	 *
	 * @param string $side
	 * @return boolean
	 * @throws Exception
	 */
	protected function isSideCompliant($side)
	{
		if (!$this->_suitability) {
			$criteria = new CDbCriteria;
			$criteria->compare('event_id',$this->event_id);
			$this->_suitability = Element_OphCoTherapyapplication_PatientSuitability::model()->find($criteria);
		}
		if ( ($side == 'left' && !$this->_suitability->hasLeft()) ||
			($side == 'right' && !$this->_suitability->hasRight()) ) {
			throw new Exception("cannot determine compatibility for invalid side");
		}
		return $this->_suitability->{$side . '_nice_compliance'};
	}

	/**
	 * Actually send the email(s) for the application. Returns success/failure flag
	 *
	 * @return boolean
	 */
	public function sendEmail()
	{
		$success = true;
		if ($this->hasLeft()) {
			$success = $this->sendEmailForSide('left');
		}
		if ($success && $this->hasRight()) {
			$success = $this->sendEmailForSide('right');
		}
		if ($success) {
			// save it to mark the element as modified, which indicates last sent date
			$this->save();
		}
		return $success;
	}

}

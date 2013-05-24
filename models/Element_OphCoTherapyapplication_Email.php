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
* @property string $left_application
* @property string $right_email_text
* @property string $right_application
*
* The followings are the available model relations:
*
* @property ElementType $element_type
* @property EventType $eventType
* @property Event $event
* @property User $user
* @property User $usermodified
* @property Firm $consultant
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
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('event_id, eye_id,', 'safe'),
				array('event_id, eye_id', 'required'),
				array('left_email_text','requiredIfSide', 'side' => 'left'),
				array('right_email_text','requiredIfSide', 'side' => 'right'),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('id, event_id, eye_id, left_email_text, left_application, right_email_text, right_application', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
				'element_type' => array(self::HAS_ONE, 'ElementType', 'id','on' => "element_type.class_name='".get_class($this)."'"),
				'eventType' => array(self::BELONGS_TO, 'EventType', 'event_type_id'),
				'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
				'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
				'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
				'eye' => array(self::BELONGS_TO, 'Eye', 'eye_id'),
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

	public function isEditable() {
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
		}
		else {
			$message->setTo(Yii::app()->params['OphCoTherapyapplication_noncompliant_recipient_email']);
		}
		
		$message->setBody($this->{$side . '_email_text'});
		if ($this->{$side . '_application'}) {
			$message->attach(Swift_Attachment::fromPath($this->{$side . '_application'}) );
		}
		
		if (Yii::app()->mailer->sendMessage($message)) {
			return true;
		}
		else {
			return false;
		}
	}
	
	/**
	 * Determines if the given side is a compliant application or not
	 * 
	 * NOTE: if we wind up with an event object, this should make use of that rather than performing its 
	 * own query on a sibling element
	 * 
	 * @param string $side
	 * @return boolean
	 */
	protected function isSideCompliant($side) {
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
?>
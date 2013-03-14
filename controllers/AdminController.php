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

class AdminController extends Controller
{
	public $defaultAction = "ViewDecisionTrees";
	public $showForm = false;
	public $assetPath;
	
	# TODO: push this up into a root admin controller
	public $layout='/layouts/column2';
	
	# TODO: push this up into a root admin controller
	protected function beforeAction($action)
	{
		// Sample code to be used when RBAC is fully implemented.
		if (!Yii::app()->user->checkAccess('admin')) {
			throw new CHttpException(403, 'You are not authorised to perform this action.');
		}
	
		// Set asset path
		if (file_exists(Yii::getPathOfAlias('application.modules.'.$this->getModule()->name.'.assets'))) {
			$this->assetPath = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.modules.'.$this->getModule()->name.'.assets'), false, -1, YII_DEBUG);
			Yii::app()->clientScript->registerScriptFile($this->assetPath.'/js/admin.js');
			
			// Register css
			Yii::app()->getClientScript()->registerCssFile($this->assetPath.'/css/admin.css');
		}
		
		return parent::beforeAction($action);
	}

	public function actionViewDecisionTrees() {
		$dataProvider=new CActiveDataProvider('OphCoTherapyapplication_DecisionTree');
		$this->render('list',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionViewTreatments() {
		$dataProvider=new CActiveDataProvider('Element_OphCoTherapyapplication_PatientSuitability_Treatment');
		$this->render('list',array(
				'dataProvider'=>$dataProvider,
		));
	}
	
	public function actionUpdateTreatment($id) {
		$model = Element_OphCoTherapyapplication_PatientSuitability_Treatment::model()->findByPk((int)$id);
		
		if (isset($_POST['Element_OphCoTherapyapplication_PatientSuitability_Treatment'])) {
			$model->attributes = $_POST['Element_OphCoTherapyapplication_PatientSuitability_Treatment'];
			
			if ($model->save()) {
				Audit::add('Element_OphCoTherapyapplication_PatientSuitability_Treatment','update', serialize($model->attributes));
				Yii::app()->user->setFlash('success', 'Treatment update');
				
				$this->redirect(array('viewtreatments'));
			}
		}
		
		$this->render('update', array(
				'model' => $model,
		));
	}
	
	public function actionDecisionTreeEdit($flowId) {
		
		$this->render('assessmentflowedit');
	}

	public function actionCreateDecisionTree() {
		$model = new OphCoTherapyapplication_DecisionTree();
		
		if (isset($_POST['OphCoTherapyapplication_DecisionTree'])) {
			// do the actual create
			$model->attributes = $_POST['OphCoTherapyapplication_DecisionTree'];
			
			if ($model->save()) {
				Audit::add('OphCoTherapyapplication_DecisionTree','create', serialize($model->attributes));
				Yii::app()->user->setFlash('success', 'Decision Tree created');
				
				$this->redirect(array('viewdecisiontree','id'=>$model->id));
			}
		}
		
		$this->render('form_OphCoTherapyapplication_DecisionTree',array(
				'model'=>$model,
		));
		
	}
	
	public function actionViewDecisionTree($id) {
		$model = OphCoTherapyapplication_DecisionTree::model()->findByPk((int)$id);
		
		if (@$_GET['node_id']) {
			$node = OphCoTherapyapplication_DecisionTreeNode::model()->findByPk((int)$_GET['node_id']);
			if ($node->decisiontree_id != $model->id) {
				throw Exception("mismatched node and decision tree!");
			}
		}
		else
		{
			$node = $model->getRootNode();
		}
		
		$this->render('view_OphCoTherapyapplication_DecisionTree', array(
				'model' => $model,
				'node' => $node
		));
	}
	
	public function actionCreateDecisionTreeNode($id) {
		$tree = OphCoTherapyapplication_DecisionTree::model()->findByPk((int)$id);
		
		$parent = null;
		if (isset($_GET['parent_id'])) {
			$parent = OphCoTherapyapplication_DecisionTreeNode::model()->findByPk((int)$_GET['parent_id']);
		}
		
		$model = new OphCoTherapyapplication_DecisionTreeNode();
		
		if (isset($_POST['OphCoTherapyapplication_DecisionTreeNode'])) {
			$model->attributes = $_POST['OphCoTherapyapplication_DecisionTreeNode'];
			$model->decisiontree_id = $id;
			
			if ($parent) {
				$model->parent_id = $parent->id;
			}
			error_log(print_r($model->attributes,true));
			
			if ($model->save()) {
				Audit::add('OphCoTherapyapplication_DecisionTreeNode','create', serialize($model->attributes));
				Yii::app()->user->setFlash('success', 'Decision Tree node created');
				
				$this->redirect(array('viewdecisiontree', 'id'=>$id));
			}
			
		}
		
		$this->renderPartial('create', array(
				'model' => $model,
				'decisiontree' => $tree,
		));
	}
	
	public function actionUpdateDecisionTreeNode($id) {
		$model = OphCoTherapyapplication_DecisionTreeNode::model()->findByPk((int)$id);
		
		if (isset($_POST['OphCoTherapyapplication_DecisionTreeNode'])) {
			$model->attributes = $_POST['OphCoTherapyapplication_DecisionTreeNode'];
			
			if ($model->save()) {
				Audit::add('OphCoTherapyapplication_DecisionTreeNode', 'update', serialize($model->attributes));
				
				$this->redirect(array('viewdecisiontree', 'id'=>$model->decisiontree_id));
			}
		}
		
		$this->renderPartial('update', array(
				'model' => $model,
		));
	}
	
	public function actionCreateDecisionTreeNodeRule($id) {
		$node = OphCoTherapyapplication_DecisionTreeNode::model()->findByPk((int)$id);
		
		$model = new OphCoTherapyapplication_DecisionTreeNodeRule();
		
		if (isset($_POST['OphCoTherapyapplication_DecisionTreeNodeRule'])) {
			$model->attributes = $_POST['OphCoTherapyapplication_DecisionTreeNodeRule'];
			$model->node_id = $node->id;
			
			if ($model->save()) {
				Audit::add('OphCoTherapyapplication_DecisionTreeNodeRule', 'create', serialize($model->attributes));
				Yii::app()->user->setFlash('success', 'Decision Tree Node rule created');
				
				$this->redirect(array('viewdecisiontree', 'id' => $node->decisiontree_id, 'node_id' => $node->id));
			}
		}
		
		$this->renderPartial('create', array(
			'model' => $model,
			'node' => $node,
		));
	}
	
}

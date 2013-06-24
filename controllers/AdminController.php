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

class AdminController extends ModuleAdminController
{
	public $defaultAction = "ViewDecisionTrees";
	
	private function popupCloseAndRedirect($redirect) {
		$this->render('popupcloseandredirect', array(
				'url' => $redirect,
		));
	}
	
	// Treatment actions
	public function actionViewTreatments() {
		$dataProvider=new CActiveDataProvider('OphCoTherapyapplication_Treatment');
		
		$this->render('list',array(
				'dataProvider'=>$dataProvider,
				'title'=>'Treatments',
		));
	}
	
	public function actionUpdateOphCoTherapyapplication_Treatment($id) {
		$model = OphCoTherapyapplication_Treatment::model()->findByPk((int)$id);
		
		if (isset($_POST['OphCoTherapyapplication_Treatment'])) {
			$model->attributes = $_POST['OphCoTherapyapplication_Treatment'];
			
			if ($model->save()) {
				Audit::add('OphCoTherapyapplication_Treatment','update', serialize($model->attributes));
				Yii::app()->user->setFlash('success', 'Treatment update');
				
				$this->redirect(array('viewtreatments'));
			}
		}
		
		$this->render('update', array(
				'model' => $model,
				'title'=>'Treatment'
		));
	}
	
	public function actionCreateOphCoTherapyapplication_Treatment() {
		$model = new OphCoTherapyapplication_Treatment();
		
		if (isset($_POST['OphCoTherapyapplication_Treatment'])) {
			// do the actual create
			$model->attributes = $_POST['OphCoTherapyapplication_Treatment'];
			
			if ($model->save()) {
				Audit::add('OphCoTherapyapplication_Treatment','create', serialize($model->attributes));
				Yii::app()->user->setFlash('success', 'Treatment created');
				
				$this->redirect(array('viewtreatments'));
			}
		}
		
		$this->render('create', array(
				'model' => $model,
				'title'=>'Treatment'
		));
	}
	
	// decision tree actions
	
	public function actionViewDecisionTrees() {
		$dataProvider=new CActiveDataProvider('OphCoTherapyapplication_DecisionTree');
		$this->render('list',array(
				'dataProvider'=>$dataProvider,
				'title'=>'Decision Trees',
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
	
	public function actionCreateOphCoTherapyapplication_DecisionTree() {
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
	
		$this->render('create',array(
				'model'=>$model,
				'title'=>'Decision Tree'
		));
	
	}
	
	// decision tree node actions
	
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

			if ($model->save()) {
				Audit::add('OphCoTherapyapplication_DecisionTreeNode','create', serialize($model->attributes));
				Yii::app()->user->setFlash('success', 'Decision Tree node created');
				
				$this->popupCloseAndRedirect(Yii::app()->createUrl('OphCoTherapyapplication/admin/viewdecisiontree', array('id'=>$model->decisiontree_id) ) . "/?node_id=" . $model->id );
			}
			
		}
		
		$this->renderPartial('create', array(
				'model' => $model,
				'decisiontree' => $tree,
		));
	}
	
	public function actionUpdateDecisionTreeNode($id) {
		$this->layout = "//layouts/admin_popup";
		
		$model = OphCoTherapyapplication_DecisionTreeNode::model()->findByPk((int)$id);
		
		if (isset($_POST['OphCoTherapyapplication_DecisionTreeNode'])) {
			$model->attributes = $_POST['OphCoTherapyapplication_DecisionTreeNode'];
			
			if ($model->save()) {
				Audit::add('OphCoTherapyapplication_DecisionTreeNode', 'update', serialize($model->attributes));
				Yii::app()->user->setFlash('success', 'Decision Tree node updated');
				
				$this->popupCloseAndRedirect(Yii::app()->createUrl('OphCoTherapyapplication/admin/viewdecisiontree', array('id'=>$model->decisiontree_id) ) . "/?node_id=" . $model->id );
			}
		}
		
		$this->render('update', array(
				'model' => $model,
		));
	}
	
	public function actionCreateDecisionTreeNodeRule($id) {
		$node = OphCoTherapyapplication_DecisionTreeNode::model()->findByPk((int)$id);
		
		$model = new OphCoTherapyapplication_DecisionTreeNodeRule();
		$model->node = $node;
		
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
	
	public function actionUpdateDecisionTreeNodeRule($id) {
		$model = OphCoTherapyapplication_DecisionTreeNodeRule::model()->findByPk((int)$id);
	
		if (isset($_POST['OphCoTherapyapplication_DecisionTreeNodeRule'])) {
			$model->attributes = $_POST['OphCoTherapyapplication_DecisionTreeNodeRule'];
				
			if ($model->save()) {
				Audit::add('OphCoTherapyapplication_DecisionTreeNodeRule', 'update', serialize($model->attributes));
				Yii::app()->user->setFlash('success', 'Decision Tree Node Rule updated');
	
				$this->redirect(array('viewdecisiontree', 'id' => $model->node->decisiontree_id, 'node_id' => $model->node->id));
			}
		}
	
		$this->renderPartial('create', array(
				'model' => $model,
				'node' => $model->node,
		));
	}
	
	// File Collections
	public function actionViewFileCollections() {
		$dataProvider=new CActiveDataProvider('OphCoTherapyapplication_FileCollection');
		$this->render('list',array(
				'dataProvider'=>$dataProvider,
				'title'=>'File Collections',
		));
	}
	
	public function actionViewOphCoTherapyapplication_FileCollection($id) {
		$model = OphCoTherapyapplication_FileCollection::model()->findByPk((int)$id);
		
		$this->render('view_' . get_class($model), array(
				'model' => $model)
		);
	}
	
	public function actionCreateOphCoTherapyapplication_FileCollection() {
		$model = new OphCoTherapyapplication_FileCollection();
		
		if (isset($_POST['OphCoTherapyapplication_FileCollection'])) {
			$model->attributes = $_POST['OphCoTherapyapplication_FileCollection'];

			// validate the model
			$model->validate();
			
			$file_errs = array();
			$files = array();
			foreach ($_FILES['OphCoTherapyapplication_FileCollection_files']['tmp_name'] as $i => $f) {
				if (!empty($_FILES['OphCoTherapyapplication_FileCollection_files']['error'][$i])) {
					$file_errs[] = "file $i had an error";
				}
				elseif (!empty($f) && is_uploaded_file($f)) {
					$name = $_FILES['OphCoTherapyapplication_FileCollection_files']['name'][$i];
					// check the file mimetype
					if (OphCoTherapyapplication_FileCollection::checkMimeType($f)) {
						$files[] = array('tmpfile' => $f, 'name' => $name);
					}
					else {
						$model->addError("files", "File $name is not a valid filetype");
					}
				}
			}

			// do the actual create
			if (!count($model->getErrors()) ) {
				$pfs = array();
				foreach ($files as $fdet) {
					$pf = ProtectedFile::createFromFile($fdet['tmpfile']);
					$pf->name = $fdet['name'];
					if ($pf->save()) {
						$pfs[] = $pf->id;
					}
					else {
						throw new Exception('Could not save file object');
						Yii::log("couldn't save file object" . print_r($pf->getErrors(), true), 'error');
					}
				}
				
				if ($model->save()) {
					
					$model->updateFiles($pfs);
					
					Audit::add('OphCoTherapyapplication_FileCollection','create', serialize($model->attributes));
					Yii::app()->user->setFlash('success', 'File Collection created');
					
					$this->redirect(array('viewfilecollections'));
				} else {
					//TODO: delete the files again
				}
			}
		}
		
		$this->render('create', array(
				'model' => $model,
				'title' => 'File Collection',
		));
	}
}

<?php

namespace app\actions\document;


use Yii;
use app\messages\Messages;
use app\models\UserMaster;
use yii\helpers\Json;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use app\actions\AbstractAction;
use app\util\Security;
use app\util\Access;
use app\util\MessageEnum;
use yii\web\UnauthorizedHttpException;



class DocumentList extends AbstractAction {

	
	public function run(){

		$this->execute();
		return parent::sendResponse();
	}

	public function execute()
	{
		
		$showRecord = MessageEnum::$access[MessageEnum::NoRecord];
		$access = Access::$access[Access::UserAccess];
		$model_class = Yii::$app->controller->modelClass;
		// This is how you get body params request and respectivly their value
		$requestData 	=   Yii::$app->getRequest()->getHeaders();
		$docMaster = new $model_class();

//correction required
		$docMaster = $docMaster->find()
				->andwhere(['doc_type' => $requestData['docType']])
				->andWhere(['owner_id' => $requestData['ownerId']])
				->all();
		if($docMaster != null){
			$this->responseData = $docMaster;
		}
		else{
			$this->exceptionCode = $showRecord['code'];
			$this->exceptionMessage = $showRecord['message'];
		}

	}
}

?>
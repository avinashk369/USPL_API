<?php

namespace app\actions\user;


use Yii;
use app\messages\Messages;
use app\models\UserAccess;
use yii\helpers\Json;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use app\actions\AbstractAction;
use app\util\Security;
use app\util\Access;
use app\util\MessageEnum;
use yii\web\UnauthorizedHttpException;



class UserAccessList extends AbstractAction {

	public function run(){
		
		$this->execute();
		return parent::sendResponse();
	}

	public function execute()
	{
		
		$showRecord = MessageEnum::$access[MessageEnum::NoRecord];
		$requestData 	=   Yii::$app->getRequest()->getHeaders()->get('userId');
		$model = new UserAccess();
		$data = $model->find()->all();
		if($data != null){
			//$data = json::encode(array(explode("\\",$model_class)[2]=>$data))
			$this->responseData = $data;
		}
		else{
			$this->exceptionCode = $showRecord['code'];
			$this->exceptionMessage = $showRecord['message'];
		}
	}
}

?>
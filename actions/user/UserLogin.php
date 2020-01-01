<?php

namespace app\actions\user;


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



class UserLogin extends AbstractAction {

	
	public function run(){

		$this->execute();
		return parent::sendResponse();
	}

	public function execute()
	{
		
		$model_class = Yii::$app->controller->modelClass;
		$access = Access::$access[Access::UserAccess];
		$user_login = MessageEnum::$access[MessageEnum::UserLogin];
		$api_key = $access['apiSecret'];
		$sha256 = hash('sha256', $api_key.Security::getTimeNDate(), true);
		$authToken = bin2hex($sha256);

		// This is how you get body params request and respectivly their value
		$request = Yii::$app->request->getBodyParams();

		$model = new $model_class();
		$model = $model->find()
					->where(['email'=>$request['email']])
					->one();

		$access = Access::$access[Access::UserAccess];
		$user_login = MessageEnum::$access[MessageEnum::UserLogin];
		$api_key = $access['apiKey'];
		$sha256 = hash('sha256', $api_key.Security::getTimeNDate(), true);
		$authToken = bin2hex($sha256);

		$encryptedPassword = bin2hex(hash('sha256', $request['password'].$api_key, true));	

		
		
		if(is_null($model)){
			$this->exceptionCode = "501";
			$this->exceptionMessage = $user_login['message'];
		}
		else if($encryptedPassword===$model['password'])
		{
			$this->responseData = $model;

		}
		else{
			$this->exceptionCode = $user_login['code'];
			$this->exceptionMessage = $user_login['message'];
		}

	}
}

?>
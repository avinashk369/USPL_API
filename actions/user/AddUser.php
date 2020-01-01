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



class AddUser extends AbstractAction {

	
	public function run(){

		$this->execute();
		return parent::sendResponse();
	}

	public function execute()
	{
		
		$showPassowrd = MessageEnum::$access[MessageEnum::password];
		$access = Access::$access[Access::UserAccess];
		$model_class = Yii::$app->controller->modelClass;
		// This is how you get body params request and respectivly their value
		$request = Yii::$app->request->getBodyParams();
		$userMaster = new $model_class();
		$userMaster->load($request,'');

		
		$api_key = $access['apiKey'];
		$sha256 = hash('sha256', $api_key.Security::getTimeNDate(), true);
		$authToken = bin2hex($sha256);
		$userMaster->password = bin2hex(hash('sha256', $userMaster->password.$api_key, true));	
		

		$times = Security::getTimeNDate();
		$userMaster->created_on = $times;
		/*if(substr($request['flags'], 0,1) == "1")
			$userMaster->flags = substr_replace($userMaster->flags,"1",4,5);*/
		if($userMaster->save())
		{

			/*$emailSend = new SendEmail();
			$emailSend->registrationEmail($userMaster->email,$userMaster->mobile,$userMaster->name,$request['password']);*/
			
			$this->responseData = $userMaster;
		}
		else{
			foreach($userMaster->getErrors() as $error=>$msg)
				foreach($msg as $v=>$m)
					$userMaster->error = $m;
			
			throw new UnauthorizedHttpException($userMaster->error);
		}

	}
}

?>
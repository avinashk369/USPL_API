<?php

namespace app\actions\user;


use Yii;
use yii\helpers\Json;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use app\util\MessageEnum;
use app\actions\AbstractAction;

/**
	Api description -  This Api will accept string id in header and show that row if it exits
	Api URL - http://192.168.43.193/techcamino/api/sod/web/index.php/any valid controller name [i.e - user,service]/show;
	Optional url = http://192.168.43.193/techcamino/api/sod/web/index.php/user/show?id=sodum000000000000018;
	Api Param - @Header Param
	Api Method - Get
	return type Json
**/

class UserDetail extends AbstractAction {


	public function run(){

		$this->execute();
		return parent::sendResponse();
	}

	public function execute()
	{
		
		$showRecord = MessageEnum::$access[MessageEnum::NoRecord];
		$model_class = Yii::$app->controller->modelClass;
		// This is how you get header params request and respectivly their value
		$requestData 	=   Yii::$app->getRequest()->getHeaders()->get('userId');
		$model = new $model_class();

		$data = $model->find()
				->where(['id' => $requestData])
				->with(['store','region','brand','access'])
				->asArray()
				->one();
				
		if($data != null){
			$this->responseData = $data;
		}
		else{
			$this->exceptionCode = $showRecord['code'];
			$this->exceptionMessage = $showRecord['message'];
		}
		
	}
}

?>
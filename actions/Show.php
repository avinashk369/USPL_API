<?php

namespace app\actions;


use Yii;
use yii\helpers\Json;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use app\util\MessageEnum;

/**
	Api description -  This Api will accept string id in header and show that row if it exits
	Api URL - http://192.168.43.193/techcamino/api/sod/web/index.php/any valid controller name [i.e - user,service]/show;
	Optional url = http://192.168.43.193/techcamino/api/sod/web/index.php/user/show?id=sodum000000000000018;
	Api Param - @Header Param
	Api Method - Get
	return type Json
**/

class Show extends AbstractAction {

	public $viewName = 'index';
	public function run(){

		$this->execute();
		return parent::sendResponse();
	}

	public function execute()
	{
		
		$showRecord = MessageEnum::$access[MessageEnum::NoRecord];
		$model_class = Yii::$app->controller->modelClass;
		// This is how you get header params request and respectivly their value
		$requestData 	=   Yii::$app->getRequest()->getHeaders()->get('id');
		$model = new $model_class();

		$data = $model->find()
				->where(['id' => $requestData])
				->with(['store'])
				->asArray()
				->one();
				
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
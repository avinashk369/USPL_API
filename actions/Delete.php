<?php

namespace app\actions;


use Yii;
use yii\helpers\Json;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use app\util\MessageEnum;

/**
	Api description -  This Api will accept string id in header and delete that row if it exits
	Api URL - http://192.168.43.193/techcamino/api/sod/web/index.php/any valid controller name [i.e - user,service]/delete;
	Api Param - @Header Param
	Api Method - DELETE
	return type Json
**/

class Delete extends AbstractAction {

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
		$data = $model->findOne($requestData);
		
		if($data!=null){
			$data->delete();
			$this->responseData = array("message"=>"success");
		}
		else{
			$this->exceptionCode = $showRecord['code'];
			$this->exceptionMessage = $showRecord['message'];
		}
		
	}
}

?>
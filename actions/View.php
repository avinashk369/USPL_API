<?php

/**
 * @author gencyolcu
 * @copyright 2013
 */
namespace app\actions;


use Yii;
use app\models\SodUserMaster;
use app\messages\MessageDetail;
use app\messages\Messages;
use yii\helpers\Json;
use app\util\security;
use app\util\MessageEnum;

/**
	Api description -  This Api will accept auth token and other verification key in header and show as many row exits
	Api URL - http://192.168.43.193/techcamino/api/sod/web/index.php/any valid controller name [i.e - user,service]/view;
	Api Param - @Header Param
	Api Method - Get
	return type Json
**/

class View extends AbstractAction
{
	public $viewName = 'index';
	public function run(){

		$this->execute();
		return parent::sendResponse();
	}

	public function execute()
	{
		
		$showRecord = MessageEnum::$access[MessageEnum::NoRecord];
		$model_class = Yii::$app->controller->modelClass;
		
		$model = new $model_class();
		$data = $model->find()
				->with(['store','region','brand','access'])
				->asArray()
				->all();
		//$data = $model->find()->with(['authtokenDetail','userImage'])->asArray()->all(); // Make a separate action class for custom view data
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
<?php

namespace app\actions\imageverify;


use Yii;
use app\messages\Messages;
use yii\helpers\Json;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use app\actions\AbstractAction;
use app\actions\imageverify\CompareImages;
use app\util\Security;
use app\util\Access;
use app\util\MessageEnum;
use yii\web\UnauthorizedHttpException;



class ImageVerify extends AbstractAction {

	
	public function run(){

		$this->execute();
		return parent::sendResponse();
	}

	public function execute()
	{
		$a = __DIR__.'/../../img/b.jpg'; // replace this image with requested image
		
		$model_class = Yii::$app->controller->modelClass;
		$requestData 	=   Yii::$app->getRequest()->getHeaders();

		$compareImage = new compareImages();
		$jpg_files = glob(__DIR__."/*.{jpg,png}",GLOB_BRACE);
		
		$mathImg;
		foreach($jpg_files as $img)
		{
			$diff =  $compareImage->compare($a,$img);
			echo $diff." - ". $img;
			echo "\n";
			if($diff<=10){
				$mathImg = $img;
			}
		}
		die;
		if($mathImg != ""){
			$this->responseData = $mathImg;
		}
		else{
				throw new UnauthorizedHttpException("Wrong image sent");
			}
		
	}
}

?>
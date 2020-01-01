<?php

namespace app\actions\img;


use Yii;
use app\messages\Messages;
use yii\helpers\Json;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use app\actions\AbstractAction;
use app\util\Security;
use app\util\Access;
use app\util\MessageEnum;
use yii\web\UnauthorizedHttpException;

class UploadImage extends AbstractAction {

	public function run(){

		$this->execute();
		return parent::sendResponse();
	}

	public function execute()
	{
		
		$request = Yii::$app->request->getBodyParams();
		$decodedImage = base64_decode($request['user_file']);
		
		$filePath = __DIR__."/".$request['folder_name']."/";
		$filesName = $filePath.$request['owner_id'].".jpg";

		if (!file_exists($filePath)) {
		    
			   mkdir($filePath, 0777, true);
			}

		file_put_contents($filesName, $decodedImage);

		if(file_exists($filesName)){
			return $this->responseData = $filesName;
		}
		

		
	}
}

?>
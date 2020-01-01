<?php

namespace app\actions\inventory;


use Yii;
use app\messages\Messages;
use app\models\InventoryMaster;
use yii\helpers\Json;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use app\actions\AbstractAction;
use app\util\Security;
use app\util\Access;
use app\util\SimpleXLSX;
use app\util\MessageEnum;
use yii\web\UnauthorizedHttpException;



class GetInventoryReport extends AbstractAction {

	public function run(){
		
		$this->execute();
		return parent::sendResponse();
	}

	public function execute()
	{
		
		$showRecord = MessageEnum::$access[MessageEnum::NoRecord];
		$requestData = Yii::$app->getRequest()->getHeaders();

		$model = new InventoryMaster();
		$data = $model->find()
				->andWhere(['owner_id' => $requestData['ownerId']]);
				if(!is_null($requestData['productType'])){
					$data->andwhere(['product_type' => $requestData['productType']]);
				}
		$data = $data->limit($requestData['limit']) // limited row 10
				->offset($requestData['offset']) // starting 0
				//->asArray()
				->all();
				
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
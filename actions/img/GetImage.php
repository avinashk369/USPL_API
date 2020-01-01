<?php

/**
 * @author gencyolcu
 * @copyright 2013
 */
namespace app\actions\img;
use yii\db\Query;


use Yii;
use app\models\ImageMaster;
use app\actions\AbstractAction;
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

class GetImage extends AbstractAction
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
		$requestData 	=   Yii::$app->getRequest()->getHeaders();//->get('userAccess');
		//$storeId 	=   Yii::$app->getRequest()->getHeaders()->get('storeId');
		$model = new $model_class();
		/*$model = $model->find()
				->joinwith(['store'])
				->andwhere(['user_access' => $requestData['userAccess']]);
				if(!is_null($requestData['storeId'])){
					$model->andwhere(['store_id' => $requestData['storeId']]);
				}
		$model = $model
				->asArray()
				->all();*/
				$query = new Query;
				$query	->select([
				        'im.id  id', 
				        'im.owner_id owner_id',
				        'im.image_path image_path',
				        'im.user_access user_access',
				        'im.store_id store_id',
				        'im.created_on created_on',
				        'sm.name storeName',
				        'sm.id storeId',
				        'rm.id regionId',
				        'rm.name regionName',
				        'bm.id brandId',
				        'bm.brand_name brandName' ]
				        )  
				        ->from('image_master im')
				        ->join('LEFT JOIN', 'store_master sm',
				            'sm.id =im.store_id')
			            ->join('LEFT JOIN', 'brand_master bm',
			            'bm.id =sm.brand_id')		
				        ->join('LEFT JOIN', 'region_master rm', 
				            'rm.id =sm.region_id')
				        ->andwhere(['im.user_access' => $requestData['userAccess']]); 
		        
		        if(!is_null($requestData['storeId'])){
					$query->andwhere(['im.store_id' => $requestData['storeId']]);
				}
				$query->OrderBy(['im.created_on' => SORT_DESC]);
						
				$command = $query->createCommand();
				$model = $command->queryAll();
		//$data = $model->find()->with(['authtokenDetail','userImage'])->asArray()->all(); // Make a separate action class for custom view data
		if($model != null){
			$this->responseData = $model;
		}
		else{
			$this->exceptionCode = $showRecord['code'];
			$this->exceptionMessage = $showRecord['message'];
		}
		
	}
}

?>
<?php
namespace app\filters;

use yii;
use yii\base\Behavior;
use yii\base\ActionFilter;
use app\models\UserMaster;
use yii\web\UnauthorizedHttpException;

use app\util\MessageEnum;

/**
 *
 * @author sushil
 * Requset filter  for authorization on the basis of API_KEY and SECRET_KEY
 *
 */

class AuthTokenFilter extends ActionFilter
{
	/**
	 * @var Request the current request. If not set, the `request` application component will be used.
	 */
	public $request;
	/**
	 * @var Response the response to be sent. If not set, the `response` application component will be used.
	 */
	public $response;

	public function beforeAction($action)
	{
		$this->processAuthorization();	
		return true;
	}

	public function processAuthorization()
	{
		$request   	=  	$this->request ? : Yii::$app->getRequest();
		$response 	=  	$this->response ? : Yii::$app->getResponse();

		$unauthAccess = MessageEnum::$access[MessageEnum::unauthorised];
		$invalidAuth = MessageEnum::$access[MessageEnum::authToken];

		//echo $unauthAccess['message'];

		/**
		 * getting data from headers and queryparams
		*/
		$headers   			= 	$request->getHeaders();
		/*print_r($headers );
		die;*/
		$authtoken 			= 	$headers->get('authtoken');

		$model = new UserMaster();
		$model = $model->find()
					->joinwith(['storeDetails'])
					->andWhere(['user_master.id'=> $headers->get('id')])
					->andWhere(['SUBSTR(user_master.flags,1,1)'=> ["1","2","3"]])
					->asArray()
					->one();

				if(!is_null($model['storeDetails'])){
					
					if(substr($model['storeDetails']['flags'], 3,4)!="1")
					{
						throw new UnauthorizedHttpException('Please login');
					}
				}
				if(!is_null($model)){
					
					if(substr($model['flags'], 3,4)!="1")
					{
						throw new UnauthorizedHttpException('Please login');
					}
				}


		if (isset($authtoken) && !empty($authtoken))
		{
			
		}
		else
			throw new UnauthorizedHttpException('You are requesting with an invalid Auth Token.');
	}
}
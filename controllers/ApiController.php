<?php

namespace app\controllers;

use Yii;

use yii\filters\VerbFilter;
use app\filters\AuthTokenFilter;
use yii\filters\AccessControl;
use yii\rest\ActiveController;
use yii\helpers\Json;
use yii\web\Response;


class ApiController extends ActiveController{

	
	public function behaviors()
	{
	   $behaviors= [ 
			           	'contentNegotiator'=> [
											   'class' =>'yii\filters\ContentNegotiator',
											   'formats' => [
													            'application/json' => Response::FORMAT_JSON,
													            'application/xml' => Response::FORMAT_XML,
											   		           /// 'text/html' => Response::FORMAT_HTML,
											   		         ],
				                               ],   
				        'verbs' => [
					                  'class' => \yii\filters\VerbFilter::className(),
					                  'actions' => [
					                      'view'   => ['get'],
					                      'show' => ['get'],
					                      'add' => ['post'],
					                      'read' => ['get'],
					                      'delete' => ['delete'],
					                  ],
					              ],
				       //'authorization'=> ['class'=>app\filters\AuthorizationFilter::className()],
				       // 'authTokenAuthorization'=>['class'=>'app\filters\AuthTokenFilter']
				     ];
		return $behaviors;

		
	}

	public  function actions()
    {
        return $actions = [
                      'view'   =>    ['class' => 'app\actions\View'],     //View Action
                      'show'   =>    ['class' => 'app\actions\Show'],     //Show by id Action
                      'delete'   =>    ['class' => 'app\actions\Delete'],     //Create new user Action
                      'read'   =>	 ['class' => 'app\actions\ReadJson'],
                   ];
        
    }

	
}
?>
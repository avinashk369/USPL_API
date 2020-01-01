<?php

namespace app\controllers;

use yii;
use app\controllers\ApiController;
use yii\helpers\ArrayHelper;
use app;

class UserController extends ApiController
{
	public $modelClass = 'app\models\UserMaster';

    public function behaviors()
    {
        $behaviors= [ 
                    
                'verbs' => [
                  'class' => \yii\filters\VerbFilter::className(),
                  'actions' => [
                      
                      'verify' => ['post'],
                      'add' => ['post'],
                      'upload' => ['post'],
                      'test' => ['post'],
                      'dbcleanup' => ['post'],
                      'access' => ['get'],
                      'login' => ['post'],
                      'detail' => ['get'],
                      'fcm' => ['post'],
                      'inventory' => ['post']
                  ],
              ],
             ];

        return ArrayHelper::merge($behaviors,parent::behaviors());
    }
    public  function actions()
    {
        return array_merge(
            parent::actions(), 
            $actions = [
              'inventory' => ['class' => 'app\actions\user\UpdateInventory'],
              'fcm'   =>    ['class' => 'app\actions\user\FCMNotification'],
                      'verify'   =>    ['class' => 'app\actions\imageverify\ImageVerify'],
                      'add'      =>    ['class' => 'app\actions\user\AddUser'],
                      'test'      =>    ['class' => 'app\actions\user\Testing'],
                      'dbcleanup'      =>    ['class' => 'app\actions\user\DBCleanup'],
                      'access'      =>    ['class' => 'app\actions\user\UserAccessList'],
                      'login'      =>    ['class' => 'app\actions\user\UserLogin'],
                      'detail'      =>    ['class' => 'app\actions\user\UserDetail'],
                      'upload'   =>    ['class' => 'app\actions\imageverify\UploadMultipleImage'],
                   ]);
        
    }
}

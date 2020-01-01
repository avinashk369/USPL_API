<?php

namespace app\controllers;

use yii;
use app\controllers\ApiController;
use yii\helpers\ArrayHelper;
use app;

class ImageController extends ApiController
{
	public $modelClass = 'app\models\ImageMaster';

    public function behaviors()
    {
        
        $behaviors= [ 
                    
                'verbs' => [
                  'class' => \yii\filters\VerbFilter::className(),
                  'actions' => [
                      
                      'upload' => ['post'],
                      'gallery' => ['get'],
                      'bulk' => ['post'],
                      'pdf'  =>['post'],
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
                      'bulk'     =>    ['class' => 'app\actions\img\UploadMultipleImage'],
                      'pdf'       => ['class' => 'app\actions\img\UploadFile'],
                      'gallery'    =>    ['class' => 'app\actions\img\GetImage'],     //
                      'upload'   =>    ['class' => 'app\actions\img\UploadImage'],     //Create new 
                   ]);
        
    }


}

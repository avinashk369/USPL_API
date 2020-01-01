<?php

namespace app\controllers;

use yii;
use app\controllers\ApiController;
use yii\helpers\ArrayHelper;
use app;

class DocumentController extends ApiController
{
	public $modelClass = 'app\models\DocumentMaster';

    public function behaviors()
    {
        $behaviors= [ 
                    
                'verbs' => [
                  'class' => \yii\filters\VerbFilter::className(),
                  'actions' => [
                      
                      'list' => ['get'],
                      'download' => ['get'],
                      'upload' => ['post']
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
                    'list'     =>    ['class' => 'app\actions\document\DocumentList'],
                    'download' =>    ['class' => 'app\actions\document\DownloadDocument'],
                    'upload'   =>    ['class' => 'app\actions\document\UploadDocument'],
                   ]);
        
    }
}

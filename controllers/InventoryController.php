<?php

namespace app\controllers;

use yii;
use app\controllers\ApiController;
use yii\helpers\ArrayHelper;
use app;

class InventoryController extends ApiController
{
	public $modelClass = 'app\models\InventoryMaster';

    public function behaviors()
    {
        $behaviors= [ 
                    
                'verbs' => [
                  'class' => \yii\filters\VerbFilter::className(),
                  'actions' => [
                      
                      'report' => ['get'],
                      'download' => ['get'],
                      'update' => ['post']
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
                    'report'     =>    ['class' => 'app\actions\inventory\GetInventoryReport'],
                    'download' =>    ['class' => 'app\actions\document\DownloadDocument'],
                    'update'   =>    ['class' => 'app\actions\inventory\UpdateInventory'],
                   ]);
        
    }
}

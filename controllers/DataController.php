<?php

namespace app\controllers;

use yii;
use app\controllers\ApiController;
use yii\helpers\ArrayHelper;
use app;

class DataController extends ApiController
{
	public $modelClass = 'app\models\UserMaster';

    public function behaviors()
    {
        $behaviors= [ 
                    
                'verbs' => [
                  'class' => \yii\filters\VerbFilter::className(),
                  'actions' => [
                      
                      'region' => ['get'],
                      'brand' => ['get'],
                      'store' => ['get']
                      
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
                      'region'   =>    ['class' => 'app\actions\dataList\GetRegion'],
                      'brand'    =>    ['class' => 'app\actions\dataList\GetBrand'],
                      'store'    =>    ['class' => 'app\actions\dataList\GetStore'],
                   ]);
        
    }
}

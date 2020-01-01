<?php

namespace app\actions;


use Yii;
use yii\helpers\Json;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use app\util\MessageEnum;
use app\models\StateMaster;
use app\models\CityMaster;


class ReadJson extends AbstractAction {

	public $viewName = 'index';
	public function run(){

		$this->execute();
	}

	public function execute()
	{
		
		// Read JSON file
		$json = file_get_contents(__DIR__.'/national.json');
		//Decode JSON
		$json_data = json_decode($json,false);
		
		foreach($json_data as $error=>$msg){
			$stateMaster = new StateMaster();
			$stateMaster->name = $error; 
			if($stateMaster->save()){
				foreach($msg as $v=>$m)
				{
					$cityMaster = new CityMaster();
					$cityMaster->state_id = $stateMaster->id;
					$cityMaster->name = $m;
					$cityMaster->save();
 				}
				
			}
		}
	}
}

?>
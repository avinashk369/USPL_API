<?php

namespace app\actions\user;


use Yii;
use app\messages\Messages;
use app\models\BrandMaster;
use app\models\StoreMaster;
use app\models\RegionMaster;
use yii\helpers\Json;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use app\actions\AbstractAction;
use app\util\Security;
use app\util\Access;
use app\util\SimpleXLSX;
use app\util\MessageEnum;
use yii\web\UnauthorizedHttpException;



class DBCleanup extends AbstractAction {

	private $regionName;
	private $brandId;
	private $regionId;
	
	public function run(){
		
		ini_set('error_reporting', E_ALL);
		ini_set('display_errors', true);

		$this->execute();
		return parent::sendResponse();
	}

	public function execute()
	{
		
		if ( $xlsx = SimpleXLSX::parse(__DIR__.'/demo_xls.xlsx') ) {

			$dim = $xlsx->dimension();
			$num_cols = $dim[0];
			$num_rows = $dim[1];

			$data = [];
			for($i=0;$i<sizeof($xlsx->sheetNames());$i++){
				$header_values = $rows = [];
				foreach ( $xlsx->rows( $i ) as $k => $r ) {

						if ( $k === 0 ) {
							$header_values = $r;
							continue;
						}

						$rows[] = array_combine( $header_values, $r );

					}
				$data[$xlsx->sheetNames()[$i]] = $rows;
			}
			

/*print_r($data);
die;*/

			
			foreach ( $data as $k => $r ){
				// save brand here
				$brandMaster = new BrandMaster();
				$brandMaster->brand_name = $k;
				$brandMaster->created_on = Security::getTimeNDate();
				$brandMaster->save();
				$this->brandId = $brandMaster->getPrimaryKey();

				foreach ( $r as $k => $v ){
					if(!empty($v['REGION'])){
						//check if region already exist or not then save region master here
						$regionMaster = new RegionMaster();
						$regionMaster->name = $v['REGION'];
						$regionMaster->created_on = Security::getTimeNDate();
						if($regionMaster->save()){
							/*foreach($regionMaster->getErrors() as $error=>$msg)
								foreach($msg as $v=>$m)
									echo $m;*/
									$this->regionId = $regionMaster->getPrimaryKey();
						}else{
							$regionMaster = RegionMaster::find()
								    ->select(['id'])
								    ->where(['name' => $v['REGION']])
								    ->one();
								    $this->regionId=$regionMaster->id; 
						}
					}

						//save store master here
						$storeMaster = new StoreMaster();
						$storeMaster->name = $v['STORE_NAME'];
						$storeMaster->created_on = Security::getTimeNDate();
						$storeMaster->region_id = $this->regionId;
						$storeMaster->brand_id = $this->brandId;
						$storeMaster->save();
						//$regionId = $regionMaster->getPrimaryKey();
						/*echo $v['STORE_NAME'];
						echo "\n";
						echo (!empty($v['WROGN']) ? $v['WROGN'] : '');
						echo "\n";
						echo $v['IMARA'];
						echo "\n";*/
				}
					
			}
			
		} else {
			echo SimpleXLSX::parseError();
		}
	}
}

?>
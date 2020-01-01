<?php

namespace app\actions\user;


use Yii;
use app\messages\Messages;
use app\models\BrandMaster;
use app\models\StoreMaster;
use app\models\ProductTypeMaster;
use app\models\InventoryMaster;
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



class Testing extends AbstractAction {

	private $regionName;
	private $brandId;
	private $regionId;
	
	public function run(){
		
		/*ini_set('error_reporting', E_ALL);
		ini_set('display_errors', true);*/

		$this->execute();
		return parent::sendResponse();
	}

public function execute(){

        if(isset($_POST['folder_name'])){
            //$target_path = dirname(__FILE__).'/'.$_POST['folder_name'].'/';
            $target_path = __DIR__."/".$_POST['folder_name']."/";

            if (!file_exists($target_path)) {
                    mkdir($target_path, 0777, true);
                }
                
            $request = Yii::$app->request->getBodyParams();
            for($i = 0; $i < count ( $_FILES ['file'] ['name'] ); $i ++) {

                try {
                    if (move_uploaded_file( $_FILES ['file'] ["tmp_name"][$i], $target_path . $_FILES ["file"] ["name"][$i] )) {
                
                        $this->uploadXls($target_path.$_FILES ["file"] ["name"][$i] );
                    } else {
                        $result = array("success" => "error uploading file");
                        throw new Exception('Could not move file');
                    }
                } catch (Exception $e) {
                    die('File did not upload: ' . $e->getMessage());
                }
            }
        }
    else{
                $result = array("success" => "error uploading file");
                return $this->responseData = $result;
        }
}

	public function uploadXls($filePath)
	{
		
		if ( $xlsx = SimpleXLSX::parse($filePath) ) {

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
			
			foreach ( $data as $k => $r ){

				foreach ( $r as $k => $v ){

						$productTypeMaster = ProductTypeMaster::find()
								    ->select(['id'])
								    ->where(['name' => $v['Type of Product']])
								    ->one();

						if(is_null($productTypeMaster)){
							$productTypeMaster = new ProductTypeMaster();
							$productTypeMaster->name = $v['Type of Product'];
							$productTypeMaster->created_on = Security::getTimeNDate();
							if(!$productTypeMaster->save()){
								foreach($productTypeMaster->getErrors() as $error=>$msg)
											foreach($msg as $v=>$m)
												throw new UnauthorizedHttpException($m);
							}
						}
						
						$inventoryMaster = new InventoryMaster();
						$inventoryMaster->in_stock_date = $v['Date '];
						$inventoryMaster->product_type = $v['Type of Product'];
						$inventoryMaster->quantity_available = $v['Available Quantity'];
						$inventoryMaster->quantity_required = $v['Required Quantity'];
						$inventoryMaster->created_on = Security::getTimeNDate();

						$fQty = $v['Required Quantity'] - $v['Available Quantity'];
						$inventoryMaster->quantity_excess = ($fQty < 0) ? $fQty : 0;
						$inventoryMaster->quantity_short = ($fQty > 0) ? $fQty : 0;
						

						if(!$inventoryMaster->save()){
							foreach($inventoryMaster->getErrors() as $error=>$msg)
											foreach($msg as $v=>$m)
												throw new UnauthorizedHttpException($m);
						}
						
				}
					
			}

			
			if (file_exists($filePath)) {
                    
                    if (!unlink($filePath)) {  
				    throw new UnauthorizedHttpException("Error deleting file");  
					}  
					else {  
					    $this->responseData = $inventoryMaster;  
					}
                }
			 
			
		} else {
			echo SimpleXLSX::parseError();
		}
	}
}

?>
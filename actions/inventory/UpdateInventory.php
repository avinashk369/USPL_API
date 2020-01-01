<?php

namespace app\actions\inventory;


use Yii;
use yii\db\Query;
use app\messages\Messages;
use app\models\BrandMaster;
use app\models\StoreMaster;
use app\models\DocumentMaster;
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



class UpdateInventory extends AbstractAction {

	private $ownerId;
	private $channelId;
	private $storeId;
	private $productTypeId;
	
	public function run(){
		
		ini_set('error_reporting', E_ALL);
		ini_set('display_errors', true);

		$this->execute();
		return parent::sendResponse();
	}

	public function execute()
	{
		
		if(isset($_POST['folder_name'])){
			$ownerId = $_POST['owner_id'];
            //$target_path = dirname(__FILE__).'/'.$_POST['folder_name'].'/';
            $target_path = __DIR__."/".$_POST['folder_name']."/";

            if (!file_exists($target_path)) {
                    mkdir($target_path, 0777, true);
                }
                
            $request = Yii::$app->request->getBodyParams();
            //for($i = 0; $i < count ( $_FILES ['file'] ['name'] ); $i ++) {
                try {
                    if (move_uploaded_file( $_FILES ['file'] ["tmp_name"], $target_path . $_FILES ["file"] ["name"] )) {

                    	$document = new DocumentMaster();
                        $document->owner_id = $_POST['owner_id'];
                        $document->path = $_FILES ["file"] ["name"];
                        $document->doc_type = $_POST['doc_type'];
                        $times = Security::getTimeNDate();
                        $document->created_on = $times;
                        if($document->save()){
                            $this->uploadXls($target_path.$_FILES ["file"] ["name"],
                            	$ownerId );
                        }else{
                            throw new Exception('Could not save DB');
                        }

                        
                    } else {
                        $result = array("success" => "error uploading file");
                        throw new Exception('Could not move file');
                    }
                } catch (Exception $e) {
                    die('File did not upload: ' . $e->getMessage());
                }
            //}
        }
    else{
                $result = array("success" => "error uploading file");
                return $this->responseData = $result;
        }
	}

	public function uploadXls($filePath,$ownerId)
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

						/*$storeMaster = StoreMaster::find()
								    ->select(['id'])
								    ->where(['name' => $v['Store Name']])
								    ->one();

								    $storeId = $storeMaster->id;

					    $channelMaster = BrandMaster::find()
								    ->select(['id'])
								    ->where(['brand_name' => $v['Channel Name']])
								    ->one();

								    $channelId = $channelMaster->id;*/
				

							$productTypeMaster = new ProductTypeMaster();
							$productTypeMaster->name = $v['Type of Product'];
							$productTypeMaster->created_on = Security::getTimeNDate();
							/*if(!$productTypeMaster->save()){
								foreach($productTypeMaster->getErrors() as $error=>$msg)
											foreach($msg as $v=>$m)
												throw new UnauthorizedHttpException($m);
										}*/
						if($productTypeMaster->save()){
							$this->productTypeId = $productTypeMaster->getPrimaryKey();
						}else{

							$productTypeMaster = ProductTypeMaster::find()
							    ->select(['id'])
							    ->where(['name' => $v['Type of Product']])
							    ->one();

							$this->productTypeId = $productTypeMaster->id;
							
						}
						
						$inventoryMaster = new InventoryMaster();
						$inventoryMaster->in_stock_date = $v['Date '];
						$inventoryMaster->product_type = $this->productTypeId;
						$inventoryMaster->quantity_available = $v['Available Quantity'];
						$inventoryMaster->quantity_required = $v['Required Quantity'];
						//$inventoryMaster->channel_name = $v['Channel Name'];
						$inventoryMaster->store_name = $v['Store Name'];
						$inventoryMaster->owner_id = $ownerId;
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
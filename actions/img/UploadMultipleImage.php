<?php

namespace app\actions\img;


use Yii;
use app\models\ImageMaster;
use app\models\AuthtokenMaster;
use app\messages\Messages;
use yii\helpers\Json;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use app\actions\AbstractAction;
use app\util\Security;
use app\util\Access;
use app\util\MessageEnum;
use yii\web\UnauthorizedHttpException;


class UploadMultipleImage extends AbstractAction {

	public function run(){

		$this->execute();
		return parent::sendResponse();
	}

	public function execute()
	{
		//$target_path = dirname(__FILE__).'/'.$_POST['folder_name'].'/';
		$target_path = __DIR__."/".$_POST['folder_name']."/";

		if (!file_exists($target_path)) {
			    mkdir($target_path, 0777, true);
			}
			
			/*$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
			fwrite($myfile, $_POST['email']);
			$txt = "\n";
			fwrite($myfile, $txt);
			fclose($myfile);*/

		$request = Yii::$app->request->getBodyParams();
		for($i = 0; $i < count ( $_FILES ['file'] ['name'] ); $i ++) {

			try {
				if (move_uploaded_file( $_FILES ['file'] ["tmp_name"][$i], $target_path . $_FILES ["file"] ["name"][$i] )) {
					
					//$newPath = split("@", $_FILES ["file"] ["name"][$i]);
					$image = new ImageMaster();
					$image->owner_id = $_POST['owner_id'];
					$image->user_access = $_POST['user_access'];
					$image->store_id = $_POST['store_id'];
					$image->image_path = $_FILES ["file"] ["name"][$i];
					$times = Security::getTimeNDate();
					$image->created_on = $times;
					$image->save();
					$result = $image;
					//return $this->responseData = $image;

					//$result = array("success" => "File successfully uploaded");
				} else {
					$result = array("success" => "error uploading file");
					throw new Exception('Could not move file');
				}
			} catch (Exception $e) {
		    	die('File did not upload: ' . $e->getMessage());
			}
			
		}
		return $this->responseData = $result;

	}
}

?>
<?php

namespace app\actions\imageverify;


use Yii;
use app\messages\Messages;
use yii\helpers\Json;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use app\actions\AbstractAction;
use app\actions\imageverify\CompareImages;
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
		

		$request = Yii::$app->request->getBodyParams();
		
		$decodedImage = base64_decode($request['user_file']);
		
		$filePath = __DIR__."/".$request['folder_name']."/";
		$filesName = $filePath.$request['owner_id'].".jpg";
		$searchPath = __DIR__."/image_DB/";
		

		if (!file_exists($filePath)) {
		    
			   mkdir($filePath, 0777, true);
			}


		file_put_contents($filesName, $decodedImage);

		if(file_exists($filesName)){

			$compareImage = new compareImages();
			$jpg_files = glob($searchPath."/*.{jpg,png}",GLOB_BRACE);
				
				$matchImage = "";
				$originalImage = "";

				foreach($jpg_files as $img)	{

					$diff =  $compareImage->compare($filesName,$img);
					if($diff<10){
						$urlsPlit = explode("/", $img);
						$matchImage = $urlsPlit[sizeof($urlsPlit)-1];
						$originUrl = explode("/", $filesName);
						$originalImage = $originUrl[sizeof($originUrl)-1];
					}
				}

				$urls = "http://altimage.tk/API/actions/imageverify/uploaded/".$originalImage;
				$originU = "http://altimage.tk/API/actions/imageverify/image_DB/".$matchImage;
						$this->sendNotification($request['deviceId'],$urls,$originU);

			$result = array("success" => "uploading done");
			return $this->responseData = $result;

		}
	
	}

	public function sendNotification($deviceId,$urlPath,$orginImage)
	{
		
		$server_key = 'AAAA1RCZtKw:APA91bEUikcob9JpgNHMxZvKamlOA7frf4h9I3GvyX76CddJq_9JKScPAneiTVBbVfC5GKnU5lO4w9nZy1wcP7rlptMWreR3AyX9KXicfNcyrSgmyVf5o0mZJiyZZ9Cylu50EOhZGIZK';

	    $url = 'https://fcm.googleapis.com/fcm/send';
	      //$url = "https://iid.googleapis.com/iid/v1:batchRemove";
	      /*$fields['registration_tokens'] = $deviceId;
	      $fields['to'] = '/topics/my-app';*/

	      $fields = array(
                        'to' => $deviceId,
                        'priority' => "high",
                        //'notification' => array('title' => 'Supertramp', 'body' => 'Notification'),
                        'data' => array(
                        	'message' => $urlPath,
                    		'image' => $orginImage
                        )
                    );

	      $headers = array(
	      'Content-Type:application/json',
	          'Authorization:key='.$server_key
	      );
	      
	      $ch = curl_init();
	      curl_setopt($ch, CURLOPT_URL, $url);
	      curl_setopt($ch, CURLOPT_POST, true);
	      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
	      $result = curl_exec($ch);
	      if ( curl_errno( $ch ) )
	        {
	            echo 'GCM error: ' . curl_error( $ch );
	        }
	      //echo $result;
	      curl_close($ch);
	      //var_dump($result);exit;
	}

}

?>
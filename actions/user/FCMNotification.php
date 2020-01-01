<?php

namespace app\actions\user;


use Yii;
use app\models\UserMaster;
use app\models\ImageMaster;
use app\models\StoreMaster;
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
use app\actions\user\SendEmail;

/**
	Api description -  This Api will accept string id in header and show that row if it exits
	Api URL - http://192.168.43.193/techcamino/api/sod/web/index.php/any valid controller name [i.e - user,service]/show;
	Optional url = http://192.168.43.193/techcamino/api/sod/web/index.php/user/show?id=sodum000000000000018;
	Api Param - @Header Param
	Api Method - Get
	return type Json
**/

class FCMNotification extends AbstractAction {

	public function run(){

		$this->execute();
		//return parent::sendResponse();
	}

	public function execute()
	{
		
		$server_key = 'AAAAyslOzB8:APA91bEK51-jFnQYQq0wIADCyXw_U42LKjkorJCqNlQ888DSqfc1-jzZtfrkIeWr6AYuMu64pcvDOSssKkvTAlvGJZErVjz_VGeDSSQNWPErBArwmZ2nOTtFSl_cmMWr6KIyXotYGFME';

		$deviceId = "euF9UrYFwAA:APA91bElmSD8lGydvFknNYphs1zDUUXB3MSG2-GNgxZso5_VB6l1oISc-1AP189Ocru5RxZB-jRC0CIWHbSfWlclzHs3YacxAJ-q_5L6he4JYxV4-C4amhOF37wCW94vQt0z2cJ8GeIn";
    
	      $url = 'https://fcm.googleapis.com/fcm/send';
	      //$url = "https://iid.googleapis.com/iid/v1:batchRemove";
	      /*$fields['registration_tokens'] = $deviceId;
	      $fields['to'] = '/topics/my-app';*/

	      $fields = array(
                        'to' => $deviceId,
                        'priority' => "high",
                        //'notification' => array('title' => 'Supertramp', 'body' => 'Notification'),
                        'data' => array('message' => "Testing")
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
	      echo $result;
	      curl_close($ch);
	      //var_dump($result);exit;
	}
}

?>
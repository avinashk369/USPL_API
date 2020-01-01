<?php

namespace app\filters;

use Yii;
use yii\base\ActionFilter;

class LogingFilter extends ActionFilter
{

	public function beforeAction($action)
    {
        $timezone = "Asia/Calcutta";
		if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
		$header ='';
		/*foreach(getallheaders() as $key=>$val)
		$header .= $key."=".$val.", ";*/
		$filename = __DIR__ .'/requestLog.txt';
		$fp = fopen($filename, 'a+');
		fwrite($fp, "Your request :-------------\n");
		fwrite($fp, "Request Params".file_get_contents('php://input')."\n");
		fwrite($fp, "Request headers:- ".$header." URL:- ".$_SERVER['REQUEST_URI']."\n");
		fwrite($fp, " at the :- ".date('Y-m-d h:i:s', time())."\n\n");
		fclose($fp);
        return parent::beforeAction($action);
    }

    public function afterAction($action, $result)
    {
        /*$time = microtime(true) - $this->_startTime;
        Yii::trace("Action '{$action->uniqueId}' spent $time second.");
        return parent::afterAction($action, $result);*/
    }

	
    function getallheaders() {
		foreach($_SERVER as $name => $value)
		if(substr($name, 0, 5) == 'HTTP_')
		$headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
		return $headers;
	}
	protected function postFilter($filterChain)
	{
		print_r(file_get_contents('php://input'));
		//print_r($filterChain);
		/*$id=$this->loggerId;
		$passModelCond = 'id=:id';
		$passModelCondArray =  array(':id'=>$id);
		$logMasterModel = $this->loadGenericModel("LogMaster",$id,$passModelCond,$passModelCondArray);
		date_default_timezone_set('asia/kolkata');
		$logMasterModel->response_log= "";
		$logMasterModel->response_time= date("Y-m-d H:i:s");
		$logMasterModel->update();*/
		//return true;
	}

	public function _sendResponse($status = 200, $body = '', $content_type = 'text/html')
	{
		$status_header = 'HTTP/1.1 ' . 401 . ' ' . "Unauthorized";
		header($status_header);
		header('Content-type: ' . $content_type);
		echo $body;
		Yii::app()->end();
	}
	public function loadGenericModel($model,$id,$condition,$conditionArray)
	{
		$modelReturn = new $model;
		$modelReturn=$modelReturn->model()->find($condition,$conditionArray);
		if($modelReturn===null)
		{
			return $modelReturn =new $model;
		}
		return $modelReturn;
	}
}
?>
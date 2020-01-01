<?php

namespace app\actions;

use yii\rest\Action;
use yii;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\helpers\Json;
use common\models\SodUserMaster;
/**
 *
 * @author Avinash.k
 *         Base action for every controller action used in sod.
 *         Base Resource action.
 *        
 */
abstract class AbstractAction extends Action  
{
	
	/**
	 *
	 * @var responseData represents responsedata which is sent to the usesr after request processing.
	 * @var statusCode represnts statuscode which is to be set after processing within the response.
	 * @var requestObject represents reuqest object.
	 * @var responseObject represents response object.
	 */
	public $responseData;
	public $stausCode =200;
	public $responseObject;
	public $requestObject;
	public $exceptionMessage = "wrong data sent";
	public $exceptionCode =501;
	public $userDetail;
	/**
	 * abstract action must be implemented by all classes that extend recovryaction.
	 * It must contain the main implementation of processing of the request.
	 */
	abstract function execute();
	
	//abstract function executeHtml();
	
	
	
	public  function init()
	{
	  
	   $this->requestObject   = Yii::$app->request;
	   $this->responseObject  = Yii::$app->response;
	   
	}
	
	/**
	 * method to send the final response.
	 */
	public function sendResponse()
	{
		$this->setResponseObject();
		if ($this->responseData != null && !empty($this->responseData))
			return $this->responseData;
		else 
			throw  new HttpException($this->exceptionCode,$this->exceptionMessage);
	}
	
	/**
	 * method to set the properties of responseobject like statuscode, statustext ;
	 */
	public function setResponseObject() 
	{
		$this->responseObject->setStatusCode($this->stausCode);
	}
	
	public function saveObjecttoDb($modelClass)
	{
		
		if($modelClass->save())
		{
			return $modelClass;
		}
		else 
		{
	    	$message =json_encode($modelClass->errors);
			throw  new HttpException("501",$message);
		}
	}
	public function DeleteObject($modelObject)
	{
		if($modelObject!=null && $modelObject->delete())
		{
              return true;
		}
		else
		{
			throw new NotFoundHttpException("Object not found");
		}
	}

}
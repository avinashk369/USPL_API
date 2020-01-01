<?php
namespace app\util;
/**
 * 
 * @author sushil
 *
 */
use yii;


class MessageEnum
{

  const UserLogin = "UserLogin";
  const NoRecord = "NoRecord";
  const password = "password";
  const unauthorised = "unauthorised";
  const authToken = "authToken";
  
  public static $access = array
  (
   	 MessageEnum::UserLogin => array("code"=>"403","message"=>"Invalid Credentials"),
   	 MessageEnum::NoRecord => array("code"=>"501","message"=>"No Record Found"),
   	 MessageEnum::password => array("code"=>"501","message"=>"Password is blank"),
   	 MessageEnum::unauthorised => array("code"=>"501","message"=>"Un-authorised access"),
   	 MessageEnum::authToken => array("code"=>"501","message"=>"Auth token not supplied in the header"),
  );
}
?>
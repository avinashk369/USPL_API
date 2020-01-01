<?php
namespace app\util;
/**
 * 
 * @author sushil
 *
 */
use yii;


class Access
{

  const UserAccess = "UserAccess";
  public static $access = array
  (
  	/**
  	apiSecret - staff api_key
  	apiKey - admin api_key
  	**/
   	 Access::UserAccess => array(
   	 	"apiKey"=>"a481fd4b0b1da7ab3929ba0a6673c4f547ad645631974def23f5b0a064bcb579",
   	 	"apiSecret"=>"ee138f4e89b8a2fe00273564eccc1dd652bc37fbad7b3e6d0d358c387e9fdb95"),
  );
}
?>
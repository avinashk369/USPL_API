<?php

namespace app\actions\document;


use Yii;
use app\models\DocumentMaster;
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


class UploadDocument extends AbstractAction {

    public function run(){

        $this->execute();
        return parent::sendResponse();
    }

    public function execute()
    {
        $json = json_encode($_POST);
        $myfile = fopen("newfile.txt", "w+") or die("Unable to open file!");
        fwrite($myfile, $json);
        fclose($myfile);
        
        if(isset($_POST['folder_name'])){
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
                        $document = new DocumentMaster();
                        $document->owner_id = $_POST['owner_id'];
                        $document->path = $_FILES ["file"] ["name"][$i];
                        $document->doc_type = $_POST['doc_type'];
                        $times = Security::getTimeNDate();
                        $document->created_on = $times;
                        if($document->save()){
                            $result = $document;    
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
                
            }
            return $this->responseData = $result;
        }
    else{
                $result = array("success" => "error uploading file");
                return $this->responseData = $result;
        }
    }
}

?>
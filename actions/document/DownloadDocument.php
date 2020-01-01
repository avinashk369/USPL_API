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


class DownloadDocument extends AbstractAction {

    public function run(){

        $this->execute();
        return parent::sendResponse();
    }

    public function execute()
    {
        
        
    }
}

?>
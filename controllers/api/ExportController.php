<?php

namespace app\controllers\api;

use app\components\ApiController;
use app\components\ExportEnum;
use app\models\ExportForm;
use app\models\Lang;
use yii\data\ActiveDataProvider;
use app\models\Translation;
use yii\helpers\VarDumper;

class ExportController extends ApiController
{
    public $modelClass = ExportForm::class;

    public function actions() {
        return [
            
        ];
    }

    public function actionIndex() 
    {
        return ExportEnum::enum();
    }

    public function actionView($id) {
        $form = new ExportForm();
        $form->type = $id;

        $form->processExport();
        $zipFile = $form->getFile();
        
        $zipFileLocation = stream_get_meta_data($zipFile)['uri'];
        \Yii::$app->response->sendFile($zipFileLocation, $form->getSuggestedFilename(), ['inline' => true])->send();
    }
}

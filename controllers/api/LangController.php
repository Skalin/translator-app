<?php

namespace app\controllers\api;

use app\components\ApiController;
use yii\data\ActiveDataProvider;
use app\models\Lang;

class LangController extends ApiController
{
    public $modelClass = Lang::class;
    public function actions() {
        $actions = parent::actions();
        
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);
        return $actions;
    }
}

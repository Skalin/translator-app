<?php

namespace app\components;

use yii\rest\ViewAction;
use yii\base\Model;
use yii\db\ActiveRecord;

class ScenarioViewAction extends ViewAction
{
    public $scenario = Model::SCENARIO_DEFAULT;

    public function run($id) {
        $model = parent::run($id);
        $model->scenario = $this->scenario;
        return $model;
    }
}
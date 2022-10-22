<?php

namespace app\controllers\api;

use app\components\ApiController;
use yii\data\ActiveDataProvider;
use app\models\Translation;

class TranslationController extends ApiController
{
    public $updateScenario = Translation::SCENARIO_UPDATE;

    public $modelClass = Translation::class;
    
}

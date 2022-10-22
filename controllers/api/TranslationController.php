<?php

namespace app\controllers\api;

use app\components\ApiController;
use app\components\ScenarioViewAction as ComponentsScenarioViewAction;
use app\models\Translation;

class TranslationController extends ApiController
{
    public $updateScenario = Translation::SCENARIO_UPDATE;
    public $viewScenario = Translation::SCENARIO_UPDATE;
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public $modelClass = Translation::class;
    
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['view']['class'] = ComponentsScenarioViewAction::class;
        $actions['view']['scenario'] = $this->viewScenario;
        return $actions;
    }

    public function validate() {
        
        $model = new Translation();
        $model->load(\Yii::$app->getRequest()->post(), '');
        $model->validate();
        return $model->getErrors();
    }

}

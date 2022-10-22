<?php 

namespace app\components;

use yii\rest\ActiveController;
use yii\web\Response;

abstract class ApiController extends ActiveController 
{
    public $enableCsrfValidation = false;
    public function behaviors() {
        $behaviors = array_merge(parent::behaviors(), [

            // For cross-domain AJAX request
            'corsFilter'  => [
                'class' => \yii\filters\Cors::className(),
                'cors'  => [
                    // restrict access to domains:
                    'Origin'                           => ['http://localhost:3000'],
                    'Access-Control-Allow-Headers' => ['Origin', 'X-Requested-With', 'Content-Type', 'accept', 'Authorization'], 
                    'Access-Control-Request-Method'    => ['POST', 'PATCH', 'PUT', 'DELETE'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age'           => 0,                 // Cache (seconds)
                ],
            ],

        ]);
        return $behaviors;
    }
}
<?php

namespace app\components;

use app\components\IExporter;
use yii\helpers\Json;

class JsonExporter implements IExporter
{
    private $_data = [];

    public function export($data)
    {
        foreach ($data as $key => $translation) {
            $this->_data[] = ['key' => $key, 'translation' => $translation];
        }
        
        return Json::encode($this->_data);
    }
}
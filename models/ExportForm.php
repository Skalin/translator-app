<?php

namespace app\models;

use app\components\CSVExporter;
use app\components\ExportEnum;
use app\components\JsonExporter;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use ZipArchive;

class ExportForm extends Model
{
    public $type;

    private $_file;
    private $_id;

    public function rules()
    {
        return [[['type'], 'in', 'range' => ExportEnum::class]];
    }
    

    public function processExport()
    {
        $this->_file = tmpfile(); 
        $fileLocation = stream_get_meta_data($this->file)['uri'];
        $file = new ZipArchive;
        $file->open($fileLocation, ZipArchive::OVERWRITE);
        foreach (Lang::find()->all() as $lang) {
            $file->addFromString($lang->shortcut.'.'.$this->type, $this->convertToFormat($this->prepareDataForLanguage($lang)));
        }
        $file->close();
        return true;
    }
    

    protected function prepareDataForLanguage(Lang $lang)
    {
        $data = [];
        $provider = new ActiveDataProvider(['query' => Translationlang::find()
            ->where('lang = :lang', [':lang' => $lang->shortcut])]);
        while ($provider->pagination->getPage() <= $provider->pagination->getPageCount())
        {   
            $data = ArrayHelper::merge($data, ArrayHelper::map($provider->getModels(), 'key', 'translation'));
            $provider->pagination->setPage($provider->pagination->getPage()+1);
        }
        return $data;
    }


    protected function convertToFormat($content) {
        switch ($this->type)
        {
            case ExportEnum::JSON:
                return (new JsonExporter())->export($content);
            case ExportEnum::CSV:
                return (new CSVExporter())->export($content);
                
        }
    }

    public function getFile() {
        return $this->_file;
    }

    public function getSuggestedFilename() {
        return "export.zip";
    }
}
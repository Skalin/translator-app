<?php

namespace app\components;

use app\components\IExporter;
use yii\helpers\VarDumper;

class CSVExporter implements IExporter
{

    protected $separator;


    public function __construct($separator = ';')
    {
        $this->separator = $separator;
    }

    public function export($data)
    {
        if (!is_array($data)) {
            $data = [$data];
        }
        $f = fopen('php://memory', 'r+');
        fputcsv($f, ['key', 'translation'], $this->separator);
        foreach ($data as $key => $translation) {

            if (fputcsv($f, [$key, $translation], $this->separator) === false) {
                return false;
            }
        }

        rewind($f);
        return stream_get_contents($f);
    }
}

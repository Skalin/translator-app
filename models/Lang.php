<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\queries\LangQuery;

/**
 * Lang model
 *
 * @property string $shortcut
 * @property string $name
 */
class Lang extends ActiveRecord 
{
    
    /**
     * @return LangQuery custom query class with user scopes
     */
    public static function find()
    {
        return new LangQuery(get_called_class());
    }
    

    public function getTranslationlangs() {
        return $this->hasMany(Translationlang::class, ['lang' => 'shortcut']);
    }
}

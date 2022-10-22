<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\Translation;
use app\models\Lang;
use app\models\queries\TranslationlangQuery;

/**
 * Translationlang model
 *
 * @property string $key
 * @property string $lang
 * @property string $translation
 */
class Translationlang extends ActiveRecord 
{
    public function rules() {
        return [
            [['key', 'lang', 'translation'], 'string'],
            [['key', 'lang', 'translation'], 'required'],
        ];
    }

    public function fields() {
        $fields = parent::fields();

        unset($fields['key']);
        return $fields;
    }


    /**
     * @return TranslationlangQuery custom query class with user scopes
     */
    public static function find()
    {
        return new TranslationlangQuery(get_called_class());
    }

    public function getTranslation() {
        return $this->hasOne(Translation::class, ['key' => 'key']);
    }

    public function getLang() {
        return $this->hasOne(Lang::class, ['shortcut' => 'lang']);
    }
}

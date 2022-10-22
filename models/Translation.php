<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\Translationlang;
use app\models\queries\TranslationQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\log\Logger;

/**
 * Lang model
 *
 * @property string $shortcut
 * @property string $name
 */
class Translation extends ActiveRecord 
{
    public $translations = [];

    const SCENARIO_UPDATE = 'update';
    
    public function rules() {
        return [
            [['key'], 'string'],
            [['key'], 'required', 'message' => Yii::t('app', '{attribute} is required')],
            [['key'], 'match', 'pattern' => '/^[A-Z\_]+[A-Z\_]+/', 'message' => Yii::t('app', 'Expected format is: "[A-Z\_]+[A-Z\_]+".')],
            [['translations'], 'required', 'on' => self::SCENARIO_UPDATE]
        ];
    }

    public function getTranslationlangs() {
        return $this->hasMany(Translationlang::class, ['key' => 'key']);
    }

    public function setTranslations($value) {
        $this->translations = $value;
    }

    public function getTranslations() {
        $translations = $this->translationlangs;
        $langs = ArrayHelper::map(Lang::find()->all(), 'shortcut','name');
        $filledLangs = array_flip(ArrayHelper::getColumn($translations, 'lang'));
        $missingLangs = array_diff_key($langs, $filledLangs);
        foreach ($missingLangs as $lang => $name) {
            $translation = new Translationlang();
            $translation->key = $this->key;
            $translation->lang = $lang;
            $translations[] = $translation;
        }
        return $translations;
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields['id'] = function ($model) {return $this->key;};
        if ($this->scenario == self::SCENARIO_UPDATE) 
        {
            unset($this->translationlangs);
            $fields['translations'] = function ($model) {return $model->getTranslations();};
            unset($fields['id']);
        }
        return $fields;
    }

    /**
     * @return TranslationQuery custom query class with user scopes
     */
    public static function find()
    {
        return new TranslationQuery(get_called_class());
    }
   
    public function save($runValidation = true, $attributeNames = null)
    {
        $t = Yii::$app->db->beginTransaction();
        try {
            $status = parent::save($runValidation, $attributeNames);
            foreach ($this->translationlangs as $translation) {
                $translation->delete();
            }
            foreach ($this->translations as $translation) {
                $translationlang = new Translationlang();
                $translationlang->setAttributes($translation);
                $translationlang->key = $this->key;
                $status = $status && $translationlang->save(false);
            }
            $t->commit();
            return $status;
        } catch (yii\db\Exception $e) {    
            $t->rollback();
        }
        return false;
    }

}

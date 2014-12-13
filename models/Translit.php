<?php

namespace app\models;

use Yii;
use app\models\Lang;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "translit".
 *
 * @property integer $id
 * @property integer $from_lang_id
 * @property integer $to_lang_id
 * @property string $from_symbol
 * @property string $to_symbol
 *
 * @property Lang $toLang
 * @property Lang $fromLang
 */
class Translit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'translit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_lang_id', 'to_lang_id', 'from_symbol', 'to_symbol'], 'required'],
            [['from_lang_id', 'to_lang_id'], 'integer'],
            [['from_symbol', 'to_symbol'], 'string', 'max' => 8]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_lang_id' => 'С какого языка',
            'to_lang_id' => 'На какой язык',
            'from_symbol' => 'Симовл',
            'to_symbol' => 'Транслитерация',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToLang()
    {
        return $this->hasOne(Lang::className(), ['id' => 'to_lang_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromLang()
    {
        return $this->hasOne(Lang::className(), ['id' => 'from_lang_id']);
    }

    public static  function Translit($word, $to_lang_id=1)
    {
        $b = array(
            'а' => 'a', 'б' => 'b', 'в' => 'v',
            'г' => 'g', 'д' => 'd', 'е' => 'e',
            'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
            'и' => 'i', 'й' => 'y', 'к' => 'k',
            'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
            'ь' => '\'', 'ы' => 'y', 'ъ' => '\'',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',

            'А' => 'A', 'Б' => 'B', 'В' => 'V',
            'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
            'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
            'И' => 'I', 'Й' => 'Y', 'К' => 'K',
            'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R',
            'С' => 'S', 'Т' => 'T', 'У' => 'U',
            'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
            'Ь' => '\'', 'Ы' => 'Y', 'Ъ' => '\'',
            'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya'
        );
        $model = Translit::find()->where(['from_lang_id'=>$to_lang_id,'to_lang_id'=>Lang::$current->id])->all();
            $array = ArrayHelper::map($model,'from_symbol','to_symbol');
            return strtr($word, $array);
    }

}

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
            'from_lang_id' => 'РЎ РєР°РєРѕРіРѕ СЏР·С‹РєР°',
            'to_lang_id' => 'РќР° РєР°РєРѕР№ СЏР·С‹Рє',
            'from_symbol' => 'РЎРёРјРѕРІР»',
            'to_symbol' => 'РўСЂР°РЅСЃР»РёС‚РµСЂР°С†РёСЏ',
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
            'Р°' => 'a', 'Р±' => 'b', 'РІ' => 'v',
            'Рі' => 'g', 'Рґ' => 'd', 'Рµ' => 'e',
            'С‘' => 'e', 'Р¶' => 'zh', 'Р·' => 'z',
            'Рё' => 'i', 'Р№' => 'y', 'Рє' => 'k',
            'Р»' => 'l', 'Рј' => 'm', 'РЅ' => 'n',
            'Рѕ' => 'o', 'Рї' => 'p', 'СЂ' => 'r',
            'СЃ' => 's', 'С‚' => 't', 'Сѓ' => 'u',
            'С„' => 'f', 'С…' => 'h', 'С†' => 'c',
            'С‡' => 'ch', 'С€' => 'sh', 'С‰' => 'sch',
            'СЊ' => '\'', 'С‹' => 'y', 'СЉ' => '\'',
            'СЌ' => 'e', 'СЋ' => 'yu', 'СЏ' => 'ya',

            'Рђ' => 'A', 'Р‘' => 'B', 'Р’' => 'V',
            'Р“' => 'G', 'Р”' => 'D', 'Р•' => 'E',
            'РЃ' => 'E', 'Р–' => 'Zh', 'Р—' => 'Z',
            'Р' => 'I', 'Р™' => 'Y', 'Рљ' => 'K',
            'Р›' => 'L', 'Рњ' => 'M', 'Рќ' => 'N',
            'Рћ' => 'O', 'Рџ' => 'P', 'Р ' => 'R',
            'РЎ' => 'S', 'Рў' => 'T', 'РЈ' => 'U',
            'Р¤' => 'F', 'РҐ' => 'H', 'Р¦' => 'C',
            'Р§' => 'Ch', 'РЁ' => 'Sh', 'Р©' => 'Sch',
            'Р¬' => '\'', 'Р«' => 'Y', 'РЄ' => '\'',
            'Р­' => 'E', 'Р®' => 'Yu', 'РЇ' => 'Ya'
        );
        $model = Translit::find()->where(['from_lang_id'=>$to_lang_id,'to_lang_id'=>Lang::$current->id])->all();
            $array = ArrayHelper::map($model,'from_symbol','to_symbol');
            return strtr($word, $array);
    }

}

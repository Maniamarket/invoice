<?php

namespace app\models;

use Yii;

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
}

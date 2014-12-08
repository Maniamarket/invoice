<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "lang".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Translit[] $translits
 */
class Lang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 40]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTranslits()
    {
        return $this->hasMany(Translit::className(), ['from_lang_id' => 'id']);
    }

    public static function getLanguageArray(){
        $models = self::find()->all();
        $result = ArrayHelper::map($models,'id','name');
        return $result;
    }
}
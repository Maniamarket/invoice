<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "country".
 *
 * @property integer $id
 * @property integer $cid
 * @property integer $lang_id
 * @property string $name
 *
 * @property Lang $lang
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lang_id', 'name'], 'required'],
            [['lang_id', 'cid'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'lang_id' => Yii::t('app', 'Lang ID'),
            'cid' => Yii::t('app', 'Country ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Lang::className(), ['id' => 'lang_id']);
    }

    /**
     * @param int $lang Language id
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getCountriesArray($lang = 1)
    {
        $models = self::find()->where(['lang_id'=>$lang])->orderBy('cid')->asArray()->all();
        $array = ArrayHelper::map($models,'cid','name');
        return $models;
    }

    /**
     * @param int $lang Language id
     * @return array
     */
    public static function list_Countries($lang = 1)
    {
        $models = self::find()->where(['lang_id'=>$lang])->orderBy('cid')->asArray()->all();
        $array = ArrayHelper::map($models,'cid','name');
        return $array;
    }

    /**
     * @param int $lang Language id
     * @return array
     */
    public function getNameByLocale()
    {
        $models = self::find()->where(['lang_id'=>Lang::$current->id, 'cid'=>$this->cid])->orderBy('cid')->one();
        return  $models->name;
    }

    /**
     * @param $name
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getCountriesByName($name){
           return self::find()->where('name LIKE :word')->addParams([':word'=>"%$name%"])->asArray()->all();
    }

    /**
     * Р—Р°РїРѕР»РЅСЏРµС‚ С‚Р°Р±Р»РёС†Сѓ СЃС‚СЂР°РЅ
     * @param int $vk_lang ID СЏР·С‹РєР° РІРѕ Р’Рљ
     * @param int $our_db_lang_id ID СЏР·С‹РєР° РІ РЅР°С€РµР№ Р±Р°Р·Рµ
     * @param bool $both  РµСЃР»Рё true С‚Рѕ Р°РІС‚РѕРјР°С‚РёС‡РµСЃРєРё Р·Р°РѕР»РЅСЏРµС‚ Р±Р°Р·Сѓ РЅР° РґРІСѓС… СЏР·С‹РєР°С… Р°РЅРіР»РёР№СЃРєРёР№(1) Рё СЂСѓСЃСЃРєРёР№(2)
     */
    public static function getFromVK($vk_lang = 0, $our_db_lang_id = 2, $both = false)
    {
        if ($both) {

            $lang = 0;
            $headerOptions = array(
                'http' => array(
                    'method' => "GET",
                    'header' => "Accept-language: en\r\n" .
                        "Cookie: remixlang=$lang\r\n"
                )
            );
            $methodUrl = 'http://api.vk.com/method/database.getCountries?v=5.5&need_all=1&count=1000';
            $streamContext = stream_context_create($headerOptions);
            $json = file_get_contents($methodUrl, false, $streamContext);
            $ar = json_decode($json, true)['response'];
            $res = $ar['items'];


            foreach ($res as $c) {
                $country = new Country;
                $country->cid = $c['id'];
                $country->lang_id = 2;
                $country->name = $c['title'];
                var_dump($country->save());
            }

            $lang = 3;

            $headerOptions = array(
                'http' => array(
                    'method' => "GET",
                    'header' => "Accept-language: en\r\n" .
                        "Cookie: remixlang=$lang\r\n"
                )
            );
            $methodUrl = 'http://api.vk.com/method/database.getCountries?v=5.5&need_all=1&count=1000';
            $streamContext = stream_context_create($headerOptions);
            $json = file_get_contents($methodUrl, false, $streamContext);
            $ar = json_decode($json, true)['response'];
            $res = $ar['items'];


            foreach ($res as $c) {
                $country = new Country;
                $country->cid = $c['id'];
                $country->lang_id = 1;
                $country->name = $c['title'];
                var_dump($country->save());
            }
        } else {
            $lang = $vk_lang;
            /*
            Р СѓСЃСЃРєРёР№ 	0
            РЈРєСЂР°РёРЅСЃРєРёР№ 	1
            РђРЅРіР»РёР№СЃРєРёР№ 	3
            РСЃРїР°РЅСЃРєРёР№ 	4
            РџРѕСЂС‚СѓРіР°Р»СЊСЃРєРёР№ 	12
            РќРµРјРµС†РєРёР№ 	6
            Р¤СЂР°РЅС†СѓР·СЃРєРёР№ 	16
            РС‚Р°Р»СЊСЏРЅСЃРєРёР№ 	7
             */
            $headerOptions = array(
                'http' => array(
                    'method' => "GET",
                    'header' => "Accept-language: en\r\n" .
                        "Cookie: remixlang=$lang\r\n"
                )
            );
            $methodUrl = 'http://api.vk.com/method/database.getCountries?v=5.5&need_all=1&count=1000';
            $streamContext = stream_context_create($headerOptions);
            $json = file_get_contents($methodUrl, false, $streamContext);
            $ar = json_decode($json, true)['response'];
            $res = $ar['items'];


            foreach ($res as $c) {
                $country = new Country;
                $country->cid = $c['id'];
                $country->lang_id = $our_db_lang_id;
                $country->name = $c['title'];
                var_dump($country->save());
            }
        }
    }
}

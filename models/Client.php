<?php
namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * Client model
 *
 * @property integer $id
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class Client extends ActiveRecord implements IdentityInterface
{
    public $file;
    public $password_;
    public $invoice,$total;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%client}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email'], 'unique'],
            ['email','email'],
            [['city','street','phone','name','email','post_index','company_name','vat_number','tax_agency','fax','web_site'], 'filter', 'filter' => 'trim'],
	        [['city','street','phone','name','email','post_index','company_name','vat_number','tax_agency','fax','web_site'], 'string', 'max' => 100],
            [['country_id','def_lang_id'],'integer'],
            [['avatar'], 'safe'],
            ['file', 'file', 'extensions' => ['jpg','jpeg','png','gif']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID Number'),
            'name' => Yii::t('app', Yii::t('app', 'Full Name')),
            'company_name' => Yii::t('app', Yii::t('app', 'Company Name')),
            'vat_number' => Yii::t('app', Yii::t('app', 'Vat')),
            'tax_agency' => Yii::t('app', Yii::t('app', 'Tax Agency')),
            'post_index' => Yii::t('app', Yii::t('app', 'Zip')),
            'phone' => Yii::t('app', Yii::t('app', 'Telephone')),
            'fax' => Yii::t('app', Yii::t('app', 'Fax')),
            'country_id' => Yii::t('app', Yii::t('app', 'Country')),
            'city' => Yii::t('app', Yii::t('app', 'City')),
            'street' => Yii::t('app', 'Address'),
            'web_site' => Yii::t('app', 'Url'),
            'def_lang_id' => Yii::t('app', Yii::t('app', 'Language')),
            'file' => Yii::t('app', Yii::t('app', 'Logo')),
            'inn' => Yii::t('app', 'Inn'),
        ];
    }

    public function getLanguage()
    {
        return $this->hasOne('app\models\Lang', array('id' => 'def_lang_id'));
        // Первый параметр – это у нас имя класса, с которым мы настраиваем связь.
        // Во втором параметре в виде массива задаётся имя удалённого PK ключа  (id) и FK из текущей таблицы модели (author_id), которые связываются между собой
    }

    public function getCountry()
    {
        return $this->hasOne('app\models\Country', array('cid' => 'country_id'));
        // Первый параметр – это у нас имя класса, с которым мы настраиваем связь.
        // Во втором параметре в виде массива задаётся имя удалённого PK ключа  (id) и FK из текущей таблицы модели (author_id), которые связываются между собой
    }

    /*public static function queryProvider($qp) {
//        $query = Client::find()->where(['user_id'=>  Yii::$app->user->id]);
        //country id
        if (isset($qp['name']))
        {
            if ( !empty($qp['name'])){
                $q->filterWhere(['like', 'name', $qp['name']]);
                $query->orFilterWhere(['like', 'email', $qp['name']]);

                $cid = Country::getCountriesByName($qp['name']);
                $arr = [];
                foreach($cid as $c){
                    array_push($arr,$c['cid']);
                }
                $query->orFilterWhere(['in', 'country_id', $arr]);
            }
            if ( !empty($qp['lang']))
                $query->andFilterWhere(['like','def_lang_id',$qp['lang']]);

            if (isset($qp['orderby'])) {
                $orderBy = ($qp['orderby']=='asc')? SORT_ASC:SORT_DESC;
                $query->orderBy(['name'=>$orderBy]);
            }

        }
        $query = $q->createCommand()->queryAll();
        var_dump($query); exit;
        return $query;
    }
*/

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = self::find()->where(['user_id'=>  Yii::$app->user->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'email' => $this->email,
            'created_at' => $this->created_at,
            'def_lang_id' => $this->def_lang_id,
            'country_id' => $this->country_id,
            'city' => $this->city,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'created_at', $this->created_at]);

        return $dataProvider;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findById($id)
    {
        return static::findOne(['id' => $id ]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int)end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
   //       return $password;
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
//        $this->password_hash = $password;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        // установка роли пользователя
    }
}

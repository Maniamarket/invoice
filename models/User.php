<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
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
class User extends ActiveRecord implements IdentityInterface {

    const STATUS_INACTIVE = 0;
    const STATUS_BANNED = 5;
    const STATUS_ACTIVE = 10;
    const ROLE_USER = 'user';
    const ROLE_MANAGER = 'manager';
    const ROLE_ADMIN = 'admin';
    const ROLE_SUPERADMIN = 'superadmin';

    public $credit, $sum_profit, $profit_manager, $profit_admin, $income, $my_profit, $sum_profit_manager, $sum_profit_admin;
    public $password_,$surtax;
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => array_keys(self::getStatusArray())],
            ['role', 'default', 'value' => self::ROLE_USER],
            ['role', 'in', 'range' => array_keys(self::getRoleArray())],
            [['email'], 'required'],
            [['email', 'username'], 'unique'],
            ['email', 'email'],
        ];
    }

    public function attributeLabels() {
        return array(
            'username' => Yii::t('app', 'Login'),
            'email' => Yii::t('app', 'Email'),
        );
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    /* Todo удалить, если не используется */

    public function getStatusLabel($status = '') {
        $status = (empty($status)) ? $this->role : $status;
        switch ($status) {
            case 10:
                return ['success', 'user'];
            default:
                return ['danger', 'error'];
        }
    }

    /* Todo удалить, если не используется */

    public function getRolesList() {
        return array(self::ROLE_USER => 'User');
    }

    /* Todo удалить, если не используется */

    public function getStatusList() {
        return array(self::STATUS_ACTIVE => 'Active', self::STATUS_INACTIVE => 'Inactive', self::STATUS_BANNED => 'Banned');
    }

    /**
     * @return string Model status.
     */
    public function getStatus() {
        if ($this->_status === null) {
            $statuses = self::getStatusArray();
            $this->_status = $statuses[$this->status_id];
        }
        return $this->_status;
    }

    /**
     * @return array Status array.
     */
    public static function getStatusArray() {
        return [
            self::STATUS_ACTIVE => Yii::t('users', 'STATUS_ACTIVE'),
            self::STATUS_INACTIVE => Yii::t('users', 'STATUS_INACTIVE'),
            self::STATUS_BANNED => Yii::t('users', 'STATUS_BANNED')
        ];
    }

    /**
     * @return array Role array.
     */
    public static function getRoleArray() {
        return ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
    }

    /**
     * @return array Parentarray.
     */
    public static function getParentArray() {
        $parent = User::find()->all();
        return ArrayHelper::map($parent, 'id', 'username');
    }

    public function getSetting() {
        return $this->hasOne('app\models\Setting', array('user_id' => 'id'));
        // Первый параметр – это у нас имя класса, с которым мы настраиваем связь.
        // Во втором параметре в виде массива задаётся имя удалённого PK ключа  (id) и FK из текущей таблицы модели (author_id), которые связываются между собой
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        // установка роли пользователя
        $auth = Yii::$app->authManager;
        $name = $this->role ? $this->role : self::ROLE_USER;
        $role = $auth->getRole($name);
        if (!$insert) {
            $auth->revokeAll($this->id);
        }
        $auth->assign($role, $this->id);
    }

    /**
     * @param string $email_confirm_token
     * @return static|null
     */
    public static function findByEmailConfirmToken($email_confirm_token) {
        return static::findOne(['email_confirm_token' => $email_confirm_token, 'status' => self::STATUS_INACTIVE]);
    }

    /**
     * Generates email confirmation token
     */
    public function generateEmailConfirmToken() {
        $this->email_confirm_token = Yii::$app->security->generateRandomString();
    }

    /**
     * Removes email confirmation token
     */
    public function removeEmailConfirmToken() {
        $this->email_confirm_token = null;
    }

}

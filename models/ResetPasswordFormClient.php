<?php
namespace app\models;
use app\models\Client;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;
/**
 * Password reset form
 */
class ResetPasswordFormClient extends Model
{
    public $password;
    /**
     * @var \app\models\Client
     */
    private $_client;
    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Password reset token cannot be blank.');
        }
        $this->_client = Client::findByPasswordResetToken($token);
        if (!$this->_client) {
            throw new InvalidParamException('Wrong password reset token.');
        }
        parent::__construct($config);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }
    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function resetPassword()
    {
        $client = $this->_client;
        $client->password = $this->password;
        $client->removePasswordResetToken();
        $client->save();
        return $client->save();
    }
}

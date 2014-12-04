<?php

namespace app\components\rbac;

use Yii;
use yii\rbac\Rule;

class UserRule extends Rule
{
    /**
     * @inheritdoc
     */
    public $name = 'user';

    /**
     * @inheritdoc
     */
    public function execute($user, $item, $params)
    {
        return !Yii::$app->user->isGuest;
    }
}

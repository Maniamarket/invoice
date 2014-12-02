<?php
/**
 * Created by PhpStorm.
 * User: XeDN
 * Date: 02.12.14
 * Time: 13:39
 */

namespace app\rbac;

use Yii;
use yii\rbac\Rule;

class UserGroupRule extends Rule
{
    public $name = 'userGroup';

    public function execute($user, $item, $params)
    {
        if (!\Yii::$app->user->isGuest) {
            $group = \Yii::$app->user->identity->group;
            if ($item->name === 'ADMIN') {
                return $group == 'ADMIN';
            } elseif ($item->name === 'MANAGER') {
                return $group == 'ADMIN' || $group == 'MANAGER';
            } elseif ($item->name === 'USER') {
                return $group == 'ADMIN' || $group == 'USER';
            }
        }
        return true;
    }
}
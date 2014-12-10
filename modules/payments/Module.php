<?php

namespace app\modules\payments;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\payments\controllers';

    public function init()
    {
        parent::init();

        $this->setImport(array(
            'mypurse.models.*',
            'mypurse.components.*',
        ));
        // custom initialization code goes here
    }
}

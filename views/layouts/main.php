<?php /* @var $this Controller */
use yii\helpers\Html;
use yii\widgets\Menu;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\components\LanguageSelector;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        ?>
        <div  id="language-selector" style="float:right; margin:5px;">
            <?= LanguageSelector::widget([]) ?>
		    <?php

		    //$this->widget('application.components.widgets.LanguageSelector');
		    ?>
        </div>
        <?php
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => Yii::t('lang', 'Home'), 'url' => ['/site/index'], 'visible' => !Yii::$app->user->isGuest],
                ['label' => Yii::t('lang', 'Users'), 'url' => ['/user/index'], 'visible' => !Yii::$app->user->isGuest],
                ['label' => Yii::t('lang', 'Clients'), 'url' => ['/client/index'], 'visible' => !Yii::$app->user->isGuest],
                ['label' => Yii::t('lang', 'Invoice'), 'url' => ['/invoice/index'], 'visible' => !Yii::$app->user->isGuest],
                ['label' => Yii::t('lang', 'Companies'), 'url' => ['/company/index'], 'visible' => !Yii::$app->user->isGuest],
                ['label' => Yii::t('lang', 'Services'), 'url' => ['/service/index'], 'visible' => !Yii::$app->user->isGuest],
                ['label' => Yii::t('lang', 'Taxes'), 'url' => ['/tax/index'], 'visible' => !Yii::$app->user->isGuest],
                ['label' => Yii::t('lang', 'Settings'), 'url' => ['/setting/update'], 'visible' => !Yii::$app->user->isGuest],
                ['label' => Yii::t('lang', 'Register'), 'url' => ['/site/signup'], 'visible' => Yii::$app->user->isGuest],
                Yii::$app->user->isGuest ?
                    ['label' => 'Login', 'url' => ['/site/login']] :
                    ['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                        'url' => ['/site/logout'],
                        'linkOptions' => ['data-method' => 'post']],
            ],
        ]);
        NavBar::end();  ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>


<?php $this->endBody() ?>
</body>
</html>
<?php
$this->registerJsFile(Yii::getAlias('@web/js/app.js'),[\yii\web\View::POS_READY]);
?>
<?php $this->endPage() ?>

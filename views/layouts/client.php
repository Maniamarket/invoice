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
            'brandLabel' => 'Invoice',
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
                ['label' => Yii::t('lang', 'Invoice'), 'url' => ['/client/invoice'], 'visible' => $this->context->isClient()],
                ['label' => Yii::t('lang', 'Settings'), 'url' => ['/client/update'], 'visible' => $this->context->isClient()],
                Yii::$app->user->isGuest ?
                    ['label' => 'Login', 'url' => ['/client/login']] :
                    ['label' => 'Logout',
                        'url' => ['/client/logout'],
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
<?php $this->endPage() ?>

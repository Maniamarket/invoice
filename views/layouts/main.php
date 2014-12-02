<?php /* @var $this Controller */
use yii\helpers\Html;
use yii\widgets\Menu;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::$app->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::$app->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::$app->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::$app->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::$app->request->baseUrl; ?>/css/form.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::$app->request->baseUrl; ?>/css/invoice.css" />

	<title><?php echo Html::encode($this->title); ?></title>
    </head>

    <body>

	<div class="container" id="page">

	    <div id="header">
		<div id="logo"><?php echo Html::encode(Yii::$app->name); ?></div>
		<div  id="language-selector" style="float:right; margin:5px;">
		    <?php
//		    $this->widget('application.components.widgets.LanguageSelector');
		    ?>
		</div>
	    </div><!-- header -->

	    <div id="mainmenu">
		<?php
		//echo Yii::app()->user->role;
		echo Menu::widget([
		    'items' => array(
			array('label' => Yii::t('lang', 'Home'),
			    'url' => array('/site/index'),
                'visible' => !Yii::$app->user->isGuest
			),
			array('label' => Yii::t('lang', 'Clients'),
			    'url' => array('/user/index'),
                'visible' => !Yii::$app->user->isGuest
			),
			array('label' => Yii::t('lang', 'Invoice'),
			    'url' => array('/invoice/index'),
                'visible' => !Yii::$app->user->isGuest
			),
			array('label' => Yii::t('lang', 'Companies'),
			    'url' => array('/company/index'),
                'visible' => !Yii::$app->user->isGuest
			),
			array('label' => Yii::t('lang', 'Services'),
			    'url' => array('/service/index'),
                'visible' => !Yii::$app->user->isGuest
			),
			array('label' => Yii::t('lang', 'Taxes'), 
			    'url' => array('/tax/index'),
                'visible' => !Yii::$app->user->isGuest
			),
			/*
			array('label' => Yii::t('lang', 'Credits'), 
			    'url' => array('/site/aa'),
			    'visible' => Yii::app()->user->checkAccess('2')
			),
			array('label' => Yii::t('lang','Users'), 
			    'url' => array('/user/index'),
			    'visible' => Yii::app()->user->checkAccess('3')
			),
			 * */
			 
			array('label' => Yii::t('lang', 'Settings'),
			    'url' => array('/setting/update'),
                'visible' => !Yii::$app->user->isGuest
			),
			/*
			array('label' => Yii::t('lang', 'Configuration'), 
			    'url' => array('/config/index'),
			    'visible' => Yii::app()->user->checkAccess('1')
			),*/
			/*array('label' => Yii::t('lang', 'About'), 
			    'url' => array('/site/page',
			    'view' => 'about'), 
			    'visible' => Yii::app()->user->checkAccess('1')
			),
			array('label' => Yii::t('lang', 'Contact'), 
			    'url' => array('/site/contact'),
			    'visible' => Yii::app()->user->checkAccess('1')
			),*/
			array('label' => Yii::t('lang', 'Login'),
			    'url' => array('/site/login'),
                'visible' => Yii::$app->user->isGuest
			),
			array('label' => 'Logout (' . Yii::$app->user->getId() . ')',
			    'url' => array('/site/logout'),
                'visible' => !Yii::$app->user->isGuest
			)
		    ),
		]);
		?>
		<?php /* $this->widget('zii.widgets.CMenu',array(
		  'items'=>array(
		  array('label'=>'Clients', 'url'=>array('/site/index')),
		  array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),
		  array('label'=>'Contact', 'url'=>array('/site/contact')),
		  array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
		  array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
		  ),
		  )); */ ?>
	    </div><!-- mainmenu -->
	    <?php if (isset($this->breadcrumbs)): ?>
		<?php
		$this->widget('zii.widgets.CBreadcrumbs', array(
		    'links' => $this->breadcrumbs,
		));
		?><!-- breadcrumbs -->
	    <?php endif ?>

	    <?php echo $content; ?>

	    <div class="clear"></div>

	    <div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	    </div><!-- footer -->

	</div><!-- page -->

    </body>
</html>

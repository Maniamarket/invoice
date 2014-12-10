<?php if (Yii::app()->user->hasFlash('ok')) { ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('ok'); ?>
    </div>
<?php } ?>

<?php if (Yii::app()->user->hasFlash('notice')) { ?>
    <div class="flash-notice">
        <?php echo Yii::app()->user->getFlash('notice'); ?>
    </div>
<?php } ?>

<?php if (Yii::app()->user->hasFlash('error')) { ?>
    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php } ?>
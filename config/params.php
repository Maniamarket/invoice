<?php
        
$params = array(
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'info@site.com',
    'user.passwordResetTokenExpire' => 3600,
    'languages' => array('ru' => 'Русский', 'de' => 'Deutsch', 'en' => 'English'),
    'currency' => array('1' => 'EUR', '2' => 'USD', '3' => 'GBP', '4' => 'RUR'),
    'imagePath' => '/images/',
    'logoPath' => 'images/companies/',
    'avatarPath' => 'images/avatars/',
    'creditPath' => 'images/payment_credit/',
    'is_cache' => false,
    'paymentMode' => 'live',
    'paypal_percent' => 0.035,
);
if (YII_ENV_DEV) {
    $params ['paymentMode'] = 'test';
}
return $params;

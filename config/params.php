<?php

$params = array(
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'info@site.com',
    'user.passwordResetTokenExpire' => 3600,
    'languages' => array('ru' => 'Русский', 'de' => 'Deutsch', 'en' => 'English'),
    'currency' => array('1' => 'EUR', '2' => 'USD', '3' => 'GBP', '4' => 'RUR'),
    'imagePath' => '/images/',
    'logoPath' => 'images/companies/',
    'creditPath' => 'images/payment_credit/',
    'is_cache' => 'false',
    'paymentMode' => 'live',
);
if (YII_ENV_DEV) {
    $params ['paymentMode'] = 'test';
}
return $params;

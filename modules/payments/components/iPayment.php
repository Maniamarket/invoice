<?php

interface iPayment {

    public function getLogo();

    public function getUrl();

    public function getName();

    public function getFormName();

    public function getMethod();

    public function getAction();

    public function getParams(PaymentHistory $history);

    public function checkSign();

    public function setResult();

    public function setSuccess();

    public function getScenario();
}

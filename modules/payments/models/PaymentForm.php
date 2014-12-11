<?php

class PaymentForm extends CFormModel {

//    public $url = 'http://test.robokassa.ru/Index.aspx';
    public $url = 'https://merchant.roboxchange.com/Index.aspx';
    public $mrh_pass1 = 'huj4+eq&Prapr2#';
    public $mrh_pass2 = '*ERe9heNu!5uceY';
    public $mrh_login = "Lex_wm";
    // номер заказа
    public $inv_id = 1;
    // описание заказа
    public $inv_desc = "";
    // сумма заказа
    public $out_summ = "";
    // тип товара
    public $shp_item = 1;
    // предлагаемая валюта платежа
    public $in_curr = "";
    // язык
    public $culture = "ru";
    public $crc;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            array('out_summ, in_curr', 'required'),
            array('out_summ', 'numerical', 'min' => 1, 'tooSmall' => Yii::t('payment', 'The summ can not be less than $ 1'), 'message' => Yii::t('payment', 'Summ must be a number')),
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels() {
        return array(
            'out_summ' => Yii::t('credits', 'Sum'),
            'in_curr' => Yii::t('credits', 'Payment method'),
        );
    }

    public function safeAttributes() {
        return array('out_summ', 'in_curr', 'inv_desc');
    }

    public function generateCRC() {
        $this->crc = md5("{$this->mrh_login}:{$this->out_summ}:{$this->inv_id}:{$this->mrh_pass1}:Shp_item={$this->shp_item}");
    }

    public function validateCRC() {
        return strtoupper(md5("{$this->out_summ}:{$this->inv_id}:{$this->mrh_pass2}:Shp_item={$this->shp_item}"));
    }

    public function GetCurrenciesDropDownList() {
        $request = 'https://merchant.roboxchange.com/WebService/Service.asmx/GetCurrencies?MerchantLogin='.$this->mrh_login.'&Language=' . $this->culture;
        $xml = new SimpleXMLElement(file_get_contents($request));
        if (isset($xml->Result->Code) && $xml->Result->Code == 0) {
            $listOptions = array();
            foreach ($xml->Groups->Group as $Group) {
                $Description = (string) $Group->attributes()->Description;
                $options = array();
                foreach ($Group->Items->Currency as $Currency) {
                    $Label = (string) $Currency->attributes()->Label;
                    $Name = (string) $Currency->attributes()->Name;
                    $options[$Label] = $Name;
                }
                $listOptions[$Description] = $options;
            }
        }
        return CHtml::dropDownList('PaymentForm[in_curr]', '', $listOptions);
//        return CHtml::dropDownList('PaymentForm[in_curr]', '', $listOptions, $this->htmlOptions());
    }

    public function htmlOptions() {
        return array(
            'ajax' => array(
                'type' => 'POST', //request type
                'url' => Yii::$app->createUrl('/credits/payment/update'), //url to call.
                'update' => '#addtitionalInfo', //selector to update
                ));
    }

}

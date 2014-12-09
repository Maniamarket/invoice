<?php

/**
 * This is the model class for table "tbl_payment_system".
 *
 * The followings are the available columns in table 'tbl_payment_system':
 * @property string $id
 * @property string $model
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property PaymentHistory[] $PaymentHistories
 */
class PaymentSystem extends MyActiveRecord {

    public function tableName() {
        return 'payment_system';
    }

    public function rules() {
        return array(
            array('model', 'required'),
            array('active', 'numerical', 'integerOnly' => true),
            array('model', 'length', 'max' => 128),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, model, active', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'model' => Yii::t('mypurse', 'Model'),
            'active' => Yii::t('mypurse', 'Active'),
        );
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('model', $this->model, true);
        $criteria->compare('active', $this->active);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getConfig() {
        return new $this->model;
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}

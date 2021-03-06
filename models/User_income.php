<?php
namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use app\models\Company;
use app\models\Lang;
use app\models\Vat;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "setting".
 *
 * The followings are the available columns in table 'setting':
 * @property integer $user_id
 * @property integer $credit
 * @property integer $vat
 * @property integer $def_company
 * @property integer $def_lang
 */
class User_income extends ActiveRecord {
            
    public static function tableName() {
	return 'user_income';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
	// NOTE: you should only define rules for those attributes that
	// will receive user inputs.
	return array(
	    [['user_id','credit','parent_id', 'date'], 'required'],
	    [['user_id'], 'integer'],
            
	    [['profit_manager'], 'integer','integerOnly'=>FALSE],
	);
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
	// NOTE: you may need to adjust the relation name and the related
	// class name for the relations automatically generated below.
	return array(
	);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
    	return array(
	    );
    }


    public static function setIncome()
    {
        $u_income = User_income::findBySql('select u.id,u.profit_manager, u.profit_admin from {{user_income}} as u '
                    . '  where (u.profit_manager > 0 or u.profit_admin>0) and YEAR(`date`)=YEAR(NOW())')->all();
        if(count($u_income) > 0){
            foreach ( $u_income as $val){
                if( $val['profit_manager'] >0 ){
                    $income = self::getIncome($val['profit_manager']);
                    Yii::$app->db->createCommand("UPDATE user_income SET my_profit=:prof, income = :in  WHERE id=:id")
                      ->bindValues([':prof'=>$income['manager']*$val['profit_manager']/100,':in'=>$income['manager'],':id'=>$val['id']])->execute();
                }
                else {
                    $income = self::getIncome($val['profit_admin']);
                    Yii::$app->db->createCommand("UPDATE user_income SET my_profit=:prof, income = :in  WHERE id=:id")
                      ->bindValues([':prof'=>$income['admin']*$val['profit_admin']/100, ':in'=>$income['admin'],'id'=>$val['id']])->execute();
                }
            }
        }
                
        return TRUE;
    }

    public static function getIncome( $profit )
    {
        $u_income = Income::find()->all();
        
        $q = new \yii\db\Query;
        foreach ( $u_income as $val){
            $atr = $val->getAttributes();     
            if( $atr['from']<= $profit && $atr['to'] > $profit) return $atr; 
        }
                
        return TRUE;
    }


    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Setting the static model class
     */
    public static function model($className = __CLASS__) {
	return parent::model($className);
    }

}

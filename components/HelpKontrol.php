<?php
namespace app\components;

use Yii;
use yii\base\Component;


class HelpKontrol  extends Component
{
    public static function update_cacheMe($table)
    {
        $kol = strlen(Yii::$app->db->tablePrefix);
        $table_name = substr($table, $kol);
//        echo 'ee  aaaaaa     '.$table_name;   exit;
        $q = 'select * from {{%cache}} where tabl = "'.$table_name.'" order by value desc';
        $res = Yii::$app->db->createCommand( $q )->queryAll();
        if(is_array($res) && $count = count($res))
        {
            $s = '';
            foreach ($res as $val)
            {
                $cache_id = $val['name'].$val['value'];
                Yii::$app->cache->delete($cache_id);
                $s .= '"'.$val['tabl'].'",';
            }
            $s = substr($s, 0, -1);
            $now = time();
            $q = 'update  {{%cache}}set value ='.$now.' where tabl in( '.$s.')';
            Yii::$app->db->createCommand( $q )->execute();
        }
    }


    public static function set_cacheMe($cache_id,$data,$duration)
    {
        Yii::$app->cache->set($cache_id,$data,$duration);
    }

    public static function get_cacheMe($table,$sub_name = '')
    {
        $count = 1;
        if( is_array($table) && $count = count($table))
        {   $cache_id = $sub_name;
            foreach ($table as $name) $cache_id .= '_'.$name;
        }
        else $cache_id = $sub_name.'_'.$table;

        $q = 'select value from {{%cache}} where name = "'.$cache_id.'" order by value desc';
        $res = Yii::$app->db->createCommand( $q )->queryAll();
        if( $count != count($res))
        {
            $now = time();
            if( is_array($table) && $count = count($table))
            {
                foreach ( $table as $name)
                {
                    $q = 'insert into {{%cache}} (tabl,name,value) values';
                    $q .= ' ("'.$name.'","'.$cache_id.'",'.$now.')';
                    $q .= ' ON DUPLICATE KEY UPDATE tabl = "'.$name.'"';
                    $res = Yii::$app->db->createCommand($q)->execute();
                }
            }
            else
            {
                $q = 'insert into {{%cache}} (tabl,name,value) values';
                $q .= ' ("'.$table.'","'.$cache_id.'",'.$now.')';
                $q .= ' ON DUPLICATE KEY UPDATE tabl = "'.$table.'"';
                $res = Yii::$app->db->createCommand($q)->execute();
            }
            $cache_id .= $now;
        }
        else $cache_id .= $res[0]['value'];
        //   var_dump($keys_cache);        var_dump(Yii::$app->cache->get($keys_cache[0])); exit;
        return  ['data'=>Yii::$app->cache->get($cache_id),'key'=>$cache_id] ;
    }

    public static function getRoute()
    {
        $params = Yii::$app->request->getQueryParams();
        if (isset($r_params['r'])) { unset($r_params['r']); }
        return  Url::toRoute(ArrayHelper::merge([''],$params));
    }

    public static  function typ_date_time(&$par)
    { $par=trim($par);
        if (preg_match('/^([0-3]?[0-9])\/([01]?[0-9])\/([0-9]{4})$/',$par,$date))
        { $day=$date[1]; $month=$date[2]; $year=$date[3];
            if (checkdate($month,$day,$year) ) {return true;}
        };
        return false;
    }
//      if (preg_match('/^([0-9]{4})-([01]?[0-9])-([0-3]?[0-9]-([0-9]{2}):([0-9]{2}):([0-9]{2}) )$/',$par,$date))

    public static function date_time_all(&$par)
    { $par=trim($par);
        if (preg_match('/^([0-9]{4})-([01]?[0-9])-([0-3]?[0-9]) ([0-2]?[0-9]):([0-5]?[0-9]):([0-5]?[0-9])$/',$par,$date))
        { $day=$date[3]; $month=$date[2]; $year=$date[1];
            if (checkdate($month,$day,$year) && $date[4]<=23 ) {return true;}

        };
        return false;
    }

    public static function typ_name(&$par)
    {
        $par=preg_replace("/[ ]+/i", ' ',$par);
        $par=trim($par);
        if (preg_match("/^[a-zA-Z]{1,4}[a-zA-Z0-9]*/i",$par) )
//            if (preg_match("/^[\s\da-zA-Zа-яА-Я]+/i",$par) )
        {
            return true;
        }
        else  return false;
    }

    public static function typ_name_all(&$par)
    {
        $par=preg_replace("/[ ]+/i", ' ',$par);
        $par=trim($par);
        if (preg_match("/^[a-zA-Zа-яА-Я]{1,4}[a-zA-Zа-яА-Я0-9]*/i",$par) )
//            if (preg_match("/^[\s\da-zA-Zа-яА-Я]+/i",$par) )
        {
            return true;
        }
        else  return false;
    }

    public static function typ_phone(&$par)
    {
        $par=preg_replace("/[ ]+/i", ' ',$par);
        $par=trim($par);
        if (preg_match("/^[0-9|+]?[0-9]+/i",$par) ) return true;
        else  return false;
    }

    public static function typ_email(&$par)
    {   $par=trim($par);
        if (preg_match('/^[a-zA-Z_]+@[a-zA-Z0-9_^\.]+\.[a-zA-Z]{2,6}$/',$par)) {return true; }
        else  return false;
    }

    public static function typ_email_seach(&$par)
    {   $par=trim($par);
        if (preg_match('/^[a-zA-Z_]+@[a-zA-Z0-9_\.]*$/',$par)) {return true; }
        else  return false;
    }

    public static function get_lang(&$par)
    {   $par=trim($par);
        if (preg_match('/^[а-яА-Я_]+$/',$par)) return 'ru';
        else  return 'en';
    }



}  //////////////////////////////////////////

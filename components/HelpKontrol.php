<?php
namespace app\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;


class HelpKontrol  extends Component
{
    public function logMe($mess)
    {
        $my_log = Yii::$app()->params['my_log_file'];
        if ( ! file_exists($my_log) )
        {
            $handle = fopen($my_log, "w+");
            fclose($handle);
        }
        $str = date('[Y-m-d H:i:s]') . ' ' . $mess . "\r\n";
        error_log($str, 3, $my_log);
    }

    public function generate_keyMe($key,$update)
    {
        $arr = array();
        if ( is_array($update) && count($update)>0 )
        {
            foreach( $update as $nom=>$value)
            {
                $arr[] = $key.$value['update_cache'];
                if( $nom>=1) break;
            }
        }
        else $arr[] = $key;
        return $arr;
    }

    public function set_cacheMe($keys,$data,$duration,$key_del)
    {
        Yii::$app->cache->set($keys[0],$data,$duration);
        $key = $key_del.'_del';
        $res = Yii::$app->cache->get($key);
        if( $res )
        {
            Yii::$app->cache->delete($res);
            Yii::$app->cache->delete('view_'.$res);
        }
        Yii::$app->cache->set($key,$keys[0],31536000);
    }

}  //////////////////////////////////////////

<?php
namespace app\components;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\db\Query;


class PagenService extends \yii\base\Component
{
    /**
     * @var integer
     */
    protected $page;

    /**
     * @var integer
     */
    protected $start_page;

    /**
     * @var integer
     */
    protected $end_page;

    /**
     * @var integer
     * kol-vo show pages
     */
    protected $interval_page;

    /**
     * @var integer
     */
    protected $count_interval;

    /**
     * @var integer
     */
    protected $items_per_page;

    /**
     * @var mixed
     */
    protected $ajax_div_id;

    /**
     * @var integer
     */
    protected $pages;

    /**
     * Constructor.
     */
  /*  public function __construct()
    {
        $this->items_per_page = 3;
        $this->start_page = 1;
        $this->interval_page = 2;
    }
*/
    public function init()
    {
        $this->items_per_page = 3;
        $this->start_page = 1;
        $this->interval_page = 2;
        $this->ajax_div_id = 0;
    }

    public function find_start_page( $page )
    {
        $this->count_interval = ceil( $this->pages/$this->interval_page);
        $start = 1;
        for( $i = 1; $i <= $this->count_interval; $i++)
        {
            if( $page >= $start and $page <= $i*$this->interval_page )  break;
            $start += $this->interval_page;
        }
        $this->start_page = $start;
        $this->end_page = $start+$this->interval_page-1;
        if( $this->end_page>$this->pages ) $this->end_page = $this->pages;
        return $start;
    }

    public function link_html( $name,$url )
    {
        $res = '<li class="page">';
        if( $this->ajax_div_id === 0)
            $res .=Html::a($name,$url);
        else
            $res .=Html::a($name,$url, ['onclick' => 'return ajaxpagen('."'".$this->ajax_div_id."','".$url."')"]);
        return $res .='</a></li>';
    }

    public function puc_begin( $route )
    {
        $route['page'] = 1;
        $url = Url::toRoute($route);
        $begin_str =  $this->link_html( 'в начало',$url );
        return $begin_str;
    }

    public function puc_lt( $route )
    {
        $new_page = $this->start_page-$this->interval_page;
        $route['page'] = ( $new_page>0 ) ? $new_page : 1;
        $url = Url::toRoute($route);
        $begin_str = $this->link_html( '&lt ',$url );
        return $begin_str;
    }

    public function puc_gt( $route )
    {
        $new_page = $this->start_page+$this->interval_page;
        $route['page'] = ( $new_page<=$this->pages ) ? $new_page : $this->pages;
        $url = Url::toRoute($route);
        $end_str = $this->link_html( '&gt ',$url );
        return $end_str;
    }

    public function puc_end( $route )
    {
        $route['page'] = $this->pages;
        $url = Url::toRoute($route);
        $end_str = $this->link_html( 'в конец ',$url );
        return $end_str;
    }

    public function myPaginat($all_row,$route,$page)
    {
        $this->pages = ceil($all_row/$this->items_per_page);
        if( $page<1 ) $page = 1;
        $this->page = $page;

        if( $this->pages <= 1)  return '';
        if( $this->pages <= $this->interval_page)
        {
            $this->start_page = 1;
            $this->end_page = $this->pages;
            $begin_str = '';
            $end_str = '';
        }
        else
        {
            $this->find_start_page( $page );
        //    ld('11 $this->end_page'.$this->end_page.' $this->pages= '.$this->pages);
            switch ( $this->end_page ):
                case  $this->interval_page : { // в начало
                    $begin_str = '';
                    $end_str = $this->puc_gt( $route );
                    $end_str .= $this->puc_end( $route );
                    break;
                }
                case  $this->pages : { // в конец
                    $begin_str = $this->puc_begin( $route );
                    $begin_str .= $this->puc_lt( $route );
                    $end_str = '';
                    break;
                }
                default : { // текущая страница
                    $begin_str = $this->puc_begin( $route );
                    $begin_str .= $this->puc_lt( $route );
                    $end_str = $this->puc_gt( $route );
                    $end_str .= $this->puc_end( $route );
                }
            endswitch;
        }

        $res = '<div class="pager-blue">'."\n"
            .'<span class="pagination-label">Перейти к странице:</span> '."\n"
            .'<ul id="foot_pager" class="pagination">';
        $res .= $begin_str;
        for( $k = $this->start_page; $k <= $this->end_page; $k++)
        {
            if($k == $this->page )  {
                $route['page'] = $k;
                $url = Url::toRoute($route);
//                $tek = '<li class="page selected">';
                $tek = '<li class="page active">';
                $tek .= ( $this->ajax_div_id === 0) ? Html::a($k,$url) :
                        Html::a($k,$url, array('onclick' => 'return ajaxpagen('."'".$this->ajax_div_id."','".$url."')"));
                $tek .= '</li>';
            }
            else
            {
                $route['page'] = $k;
                $url = Url::toRoute($route);
                $tek = $this->link_html( $k,$url );
            }
            $res.=$tek;
        }
        $res.='&nbsp;&nbsp;'.$end_str;
        $res .= '</ul>'."\n".'</div>';
        return  $res;
    }

    public  function getPaginat($count, Query $q_all,$per_page,$inter_page,$page,$AjaxDivId=0)
    {
        $r_param = Yii::$app->request->queryParams;
        if (isset($r_param['r'])) {
            $route_all[] = $r_param['r'];
            unset($r_param['r']);
        }
        foreach ($r_param as $row)
           if(is_array($row)) foreach ($row as $key=>$val ) $route_all[$key] = $val;
        $route_all['page'] = $page;  
        $all_count = $count['kol'];
        if ($all_count >0)
        {
            $this->setInterval_page($inter_page);
            $this->setItems_per_page($per_page);
            if ($AjaxDivId != 0) $this->setAjaxDivId('#'.$AjaxDivId);
            $pages = $this->myPaginat( $all_count, $route_all,$page);

            $page = $this->getPage();
            $limit = $this->getItems_per_page();
            $offset = ($page-1)*$limit;
            $q_all->limit($limit)->offset($offset);
         
            $result= $q_all->createCommand()->queryAll();
 //           echo '                page='.$page.'  $q_all='; print_r($q_all);
     //       echo ' <br/>                 all='.$all_count.'  res='; print_r($pages); exit;
            return  array('values'=>$result,'pages'=>$pages,'page'=>$page );
        }
        else  return  array('values'=>array(),'pages'=>'','page'=>1);
    }

    public  function getPaginatCateg($count, Query $q_all,$per_page,$inter_page,$page,$AjaxDivId=0)
    {
        $r_param = Yii::$app->request->queryParams;         
        $route_all[] = $r_param['r'];        
        unset($r_param['r']);
        foreach ($r_param as $row)
           if(is_array($row)) foreach ($row as $key=>$val ) $route_all[$key] = $val;
        $route_all['page'] = $page;  

        $all_count=$count['kol'];
        if ($all_count >0)
        {
            $pagen_service = Yii::$app->pagenService;
            $pagen_service->setInterval_page($inter_page);
            $pagen_service->setItems_per_page($per_page);
            if ($AjaxDivId != 0) $pagen_service->setAjaxDivId('#'.$AjaxDivId);
            $pages = $pagen_service->myPaginat( $all_count, $route,$page);
            $page = $pagen_service->getPage();
            $limit = $pagen_service->getItems_per_page();
            $offset = ($page-1)*$limit;
            $q_all->limit($limit)->offset($offset);
         
            $result= $q_all->createCommand()->queryAll();

            return  array('values'=>$result,'pages'=>$pages,'page'=>$page,'all_count'=>$all_count );
        }
        else  return  array('values'=>array(),'pages'=>'','page'=>1,'all_count'=>0);
    }


    /**
     * Set $Items_per_page
     *
     * @param integer $items_per_page
     * @return PagenService
     */
    public function setItems_per_page($items_per_page)
    {
        if( $items_per_page >0 ) $this->items_per_page = $items_per_page;
        return $this;
    }

    /**
     * Get Items_per_page
     *
     * @return integer
     */
    public function getItems_per_page()
    {
        return $this->items_per_page;
    }

    /**
     * Set $Interval_page
     *
     * @param integer $items_per_page
     * @return PagenService
     */
    public function setInterval_page($interval_page)
    {
        if( $interval_page > 0 ) $this->interval_page = $interval_page;
        return $this;
    }

    public function getInterval_page()
    {
        return $this->interval_page;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function setAjaxDivId($ajax_div_id)
    {
        $this->ajax_div_id = $ajax_div_id;
        return $this;
    }

    public function getAjaxDivId()
    {
        return $this->ajax_div_id;
        return $this;
    }



}


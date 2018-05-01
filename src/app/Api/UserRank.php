<?php
namespace App\Api;

use PhalApi\Api;
use App\Domain\UserRank as DomainUserRank;
use PhalApi\Exception\BadRequestException;
/**
 * 默认接口服务类
 *
 * @author: dogstar <chanzonghuang@gmail.com> 2014-10-04
 */

class UserRank extends Api 
{
    public function getRules() 
    {
        return array(
            'list' => array(
                'page' =>array('name'=> 'page', 'type'=> 'int', 'default' => '1', 'require'=> true),
                'perpage' => array('name' => 'perpage', 'type' => 'int' , 'default'=>\PhalApi\DI()->config->get('comm.perpage'), 'require'=> 'true')
            ),
            'info' =>array(
                'rank_id' => array(
                    'name' => 'rank_id', 'type' => 'int'
                ),
                'rank_name' => array('name'=>'rank_name', 'type' =>'string')
            ),
            'add' => array(
                'rank_name' =>array('name'=>'rank_name', 'type'=>'string','require'=>true),
                'discount' => array('name'=>'discount', 'type'=>'int', 'require'=> true, 'default'=> 0, 'min' => 0, 'max'=>100, 'desc'=>'折扣')
            ),
            'update' => array(
                'rank_id'=> array('name'=>'rank_id', 'require'=> true, 'type'=> 'int'),
                'rank_name' => array('name'=>'rank_name', 'type'=>'string'),
                'discount' => array('name'=>'discount', 'type'=>'int', 'require'=> true, 'default'=> 0, 'min' => 0, 'max'=>100, 'desc'=>'折扣')
            ),
            'delete' => array(
                'rank_id' => array('name'=>'rank_id', 'type'=>'int', 'require'=>true)
            )
        );
    }

    public function list() 
    {
        $rank = new DomainUserRank();
        return array(
            'rank' => $rank->getList($this->page, $this->perpage)
        );
    }
    
    public function info() 
    {
        if(empty($this->rank_id) && empty($this->rank_name))
        {
            throw new BadRequestException('请求参数为空', 1);
        }

        $where = array(
            'rank_id' => $this->rank_id,
            'rank_name' => $this-> rank_name,
        );
        
        $rank = new DomainUserRank();
        return array(
            'rank' => $rank->getInfo($where)
        );
    }

    public function add() 
    {
        $user = new DomainUserRank();
        $data = array(
            'rank_name' => $this->rank_name,
            'discount' => $this->discount
        );
        if( $id = $user->insert($data))
        {
            $rs['id'] = $id;
            return $rs; 
        }else{
            throw new BadRequestException('添加失败', 1);
        }
    }

    public function update()
    {
        if(empty($this->rank_id))
        {
            throw new BadRequestException('rank_id', 1);
        }
        if(empty($this->rank_name) && empty($this->discount))
        {
            throw new BadRequestException('请求参数为空', 1);
        }
        $userRank = new DomainUserRank();
        $data =array();
        $data['rank_name'] = $this->rank_name;
        $data['discount'] = $this->discount;

        return $userRank->update($this->rank_id, $data);
    }

    public function delete()
    {
        $rank = new DomainUserRank();
        return $rank->delete($this->rank_id);
    }
}

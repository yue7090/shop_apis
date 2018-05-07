<?php
namespace App\Api;

use PhalApi\Api;
use App\Domain\ProductAttribute as DomainProductAttribute;
use PhalApi\Exception\BadRequestException;
/**
 * 默认接口服务类
 *
 * @author: dogstar <chanzonghuang@gmail.com> 2014-10-04
 */

class ProductAttribute extends Api 
{
    public function getRules() 
    {
        return array(
            'list' => array(
                'page' 	=> array('name' => 'page', 'default' => '1', 'desc' => '页码', 'require' => true),
                'perpage' 	=> array('name' => 'perpage', 'default' => \PhalApi\DI()->config->get('comm.perpage'), 'desc' => '每页显示条数', 'require' => true),
            ),
            'info' => array(
                'attr_id' => array('name' => 'attr_id', 'desc'=> 'attr_id'),
                'attr_name' => array('name' => 'attr_name')
            ),
            // 'regist' => array(
            //     'user_name' => array('name' => 'user_name', 'desc' => '用户名', 'require' => true ),
            //     'email' => array('name' => 'email', 'desc' => '邮箱', 'require' => true ),
            //     'password' => array('name' => 'password', 'desc' => '密码', 'require' => true ),
            //     'ec_salt' => array('name' => 'ec_salt', 'desc' => 'MD5加密盐值', 'default' => rand(1000, 9999), 'require' => true),
            // ),
            // 'update' => array(
            //     'user_id' =>array('name' => 'user_id', 'require' => true, 'type' => 'int'),
            //     'user_name' => array('name' => 'user_name', 'desc' => '用户名'),
            //     'email' => array('name' => 'email', 'desc' => '邮箱' ),
            //     'password' => array('name' => 'password', 'desc' => '密码' ),
            // ),
            'delete' => array(
                'attr_id' => array('name' => 'attr_id', 'type' => 'int', 'require' => true)
            )
        );
    }

    public function list() 
    {
        $productAttribute = new DomainProductAttribute();
        return array(
            'productAttribute' => $productAttribute->getList($this->page, $this->perpage)
        );
    }
    
    public function info() 
    {
        if(empty($this->attr_id) && empty($this->attr_name))
        {
            throw new BadRequestException('请求参数为空', 1);
        }

        $where = array(
            'attr_id' => $this->attr_id,
            'attr_name' => $this->attr_name
        );
        
        $productAttribute = new DomainProductAttribute();
        return array(
            'productAttribute' => $productAttribute->getInfo($where)
        );
    }

    // public function add() 
    // {
    //     $user = new DomainUser();
    //     $data = array(
    //         'region_name' => $this->user_name,
    //         'email' => $this->email,
    //         'password' => $this->password,
    //         'ec_salt' => $this->ec_salt,
    //     );
    //     if( $id = $user->insert($data))
    //     {
    //         $rs['id'] = $id;
    //         return $rs; 
    //     }else{
    //         throw new BadRequestException('注册失败', 1);
    //     }
    // }

    // public function update()
    // {
    //     if(empty($this->user_id))
    //     {
    //         throw new BadRequestException('user_id为空', 1);
    //     }
    //     if(empty($this->password) && empty($this->email) && empty($this->user_name))
    //     {
    //         throw new BadRequestException('请求参数为空', 1);
    //     }
    //     $user = new DomainUser();
    //     $data =array();
    //     $data['password'] = $this->password;
    //     $data['email'] = $this->email;
    //     $data['user_name'] = $this->user_name;

    //     return $user->update($this->user_id, $data);
    // }

    public function delete()
    {
        $productAttribute = new DomainProductAttribute();
        return $productAttribute->delete($this->attr_id);
    }
}

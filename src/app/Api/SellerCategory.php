<?php
namespace App\Api;

use PhalApi\Api;
use App\Domain\SellerCategory as DomainSellerCategory;
use PhalApi\Exception\BadRequestException;
/**
 * 默认接口服务类
 *
 * @author: dogstar <chanzonghuang@gmail.com> 2014-10-04
 */

class SellerCategory extends Api 
{
    public function getRules() 
    {
        return array(
            'list' => array(
                'page' 	=> array('name' => 'page', 'default' => '1', 'desc' => '页码', 'require' => true),
                'perpage' 	=> array('name' => 'perpage', 'default' => \PhalApi\DI()->config->get('comm.perpage'), 'desc' => '每页显示条数', 'require' => true),
            ),
            'info' => array(
                'cat_id' => array('name' => 'cat_id', 'desc'=> 'cat_id'),
                'cat_name' => array('name' => 'cat_name')
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
                'cat_id' => array('name' => 'cat_id', 'type' => 'int', 'require' => true)
            )
        );
    }

    public function list() 
    {
        $sellerCategory = new DomainSellerCategory();
        return array(
            'sellerCategory' => $sellerCategory->getList($this->page, $this->perpage)
        );
    }
    
    public function info() 
    {
        if(empty($this->cat_id) && empty($this->cat_name))
        {
            throw new BadRequestException('请求参数为空', 1);
        }

        $where = array(
            'cat_id' => $this->cat_id,
            'cat_name' => $this->cat_name
        );
        
        $sellerCategory = new DomainSellerCategory();
        return array(
            'sellerCategory' => $sellerCategory->getInfo($where)
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
        $sellerCategory = new DomainSellerCategory();
        return $sellerCategory->delete($this->cat_id);
    }
}

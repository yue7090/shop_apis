<?php
namespace App\Domain;

use App\Model\SellerCategory as ModelSellerCategory;

class SellerCategory {

    public function getList($page, $perpage) {
        $rs = array('items' => array(), 'total' => 0);

        $model = new ModelSellerCategory();
        $items = $model->getSellerCategoryItems($page, $perpage);
        $total = $model->getSellerCategoryTotal();

        $rs['items'] = $items;
        $rs['total'] = $total;

        return $rs;
    }

    public function getInfo($where)
    {
        $rs = array('info' => array());
        foreach( $where as $k=> $v )
        {
            if(empty($v))
            {
                unset($where[$k]);
            }
        }
        $model = new ModelSellerCategory();
        $info = $model->getSellerCategoryInfo($where);
        $rs['info'] = $info;
        return $rs;
    }

    // public function insert($data)
    // {
    //     // todo 验证用户名 邮箱的唯一性
    //     $model = new ModelUser();
    //     $data['password'] = md5($data['password'].$data['ec_salt'] );
    //     $data['reg_time'] = strtotime(date("Y-m-d H:i:s"));
    //     $data['aite_id'] = '';
    //     $data['nick_name'] = '';
    //     $data['alias'] = '';
    //     $data['msn'] = '';
    //     $data['qq'] = '';
    //     $data['office_phone'] = '';
    //     $data['home_phone'] = '';
    //     $data['mobile_phone'] = '';
    //     $data['credit_line'] = 0;
    //     $data['user_picture'] = '';
    //     $data['old_user_picture'] = '';
    //     return $model->insert($data);
    // }

    // public function update($user_id, $data)
    // {
    //     $model = new ModelUser();
    //     foreach( $data as $k=> $v )
    //     {
    //         if(empty($v))
    //         {
    //             unset($data[$k]);
    //         }
    //     }

    //     if(isset($data['password']))
    //     {
    //         $data['ec_salt'] = rand( 1000, 9999);
    //         $data['password'] = md5($data['password'].$data['ec_salt']);
    //     }

    //     $data['last_time'] = date('Y-m-d H:i:s');
    //     return $model->update($user_id,$data);
    // }

    public function delete($cat_id)
    {
        $model = new ModelSellerCategory();
        return $model->delete($cat_id);
    }
}

<?php
namespace App\Domain;

use App\Model\UserRank as ModelUserRank;

class UserRank {

    public function getList($page, $perpage) {
        $rs = array('items' => array(), 'total' => 0);

        $model = new ModelUserRank();
        $items = $model->getUserRankItems($page, $perpage);
        $total = $model->getUserRankTotal();

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
        $model = new ModelUserRank();
        $info = $model->getUserRankInfo($where);
        $rs['info'] = $info;
        return $rs;
    }

    public function insert($data)
    {
        // todo 验证用户名 邮箱的唯一性
        $model = new ModelUserRank();
        return $model->insert($data);
    }

    public function update($rank_id, $data)
    {
        $model = new ModelUserRank();
        foreach( $data as $k=> $v )
        {
            if(empty($v))
            {
                unset($data[$k]);
            }
        }
        return $model->update($rank_id,$data);
    }

    public function delete($rank_id)
    {
        $model = new ModelUserRank();
        return $model->delete($rank_id);
    }
}

<?php
namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;


class ProductType extends NotORM {

    protected function getTableName($id) {
        return 'goods_type';
    }

    protected function getTableKey($table)
    {
        return 'cat_id';
    }


    public function getProductTypeItems($page, $perpage) {
        return $this->getORM()
            ->select('*')
            ->order('cat_id DESC')
            ->limit(($page - 1) * $perpage, $perpage)
            ->fetchAll();
    }

    public function getProductTypeTotal() {
        $total = $this->getORM()
            ->count('cat_id');

        return intval($total);
    }

    public function getProductTypeInfo($where)
    {   
        return $this->getORM()
        ->where($where)
        ->fetchOne();
    }

}

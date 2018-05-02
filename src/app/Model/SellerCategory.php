<?php
namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;


class SellerCategory extends NotORM {

    protected function getTableName($id) {
        return 'wholesale_cat';
    }

    protected function getTableKey($table)
    {
        return 'cat_id';
    }


    public function getSellerCategoryItems($page, $perpage) {
        return $this->getORM()
            ->select('*')
            ->order('cat_id DESC')
            ->limit(($page - 1) * $perpage, $perpage)
            ->fetchAll();
    }

    public function getSellerCategoryTotal() {
        $total = $this->getORM()
            ->count('cat_id');

        return intval($total);
    }

    public function getSellerCategoryInfo($where)
    {   
        return $this->getORM()
        ->where($where)
        ->fetchOne();
    }

}

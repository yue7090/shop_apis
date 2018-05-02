<?php
namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;


class ProductCategory extends NotORM {

    protected function getTableName($id) {
        return 'category';
    }

    protected function getTableKey($table)
    {
        return 'cat_id';
    }


    public function getProductCategoryItems($page, $perpage) {
        return $this->getORM()
            ->select('*')
            ->order('cat_id DESC')
            ->limit(($page - 1) * $perpage, $perpage)
            ->fetchAll();
    }

    public function getProductCategoryTotal() {
        $total = $this->getORM()
            ->count('cat_id');

        return intval($total);
    }

    public function getProductCategoryInfo($where)
    {   
        return $this->getORM()
        ->where($where)
        ->fetchOne();
    }

}

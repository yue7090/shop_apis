<?php
namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;


class ProductAttribute extends NotORM {

    protected function getTableName($id) {
        return 'attribute';
    }

    protected function getTableKey($table)
    {
        return 'attr_id';
    }


    public function getProductAttributeItems($page, $perpage) {
        return $this->getORM()
            ->select('*')
            ->order('attr_id DESC')
            ->limit(($page - 1) * $perpage, $perpage)
            ->fetchAll();
    }

    public function getProductAttributeTotal() {
        $total = $this->getORM()
            ->count('attr_id');

        return intval($total);
    }

    public function getProductAttributeInfo($where)
    {   
        return $this->getORM()
        ->where($where)
        ->fetchOne();
    }

}

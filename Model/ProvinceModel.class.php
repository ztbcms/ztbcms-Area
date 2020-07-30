<?php

// +----------------------------------------------------------------------
// | Author: Jayin Ton <tonjayin@gmail.com>
// +----------------------------------------------------------------------

namespace Area\Model;

/**
 * 省份级别,如北京, 广东省
 *
 * @package Area\Model
 */
class ProvinceModel extends BaseModel{

    protected $tableName = 'area_province';

    public function getProvinces() {
        // 设置缓存
        $data = S('getProvinces');
        if($data) return $data;

        $data = $this->get(0, self::LEVEL_PROVINCE);
        S('getProvinces',$data,3600);
        return $data;
    }

    public function getProvinceById($id){
        $result = $this->where(['id' => $id])->find();
        return $result;
    }


}
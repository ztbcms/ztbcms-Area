<?php

// +----------------------------------------------------------------------
// | Author: Jayin Ton <tonjayin@gmail.com>
// +----------------------------------------------------------------------

namespace Area\Model;

/**
 * 市级别, 如北京市, 广东佛山
 *
 * @package Area\Model
 */
class CityModel extends BaseModel{

    protected $tableName = 'area_city';


    public function getCitiesByProvinceId($id) {
        // 设置缓存
        $data = S('getCitiesBy'.$id);
        if($data) return $data;

        $data = $this->get($id, self::LEVEL_CITY);
        S('getCitiesBy'.$id,$data,3600);
        return $data;
    }

    public function getCityById($id){
        $result = $this->where(['id' => $id])->find();
        return $result;
    }



}
<?php

// +----------------------------------------------------------------------
// | Author: Jayin Ton <tonjayin@gmail.com>
// +----------------------------------------------------------------------

namespace Area\Model;


/**
 * 县、区级别,如:佛山市南海区
 *
 * @package Area\Model
 */
class DistrictModel extends BaseModel {


    protected $tableName = 'area_district';

    public function getDistrictsByCityId($id) {
        // 设置缓存
        $data = S('getDistrictsBy'.$id);
        if($data) return $data;

        // 若区与市同名，且只有一个区，则使用第四级区域
        $data = $this->get($id, self::LEVEL_DISTRICT);
        $city = (new CityModel)->where(['id'=>$id])->getField('areaname');
        if(count($data) == 1 && $data[0]['areaname'] == $city){
            $data = (new StreetModel)->getStreetsByDistrictId($data[0]['id']);
        }

        S('getDistrictsBy'.$id,$data,3600);
        return $data;
    }

    public function getDistrictById($id){
        $result = $this->where(['id' => $id])->find();
        return $result;
    }

}
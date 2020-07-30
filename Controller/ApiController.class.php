<?php

// +----------------------------------------------------------------------
// | Author: Jayin Ton <tonjayin@gmail.com>
// +----------------------------------------------------------------------

namespace Area\Controller;

use Area\Model\CityModel;
use Area\Model\DistrictModel;
use Area\Model\ProvinceModel;
use Area\Model\SchoolModel;
use Area\Model\StreetModel;
use Common\Controller\Base;

/**
 * 区域模块对外API
 *
 * @package Area\Controller
 */
class ApiController extends Base {

    protected function _initialize() {
        parent::_initialize();

    }

    /**
     * 获取学校列表
     * @param string $keyword
     * @param int $page
     * @param int $limit
     */
    public function getSchoolList($keyword = '', $page = 1, $limit = 100000) {
        $schoolModel = new SchoolModel();
        $where = [];
        if ($keyword) {
            $where['school_name'] = array(
                'like',
                "%" . $keyword . "%"
            );
        }
        $schools = $schoolModel->where($where)->page($page, $limit)->select();
        $this->ajaxReturn(array(
            'status' => 'success',
            'data' => $schools ? $schools : array(),
        ));
    }

    /**
     * 通过省份id获取学校列表
     * @param int $province_id
     * @param int $page
     * @param int $limit
     */
    public function getSchoolListByProvinceId($province_id = 0, $page = 1, $limit = 1000) {
        $schoolModel = new SchoolModel();
        $where = [];
        $province_id ? $where['province_id'] = $province_id : null;
        $schools = $schoolModel->where($where)->page($page, $limit)->select();
        $this->ajaxReturn(array(
            'status' => 'success',
            'data' => $schools ? $schools : array(),
        ));
    }

    /**
     * 省份
     */
    public function getProvinces() {
        $ProvinceModel = new ProvinceModel();

        $this->ajaxReturn(array(
            'status' => 'success',
            'data' => $ProvinceModel->getProvinces()
        ));
    }

    /**
     * 市
     *
     * @param int $id 省份ID
     */
    public function getCitiesByProvinceId($id) {
        $CityModel = new CityModel();

        $this->ajaxReturn(array(
            'status' => 'success',
            'data' => $CityModel->getCitiesByProvinceId($id)
        ));
    }

    /**
     * 根据省份名称模糊搜索城市列表
     * @param string $province_name 省名
     */
    public function getCitiesByProvince($province_name = '') {
        $ProvinceModel = new ProvinceModel();
        $where['areaname'] = array(
            'like',
            $province_name . "%"
        );
        $province = $ProvinceModel->where($where)->find();

        $id = $province['id'];
        $CityModel = new CityModel();
        $this->ajaxReturn(array(
            'status' => 'success',
            'data' => $CityModel->getCitiesByProvinceId($id)
        ));
    }

    /**
     * 区、县
     *
     * @param int $id 城市ID
     */
    public function getDistrictsByCityId($id) {
        $DistrictModel = new DistrictModel();

        $this->ajaxReturn(array(
            'status' => 'success',
            'data' => $DistrictModel->getDistrictsByCityId($id)
        ));

    }

    /**
     * 根据城市名称迷糊搜索区/县
     *
     * @param string $city_name 城市名
     */
    public function getDistrictsByCity($city_name = '') {
        $CityModel = new CityModel();
        $where['areaname'] = array(
            'like',
            $city_name . "%"
        );
        $city = $CityModel->where($where)->find();
        $id = $city['id'];
        $DistrictModel = new DistrictModel();

        $this->ajaxReturn(array(
            'status' => 'success',
            'data' => $DistrictModel->getDistrictsByCityId($id)
        ));

    }


    /**
     * 街道
     *
     * @param int $id 区县ID
     */
    public function getStreetsByDistrictId($id) {
        $StreetModel = new StreetModel();

        $this->ajaxReturn(array(
            'status' => 'success',
            'data' => $StreetModel->getStreetsByDistrictId($id)
        ));
    }

    /**
     * 获取省市区树状
     */
    public function getAreaTree(){
        $Area = S('getAreaTree');
        if($Area){
            $this->ajaxReturn(self::createReturn(true,$Area));
        }

        $ProvinceModel = new ProvinceModel();
        $CityModel = new CityModel();
        $DistrictModel = new DistrictModel();

        $list = $ProvinceModel->getProvinces();
        $data = [];
        foreach ($list as $key =>  $province){
            $data[$key]['areaname'] = $province['areaname'];
            $data[$key]['children'] = $CityModel->getCitiesByProvinceId($province['id']);
            foreach ($data[$key]['children']  as $cityKey => $child){
                $data[$key]['children'][$cityKey]['children'] = $DistrictModel->getDistrictsByCityId($child['id']);
            }
        }
        S('getAreaTree',$data,'3600');
        $this->ajaxReturn(self::createReturn(true,$data));
    }


}
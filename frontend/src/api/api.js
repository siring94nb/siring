import axios from 'axios'
const base_url = 'https://manage.siring.com.cn';
/**
 * 登录
 * @param {phone, password}
 */
export const Login = params => {
  return axios.post('api/api/user/login', params)
}

/**
 * 注册
 * @param {phone, password, password_confirm, invitation, code}
 */
export const Register = params => {
  return axios.post('api/api/user/register', params)
}

/**
 * 获取手机验证码
 * @param {phone}
 */
export const GetCode = params => {
  return axios.post('api/api/user/phone_code', params)
}

/**
 * 忘记密码
 * @param {phone, password, password_confirm, code}
 */
export const ForgetPwd = params => {
  return axios.post('api/api/user/forget', params)
}

/**
 * 首页轮播图
 * 
 */
export const GetBannerList = params => {
  return axios.post('api/api/banner/banner_list', params)
}

// 角色加盟

/**
 * 获取加盟省份
 */
export const GetProvince = params => {
  return axios.post('api/api/JoinRole/province_list', params);
}

/**
 * 获取城市等级列表
 */
export const GetLevelList = params => {
  return axios.post('api/api/JoinRole/grade_list', params);
}

/**
 * 获取加盟城市
 */
export const GetCityList = params => {
  return axios.post('api/api/JoinRole/city_list', params);
}

/**
 * 城市合伙人下单
 */
export const CityOrderAdd = params => {
  return axios.post('api/api/JoinOrder/city_order_add', params);
}

/**
 * 用户折扣
 */
export const GetDiscount = params => {
  return axios.post('api/api/JoinRole/discount', params);
}

/**
 * 支付订单
 */
export const Payment = params => {
  return axios.post('api/api/JoinOrder/get_pay', params);
}
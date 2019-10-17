import axios from 'axios'

/**
 * 登录
 * @param {phone, password}
 */
export const Login = params => {
  return axios.post('/api/api/user/login', params)
}

/**
 * 注册
 * @param {phone, password, password_confirm, invitation, code}
 */
export const Register = params => {
  return axios.post('/api/api/user/register', params)
}

/**
 * 获取手机验证码
 * @param {phone}
 */
export const GetCode = params => {
  return axios.post('/api/api/user/phone_code', params)
}

/**
 * 忘记密码
 * @param {phone, password, password_confirm, code}
 */
export const ForgetPwd = params => {
  return axios.post('/api/api/user/forget', params)
}

/**
 * 首页轮播图
 * 
 */
export const GetBannerList = params => {
  return axios.post('/api/api/banner/banner_list', params)
}
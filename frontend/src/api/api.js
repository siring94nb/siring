import axios from 'axios'
import qs from 'qs';

// https://manage.siring.com.cn/
let base_url = '/api/';
// axios.defaults.headers['Content-Type'] = 'application/x-www-form-urlencoded'
// axios.defaults.headers['Content-Type']='application/json'
const env = process.env.NODE_ENV;
if (env === 'production') {
  base_url = '/'
}


/**
 * 登录
 * @param {phone, password}
 */
export const Login = params => {
  return axios.post(`${base_url}api/user/login`, qs.stringify(params)).then(res => res.data);
}

/**
 * 注册
 * @param {phone, password, password_confirm, invitation, code}
 */
export const Register = params => {
  return axios.post(`${base_url}api/user/register`, qs.stringify(params)).then(res => res.data);
}

/**
 * 退出登录
 */
export const Logout = params => {
  return axios.get(`${base_url}api/user/logout`, { params: params });
}

/**
 * 获取手机验证码
 * @param {phone}
 */
export const GetCode = params => {
  return axios.post(`${base_url}api/user/phone_code`, qs.stringify(params)).then(res => res.data);
}

/**
 * 忘记密码
 * @param {phone, password, password_confirm, code}
 */
export const ForgetPwd = params => {
  return axios.post(`${base_url}api/user/forget`, qs.stringify(params)).then(res => res.data);
}

/**
 * seo优化
 */
export const Seo = params => {
  return axios.get(`${base_url}api/Website/seo`, { params: params });
}

/**
 * 首页轮播图
 * 
 */
export const GetBannerList = params => {
  return axios.post(`${base_url}api/banner/banner_list`, qs.stringify(params)).then(res => res.data);
}


// 角色加盟
/**
 * 获取加盟省份
 */
export const GetProvince = params => {
  return axios.post(`${base_url}api/JoinRole/province_list`, qs.stringify(params)).then(res => res.data);
}

/**
 * 获取城市等级列表
 */
export const GetLevelList = params => {
  return axios.post(`${base_url}api/JoinRole/grade_list`, qs.stringify(params)).then(res => res.data);
}

/**
 * 获取加盟城市
 */
export const GetCityList = params => {
  return axios.post(`${base_url}api/JoinRole/city_list`, qs.stringify(params)).then(res => res.data);
}

/**
 * 城市合伙人下单
 */
export const CityOrderAdd = params => {
  return axios.post(`${base_url}api/JoinOrder/city_order_add`, qs.stringify(params)).then(res => res.data);
}

/**
 * 用户折扣
 */
export const GetDiscount = params => {
  return axios.post(`${base_url}api/JoinRole/discount`, qs.stringify(params)).then(res => res.data);
}

/**
 * 支付订单
 */
export const Payment = params => {
  return axios.post(`${base_url}api/JoinOrder/get_pay`, qs.stringify(params)).then(res => res.data);
}

/**
 * 会员等级费用列表
 */
export const GetMemberList = params => {
  return axios.get(`${base_url}api/JoinRole/member_list`, { params: params });
}

/**
 * 等级会员下单
 */
export const MemberOrderAdd = params => {
  return axios.post(`${base_url}api/JoinOrder/member_order_add`, qs.stringify(params)).then(res => res.data);
}

/**
 * 分包商等级分类
 */
export const GetJoinClass = params => {
  return axios.get(`${base_url}api/JoinRole/join_class`, { params: params });
}

/**
 * 分包商费用列表
 */
export const GetJoinList = params => {
  return axios.post(`${base_url}api/JoinRole/join_list`, qs.stringify(params)).then(res => res.data);
}

/**
 * 分包商下单
 */
export const JoinOrderAdd = params => {
  return axios.post(`${base_url}api/JoinOrder/join_order_add`, params).then(res => res.data);
}

/**
 * 收益预测
 */
export const GetProfit = params => {
  return axios.post(`${base_url}api/JoinRole/profit`, params).then(res => res.data);
}

/**
 * 快捷估价 表格数据
 */
export const GetTableData = params => {
  return axios.post(`${base_url}api/Evaluate/get_plate_list`, params).then(res => res.data);
}

/**
 * 软件定制 定制类型
 */
export const GetDevlopType = params => {
  return axios.get(`${base_url}api/Software/soft_type`, { params: params });
}

/**
 * 软件定制 商品列表
 */
export const GetGoods = params => {
  return axios.post(`${base_url}api/Software/soft_list`, qs.stringify(params)).then(res => res.data);
}

/**
 * 软件定制 商品详情
 */
export const GetGoodsDetail = params => {
  return axios.post(`${base_url}api/Software/soft_detail`, params).then(res => res.data);
}

/**
 * 软件定制 商品推荐
 */
export const GetRecommend = params => {
  return axios.get(`${base_url}api/Software/soft_push`, { params: params });
}

/**
 * 软件定制 评论
 */
export const GetComment = params => {
  return axios.post(`${base_url}api/Software/soft_reviews`, params).then(res => res.data);
}

/**
 * 软件定制 商品演示
 */
export const GetDemonstration = params => {
  return axios.post(`${base_url}api/Software/soft_demo`, params).then(res => res.data);
}

/**
 * AI推广套餐
 */
export const GetSetMeal = params => {
  return axios.get(`${base_url}api/Manuscript/set_meal`, { params: params });
}

/**
 * 定制案例欣赏
 */
export const GetCustomCase = params => {
  return axios.get(`${base_url}api/Website/custom_case`, { params: params });
}

/**
 * 小程序SaaS 模板列表
 */
export const GetTemplate = params => {
  return axios.get(`${base_url}api/AppletManage/get_model_list`, { params: params });
}

/**
 * 小程序SaaS 模板列表
 */
export const GetTempList = data => {
  return axios.post(`${base_url}api/ModelMeal/model_meal_list`, qs.stringify(data)).then(res => res.data);
}
/**
 * 小程序SaaS 模板套餐下单
 */
export const templatePay = data => {
  return axios.post(`${base_url}api/MealOrder/meal_order_add`, qs.stringify(data)).then(res => res.data);
}
/**
 * 小程序SaaS 银行卡添加
 */
export const addBank = data => {
  return axios.post(`${base_url}api/UserCard/user_card_add`, qs.stringify(data)).then(res => res.data);
}
/**
 * 小程序SaaS 银行支付
 */
export const subBankPay = data => {
  return axios.post(`${base_url}api/UserCard/user_card_list`, qs.stringify(data)).then(res => res.data);
}
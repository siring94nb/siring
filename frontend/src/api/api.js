import axios from 'axios'
import qs from 'qs';
// qs 是一个增加了一些安全性的查询字符串解析和序列化字符串的库。
// https://manage.siring.com.cn/
let base_url = 'https://manage.siring.com.cn/';
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
/*
 *控制台获取用户信息
 */
export const GetUserMassage = params => {
    return axios.post(`${base_url}api/Console/personal_information`, qs.stringify(params)).then(res => res.data);
}
/*
 *获取我的订单总数
 */
export const GetSumIndent = params => {
    return axios.post(`${base_url}api/Console/my_order`, qs.stringify(params)).then(res => res.data);
}

/**
 * 获取手机验证码
 * @param {phone}
 */
export const GetCode = params => {
    return axios.post(`${base_url}api/user/phone_code`, qs.stringify(params)).then(res => res.data);
}
/*
 *获取企业列表
 */
export const GetEnterprise = params => {
    return axios.post(`${base_url}api/user/enterprise_list`, qs.stringify(params)).then(res => res.data);
}
/*
 *新增企业信息（title:企业名称，duty：税号，business_license：营业执照，id_card_just：身份证正面，id_card_back：身份证反面）
 */
export const EnterpriseAdd = params => {
    return axios.post(`${base_url}api/user/enterprise_add`, qs.stringify(params)).then(res => res.data);
}
/**
 * 忘记密码或修改密码
 * @param {phone, password, password_confirm, code}
 */
export const ForgetPwd = params => {
    return axios.post(`${base_url}api/user/forget`, qs.stringify(params)).then(res => res.data);
}
/**
 * 修改手机
 * @param {user_id, new_phone, new_code, password}
 */
export const UpdPhone = params => {
    return axios.post(`${base_url}api/user/upd_phone`, qs.stringify(params)).then(res => res.data);
}
/**
  * 修改支付密码
  * @param {phone, password, password_confirm, code}
  */
export const paymentCode = params => {
    return axios.post(`${base_url}api/user/balance_password`, qs.stringify(params)).then(res => res.data);
}
/*
*个人信息更新
*/
export const UserUpdating = params => {
    return axios.post(`${base_url}api/user/user_updating`, qs.stringify(params)).then(res => res.data);
}
/*
*控制台-角色中心 -城市、等级、技能
*参数 -type -是1.城市合伙人、2.等级会员、3.分包商
*/
export const GetRoleCenter = params => {
    return axios.post(`${base_url}api/RoleCenter/tips`, qs.stringify(params)).then(res => res.data);
}
/*
*控制台-角色中心-城市合伙人统计
*/
export const CityTotal = params => {
    return axios.get(`${base_url}api/RoleCenter/city_total`, { params: params });
}
/*
*控制台-角色中心-城市合伙人列表(必选参数type类型为int（1：城市累计会员明细 2： 我邀请的会员明细 3：合伙人入驻订单）)
*/
export const CityPartner = params => {
    return axios.post(`${base_url}api/RoleCenter/city_partner`, qs.stringify(params)).then(res => res.data);
}
/*
*控制台-角色中心-会员等级总数统计(邀请的会员总数，佣金总数)
*/
export const MemberTotal = params => {
    return axios.get(`${base_url}api/RoleCenter/member_total`, { params: params });
}
/*
*等级会员页（会员列表 必选参数type类型为int（1：城市累计会员明细 2： 我邀请的会员明细 3：合伙人入驻订单））
*/
export const MemberPartner = params => {
    return axios.post(`${base_url}api/RoleCenter/member_partner`, qs.stringify(params)).then(res => res.data);
}
/*
*分包商页（押金，佣金）
*/
export const SubcontractTotal = params => {
    return axios.get(`${base_url}api/RoleCenter/subcontract_total`, { params: params });
}
/*
*分包商页（必选参数type类型int（1：项目明细 2：申请订单））
*/
export const SubcontractPartner = params => {
    return axios.post(`${base_url}api/RoleCenter/subcontract_partner`, qs.stringify(params)).then(res => res.data);
}
/*
*分包商页项目视窗
*/
export const SubView = params => {
    return axios.get(`${base_url}api/RoleCenter/sub_view`, { params: params });
}
/*
*分包商页（分包商接单）
*/
export const Getreceipt = params => {
    return axios.post(`${base_url}api/RoleCenter/receipt`, qs.stringify(params)).then(res => res.data);
}
/*
*用户分享邀请码
*/
export const GetInvitationCode = params => {
    return axios.post(`${base_url}api/user/share_code`, qs.stringify(params)).then(res => res.data);
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
    return axios.get(`${base_url}api/JoinRole/grade_list`, qs.stringify(params)).then(res => res.data);
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
/**
 * lilu
 * 定制需求下单
 */
export const needOrderAdd = data => {
    return axios.post(`${base_url}api/NeedOrder/need_order_add`, qs.stringify(data)).then(res => res.data);
}
/**
 * 定制需求订单
 */
export const needOrderList = params => {
    return axios.get(`${base_url}api/NeedOrder/need_order_list`, { params: params });
}
/*
*测试图片上传
 */
export const Qnupload = data => {
    return axios.post(`${base_url}api/file/qn_upload`, qs.stringify(data)).then(res => res.data);
}
/**
 * 定制需求订单表单内容
 */
export const getOrderDetail = data => {
    return axios.post(`${base_url}api/NeedOrder/need_order_detail`,  qs.stringify(data)).then(res => res.data);
}
/**
 * 定制需求订单修改状态
 */
export const changeStatus = data => {
    return axios.post(`${base_url}api/NeedOrder/change_status`,  qs.stringify(data)).then(res => res.data);
}
/**
 * 定制需求订单修改内容
 */
export const confirmNeedOrder = data => {
    return axios.post(`${base_url}api/NeedOrder/confirm_need_order`,  qs.stringify(data)).then(res => res.data);
}
// https://manage.siring.com.cn/api/file/qn_upload

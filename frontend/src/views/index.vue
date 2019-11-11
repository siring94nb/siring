<template>
  <div class="index">
    <myheader />
    <myaside />
    <div class="index">
      <myswiper />
      <div class="about">
        <h2 class="title">关于Siring思锐</h2>
        <div class="about-cont">
          <div class="cover">
            <p>深圳市思锐信息技术有限公司（简称：Siring思锐）是一家集综合电商、教育直播、区块链应用与开发、物联网应用开发、综合APP应用高端定制开发、平台运营与推广为一体的高科技企业</p>
            <p>公司成立二十多年来以来一直秉承"为用户着想"的理念，力争项目完成率100%，努力为客户提供最优质的个性化全程服务</p>
            <p>团队核心成员具有十年以上的软件研发经验，凭借着100%的履约能力，赢得业内卓越口碑</p>
            <p>Siring思锐是深圳市物联网智能技术应用协会常务会员、大数据协会常务会员、广东移动ICT指定开发商单位</p>
          </div>
        </div>
      </div>
      <div class="rjdz">
        <h2 class="title">
          软件/定制开发平台
          <i class="iconfont icon-remen fire"></i>
        </h2>
        <div class="tips">
          <i class="iconfont icon-shengyin_shiti"></i>
          <span>温馨提示：为保障“软件/定制开发”产品设计及开发品质，低于5万以下的需求，建议您选择本站的智能模版化的“小程序SaaS平台”板块，自定义自助开发，快去尝试吧！</span>
        </div>
        <div class="rjdz-goods">
          <div class="goods-list">
            <template v-for="(item, index) in goodsList.data">
              <div class="goods-item" v-if="index < 8" :key="item.id">
                <div class="goods-img">
                  <router-link
                    :to="{name: 'goods-detail', params: {id: item.id}}"
                    tag="div"
                    class="goods-img"
                  >
                    <img :src="item.img" width="260" height="165" alt />
                  </router-link>
                </div>
                <div class="model_mall_info_box">
                  <div class="name_box">
                    <div class="top">
                      <div class="single-dot">
                        <!-- <i class="iconfont icon-hotchunse"></i> -->
                        <span class="goods_name">{{item.goods_name}}</span>
                      </div>
                      <i class="el-icon-star-off el-icon-star-on"></i>
                    </div>
                    <div class="bottom">
                      <span class="desc_span">APP|小程序|公众号|H5</span>
                      <span class="ljgm">
                        <router-link
                          :to="{name: 'goods-detail', params: {id: item.id}}"
                          href="javascript:;"
                        >&gt;&gt;立即购买</router-link>
                      </span>
                    </div>
                  </div>
                  <div class="time_box">
                    <div class="brand">
                      <i class="iconfont icon-fenleishouye"></i>
                      <span>{{item.category_title}}</span>
                    </div>
                    <p>
                      <i class="el-icon-time"></i>
                      <span>{{item.period}}天</span>
                    </p>
                  </div>
                </div>
              </div>
            </template>

            <div class="goods-item-holder"></div>
            <div class="goods-item-holder"></div>
            <div class="goods-item-holder"></div>
          </div>
          <router-link to="/goods" class="more">更多</router-link>
        </div>
      </div>
      <div class="xcx">
        <h2 class="title">小程序SaaS平台</h2>
        <div class="xcx-cont">
          <div class="cover">
            <div class="cover-inner">
              <div class="advantage">
                <div class="icon_box">
                  <i class="iconfont icon-dianzan" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <span>优势</span>
                </div>
                <div class="text_box">
                  <p>
                    SaaS是Software-as-a-Service（软件即服务）的简称，费用低廉，用户无需购买服务器，购买软件，所有应用通过平台线上即可完成，
                    <br />您只需定期支付线上服务费用，即可享受相应软件服务，目前推出的SaaS服务，可快速生成各类行业小程序，可为您的事业如虎添翼
                  </p>
                </div>
              </div>
              <div class="disadvantage">
                <div class="icon_box">
                  <i class="iconfont icon-dianzan1" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <span>劣势</span>
                </div>
                <div class="text_box">
                  <p>虽然费用低廉，功能上不如定制灵活；如需个性定制服务，请在模板商城或定制开发板块上寻求服务</p>
                </div>
              </div>
              <div class="tab_box">
                <div class="left_tab">
                  <ul class="nav">
                    <li
                      v-for="(item, index) in xcxnavlist"
                      :key="index"
                      :class="{'on': xcxnavon == index}"
                      @click="xcxnavClick(index)"
                    >{{ item }}</li>
                  </ul>
                </div>
                <div class="right_tab">
                  <div
                    class="content"
                    v-for="(item, index) in xcxdata"
                    :key="index"
                    :style="{'margin-top': index==0?mgtop + 'px': 0}"
                  >
                    <div class="intro">
                      <div class="intro_img">
                        <ul>
                          <li v-for="(v, i) in item.img" :key="i">
                            <div class="white_bg">
                              <img :src="v.url" width="112" height="112" :alt="v.name" />
                            </div>
                            <p>{{v.name}}</p>
                          </li>
                        </ul>
                      </div>
                      <div class="intro_text">
                        <h2>模版简介</h2>
                        <p v-html="item.desc">{{item.desc}}</p>
                      </div>
                    </div>
                    <div class="ljsq">
                      <a href="javascript:;">&gt;&gt;立即申请</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="ai">
        <h2 class="title">AI人工智能推广引擎平台</h2>
        <div class="ai-cont">
          <div class="ai-inner">
            <div class="ai-tabs">
              <el-tabs type="border-card">
                <el-tab-pane label="体验套餐">
                  <ul>
                    <li>1.围绕企业品牌和产品，（专业宣传稿代写：2篇）</li>
                    <li>2.每天覆盖1000个论坛.专业提升企业形象以及知名度.为期30天。</li>
                    <li>3.发布到新闻门户网站，（一共16个站点）。</li>
                    <li>4.优质地方新闻站投放全国地方性新闻站点投放10篇</li>
                    <li>5.问答营销宣传。百度问答，360问答，SOSO问。共50组</li>
                    <li>6.新浪、天涯、西祠、搜狐、雅虎、猫扑等知名论坛200篇。</li>
                    <li>7.在1个论坛版块中（加精或置顶） ，适应于打造热贴</li>
                    <li>8.大型博客推广，新浪，网易，和讯等大型博客发布共100条</li>
                    <li>9.分类信息投放集网、58网、易登等各大分类信息网站，共100条</li>
                    <li>10.微信推广：推荐一个微信大号做直发推广（不小于3万粉丝）</li>
                    <li>11.个人微信朋友圈转发真实转发共100转发</li>
                    <li>12.微博红人推广：推荐以下1个微博大号直发推广（不小于30万粉丝）</li>
                  </ul>
                  <div class="set-meal">
                    <div class="set-meal-price">
                      <span class="through-price">￥199.0</span>
                      <span class="sale-price">￥99.0</span>
                    </div>
                    <a href="javascript:void(0);">&gt;&gt;立即订购</a>
                  </div>
                </el-tab-pane>
                <el-tab-pane label="套餐一">套餐一</el-tab-pane>
                <el-tab-pane label="套餐二">套餐二</el-tab-pane>
                <el-tab-pane label="套餐三">套餐三</el-tab-pane>
              </el-tabs>
            </div>
            <div class="ai-img">
              <img :src="require('@/assets/images/u207.png')" width="667" height="550" />
            </div>
          </div>
        </div>
      </div>
      <jsjm />
      <jdyh />
    </div>
    <myfooter />
  </div>
</template>

<script>
// @ is an alias to /src
import Myheader from "@/components/header";
import Myaside from "@/components/aside";
import Jsjm from "@/components/jsjm";
import Jdyh from "@/components/jdyh";
import Myfooter from "@/components/footer";
import Myswiper from "@/components/mySwiper";
import { GetGoods } from "@/api/api";
export default {
  name: "index",
  components: {
    Myheader,
    Myaside,
    Jsjm,
    Jdyh,
    Myfooter,
    Myswiper
  },
  data() {
    return {
      tabPosition: "left",
      xcxnavon: 0,
      xcxnavlist: [
        "电商",
        "餐饮",
        "旅游",
        "医疗",
        "房产",
        "手机数码",
        "家居",
        "健身"
      ],
      xcxdata: [
        {
          img: [
            {
              url: require("@/assets/images/zong.jpg"),
              name: "综合商城"
            },
            {
              url: require("@/assets/images/nv.jpg"),
              name: "女装商城"
            },
            {
              url: require("@/assets/images/home1.png"),
              name: "家装Lite"
            }
          ],
          desc:
            "网上商城，一站式购物<br />消费者场景化体验，助力客户建立O2O生态体系。"
        },
        {
          img: [
            {
              url: require("@/assets/images/chick1.jpg"),
              name: "炸鸡小店"
            },
            {
              url: require("@/assets/images/fresh.jpg"),
              name: "水果生鲜"
            },
            {
              url: require("@/assets/images/naicha.jpg"),
              name: "奶茶饮品"
            }
          ],
          desc:
            "拥有到店、预定、点餐等一系列人性化功能<br />且带有会员积分优惠、可视化后台数据管理和拓展店铺营销的新渠道"
        },
        {
          img: [
            {
              url: require("@/assets/images/travel.jpg"),
              name: "旅游风光"
            },
            {
              url: require("@/assets/images/dujiajiudian.jpg"),
              name: "度假酒店"
            },
            {
              url: require("@/assets/images/youle.jpg"),
              name: "游乐园"
            }
          ],
          desc:
            "为旅游业客户提供线上购票预约功能<br />以及特色推荐，个性化定制旅程，助力旅游行业快速发展"
        },
        {
          img: [
            {
              url: require("@/assets/images/host.png"),
              name: "医疗模版"
            },
            {
              url: require("@/assets/images/med.jpg"),
              name: "药店模版"
            },
            {
              url: require("@/assets/images/zhong.jpg"),
              name: "中医馆"
            }
          ],
          desc:
            "实现在线医疗服务，无需排队挂号、缴费<br />简化就医流程，减轻医疗双方负担"
        },
        {
          img: [
            {
              url: require("@/assets/images/aprt.jpg"),
              name: "公寓模版"
            },
            {
              url: require("@/assets/images/xiaoqu.jpg"),
              name: "小区生活"
            },
            {
              url: require("@/assets/images/lou1.jpg"),
              name: "楼盘销售"
            }
          ],
          desc: "线上线下打造便利式房地产行业<br />diy细节让消费者更加直观"
        },
        {
          img: [
            {
              url: require("@/assets/images/pei.jpg"),
              name: "手机配件"
            },
            {
              url: require("@/assets/images/shuma.jpg"),
              name: "数码商城"
            },
            {
              url: require("@/assets/images/phone.jpg"),
              name: "手机专卖"
            }
          ],
          desc: "简约生活，科技生活<br />数码信息一目了然"
        },
        {
          img: [
            {
              url: require("@/assets/images/zhuang.jpg"),
              name: "装修建材"
            },
            {
              url: require("@/assets/images/home1.png"),
              name: "家装Lite"
            },
            {
              url: require("@/assets/images/home4.png"),
              name: "家居LITE"
            }
          ],
          desc:
            "具有家具资讯、分享、浏览和关于我们等一系列可diy功能<br />为用户提供更具象化的多形式服务"
        },
        {
          img: [
            {
              url: require("@/assets/images/jian1.jpg"),
              name: "健身模版"
            },
            {
              url: require("@/assets/images/swim.jpg"),
              name: "游泳"
            },
            {
              url: require("@/assets/images/min.jpg"),
              name: "羽毛球馆"
            }
          ],
          desc:
            "利用健身小程序向会员推送私人教练或团操课程<br />通过智能化的手段服务健身市场，全方位应对健身行业问题"
        }
      ],
      mgtop: 0,
      goodsList: []
    };
  },
  mounted() {
    this.getGoods();
  },
  methods: {
    xcxnavClick(index) {
      this.xcxnavon = index;
      this.mgtop = -(index * 325);
      console.log(this.mgtop);
    },
    getGoods() {
      let params = {
        type: 1
      };
      GetGoods(params).then(res => {
        let { code, data, msg } = res;
        // console.log(data);
        if (code !== 1) {
          this.$message.error(msg);
        } else {
          this.goodsList = data;
        }
      });
    }
  }
};
</script>
<style lang="scss" scoped>
.index {
  .about {
    min-width: 1200px;
    .about-cont {
      position: relative;
      background: url("~@/assets/images/fix_bg.jpg") no-repeat center center;
      height: 350px;
      width: 100%;
      background-attachment: fixed;
      .cover {
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.3);
        display: flex;
        flex-direction: column;
        justify-content: center;
        p {
          color: #fff;
          width: 100%;
          text-align: center;
          line-height: 40px;
          letter-spacing: 1px;
          font-size: 16px;
        }
      }
    }
  }
  .rjdz {
    .tips {
      width: 1200px;
      margin: 0 auto 30px;
      color: #ff0000;
      font-size: 14px;
      i {
        font-size: 20px;
        margin-right: 10px;
        vertical-align: middle;
      }
    }
    .rjdz-goods {
      width: 100%;
      background-color: rgb(244, 245, 249);
      padding: 20px 0;
      .goods-list {
        width: 1200px;
        margin: 0 auto;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        .goods-item {
          background-color: #fff;
          box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);
          margin-bottom: 40px;
          .goods-img {
            overflow: hidden;
            &:hover img {
              transform: scale(1.2);
            }
            img {
              transition: transform 0.8s;
            }
          }
          .name_box {
            width: 100%;
            border-bottom: 1px solid #999;
            padding: 10px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            .top,
            .bottom {
              width: 100%;
              display: flex;
              justify-content: space-between;
              align-items: center;
            }
            .top {
              margin-bottom: 5px;
              .el-icon-star-off {
                font-size: 20px;
                color: #999999;
              }
              .el-icon-star-on {
                font-size: 20px;
                color: rgb(244, 234, 42);
              }
              .single-dot {
                max-width: 210px;
              }
              i {
                color: #ff0000;
                font-size: 10px;
                vertical-align: middle;
              }
              span {
                vertical-align: middle;
              }
            }
            .bottom {
              .desc_span {
                font-size: 14px;
                color: #6b6b6b;
                width: 130px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
              }
              .ljgm a {
                text-decoration: none;
                font-size: 14px;
                color: #ff0000;
              }
            }
          }
          .time_box {
            position: relative;
            padding: 8px;
            .brand {
              position: absolute;
              left: 5px;
              top: 50%;
              transform: translateY(-50%);
              span {
                display: inline-block;
                width: 100px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                vertical-align: middle;
                color: #6b6b6b;
                font-size: 16px;
              }
              i {
                font-size: 16px;
                vertical-align: middle;
                margin-right: 5px;
              }
            }
            p {
              width: 100%;
              text-align: right;
              span {
                color: #666;
              }
              .el-icon-time {
                margin-right: 5px;
              }
            }
          }
        }
        .goods-item-holder {
          width: 260px;
          height: 0;
          margin: 0;
          padding: 0;
        }
      }
      .more {
        display: block;
        width: 140px;
        height: 40px;
        margin: 0 auto;
        border: 1px solid #b1120e;
        border-radius: 5px;
        text-align: center;
        line-height: 40px;
        text-decoration: none;
        color: #b1120e;
        font-size: 20px;
      }
    }
  }
  .xcx-cont {
    position: relative;
    background: url("~@/assets/images/fix_bg.jpg") no-repeat center center;
    height: 520px;
    width: 100%;
    background-attachment: fixed;
    .cover {
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.6);
      .cover-inner {
        width: 1200px;
        margin: 0 auto;
        color: #fff;
        font-size: 16px;
        line-height: 28px;
        .advantage {
          width: 100%;
          display: flex;
          height: 75px;
          .icon_box {
            flex: 1;
            display: flex;
            align-items: center;
            color: #fff;
            font-size: 18px;
          }
          .text_box {
            flex: 9;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #fff;
          }
        }
        .disadvantage {
          width: 100%;
          display: flex;
          height: 55px;
          .icon_box {
            flex: 1;
            display: flex;
            align-items: center;
            color: #fff;
            font-size: 18px;
          }
          .text_box {
            flex: 9;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #fff;
          }
        }
        .tab_box {
          height: 390px;
          display: flex;
          .left_tab {
            flex: 1;
            padding: 18px 0;
            .nav {
              border-right: 1px solid #fff;
              height: 100%;
              padding-right: 10px;
              display: flex;
              flex-direction: column;
              justify-content: space-around;
              li {
                width: 100%;
                height: 45px;
                line-height: 45px;
                text-align: center;
                color: #fff;
                font-size: 16px;
                cursor: pointer;
                &.on {
                  background-color: #3091f2;
                  border-radius: 3px;
                }
              }
            }
          }
          .right_tab {
            flex: 8;
            padding: 18px 0 0 0;
            margin-left: 68px;
            width: 1000px;
            height: 325px;
            overflow: hidden;
            .content {
              display: flex;
              width: 100%;
              height: 100%;
              transition: margin-top 0.5s;
              .intro {
                flex: 8;
                .intro_img {
                  margin-bottom: 30px;
                  ul {
                    display: flex;
                    li {
                      margin-right: 60px;
                      text-align: center;
                      .white_bg {
                        background-color: rgba(251, 251, 251, 0.2);
                        padding: 5px;
                        margin-bottom: 15px;
                        img {
                          display: inherit;
                        }
                      }
                      p {
                        width: 100%;
                        text-align: center;
                        font-size: 16px;
                        color: #fff;
                      }
                    }
                  }
                }
                .intro_text {
                  color: #fff;
                  h2 {
                    font-size: 32px;
                    margin-bottom: 20px;
                  }
                  p {
                    font-size: 16px;
                    line-height: 32px;
                  }
                }
              }
              .ljsq {
                flex: 2;
                display: flex;
                justify-content: center;
                align-items: center;
                a {
                  font-size: 24px;
                  color: #fff;
                  &:hover {
                    color: #ff0000;
                  }
                }
              }
            }
          }
        }
      }
    }
  }
  .ai-cont {
    width: 100%;
    background-color: rgb(244, 245, 249);
    height: 580px;
    .ai-inner {
      display: flex;
      width: 1200px;
      margin: 0 auto;
      padding-top: 20px;
      .ai-tabs {
        flex: 1;
        li {
          line-height: 2em;
          color: #333;
        }
        .set-meal {
          display: flex;
          align-items: center;
          justify-content: space-between;
          margin-top: 15px;
          .through-price {
            color: #ccc;
            font-size: 18px;
            text-decoration: line-through;
          }
          .sale-price {
            color: #ff0e35;
            font-size: 24px;
            font-weight: 700;
          }
          a {
            font-size: 18px;
            color: #f00;
            border: 1px solid #f00;
            border-radius: 4px;
            padding: 5px 20px;
          }
        }
      }
      .ai-img {
        flex: 1;
      }
    }
  }
}
</style>

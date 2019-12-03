<template>
  <div class="footer">
    <div class="footer_info">
      <div style="background-color: rgb(81, 81, 81);">
        <div class="footer_ul footer_info_inner">
          <ul class="ft-ul">
            <li>
              <h2>
                定制开发
                <i class="slide"></i>
              </h2>
              <p>
                <a href="javascript:;">IOSAPP开发</a>
              </p>
              <p>
                <a href="javascript:;">安卓APP开发</a>
              </p>
              <p>
                <a href="javascript:;">HTML5开发</a>
              </p>
              <p>
                <a href="javascript:;">小程序开发</a>
              </p>
              <p>
                <a href="javascript:;">区块链开发</a>
              </p>
            </li>
            <li>
              <h2>
                云平台
                <i class="slide"></i>
              </h2>
              <p>
                <a href="javascript:;">小程序SaaS平台</a>
              </p>
              <p>
                <a href="javascript:;">支付平台</a>
              </p>
              <p>
                <a href="javascript:;">短信平台</a>
              </p>
            </li>
            <li>
              <h2>
                模板商城
                <i class="slide"></i>
              </h2>
              <p>
                <a href="javascript:;">智能硬件</a>
              </p>
              <p>
                <a href="javascript:;">电子商务</a>
              </p>
              <p>
                <a href="javascript:;">生活娱乐</a>
              </p>
              <p>
                <a href="javascript:;">金融</a>
              </p>
              <p>
                <a href="javascript:;">媒体</a>
              </p>
              <p>
                <a href="javascript:;">企业服务</a>
              </p>
              <p>
                <a href="javascript:;">政府公益</a>
              </p>
            </li>
            <li>
              <h2>
                投融介
                <i class="slide"></i>
              </h2>
              <p>
                <a href="javascript:;">项目融资申请</a>
              </p>
              <p>
                <a href="javascript:;">融资评审会</a>
              </p>
            </li>
            <li>
              <h2>
                代理加盟
                <i class="slide"></i>
              </h2>
              <p>
                <a href="javascript:;">申请代理</a>
              </p>
            </li>
            <li>
              <h2>
                联系我们
                <i class="slide"></i>
              </h2>
              <p>
                座机:
                <br />0755-36609873
              </p>
              <p>
                专家顾问直线:
                <br />19925374651
              </p>
              <p>
                邮箱:
                <br />zhq@siring.com.cn
              </p>
              <p>
                地址:
                <br />深圳市福田区新闻路1号
                <br />中电信息大厦西座701
              </p>
            </li>
            <li>
              <h2>快速登录</h2>
              <div class="handle_box">
                <div class="handle_logo">
                  <a
                    href="javascript:;"
                    v-for="(item, index) in loginway"
                    :key="index"
                    @mouseenter="hoverclass(index)"
                    :class="{'curr': curr == index}"
                  >
                    <i class="iconfont" :class="item"></i>
                  </a>
                </div>
              </div>
              <div class="code_box">
                <div
                  class="wx_code"
                  v-for="(item, index) in codeList"
                  :key="index"
                  :style="{display: curr==index?'block':'none'}"
                >
                  <span class="wx_span">
                    <img :src="item.url" :alt="item.name" />
                  </span>
                  <p>{{ item.name }}</p>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <div class="yqlj footer_info_inner">
        <h2>友情链接</h2>
        <ul class="clearfix">
          <li>
            <a href="https://mp.weixin.qq.com">微信公众平台</a>
          </li>
          <li>
            <a href="https://open.weixin.qq.com">微信开放平台</a>
          </li>
          <li>
            <a href="https://pay.weixin.qq.com">微信支付平台</a>
          </li>
          <li>
            <a href="https://weixin.qq.com">微信</a>
          </li>
          <li>
            <a href="http://www.kuaidi100.com">快递100</a>
          </li>
          <li>
            <a href="https://www.aliyun.com">阿里云</a>
          </li>
          <li>
            <a href="https://cloud.tencent.com">腾讯云</a>
          </li>
          <li>
            <a href="https://weibo.com">新浪微博</a>
          </li>
          <li>
            <a href="https://www.west.cn">西部数据</a>
          </li>
          <li>
            <a href="https://www.rongcloud.cn">极光推送</a>
          </li>
          <li>
            <a href="https://www.alipay.com/">企业支付宝</a>
          </li>
          <li>
            <a href="https://www.qiniu.com/">七牛云</a>
          </li>
          <li>
            <a href="https://unionpayintl.com/">银联</a>
          </li>
          <li>
            <a href="https://www.shenjianshou.cn/">神箭手云</a>
          </li>
          <li>
            <a href="https://www.paypal.com/">PayPal</a>
          </li>
          <li>
            <a href="http://dev.360.cn/">360移动开放平台</a>
          </li>
          <li>
            <a href="https://www.pgyer.com/">蒲公英</a>
          </li>
          <li>
            <a href="https://open.tencent.com/">腾讯开放平台</a>
          </li>
          <li>
            <a href="https://developer.apple.com/">苹果开发者</a>
          </li>
          <li>
            <a href="https://market.aliyun.com/">阿里云市场</a>
          </li>
          <li>
            <a href="http://www.17sucai.com/">17素材</a>
          </li>
          <li>
            <a href="https://www.csdn.net/">CSDN</a>
          </li>
          <li>
            <a href="https://aws.amazon.com/">亚马逊云</a>
          </li>
          <li>
            <a href="https://xg.qq.com">信鸽推送</a>
          </li>
        </ul>
      </div>
      <div class="bottom">
        <p class="copyright">{{copyright}}</p>
        <div class="bottom-right">
          <div>
            <span class="bottom-gt">&gt;</span>
            <span class="bottom-year">20</span>
          </div>
          <div>
            <p class="bottom-showy">IOE应用开发与服务领航者</p>
            <span>年经验 &gt; 100人团队 &gt; 服务数万客户</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Seo } from "@/api/api";
export default {
  data() {
    return {
      copyright: '',
      curr: 0,
      loginway: [
        "icon-weixinxiaochengxu miniapp",
        "icon-taobao taobao",
        "icon-weixin weixin",
        "icon-weibo sina",
        "icon-dutoutiao toutiao"
      ],
      codeList: [
        {
          name: "小程序",
          url: require("@/assets/images/miniapp.jpg")
        },
        {
          name: "淘宝店铺",
          url: require("@/assets/images/taobao.png")
        },
        {
          name: "微信公众号",
          url: require("@/assets/images/weixin.png")
        },
        {
          name: "新浪微博",
          url: require("@/assets/images/sina.png")
        },
        {
          name: "头条",
          url: require("@/assets/images/toutiao.jpg")
        }
      ]
    };
  },
  mounted() {
    this.getSeo();
  },
  methods: {
    hoverclass(index) {
      this.curr = index;
    },
    getSeo() {
      Seo().then(res => {
        let {data, code} = res.data;
        if(code === 1){
          this.copyright = data.copyright;
        }
      });
    }
  }
};
</script>

<style scoped lang='scss'>
.footer_info {
  width: 100%;
  background-color: #fff;
  .footer_info_inner {
    width: 1200px;
    margin: 0 auto;
    .ft-ul {
      display: flex;
      justify-content: space-between;
      padding-top: 20px;
      li {
        min-width: 86px;
        h2 {
          position: relative;
          display: inline-block;
          font-size: 18px;
          color: #d7d7d7;
          font-weight: bold;
          padding-bottom: 20px;
          margin-bottom: 15px;
          .slide {
            position: absolute;
            bottom: 0;
            left: 0;
            background: url("~@/assets/images/slide.png") no-repeat;
            background-size: 100% 100%;
            width: 86px;
            height: 2px;
          }
        }
        p {
          text-decoration: none;
          font-size: 14px;
          color: #d7d7d7;
          line-height: 30px;
          a {
            text-decoration: none;
            font-size: 14px;
            color: #d7d7d7;
            line-height: 30px;
          }
        }
        .handle_logo {
          i {
            display: inline-block;
            width: 30px;
            height: 30px;
            line-height: 30px;
            color: #fff;
            font-size: 24px;
            background-color: #999;
            border-radius: 3px;
            text-align: center;
            margin-right: 3px;
          }
          a {
            position: relative;
            display: inline-block;
            &.curr {
              .miniapp {
                background-color: #2ba246;
              }
              .taobao {
                background-color: #0490f1;
              }
              .weixin {
                background-color: #2ba246;
              }
              .sina {
                background-color: #e6162d;
              }
              .toutiao {
                background-color: #e6162d;
              }
            }
            &.curr::before {
              display: inline-block;
              transition: all 0.5s;
            }
            &::before {
              display: none;
              content: "";
              width: 0;
              height: 0;
              border-left: 8px dashed transparent;
              border-right: 8px dashed transparent;
              border-bottom: 12px dashed;
              border-top: 0;
              position: absolute;
              bottom: -14px;
              left: 50%;
              margin-left: -12px;
              color: #eee;
            }
          }
        }
        .code_box {
          margin-top: 12px;
          padding: 10px;
          box-sizing: border-box;
          background-color: #eeeeee;
          .wx_span {
            display: inline-block;
            width: 163px;
            height: 163px;
            img {
              width: 100%;
              height: 100%;
            }
          }
          p {
            width: 100%;
            text-align: center;
            color: #b1120e;
            font-size: 16px;
            font-weight: 700;
          }
        }
      }
    }
  }
  .yqlj {
    position: relative;
    margin-bottom: 20px;
    margin-top: 20px;
    h2 {
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      font-size: 24px;
      color: #333;
    }
    ul {
      padding-left: 130px;
      li {
        float: left;
        margin-right: 30px;
        a {
          text-decoration: none;
          font-size: 14px;
          line-height: 24px;
          color: #0099ff;
        }
      }
    }
  }
  .bottom {
    display: flex;
    justify-content: center;
    width: 100%;
    height: 75px;
    background-color: #000;
    .copyright {
      line-height: 75px;
      font-size: 14px;
      color: #fff;
      text-align: center;
    }
    .bottom-right {
      color: #fff;
      display: flex;
      align-items: center;
      margin-left: 100px;
      .bottom-gt {
        font-size: 48px;
        color: #f00;
      }
      .bottom-year {
        font-size: 48px;
        margin-right: 10px;
      }
      .bottom-showy {
        background-color: #f00;
        text-align: center;
      }
    }
  }
}
</style>
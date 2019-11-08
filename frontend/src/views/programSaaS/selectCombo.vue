<template>
  <div class="index">
    <myheader />
    <div class="steps">
      <el-steps :active="2" align-center>
        <el-step title="选择行业模板"></el-step>
        <el-step title="选择套餐"></el-step>
      </el-steps>
    </div>
    <div class="line"></div>
    <div class="notice">
      <img src="../../assets/images/u3009.png" alt />
      <span>温馨提示：您可以选择年套餐更实惠，您还可以选择月套餐逐步熟练和熟悉后再用年套餐！</span>
    </div>
    <div class="honour">
      <div class="honour-item bz-border" @mouseenter="selectEvent(index)">
        <div class="honour-top">
          <div class="top-title">标准年套餐</div>
          <div>适合小微团队开店、个人或三个人以下运营的团队开店，满足本行业内的基础经营需求</div>
          <div class="lines"></div>
          <div class="top-price">￥3888/年</div>
        </div>
        <div class="honour-bot">
          <div class="rights-title">尊享功能</div>
          <ul class="rights">
            <li class="right right-on">极速开店，不会开发也能开店</li>
            <li class="right right-on">一键生成微信小程序</li>
            <li class="right right-on">分销、购物券、邀请码推广工具</li>
            <li class="right right-on">等级会员积分奖励规则</li>
            <li class="right right-on">门店、员工在线管理</li>
            <li class="right right-on">短信群发平台，短信赠送</li>
            <li class="right right-off">个性diy小程序界面</li>
            <li class="right right-off">优惠券、积分兑换等复购工具</li>
            <li class="right right-off">diy广告推广新玩法</li>
            <li class="right right-off">手机客服在线服务</li>
          </ul>
        </div>
        <div class="selectTemp">
          <div class="sel">选择标准月套餐>></div>
          <div>
            <span class="red">*</span>最低低至
            <span class="sel-price">399</span>元/月
          </div>
        </div>
      </div>
      <!-- 2222222 -->
      <div class="honour-item" @mouseenter="selectEvent(index)">
        <div class="honour-top">
          <div class="top-title">精装套餐</div>
          <div>适合成长型团队或企业，满足推广获客、成交转化、客户留存、复购增购、分享裂变等核心经营需求</div>
          <div class="lines"></div>
          <div class="top-price">￥6888/年</div>
        </div>
        <div class="honour-bot">
          <div class="rights-title">尊享功能</div>
          <ul class="rights">
            <li class="right right-on">极速开店，不会开发也能开店</li>
            <li class="right right-on">一键生成微信小程序</li>
            <li class="right right-on">分销、购物券、邀请码推广工具</li>
            <li class="right right-on">等级会员积分奖励规则</li>
            <li class="right right-on">门店、员工在线管理</li>
            <li class="right right-on">短信群发平台，短信赠送</li>
            <li class="right right-off">个性diy小程序界面</li>
            <li class="right right-off">优惠券、积分兑换等复购工具</li>
            <li class="right right-off">diy广告推广新玩法</li>
            <li class="right right-off">手机客服在线服务</li>
          </ul>
        </div>
        <div class="selectTemp">
          <div class="sel">选择标准月套餐>></div>
          <div>
            <span class="red">*</span>最低低至
            <span class="sel-price">799</span>元/月
          </div>
        </div>
      </div>
      <!-- 33333333333 -->
      <div class="honour-item" @mouseenter="selectEvent(index)">
        <div class="honour-top">
          <div class="top-title">豪华套餐</div>
          <div>适合规模化扩张，有多个经营场景需求的成熟商家，满足创新营销玩法等深度经营需求</div>
          <div class="lines"></div>
          <div class="top-price">￥12888/年</div>
        </div>
        <div class="honour-bot">
          <div class="rights-title">尊享功能</div>
          <ul class="rights">
            <li class="right right-on">极速开店，不会开发也能开店</li>
            <li class="right right-on">一键生成微信小程序</li>
            <li class="right right-on">分销、购物券、邀请码推广工具</li>
            <li class="right right-on">等级会员积分奖励规则</li>
            <li class="right right-on">门店、员工在线管理</li>
            <li class="right right-on">短信群发平台，短信赠送</li>
            <li class="right right-off">个性diy小程序界面</li>
            <li class="right right-off">优惠券、积分兑换等复购工具</li>
            <li class="right right-off">diy广告推广新玩法</li>
            <li class="right right-off">手机客服在线服务</li>
          </ul>
        </div>
        <div class="selectTemp">
          <div class="sel">选择标准月套餐>></div>
          <div>
            <span class="red">*</span>最低低至
            <span class="sel-price">1599</span>元/月
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Myheader from "@/components/header";
import { GetTempList } from "@/api/api";
import config from "../../../../web/build/config";

export default {
  name: "selectCombo",
  components: {
    Myheader
  },
  data() {
    return {};
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.getTempList();
    },
    getTempList(){
      GetTempList({"getTempList": 1}).then(res => {
          let { code, data, msg } = res.data;
          if (code === 1) {
            this.tempList = data;
            this.showTemp = data[0];
            this.valData.arr = data[0].id;
          }
        });
    }
  }
};
</script>

<style lang="scss" scoped>
.index {
  margin: auto;
  margin-top: 100px;
  width: 1200px;
  .steps {
    width: 500px;
    margin: auto;
  }
  .line {
    width: 1100px;
    margin: 10px auto;
    height: 2px;
    background-color: rgb(26, 188, 156);
  }
  .notice {
    margin: 15px 0;
    img {
      margin-right: 5px;
    }
  }
  .honour {
    display: flex;
    justify-content: space-between;
    .honour-item {
      width: 350px;
      height: 540px;
      box-sizing: border-box;
      border: 1px solid rgb(201, 201, 201);
      border-radius: 10px;
      .honour-top {
        padding: 18px;
        background-color: rgb(252, 249, 224);
        text-align: center;
        font-size: 13px;
        line-height: 18px;
        border-top-right-radius: 10px;
        border-top-left-radius: 10px;
        .lines {
          background-color: rgb(201, 201, 201);
          height: 1px;
          margin: 15px 0;
        }
        .top-title {
          line-height: 30px;
          width: 150px;
          margin: 10px auto;
          color: #fff;
          text-align: center;
          font-size: 14px;
          border-radius: 68px;
          font-weight: 700;
          background: linear-gradient(
            135deg,
            rgba(255, 255, 255, 1) 0%,
            rgba(255, 255, 255, 1) 0%,
            rgba(201, 201, 201, 1) 44%,
            rgba(201, 201, 201, 1) 100%
          );
        }
        .top-price {
          color: #fff;
          font-size: 24px;
          font-weight: 700;
          width: 200px;
          margin: auto;
          line-height: 38px;
          border-radius: 5px;
          background-color: rgb(201, 201, 201);
        }
      }
      .honour-bot {
        padding: 0 20px;
        .rights-title {
          font-size: 16px;
          color: #aeaeae;
          margin: 20px 0;
        }
        .rights {
          .right {
            font-size: 14px;
            color: #000;
            margin: 14px 0;
          }
          .right::before {
            display: inline-block;
            margin-right: 8px;
          }
          .right-on::before {
            content: "√";
            color: #66cc00;
          }
          .right-off {
            color: #949494;
          }
          .right-off::before {
            content: "×";
            color: #f00;
          }
        }
      }
    }
    .bz-border{border-color:rgb(0,204,204);box-shadow: 0px 0px 10px rgb(0,204,204);}
    .jz-border{border-color:rgb(255,167,38);box-shadow: 0px 0px 10px rgb(255,167,38);}
    .hh-border{border-color:rgb(170,151,19);box-shadow: 0px 0px 10px rgb(170,151,19);}
    .selectTemp {
      margin-top: 60px;
      line-height: 26px;
      color: rgb(134, 134, 134);
      .sel {
      }
      .red {
        color: red;
      }
      .sel-price {
        font-size: 22px;
        font-weight: 700;
      }
    }
  }
}
</style>
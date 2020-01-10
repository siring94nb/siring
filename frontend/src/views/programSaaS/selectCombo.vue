<template>
  <div class="index">
    <myheader />
    <div class="steps">
      <div class="lines"></div>
      <div class="label">
        <div class="label-r label-l">
          <img src="../../assets/images/u3086.png" alt />
          <div>选择行业模板</div>
          <span class="label-number">1</span>
        </div>
        <div class="label-r">
          <img src="../../assets/images/u3086.png" alt />
          <div>选择套餐</div>
          <span class="label-number">2</span>
        </div>
      </div>
    </div>
    <div class="line"></div>
    <div class="notice">
      <img src="../../assets/images/u3009.png" alt />
      <span>温馨提示：您可以选择年套餐更实惠，您还可以选择月套餐逐步熟练和熟悉后再用年套餐！</span>
    </div>
    <div class="honour">
      <div
        class="honour-item"
        v-for="(item, index) in versionData"
        @mouseenter="selectEvent(index)"
        :class="selectClassName[index === selectFlag && index]"
        :key="item.id"
      >
        <div class="honour-top" :class="selectClassName_1[index === selectFlag && index]">
          <div
            class="top-title"
            :class="selectClassName_2[index === selectFlag && index]"
          >{{comboName[index]}}</div>
          <div v-if="index == 0">适合小微团队开店、个人或三个人以下运营的团队开店，满足本行业内的基础经营需求</div>
          <div v-if="index == 1">适合成长型团队或企业，满足推广获客、成交转化、客户留存、复购增购、分享裂变等核心经营需求</div>
          <div v-if="index == 2">适合规模化扩张，有多个经营场景需求的成熟商家，满足创新营销玩法等深度经营需求</div>
          <div class="lines" :class="selectClassName_3[index === selectFlag && index]"></div>
          <div
            class="top-price"
            :class="selectClassName_3[index === selectFlag && index]"
          >￥{{item.model_meal_price}}/年</div>
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
          <div
            class="sel"
            :class="selectClassName_4[index === selectFlag && index]"
            @click="selCombo"
          >选择标准月套餐>></div>
          <div>
            <span class="red">*</span>最低低至
            <span class="sel-price" :class="index === selectFlag?'red':''">399</span>元/月
          </div>
        </div>
      </div>
    </div>

    <!-- 结算 -->
    <div :class="{payment: true, show: showPaymentFlag}">
      <div class="payment-inner">
        <div>费用：</div>
        <div>
          <div class="bgw">￥{{price}}</div>
          <p class="tip">
            <span class="red">*</span>金额
          </p>
        </div>
        <div class="symbol">×</div>
        <div>
          <div class="bgw">{{percent}}%</div>
          <p class="tip">
            <span class="red">*</span>会员折扣
            <span class="ques">？</span>
          </p>
        </div>
        <div class="symbol">×</div>
        <div>
          <el-input-number
            v-model="years"
            controls-position="right"
            @change="numChange"
            :min="1"
            :max="10"
          ></el-input-number>
          <p class="tip">
            <span class="red">*</span> 年限
          </p>
        </div>
        <div class="symbol">=</div>
        <div>
          <div class="bgw">￥{{total}}</div>
          <el-radio v-model="radio" label="1" style="margin-top:5px;">本人已确定，支付后执行下一流程</el-radio>
        </div>
        <el-button type="danger" @click="pay">立即支付</el-button>
      </div>
    </div>
    <!-- 结算 -->
  </div>
</template>

<script>
import Myheader from "@/components/header";
import { GetTempList, templatePay } from "@/api/api";

export default {
  name: "selectCombo",
  components: {
    Myheader
  },
  data() {
    return {
      versionData: [],
      comboName: ["标准年套餐", "精装套餐", "豪华套餐"],
      selectClassName: ["bz-border", "jz-border", "hh-border"], //边框
      selectClassName_1: ["honour-top-bz", "honour-top-jz", "honour-top-hh"], //头部背景色
      selectClassName_2: ["top-title-bz", "top-title-jz", "top-title-hh"], //套餐名背景颜色
      selectClassName_3: ["top-price-bz", "top-price-jz", "top-price-hh"], //线条/年费背景色
      selectClassName_4: ["sel-bz", "sel-jz", "sel-hh"], //选择套餐颜色
      selectFlag: 0, //mouseenter 给div[index]添加颜色
      showPaymentFlag: false,
      price: 0,
      percent: 100,
      total: 0,
      radio: "",
      model_meal_category: 2,
      model_grade: 1,
      years: 1,
      model_meal_type: "",
      model_type: "",
      user_id: 0
    };
  },
  mounted() {
    this.init();
    console.log(this.$route.params);
  },
  methods: {
    init() {
      this.user_id = JSON.parse(sessionStorage.getItem("user_id"));
      this.getTempList();
      this.model_meal_category = this.$route.params.model_meal_category;
      if (this.model_meal_category == 1) this.model_type = "diy";
      else this.model_type = "固定样式";
    },
    //获取模板信息
    getTempList() {
      GetTempList({ model_meal_category: this.model_meal_category }).then(
        res => {
          this.versionData = res;
        }
      );
    },
    selectEvent(index) {
      this.selectFlag = index;
      this.price = this.versionData[index].model_meal_price;
      this.model_grade = this.versionData[index].model_grade;
      this.model_meal_type = this.comboName[index];
      this.total =
        (Number(this.price) * Number(this.years) * Number(this.percent)) / 100;
    },
    //选择套餐
    selCombo() {
      this.showPaymentFlag = true;
    },
    //改变年数
    numChange(val) {
      this.years = val;
      this.total =
        (Number(this.price) * Number(this.percent) * Number(val)) / 100;
    },
    //结算
    pay() {
      let vm = this;
      if (vm.radio) {
        var params = {
          user_id: vm.user_id,
          model_type: vm.model_type,
          model_meal_type: vm.model_meal_type,
          price: vm.total,
          num: vm.years,
          tid: vm.$route.params.arr,
          applet_name: vm.$route.params.prog_name,
          applet_logo: vm.$route.params.imageUrl
        };
        //下单
        templatePay(params).then(res => {
          if(res.code == 1) {
            vm.$router.push({
              name: "comboPay",
              params: {
                'order_amount':vm.total,
                'user_id': vm.user_id,
                'id': res.data,
                'order_type': 1
              }
            });
          }
        });
      } else {
        this.$message.error("请确认");
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.index {
  margin: auto;
  margin-top: 150px;
  width: 1200px;
  .steps {
    display: flex;
    position: relative;
    margin: 70px auto;
    width: 250px;
    .lines {
      width: 250px;
      border-bottom: 2px solid rgb(26, 188, 156);
    }
    .label {
      display: flex;
      position: absolute;
      top: -30px;
      left: -30px;
      .label-r {
        position: relative;
        text-align: center;
        div {
          width: 100px;
          font-weight: 700;
          font-size: 14px;
          color: rgb(26, 188, 156);
        }
        .label-number {
          color: #fff;
          font-size: 30px;
          position: absolute;
          top: 15px;
          left: 41px;
        }
      }
      .label-l {
        margin-right: 150px;
      }
    }
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
  /*套餐*/
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
        /*套餐名背景色 */
        .top-title-bz {
          background: linear-gradient(
            135deg,
            rgba(255, 255, 255, 1) 0%,
            rgba(255, 255, 255, 1) 0%,
            rgba(0, 204, 204, 1) 44%,
            rgba(0, 204, 204, 1) 100%
          );
        }
        .top-title-jz {
          background: linear-gradient(
            135deg,
            rgba(255, 255, 255, 1) 0%,
            rgba(255, 255, 255, 1) 0%,
            rgba(255, 153, 0, 1) 44%,
            rgba(255, 153, 0, 1) 100%
          );
        }
        .top-title-hh {
          background: linear-gradient(
            135deg,
            rgba(255, 255, 255, 1) 0%,
            rgba(255, 255, 255, 1) 0%,
            rgba(170, 151, 19, 1) 44%,
            rgba(170, 151, 19, 1) 100%
          );
        }
        /*套餐名背景色 */
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
        /*线条/年费背景色 */
        .top-price-bz {
          background-color: rgb(0, 204, 204);
        }
        .top-price-jz {
          background-color: rgb(255, 167, 38);
        }
        .top-price-hh {
          background-color: rgb(170, 151, 19);
        }
        /*线条/年费背景色 */
      }
      /*头部背景色 */
      .honour-top-bz {
        background-color: rgb(234, 255, 255);
      }
      .honour-top-jz {
        background-color: rgb(255, 248, 238);
      }
      .honour-top-hh {
        background-color: rgb(252, 249, 224);
      }
      /*头部背景色 */
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
    .bz-border {
      border-color: rgb(0, 204, 204);
      box-shadow: 0px 0px 10px rgb(0, 204, 204);
    }
    .jz-border {
      border-color: rgb(255, 167, 38);
      box-shadow: 0px 0px 10px rgb(255, 167, 38);
    }
    .hh-border {
      border-color: rgb(170, 151, 19);
      box-shadow: 0px 0px 10px rgb(170, 151, 19);
    }
    .selectTemp {
      margin-top: 60px;
      line-height: 26px;
      color: rgb(134, 134, 134);
      .sel:hover {
        font-weight: 700;
        cursor: pointer;
      }
      .sel-bz {
        color: rgb(0, 204, 204);
      }
      .sel-jz {
        color: rgb(255, 167, 38);
      }
      .sel-hh {
        color: rgb(170, 151, 19);
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
  /*套餐*/
  /*结算*/
  .payment {
    display: none;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    height: 80px;
    background-color: rgb(204, 235, 248);
    &.show {
      display: block;
    }
    .payment-inner {
      float: right;
      display: flex;
      align-items: baseline;
      margin-top: 10px;
      margin-right: 40px;
      .bgw {
        background-color: #ffffff;
        padding: 10px 30px;
        color: #ff0000;
        min-width: 120px;
        box-sizing: border-box;
      }
      .symbol {
        margin: 0 20px;
      }
      .el-button {
        margin-left: 20px;
      }
      .tip {
        font-size: 14px;
        color: #999999;
        text-align: center;
        margin-top: 5px;
        .red {
          color: red;
        }
        .ques {
          display: inline-block;
          width: 20px;
          height: 20px;
          line-height: 20px;
          text-align: center;
          border-radius: 50%;
          background-color: #ff0000;
          color: #ffffff;
          cursor: pointer;
        }
      }
    }
  }
  /*结算*/
}
</style>
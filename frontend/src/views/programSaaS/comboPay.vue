<template>
  <div class="index">
    <myheader />
    <h1>订单已提交，请及时支付！</h1>
    <div class="main">
      <div class="mian-top">
        <div class="top-title">
          支付信息
          <span class="hui">（币种：人民币）</span>
        </div>
        <div class="payable">
          应付金额：
          <span class="price">
            ￥
            <span class="red">90.00</span>
          </span>
        </div>
        <div>使用账户余额支付：</div>
        <div>
          <el-input placeholder="请输入内容"></el-input>
        </div>
        <div class="balance">
          <div>（账户余额：￥10.00）</div>
          <div style="flex:1;"></div>
          <div class="blue">余额支付</div>
        </div>
        <div class="invite">
          <el-checkbox v-model="checked">
            使用邀请码
            <span class="hui">（填写推荐邀请码，优惠30元）</span>
          </el-checkbox>
          <div class="invite-code">
            <el-input placeholder="请填写邀请人的会员绑定手机号或邀请码" style="font-size:12px;"></el-input>
          </div>
          <div class="coupons">
            <span class="hui">（一次性可使用5张优惠券）</span> <span class="blue">使用优惠券>></span>
          </div>
        </div>
      </div>
      <div class="payment">
        选择一下方式支付：
        <span class="money red">￥30.00</span>
        <span class="red">（总价￥90.00 -余额￥10.00 -优惠券￥50.00 ）</span>
      </div>
    </div>
  </div>
</template>

<script>
import Myheader from "@/components/header";
// import { GetTempList } from "@/api/api";

export default {
  name: "comboPay",
  components: {
    Myheader
  },
  data() {
    return {
      checked: []
    };
  },
  mounted() {
    this.init();
    // console.log(this.$route.params)
  },
  methods: {
    init() {}
  }
};
</script>

<style lang="scss" scoped>
.hui {
  color: rgb(174, 174, 174);
}
.red{color: red;}
.blue {
  color: rgb(102,204,255);
  font-weight: 700;
}
.index {
  margin: auto;
  margin-top: 100px;
  width: 1200px;
  h1 {
    font-size: 33px;
    text-align: center;
  }
  .main {
    border: 1px solid rgb(188, 188, 188);
    width: 900px;
    margin: auto;
    .mian-top {
      // text-align: center;
      width: 400px;
      line-height: 30px;
      margin: auto;
      .top-title {
        font-size: 24px;
        margin: 30px 0 30px 15px;
        .hui{font-size: 16px;}
      }
      .payable{
        .price{
          font-size: 23px;
          }
      }
      .balance{
        display: flex;
      }
      .invite{
        .invite-code{
          width:300px;
          margin: auto;
        }
        .coupons{
          text-align: right;
          .hui{font-size: 12px;margin-right: 10px;}
        }
      }
    }
    .payment{
      background-color: rgb(242,242,242);
      padding: 15px 40px;
      font-size: 18px;
      margin: 15px 0;
      .money{font-size: 28px;}
    }
  }
}
</style>
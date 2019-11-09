<template>
  <div class="index">
    <myheader />
    <h1>订单已提交，请及时支付！</h1>
    <div>
        <div>
            <div>支付信息<span>（币种：人民币）</span></div>
            <div>应付金额：<span>￥<span>90.00</span></span></div>
            <div>使用账户余额支付：</div>
            <div>
                <el-input  placeholder="请输入内容"></el-input>
            </div>
            <div>
                <div>（账户余额：￥10.00）</div>
                <div>余额支付</div>
            </div>
            <div>
                <el-checkbox v-model="checked">使用邀请码<span>（填写推荐邀请码，优惠30元）</span></el-checkbox>
                <el-input  placeholder="请输入内容"></el-input>
                <div><span>（一次性可使用5张优惠券）</span>使用优惠券>></div>
            </div>
        </div>
        <div>
            选择一下方式支付：
            <span>￥30.00</span>
            <span>（总价￥90.00 -余额￥10.00 -优惠券￥50.00 ）</span>
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
    return {};
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
.index {
  margin: auto;
  margin-top: 100px;
  width: 1200px;
  h1 {
    font-size: 33px;
    text-align: center;
  }
}
</style>
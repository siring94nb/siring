<template>
  <div class="payment-bar">
    <!-- 结算 -->
    <div :class="{payment: true, show: showPaymentFlag}">
      <div class="payment-inner">
        <div>费用：</div>
        <div>
          <div class="bgw">￥{{price}}</div>
          <p class="tip">金额</p>
        </div>
        <div class="symbol">×</div>
        <div>
          <div class="bgw">{{percent}}%</div>
          <p class="tip">
            会员折扣
            <span class="ques">？</span>
          </p>
        </div>
        <div class="symbol">×</div>
        <el-input-number
          v-model="num"
          controls-position="right"
          @change="handleChange"
          :min="1"
          :max="10"
          v-if="order != 1"
        ></el-input-number>
        <div v-if="order==1">
          <div class="bgw">{{scale}}%</div>
          <p class="tip">
           <span style="color:red;">*</span> 一期比例
          </p>
        </div>
        <div class="symbol">=</div>
        <div>
          <div class="bgw">￥{{total}}</div>
        </div>
        <el-button type="danger" @click="pay">立即支付</el-button>
      </div>
    </div>

    <!-- 选择支付方式 -->
    <el-dialog title="选择支付方式" :visible.sync="showPayWayFlag" width="500px" center>
      <el-form ref="payway" :model="payway" label-width="80px">
        <el-form-item label="支付方式">
          <el-radio-group v-model="payway.way" @change="selectway">
            <el-radio :label="1">微信</el-radio>
            <el-radio :label="2">支付宝</el-radio>
          </el-radio-group>
        </el-form-item>
      </el-form>
      <div class="code-box">
        <img :src="payqrcode" alt />
      </div>
      <span slot="footer" class="dialog-footer">
        <el-button @click="showPayWayFlag = false">取 消</el-button>
        <el-button type="primary" @click="showPayWayFlag = false">确 定</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
import { Payment } from "@/api/api";
export default {
  props: [
    "showPaymentFlag",
    "needCodeDialog",
    "price",
    "percent",
    "pay",
    "scale",
    "order"
  ],
  data() {
    return {
      num: 1,
      payway: {
        way: 1
      },
      wayRule: {
        way: [
          {
            required: true,
            message: "请选择支付方式",
            trigger: "change"
          }
        ]
      },
      payqrcode: "",
      orderid: 0,
      showPayWayFlag: false
    };
  },
  computed: {
    total() {
      return this.price * (this.percent / 100) * (this.order == 1? this.scale/100 : this.num);
    }
  },
  methods: {
    selectway() {
      Payment({
        type: this.payway.way,
        order_id: this.orderid
      }).then(res => {
        let { code, imgData, msg } = res;
        if (code === 1) {
          this.payqrcode = imgData;
        }
      });
    },
    getOrderId(orderid) {
      if(this.needCodeDialog){
        this.showPayWayFlag = true;
      }
      this.orderid = orderid;
    },
    handleChange(value){
      this.$emit('sendNum', value);
    }
  }
};
</script>

<style scoped lang='scss'>
.payment {
  display: none;
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  height: 80px;
  background-color: rgb(204, 235, 248);
  z-index: 99;
  &.show {
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .payment-inner {
    float: right;
    display: flex;
    align-items: baseline;
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
.code-box {
  text-align: center;
  height: 300px;
  img {
    width: 300px;
    height: 300px;
  }
}
</style>
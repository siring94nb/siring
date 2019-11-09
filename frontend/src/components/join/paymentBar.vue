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
          @change="numChange"
          :min="1"
          :max="10"
        ></el-input-number>
        <div class="symbol">=</div>
        <div>
          <div class="bgw">￥{{total}}</div>
        </div>
        <el-button type="danger" @click="pay">立即支付</el-button>
      </div>
    </div>

    <!-- 选择支付方式 -->
    <el-dialog title="选择支付方式" :visible.sync="showPayWayFlag" width="500px" center>
      <el-form ref="payway" :model="payway" :rules="wayRule" label-width="80px">
        <el-form-item label="支付方式" prop="way">
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
export default {
  props: ["showPaymentFlag", "price", "percent"],
  data() {
    return {
      num: 1,
      showPayWayFlag: false,
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
      payqrcode: ""
    };
  },
  computed: {
    total() {
      return this.price * (this.percent / 100) * this.num;
    }
  },
  methods: {
    numChange(value) {},
    pay() {
      this.$refs["ruleForm"].validate(valid => {
        if (valid) {
          this.showPayWayFlag = true;
          CityOrderAdd({
            grade: this.ruleForm.cityVal,
            con: this.ruleForm.textarea,
            num: this.num,
            price: this.total,
            user_id: 1
          }).then(res => {
            let { code, data, msg } = res;
            if (code === 1) {
              this.orderId = data;
              this.selectway();
            }
          });
        }
      });
    },
    selectway() {
      this.$refs["payway"].validate(valid => {
        if (valid) {
          Payment({
            type: this.payway.way,
            order_id: this.orderId
          }).then(res => {
            let { code, imgData, msg } = res;
            if (code === 1) {
              this.payqrcode = imgData;
            }
          });
        }
      });
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
  img {
    width: 300px;
    height: 300px;
  }
}
</style>
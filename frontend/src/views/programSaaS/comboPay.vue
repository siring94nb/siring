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
          <div class>
            应付金额：
            <span class="price">
              ￥
              <span class="red">{{money}}</span>
            </span>
          </div>
          <div style="margin-left:100px;">
            <el-select v-model="valuee" placeholder="请选择优惠券">
              <el-option
                v-for="item in options"
                :key="item.value"
                :label="item.label"
                :value="item.value"
              ></el-option>
            </el-select>
          </div>
        </div>

        <!-- <div class="invite">
          <el-checkbox v-model="checked">
            使用邀请码
            <span class="hui">（填写推荐邀请码，优惠30元）</span>
          </el-checkbox>
          <div class="invite-code">
            <el-input placeholder="请填写邀请人的会员绑定手机号或邀请码" style="font-size:12px;"></el-input>
          </div>
        </div>-->
      </div>
      <div class="payment">
        选择一下方式支付：
        <span class="money red">￥{{real_money}}</span>
        <span class="red">（总价￥{{money}} -优惠券￥0.00 ）</span>
      </div>
      <div class="main-bottom">
        <el-row :gutter="20">
          <el-col :span="4">
            <div style="text-align:center;">支付类型：</div>
          </el-col>
          <el-col :span="14" :offset="2">
            <div style="text-align:center;">
              <el-radio v-model="radio" label="1">在线支付</el-radio>
              <el-radio v-model="radio" label="3">银行转账</el-radio>
              <el-radio v-model="radio" label="4" @change="payPassword">余额支付</el-radio>
            </div>
          </el-col>
        </el-row>
        <div class="line"></div>

        <!-- 在线支付 -->
        <div class="online-pay" v-if="radio == '1'">
          <div class="online-title">支付码</div>
          <div class="qrcode">
            <img :src="imgData" alt />
          </div>
          <div class="hui">请使用微信或者支付宝扫描二维码进行支付</div>
          <div class="code-type">
            <el-radio v-model="codeType" label="1" :disabled="isDisabl">
              <img src="../../assets/images/u2078.png" alt width="114px;" height="36px;" />
            </el-radio>
            <el-radio v-model="codeType" label="2" :disabled="isDisabl">
              <img src="../../assets/images/u2079.png" alt width="114px;" height="36px;" />
            </el-radio>
          </div>
          <div class="pay-money">
            <span>总计：</span>
            {{real_money}}元
          </div>
          <div style="margin:20px;" v-if="isShow">
            <el-button
              type="success"
              style="background-color:rgb(0,201,0);"
              @click="codePay"
            >生成支付二维码</el-button>
          </div>
        </div>
        <!-- 在线支付 -->

        <!-- 银行转账 -->
        <div class="bank-pay" v-if="radio == '3'">
          <div class="pay-l">
            <div class="pay-bank">
              <div class="pay-title">
                <span class="red">*</span>支付银行：
              </div>
              <div>
                <el-select v-model="value" placeholder="如没有添加银行卡，请添加→">
                  <el-option
                    v-for="(item, index) in bankCard"
                    :key="index"
                    :label="item"
                    :value="index"
                  ></el-option>
                </el-select>
              </div>
              <div class="addCard">
                <el-button type="danger" @click="dialogFormVisible = true" plain>+银行卡</el-button>
              </div>
            </div>
            <div class="pay-bank">
              <div class="pay-title">
                <span class="red">*</span>支付时间：
              </div>
              <div style="font-size:14px">
                <el-date-picker
                  v-model="pay_time"
                  type="date"
                  placeholder="选择日期"
                  format="yyyy 年 MM 月 dd 日"
                  value-format="yyyy-MM-dd"
                ></el-date-picker>
              </div>
              <div></div>
            </div>
            <div class="pay-bank">
              <div class="pay-title">留言：</div>
              <div style="font-size:14px">
                <el-input v-model="comment" type="textarea" style="width:220px;" :rows="4"></el-input>
              </div>
              <div></div>
            </div>
            <div style="text-align:center;">
              <el-button type="danger" style="width:220px;margin-left:20px;" @click="bankPay">确定</el-button>
            </div>
          </div>
          <div class="s-line"></div>
          <div class="pay-r">
            <div class="pay-tip">
              <img src="../../assets/images/u2011.png" alt />
              <span class="red">转账到以下任意平台收款账号：</span>
            </div>
            <el-row>
              <el-col :span="3">
                <div style="margin: 60px 0 0 10px;">
                  <el-radio v-model="paymentAccount" label="1">
                    <div></div>
                  </el-radio>
                </div>
              </el-col>
              <el-col :span="20">
                <div class="pay-accout">
                  <div class="bank-name" :class="{'bank-nosel': paymentAccount == '2'}">
                    <img src="../../assets/images/u1956.png" alt />
                  </div>
                  <div class="bank-main" :class="{'bank-nosel': paymentAccount == '2'}">
                    <p>账户名：吴雪</p>
                    <p>开户银行：中国工商银行深圳深圳湾支行</p>
                    <p>账号：6212264000061706160</p>
                  </div>
                </div>
              </el-col>
            </el-row>

            <el-row>
              <el-col :span="3">
                <div style="margin: 60px 0 0 10px;">
                  <el-radio v-model="paymentAccount" label="2">
                    <div></div>
                  </el-radio>
                </div>
              </el-col>
              <el-col :span="20">
                <div class="pay-accout">
                  <div class="bank-name" :class="{'bank-nosel': paymentAccount == '1'}">
                    <img src="../../assets/images/u1956.png" alt />
                  </div>
                  <div class="bank-main" :class="{'bank-nosel': paymentAccount == '1'}">
                    <p>户 名：深圳市思锐信息技术有限公司</p>
                    <p>账 号:4000040209200016204</p>
                    <p>开户银行:工行深圳深东支行</p>
                    <p>纳税人识别号:914403001924280274</p>
                  </div>
                </div>
              </el-col>
            </el-row>
            <div class="tips">以上是平台汇款账户，支付后可通知客服查账，及时为您充值！</div>
          </div>
        </div>
        <!-- 银行转账 -->

        <!-- 余额支付 -->
        <div class="balance-pay" v-if="radio == '4'">
          <div class="account">
            使用账户余额支付：
            <span class="money">
              ￥
              <span class="red">{{balance}}</span>
            </span>
            <span class="blue">充值</span>
          </div>
          <div class="password" style="display:flex;">
            <div class="pass-title">支付密码：</div>
            <el-input placeholder="请输入密码" v-model="password" style="font-size:12px;width:330px;"></el-input>
          </div>
          <div class="blue forgot-pass">忘记支付密码</div>
          <div class="pay-btn">
            <el-button type="danger" style="width:250px;" @click="bankPay">确定</el-button>
          </div>
        </div>
        <!-- 余额支付 -->

        <!-- 添加银行卡弹窗 -->
        <el-dialog title="添加银行卡" :visible.sync="dialogFormVisible">
          <el-form :model="form" :rules="rules" :label-position="labelPosition" label-width="100px">
            <el-form-item label="开户名：" prop="card_name">
              <el-input v-model="form.card_name" auto-complete="off" style="width:400px;"></el-input>
            </el-form-item>
            <el-form-item label="银行账号：" prop="card_number">
              <el-input v-model="form.card_number" auto-complete="off" style="width:400px;"></el-input>
            </el-form-item>
            <el-form-item label="银行：">
              <el-select v-model="form.bank_name" placeholder="请选择银行" style="width:400px;"></el-select>
            </el-form-item>
            <el-form-item>
              <v-region @values="regionChange" :area="false"></v-region>
            </el-form-item>
            <el-form-item label="开户支行：" prop="bank_branch">
              <el-input
                v-model="form.bank_branch"
                auto-complete="off"
                placeholder="请填写支行名"
                style="width:400px;"
              ></el-input>
            </el-form-item>
          </el-form>
          <div slot="footer" class="dialog-footer">
            <el-button @click="resetForm()">取 消</el-button>
            <el-button type="primary" @click="submitForm('form')" :disabled="isSubmit">确 定</el-button>
          </div>
        </el-dialog>
      </div>
    </div>
  </div>
</template>

<script>
import Myheader from "@/components/header";
import {
  templatePay,
  addBank,
  subBankPay,
  codeGetPay,
  getCoupou,
  getBalance,
  payStatus
} from "@/api/api";
import { bankCardAttribution } from "@/api/bank";

export default {
  name: "comboPay",
  components: {
    Myheader
  },
  data() {
    let validatePass = (rule, value, callback) => {
      let bank = bankCardAttribution(value);
      if (bank) {
        this.form.bank_name = bank.bankName;
        callback();
      } else {
        callback(new Error("银行卡号格式有误！"));
      }
    };
    return {
      isSubmit: false,
      checked: [],
      radio: "3",
      options: [], //优惠券
      codeType: "1", //支付宝或微信
      value: "",
      valuee: "",
      pay_time: "",
      money: 0, //套餐金额
      real_money: 0, //最终实付金额
      imgData: "",
      isShow: true,
      isDisabl: false,
      bankCard: [],
      bankCards: [], //银行卡号
      params: {}, //总信息
      comment: "", //留言
      //添加银行卡
      form: {
        id: 0,
        card_name: "",
        bank_name: "",
        bank_branch: "",
        card_number: "",
        province: "",
        city: "",
        user_id: 0
      },
      balance: "0.00", //余额
      paymentAccount: "0", //选择收款账号
      payAccount: [
        "工商银行-6212264000061706160",
        "工商银行-4000040209200016204"
      ],
      //银行支付--
      account_number: "", //收款账号

      dialogTableVisible: false,
      dialogFormVisible: false,
      labelPosition: "right",
      rules: {
        card_name: [
          { required: true, message: "请输入开户名", trigger: "blur" }
        ],
        // bank_name: [
        //   { required: true, message: '请选择银行名称', trigger: 'change' }
        // ],
        bank_branch: [
          { required: true, message: "请输入支行名", trigger: "blur" }
        ],
        card_number: [{ validator: validatePass, trigger: "blur" }]
      },
      ispassword: "",
      password: "", //支付密码
      isStatus: true,
      isPayTime: false
    };
  },
  mounted() {
    this.init();
    // console.log(this.$route.params)
    this.GetCoupou();
    this.GetBalance();
    // if(this.isStatus && this.isPayTime) {
      this.PayStatus();
    // }
  },
  methods: {
    init() {
      let vm = this;
      vm.money = vm.$route.params.order_amount;
      vm.real_money = vm.$route.params.order_amount;
      vm.form.user_id = vm.$route.params.user_id;
      vm.params = this.$route.params;
      //获取银行卡号
      subBankPay({ user_id: vm.$route.params.user_id }).then(res => {
        let { code, data, msg } = res;
        if (code == "1") {
          vm.bankCards = data;
          data.map(item => {
            vm.bankCard.push(item.bank_name + "-" + item.card_number);
          });
        }
      });
      // vm.GetBalance();
    },
    //支付宝微信支付
    codePay() {
      //支付类型
      let vm = this;
      if (this.radio != "1") vm.params.pay_type = this.radio;
      else vm.params.pay_type = this.codeType;
      let params = {
        order_id: vm.params.id,
        pay_type: vm.params.pay_type,
        money: vm.real_money,
        type: vm.params.order_type,
        password: "",
        unionpay: ""
      };
      codeGetPay(params).then(res => {
        let { code, imgData, msg } = res;
        this.$message(msg);
        // if (vm.params.pay_type == 1) {
        //   const { href } = this.$router.resolve({
        //     path: "alipay",
        //     query: {
        //       pdf: res
        //     }
        //   });
        //   window.open(href, "_blank");
        //   this.isShow = !this.isShow;
        //   this.isDisabl = !this.isDisabl;
        // } else {
        if (code === 1) {
          this.imgData = imgData;
          this.isShow = !this.isShow;
          this.isDisabl = !this.isDisabl;
          this.isPayTime = true;
        }
        // }
      });
    },
    //银行支付&余额支付
    bankPay() {
      let vm = this,
        pay_detail;
      if (vm.radio == 3) {
        pay_detail = {
          account_number: vm.paymentAccount,
          bank_name: vm.bankCards[vm.value].bank_name,
          bank_number: vm.bankCards[vm.value].card_number,
          pay_time: vm.pay_time,
          comment: vm.comment,
          pay_type: vm.radio,
          pay_money: vm.real_money,
          type: 2
        };
        pay_detail = JSON.stringify(pay_detail);
      }
      let params = {
        order_id: vm.params.id,
        pay_type: vm.radio,
        money: vm.real_money,
        type: vm.params.order_type,
        password: vm.password,
        unionpay: pay_detail || ""
      };
      codeGetPay(params).then(res => {
        let { code, imgData, msg } = res;
        if (code === 1) {
          vm.$message.success(msg);
          vm.$router.push({
            name: "demand_order"
          });
        } else {
          vm.$message.error(msg);
        }
      });
    },

    //添加银行卡
    submitForm(formName) {
      let vm = this;
      vm.isSubmit = !vm.isSubmit;
      let params = vm.form;
      addBank(params).then(res => {
        let { code, data, msg } = res;
        vm.$message.success(msg);
        if (code == "1") {
          this.init();
          this.resetForm();
        }
      });
    },
    resetForm() {
      (this.form = {
        id: 0,
        card_name: "",
        bank_name: "",
        bank_branch: "",
        card_number: "",
        province: "",
        city: "",
        user_id: 0
      }),
        (this.dialogFormVisible = false);
      this.isSubmit = !this.isSubmit;
      // this.$refs[formName].resetFields();
    },

    regionChange(data) {
      if (data.province) this.form.province = data.province.value;
      if (data.city) this.form.city = data.city.value;
    },
    //下单
    // payOrder(params) {
    //   templatePay(params).then(res => {
    //     console.log(res);
    //     return res;
    //   });
    // },
    //获取优惠券
    GetCoupou() {
      let vm = this,
        params = {
          uid: vm.form.user_id
        };
      getCoupou(params).then(res => {
        if (res.code == 1) {
          vm.options = res.data;
        }
      });
    },
    //获取余额
    GetBalance() {
      let vm = this,
        params = {
          uid: vm.form.user_id
        };
      getBalance(params).then(res => {
        if (res.code == 1) {
          vm.balance = res.data.money;
          vm.ispassword = res.data.pay_password;
        }
      });
    },
    payPassword(e) {
      if (this.ispassword == null || this.ispassword == "") {
        this.$confirm("您未设置支付密码，是否前往设置？", "提示", {
          confirmButtonText: "确定",
          cancelButtonText: "取消",
          type: "warning",
          center: true
        })
          .then(() => {
            this.$router.push({
              name: "safetyTabControl",
              params: {
                canshu: "third",
                title: "信息修改"
              }
            });
          })
          .catch(() => {});
      }
    },
    PayStatus() {
      let vm = this,
        params = {
          order_id: vm.form.id
        };
      window.setInterval(() => {
        setTimeout(() => {
          payStatus(params).then(res => {
            if (res.code == 1) {
              vm.isStatus = false;
            }
          });
        }, 0);
      }, 5000);
    }
    // getBank(val) {
    //   let bank = bankCardAttribution(val);
    //   console.log(bank);
    //   if (bank) this.form.bank_name = bank.bankName;
    //   else this.$message.error("银行卡号格式有误！");
    // }
  }
};
</script>

<style lang="scss" scoped>
.hui {
  color: rgb(174, 174, 174);
}
.red {
  color: red;
}
.el-radio {
  margin-right: 60px;
}
.blue {
  color: rgb(102, 204, 255);
  font-weight: 700;
}
.index {
  margin: auto;
  margin-top: 100px;
  width: 1200px;
  h1 {
    font-size: 33px;
    text-align: center;
    margin: 20px 0;
  }
  .main {
    border: 1px solid rgb(188, 188, 188);
    width: 900px;
    margin: auto;
    .mian-top {
      // text-align: center;
      width: 500px;
      line-height: 30px;
      margin: auto;
      .top-title {
        font-size: 24px;
        margin: 30px 0 30px 15px;
        .hui {
          font-size: 16px;
        }
      }
      .payable {
        display: flex;
        margin-bottom: 50px;
        .price {
          font-size: 23px;
        }
      }
      // .balance {
      //   display: flex;
      // }
      .invite {
        .invite-code {
          width: 300px;
          // margin: auto;
        }
        .coupons {
          text-align: right;
          .hui {
            font-size: 12px;
            margin-right: 10px;
          }
        }
      }
    }
    .payment {
      background-color: rgb(242, 242, 242);
      padding: 15px 40px;
      font-size: 18px;
      margin: 15px 0;
      .money {
        font-size: 28px;
      }
    }
    .main-bottom {
      .line {
        height: 1px;
        background-color: rgb(241, 241, 241);
        margin: 20px 10%;
      }
      //银行转账
      .bank-pay {
        display: flex;
        .pay-l {
          .pay-title {
            text-align: right;
            line-height: 35px;
            margin: 0 15px;
            width: 90px;
          }
          .pay-bank {
            display: flex;
            margin: 10px 0;
            .addCard {
              margin-left: 10px;
            }
          }
        }
        .s-line {
          height: 400px;
          width: 1px;
          background-color: rgb(201, 201, 201);
          margin: auto 0;
          margin-left: 5px;
        }
        .pay-r {
          height: 420px;
          .pay-tip {
            img {
              width: 36px;
              height: 36px;
              display: inline-block;
              vertical-align: middle;
            }
            span {
              font-size: 14px;
              margin-left: 30px;
              display: inline-block;
            }
          }
          .pay-accout {
            border: 1px solid rgb(188, 188, 188);
            margin-top: 10px;
            .bank-nosel {
              background: rgb(129, 129, 129) !important;
              border-color: rgb(129, 129, 129) !important;
            }
            .bank-name {
              padding: 2px 5px;
              border-bottom: 1px solid rgb(188, 188, 188);
              img {
                width: 100px;
                height: 20px;
              }
            }
            .bank-main {
              padding: 5px 40px 5px 20px;
              background-color: rgb(242, 242, 242);
              line-height: 24px;
              font-size: 15px;
              color: rgb(51, 51, 51);
            }
          }
          .tips {
            font-size: 13px;
            color: #333333;
            margin: 10px 0 0 65px;
          }
        }
      }
      //余额支付
      .balance-pay {
        width: 420px;
        height: 420px;
        margin: auto;
        line-height: 50px;
        .account {
          .money {
            font-size: 23px;
            font-weight: 400;
            margin-right: 50px;
          }
        }
        .password {
          .pass-title {
            line-height: 50px;
          }
        }
        .forgot-pass {
          text-align: right;
          line-height: 20px;
          font-size: 16px;
        }
        .pay-btn {
          text-align: center;
          margin-top: 60px;
        }
      }
      //线上支付
      .online-pay {
        width: 420px;
        margin: auto;
        text-align: center;
        .online-title {
          font-weight: 700;
          font-size: 28px;
          color: rgb(0, 0, 0);
          text-align: center;
          margin: 15px 0 10px 0;
        }
        .qrcode {
          img {
            width: 200px;
            height: 197px;
          }
        }
        .code-type {
          margin: 20px 0;
        }
        .pay-money {
          font-weight: 700;
          font-size: 18px;
          color: rgb(0, 0, 0);
          span {
            font-size: 28px;
          }
        }
      }
    }
  }
}
</style>
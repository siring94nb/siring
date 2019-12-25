<template>
  <div>
    <logginHeader>
      <i class="el-icon-edit"></i>
      <span>资金管理</span>
      <span>&gt;</span>
      <span>提现</span>
    </logginHeader>
    <div class="bottomBox">
      <div class="leftBox">
        <div>
          <span>账户余额：</span>
          <span class="biaozhi">￥{{mList.money}}</span>
        </div>
        <div>
          <span>账户名：</span>
          <span class="biaozhi">{{mList.phone}}</span>
        </div>
        <div>
          <span>
            <span class="biaozhi">*</span>
            <span>提现银行：</span>
          </span>
          <select v-model="selectItem" @change="selectFn($event)">
            <option selected="selected" value>如没有添加银行卡，请添加→</option>
            <option v-for="(item,index) in items" :value="item.id" :key="index">{{item.card_number}}</option>
          </select>
          <router-link to="/CardManagement" class="biaozhi bank">+银行卡</router-link>
        </div>
        <div>
          <span>
            <span class="biaozhi">*</span>
            <span>提现金额：</span>
          </span>
          <input type="number" value v-model="price" />
          <span>元</span>
        </div>
        <div>
          <span>手续费：</span>
          <!-- 手续费看怎么算，先写死 -->
          <span class="biaozhi">￥{{this.price*0.03}}</span>
        </div>
        <div>
          <span>到账金额：</span>
          <!-- 手续费看怎么算，先写死 -->
          <span class="biaozhi">￥{{this.price - ( this.price * 0.03)}}</span>
        </div>
        <div>
          <span>
            <span class="biaozhi">*</span>
            <span>资金密码：</span>
          </span>
          <input type="text" value v-model="password" />
          <div>
            注：会员中心的
            <router-link :to="{path:'/safetyTabControl',query:{canshu:'third',title:'信息修改'}}">安全中心</router-link>设置
          </div>
        </div>
        <div>
          <span>
            <span class="biaozhi">*</span>
            <span>短信验证码：</span>
          </span>
          <input type="text" placeholder="请输入手机验证码" />
          <input
            type="button"
            :value="showTime?`${validateTime}秒后失效`:'获取验证码'"
            class="btn"
            :disabled="showTime"
            @click.stop="getPhoneCode"
          />
        </div>
        <div>
          <button @click="getCashWith">确认</button>
          <div>低于￥1000.00元不得提现</div>
        </div>
      </div>
      <div class="rightBox">
        <div>
          <i class="el-icon-warning-outline"></i>
          <span>温馨提示：</span>
        </div>
        <div>①请妥善保管好您的资金密码以及手机验证码，切勿透露给他人。</div>
        <div>
          ②单笔提现限额
          <span>50,000.00</span>元
        </div>
        <div>
          ③单日提现限制次数为
          <span>1</span>次
        </div>
        <div>
          ④提现手续费率为
          <span>3%</span>
        </div>
        <div>
          ⑤银行卡提现
          <span>24</span>小时内到账
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import logginHeader from "@/components/logginHeader";
import { GetCode, CashDetails, BankcardList, CashWith } from "@/api/api";
export default {
  data() {
    return {
      phone: sessionStorage.getItem("phone"),
      selectItem: "",
      showTime: false, //控制获取验证码时，按钮禁用
      validateTime: 60, //倒计时初始时间
      yanzhengma: "", //获取验证码
      mList: {}, //剩余开票金额，手机号
      bankCard: "", //银行卡卡号
      price: "", //提现金额
      password: "", //资金密码
      items: [],
      serviceHarge: "0" //手续费
    };
  },
  components: {
    logginHeader
  },
  mounted() {
    this.getCashDetails();
    this.getBankcardList();
  },
  methods: {
    // 获取select选中的银行卡
    selectFn(e) {
      console.log(e);
      console.log(e.target.selectedIndex); // 选择项的index索引
      console.log(e.target.value); // 选择项的value
      this.bankCard = e.target.value;
    },
    // 获取验证码
    getPhoneCode() {
      let params = {
        phone: this.phone
      };
      GetCode(params).then(res => {
        let { data, msg, code } = res;
        this.showMsg(msg, code);
        if (code === 1) {
          this.showTime = true;
          this.countDown();
        }
      });
      // console.log(this.phone);
    },
    // 验证码倒计时
    countDown() {
      let time = 60;
      let timer = setInterval(() => {
        if (time <= 0) {
          time = 0;
          this.showTime = false;
          clearInterval(timer);
        } else {
          time -= 1;
          this.validateTime = time;
        }
      }, 1000);
    },
    // 提现
    getCashWith() {
      if (this.price < 1000) {
        this.$message('提现金额不可少于1000.00元');
      } else {
        let params = {
          bank_card: this.bankCard,
          price: this.price - this.price * 0.03,
          fund_password: this.password,
          code: this.yanzhengma
        };
        CashWith(params).then(res => {
          let { data, msg, code } = res;
          this.showMsg(msg, code);
          if (code === 1) {
          }
        });
      }
    },
    // 资金详情（余额以及电话）
    getCashDetails() {
      CashDetails().then(res => {
        let { data, msg, code } = res;
        //  this.showMsg(msg, code);
        if (code === 1) {
          this.mList = data;
        }
      });
    },
    // 银行卡信息
    getBankcardList() {
      BankcardList().then(res => {
        let { data, msg, code } = res;
        //  this.showMsg(msg, code);
        if (code === 1) {
          this.items = data;
        }
      });
    },
    // 返回值
    showMsg(msg, code) {
      this.$message({
        message: msg,
        type: code === 1 ? "success" : "error"
      });
    }
  }
};
</script>
<style lang="scss" scoped>
.bottomBox {
  background: #ffffff;
  padding: 30px 0 30px 100px;
  margin: 10px 0 0 20px;
  display: flex;
  // justify-content: space-between;
  .leftBox {
    border-right: 1px solid rgb(201, 201, 201);
    padding-right: 30px;
    margin-right: 30px;
    font-size: 13px;
    > div {
      margin-bottom: 25px;
      > span {
        &:nth-of-type(1) {
          display: inline-block;
          width: 100px;
          text-align: right;
          margin-right: 10px;
        }
      }
      select {
        width: 268px;
        padding: 10px 5px;
      }
      &:nth-of-type(4) {
        > input {
          display: inline-block;
          width: 221px;
          height: 35px;
        }
        > span:nth-last-child(1) {
          padding: 12px 15px;
          background: #f2f2f2;
          border: 1px solid #cccccc;
          border-left: 0;
          color: #333333;
        }
      }
      &:nth-of-type(7) {
        > input {
          display: inline-block;
          width: 270px;
          height: 35px;
        }
        > div {
          margin: 10px 0 0 120px;
          > a {
            color: #6699ff;
          }
        }
      }
      &:nth-of-type(8) {
        input {
          &:nth-of-type(1) {
            padding: 10px 5px;
            border-radius: 5px;
            border: 1px solid rgb(204, 204, 204);
            outline: none;
            width: 220px;
          }
          &:nth-of-type(2) {
            padding: 10px 20px;
            border: 1px solid rgb(204, 204, 204);
            background: #ffffff;
            border-radius: 5px;
            outline: none;
          }
        }
      }
      &:nth-last-child(1) {
        margin-left: 110px;
        button {
          background: #e62d31;
          color: #ffffff;
          border: 1px solid #e62d31;
          border-radius: 5px;
          padding: 10px 5px;
          width: 270px;
          margin-bottom: 10px;
          outline: none;
        }
      }
    }
  }
  .rightBox {
    font-size: 14px;
    color: #333333;
    div {
      margin-bottom: 15px;
      margin-left: 20px;
      span {
        color: #ff0000;
      }
      &:nth-of-type(1) {
        margin: 0 0 20px 0;
        i {
          color: rgb(237, 156, 146);
          font-size: 20px;
          padding-right: 5px;
        }
      }
    }
  }
  .biaozhi {
    color: rgb(255, 90, 90);
    font-size: 16px;
  }
  .bank {
    display: inline-block;
    border: 1px solid #ff0000;
    font-size: 13px;
    margin-left: 10px;
    padding: 11px 10px;
    border-radius: 5px;
  }
}
</style>
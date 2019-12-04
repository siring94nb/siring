<template>
  <div>
    <logginHeader>
      <i class="el-icon-edit"></i>
      <span>会员中心</span>
      <span>&gt;</span>
      <span>安全中心</span>
      <span>&gt;</span>
      <span>{{title}}</span>
    </logginHeader>
    <div class="bottomBox">
      <el-tabs v-model="activeName">
        <el-tab-pane label="绑定手机" name="first" :key="'first'">
          <div class="TabCon">
            <div>
              <span class="bj">当前手机号：</span>
              <span>{{phone.replace(phone.substring(3,7),"****")}}</span>
            </div>
            <div>
              <span class="bj">发送验证码：</span>
              <input type="text" maxlength="6" placeholder="请输入手机验证码" value="" v-model="yanzhengma" @input="ceshi"/>
              <input type="button" :value="showTime?`${validateTime}秒后失效`:'获取验证码'" class="btn"  :disabled="showTime" @click="getPhoneCode"/>
            </div>
            <div>
              <span class="bj">新手机号：</span>
              <input type="text" placeholder="请输入新手机号" />
              <select>
                <option>China+86</option>
              </select>
            </div>
            <div>
              <span class="bj">新手机验证码：</span>
              <input type="text" placeholder="请输入新手机验证码" />
              <input type="button" value="获取验证码" class="btn" />
            </div>
            <div>
              <span class="bj">新手机密码：</span>
              <input type="text" placeholder="请输入新手机密码" />
            </div>
            <div>
              <span class="bj">确认新手机密码：</span>
              <input type="text" placeholder="请再次输入新手机密码" />
            </div>
            <div>
              <span class="bj">验证码：</span>
              <input type="text" placeholder="请再次输入新手机密码" />
              <input type="text" value="11123" disabled class="jy" />
            </div>
             <button class="affirmPhone">确定</button>
          </div>
        </el-tab-pane>

        <el-tab-pane label="登录密码" name="second" :key="'second'">
          <div class="TabCon">
            <div>
              <span class="bj">当前手机号：</span>
              <span>{{phone.replace(phone.substring(3,7),"****")}}</span>
            </div>
            <div></div>
            <div></div>
            <div></div>
            <div>
              <span class="bj">新手机密码：</span>
              <input type="text" placeholder="请输入新手机密码" value="" v-model="mewPass"/>
            </div>
            <div>
              <span class="bj">确认新手机密码：</span>
              <input type="text" placeholder="请再次输入新手机密码" value="" v-model="mewPass1" />
            </div>
            <div>
              <span class="bj">发送验证码：</span>
              <input type="text" placeholder="请输入手机验证码" value="" v-model="yanzhengma"/>
              <input type="button" :value="showTime?`${validateTime}秒后失效`:'获取验证码'" class="btn"  :disabled="showTime" @click.stop="getPhoneCode"/>
            </div>
             <button class="affirmPhone" @click="onForget">确定</button>
          </div>
        </el-tab-pane>
        <el-tab-pane label="资金密码" name="third" :key="'third'">
          <div class="TabCon">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div>
              <span class="bj">资金密码：</span>
              <input type="text" placeholder="请输入字母或数字组合的6到15位密码" />
              <span style="padding-left:30px">(请妥善保管好个人资金密码)</span>
            </div>
            <div>
              <span class="bj">确认资金密码：</span>
              <input type="text" placeholder="请输入字母或数组组合的6到15位密码" />
            </div>
            <div>
              <span class="bj">验证码：</span>
              <input type="text" placeholder="请输入平台账号手机验证码" />
              <input type="button" :value="showTime?`${validateTime}秒后失效`:'获取验证码'" class="btn"  :disabled="showTime" @click.stop="getPhoneCode"/>
            </div>
            <div class="btnList">
              <button>返回</button>
              <button>确定</button>
            </div>
          </div>
        </el-tab-pane>
      </el-tabs>
      <!-- 注释
　　　　　　　label：选项卡显示的title
　　　　　　　name：与选项卡绑定的activeName对应的标识符，表示选项卡的别名
      -->
    </div>
  </div>
</template>
<script>
import logginHeader from "@/components/logginHeader";
import {GetCode,ForgetPwd,paymentCode} from "@/api/api";
export default {
  data() {
    return {
      phone:sessionStorage.getItem("phone"),
      activeName: "",
      title: "",
      showTime:false,//控制获取验证码时，按钮禁用
      validateTime: 60,//倒计时初始时间
      yanzhengma:"",//获取验证码
      mewPass:"",//修改密码新密码
      mewPass1:"",//修改密码确认密码
    };
  },
  components: {
    logginHeader
  },
  mounted() {
    this.gainCan();
    // this.getPhoneCode()
  },
  methods: {
    // 测试
    ceshi(){
      console.log(this.yanzhengma)
    },
    handleCommand(command) {
      // this.$message("click on item " + command);
    },
    handleClose(done) {
      this.resetFie();
      this.dialogVisible = !this.dialogVisible;
    },
    // 修改密码
    onForget() {
      const params = {
        phone: this.phone,
        password: this.mewPass,
        password_confirm: this.mewPass,
        code: this.yanzhengma
      };
      ForgetPwd(params).then(res => {
        let { data, msg, code } = res;
        this.showMsg(msg, code);
        // console.log(res);
        if (code === 1) {
          this.handleClose();
        }
      });
    },
    // 修改资金密码
    onPaymentCode() {
      const params = {
        phone: this.phone,
        password: this.mewPass,
        password_confirm: this.mewPass,
        code: this.yanzhengma
      };
      paymentCode(params).then(res => {
        let { data, msg, code } = res;
        this.showMsg(msg, code);
        // console.log(res);
        if (code === 1) {
          this.handleClose();
        }
      });
    },
    // 返回
    showMsg(msg, code) {
      this.$message({
        message: msg,
        type: code === 1 ? "success" : "error"
      });
    },
    gainCan() {
      this.activeName = this.$route.query.canshu;
      this.title = this.$route.query.title;
    },
    // 获取验证码
    getPhoneCode() {
      GetCode({ phone: this.phone }).then(res => {
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
  }
};
</script>
<style  lang="scss" scoped>
.bottomBox {
  background: #ffffff;
  margin: 10px 0 0 20px;
  padding: 20px;
  font-size: 13px;
  .el-tab-pane{
    margin-left: 200px;
    margin-top: 20px;
  }
  .TabCon{
    .btnList{
      width: 344px;
      height: 47px;
      box-sizing: border-box;
      margin: 20px 0 0 183px !important; 
      border-radius: 5px;
      button{
        width: 157px;
        height: 47px;
        box-sizing: border-box;
        border-radius: 5px;
        outline: none;
        color: #ffffff;
        &:nth-of-type(1){
          margin-right: 30px;
          border: 1px solid rgba(188, 188, 188, 1);
        }
        &:nth-of-type(2){
          border: 1px solid rgba(230, 45, 49, 1);
              background-color: rgba(255, 0, 0, 1);
        }
      }
    }
    input[disabled] {
      background: #ffffff;
    }
    .affirmPhone{
      background: rgba(230, 45, 49, 1);
      border: 1px solid rgba(230, 45, 49, 1);
      color: #ffffff;
      width: 344px;
      height: 47px;
      box-sizing: border-box;
      border-radius: 3px;
      margin-left: 182px;
      margin-top: 20px;
    }
    .bj {
      display: inline-block;
      width: 162px;
      margin-right: 20px;
      text-align: right;
    }
    input {
      height: 47px;
      box-sizing: border-box;
      border-radius: 3px;
      border: 1px solid rgba(204, 204, 204, 1);
    }
    input:hover {
      border: 1px solid rgba(0, 153, 255, 1);
    }
    div:nth-of-type(1) {
      margin-bottom: 20px;
      span:nth-of-type(2) {
        font-size: 18px;
        color: #c90000;
      }
    }
    div {
      input {
        padding: 0 10px;
        margin-right: 1px;
        &:nth-of-type(1) {
          width: 218px;
          box-sizing: border-box;
        }
        &:nth-of-type(2) {
          width: 126px;
          box-sizing: border-box;
        }
      }
      .btn {
        background: #ffffff;
      }
      .btn:hover {
        color: #c90000;
      }
      margin-bottom: 10px;
      &:nth-last-child(1) {
        margin: 0;
      }
      &:nth-of-type(2) {
        input {
          background: #ffffff;
        }
      }
      &:nth-of-type(3) {
        select {
          height: 47px;
          padding: 0 5px;
          background: linear-gradient(
            180deg,
            rgba(255, 255, 255, 1) 0%,
            rgba(255, 255, 255, 1) 0%,
            rgba(228, 228, 228, 1) 100%,
            rgba(228, 228, 228, 1) 100%
          );
          outline: none;
          box-sizing: border-box;
          width: 126px;
        }
      }
      .jy {
        text-align: center;
      }
      &:nth-of-type(5),
      &:nth-of-type(6) {
        input {
          width: 344px !important;
        }
      }
    }
  }
}
</style> 
<template>
  <div class="header">
    <el-col class="bg-black">
      <div class="cont">
        <div class="switch-lang">
          <span>中文</span>
          <el-divider direction="vertical"></el-divider>
          <span>English</span>
        </div>
        <div class="login-box">
          <div v-if="!ifLogin">
            <span @click="dialogVisible = true; isRegister = 1">注册</span>
            <el-divider direction="vertical"></el-divider>
            <span @click="dialogVisible = true; isRegister = 2">登录</span>
          </div>
          <div v-else class="after-login">
            <el-badge :value="200" :max="99" class="bell">
              <i class="el-icon-bell"></i>
            </el-badge>
            <el-avatar
              class="avatar"
              src="https://cube.elemecdn.com/0/88/03b0d39583f48206768a7534e55bcpng.png"
            ></el-avatar>
            <span class="phone">136****3045</span>
            <span @click="onLogout">退出</span>
          </div>
        </div>
      </div>
    </el-col>
    <el-col :span="24" class="nav">
      <div class="nav-cont">
        <div class="logo-box">
          <img :src="require('@/assets/images/logo.png')" width="100" alt />
        </div>
        <div class="comp-feature">
          <h2>一站式移动互联网</h2>
          <span>开发·运营·推广·赋能平台</span>
        </div>
        <div class="nav-lsit">
          <router-link to="/">
            <i class="icon iconfont icon-shouye"></i>
            <span>首页</span>
            <p class="en-name">Index</p>
          </router-link>
          <el-divider direction="vertical"></el-divider>
          <router-link to="/goods">
            <i class="icon iconfont icon-ruanjiandingzhi"></i>
            <span>软件/定制</span>
            <p class="en-name">Software develop</p>
            <i class="iconfont icon-remen fire"></i>
          </router-link>
          <el-divider direction="vertical"></el-divider>
          <router-link to="/comboPay">
            <i class="icon iconfont icon-xiaochengxu"></i>
            <span>小程序SaaS</span>
            <p class="en-name">SaaS</p>
          </router-link>
          <el-divider direction="vertical"></el-divider>
          <router-link to="/">
            <i class="icon iconfont icon-aislogo"></i>
            <span>AI推广引擎</span>
            <p class="en-name">AI advertising</p>
          </router-link>
          <el-divider direction="vertical"></el-divider>
          <router-link to="/">
            <el-dropdown @command="handleCommand" placement="bottom">
              <span class="el-dropdown-link">
                <i class="icon iconfont icon-APIwangguan"></i>
                <span>API赋能</span>
                <p class="en-name">API Enabling</p>
              </span>
              <el-dropdown-menu slot="dropdown">
                <el-dropdown-item command="b">支付平台</el-dropdown-item>
                <el-dropdown-item command="c">
                  <a
                    href="http://117.48.217.182:9001/#/login"
                    target="_blank"
                    style="color: #333333;"
                  >短信平台</a>
                </el-dropdown-item>
              </el-dropdown-menu>
            </el-dropdown>
          </router-link>
          <el-divider direction="vertical"></el-divider>
          <router-link to="/">
            <i class="icon iconfont icon-farenduiwaitouzi"></i>
            <span>投融介</span>
            <p class="en-name">Investment</p>
          </router-link>
          <el-divider direction="vertical"></el-divider>
          <a class="router-link-active" href="javascript:void(0);">
            <el-dropdown @command="handleCommand" placement="bottom">
              <span class="el-dropdown-link">
                <i class="icon iconfont icon-dailizizhizizhiqiyezizhi"></i>
                <span>角色加盟</span>
                <p class="en-name">Agency</p>
              </span>
              <el-dropdown-menu slot="dropdown">
                <el-dropdown-item command="a">
                  <router-link to="/city" style="color: #333;">合伙人</router-link>
                </el-dropdown-item>
                <el-dropdown-item command="b">
                  <router-link to="/member" style="color: #333;">等级会员</router-link>
                </el-dropdown-item>
                <el-dropdown-item command="c">
                  <router-link to="/contractor" style="color: #333;">分包商</router-link>
                </el-dropdown-item>
              </el-dropdown-menu>
            </el-dropdown>
          </a>
          <el-divider direction="vertical"></el-divider>
          <router-link to="/aboutUs">
            <i class="icon iconfont icon-guanyuwomen"></i>
            <span>Siring思锐</span>
            <p class="en-name">About us</p>
          </router-link>
        </div>
        <div class="sp-bt">
          <router-link to="/fillDemand">定制需求</router-link>
          <router-link to="/quickValuation" class="kjgj">快捷估价</router-link>
        </div>
      </div>
    </el-col>

    <el-dialog
      :title="isRegister==1?'会员注册':isRegister==2?'账户登录':'忘记密码'"
      :visible.sync="dialogVisible"
      width="600px"
      :lock-scroll="false"
      :modal-append-to-body="false"
      :before-close="handleClose"
      center
      class="dialog"
    >
      <template v-if="isRegister == 1">
        <el-form
          ref="form"
          :model="dataObj"
          :rules="rulesReg"
          label-width="70px"
          style="width: 70%; margin:0 auto;"
        >
          <el-form-item label="手机号" prop="phone">
            <el-input v-model="dataObj.phone" style="width: 64%;" placeholder="请输入手机号"></el-input>
            <el-button
              class="getcode"
              :disabled="showTime"
              @click="getPhoneCode"
            >{{showTime?`${validateTime}秒后失效`:'获取验证码'}}</el-button>
          </el-form-item>
          <el-form-item label="密码" prop="password">
            <el-input
              v-model="dataObj.password"
              :type="showPwd?'text':'password'"
              placeholder="请输入登录密码"
            ></el-input>
            <i
              class="iconfont icon-eye"
              :class="showPwd?'icon-yanjing':'icon-yanjing_bi'"
              @click="switchPwd"
            ></i>
          </el-form-item>
          <!-- <el-form-item label="验证码">
            <el-input v-model="dataObj.code"></el-input>
            <valid-code class="valid-code" :value.sync="validCode" />
          </el-form-item>-->
          <el-form-item label="验证码" prop="code">
            <el-input v-model="dataObj.code" placeholder="请输入验证码"></el-input>
          </el-form-item>
          <el-form-item label="邀请码">
            <el-input v-model="dataObj.invit" placeholder="邀请码可不填"></el-input>
          </el-form-item>

          <div class="prot">
            <div>
              <input type="checkbox" v-model="protocol" />
              <span>
                我同意
                <i class="bl">隐私协议</i>和
                <i class="bl">服务声明</i>
              </span>
            </div>
            <div>
              我已注册，
              <i class="red" @click="isRegister = 2; resetFie()">立即登录</i>
            </div>
          </div>
        </el-form>
      </template>
      <!-- 登录 -->
      <template v-else-if="isRegister == 2">
        <div class="logo-wrap">
          <el-image style="width: 140px; height: 60px;" :src="require('@/assets/images/logo.png')"></el-image>
        </div>
        <el-form
          ref="form"
          :model="dataObj"
          :rules="rulesReg"
          label-width="70px"
          style="width: 70%; margin:0 auto;"
        >
          <el-form-item label="手机号" prop="phone">
            <el-input v-model="dataObj.phone" placeholder="请输入手机号"></el-input>
          </el-form-item>
          <el-form-item label="密码" prop="password">
            <el-input
              v-model="dataObj.password"
              :type="showPwd?'text':'password'"
              placeholder="请输入登录密码"
            ></el-input>
            <i
              class="iconfont icon-eye"
              :class="showPwd?'icon-yanjing':'icon-yanjing_bi'"
              @click="switchPwd"
            ></i>
          </el-form-item>
          <div class="prot">
            <div>
              还不是会员，
              <i class="red" @click="isRegister = 1; resetFie()">立即注册</i>
            </div>
            <div>
              <i class="red" @click="isRegister = 3; resetFie()">忘记密码？</i>
            </div>
          </div>
        </el-form>
      </template>
      <!-- 修改密码 -->
      <template v-else>
        <div class="logo-wrap">
          <el-image style="width: 140px; height: 60px;" :src="require('@/assets/images/logo.png')"></el-image>
        </div>
        <el-form
          ref="form"
          :model="dataObj"
          :rules="rulesReg"
          label-width="70px"
          style="width: 70%; margin:0 auto;"
        >
          <el-form-item label="手机号" prop="phone">
            <el-input v-model="dataObj.phone" style="width: 64%;" placeholder="请输入手机号"></el-input>
            <el-button
              class="getcode"
              :disabled="showTime"
              @click="getPhoneCode"
            >{{showTime?`${validateTime}秒后失效`:'获取验证码'}}</el-button>
          </el-form-item>
          <el-form-item label="验证码" prop="code">
            <el-input v-model="dataObj.code" placeholder="请输入验证码"></el-input>
          </el-form-item>
          <el-form-item label="新密码" prop="password">
            <el-input v-model="dataObj.password" placeholder="请输入新密码"></el-input>
          </el-form-item>
        </el-form>
      </template>

      <span slot="footer" class="dialog-footer">
        <el-button
          type="danger"
          class="submit"
          @click="submit('form')"
        >{{isRegister==1?'注册':isRegister==2?'登录':'确定'}}</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
import validCode from "@/components/vaildcode";
import { Login, Register, GetCode, ForgetPwd, Logout } from "@/api/api";
export default {
  components: {
    validCode
  },
  inject: ['reload'],
  data() {
    return {
      ifLogin: false,
      dialogVisible: false,
      validCode: "",
      dataObj: { phone: "", password: "", code: "", invit: "" },
      rulesReg: {
        phone: [{ required: true, message: "请输入手机号", trigger: "blur" }],
        password: [{ required: true, message: "请输入密码", trigger: "blur" }],
        code: [{ required: true, message: "请输入验证码", trigger: "blur" }]
      },
      isRegister: 1,
      showPwd: false,
      protocol: false,
      showTime: false,
      validateTime: 60
    };
  },
  mounted() {
    this.isLogin();
  },
  methods: {
    isLogin() {
      this.ifLogin = !!this.$store.state.user_id;
    },
    handleCommand(command) {
      // this.$message("click on item " + command);
    },
    handleClose(done) {
      this.resetFie();
      this.dialogVisible = !this.dialogVisible;
    },
    resetFie() {
      this.$refs["form"].resetFields();
    },
    switchPwd() {
      this.showPwd = !this.showPwd;
    },
    showMsg(msg, code) {
      this.$message({
        message: msg,
        type: code === 1 ? "success" : "error"
      });
    },
    // 获取手机验证码
    getPhoneCode() {
      const phone = this.dataObj.phone;
      if (phone) {
        GetCode({ phone: this.dataObj.phone }).then(res => {
          let { data, msg, code } = res;
          this.showMsg(msg, code);
          if (code === 1) {
            this.showTime = true;
            this.countDown();
          }
        });
      } else {
        this.$message({
          message: "请填写手机号",
          type: "error"
        });
      }
    },
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
    submit(formName) {
      this.$refs[formName].validate(valid => {
        if (valid) {
          if (this.isRegister == 1 && !this.protocol) {
            this.$message({
              message: "您还未勾选择同意协议！",
              type: "error"
            });
          } else {
            switch (this.isRegister) {
              case 1:
                this.onRegister();
                break;
              case 2:
                this.onLogin();
                break;
              case 3:
                this.onForget();
                break;
            }
          }
        } else {
          return false;
        }
      });
    },
    // 注册
    onRegister() {
      const params = {
        phone: this.dataObj.phone,
        password: this.dataObj.password,
        password_confirm: this.dataObj.password,
        invitation: this.dataObj.invit,
        code: this.dataObj.code
      };
      Register(params).then(res => {
        let { data, msg, code } = res;
        this.showMsg(msg, code);
        this.handleClose();
      });
    },
    // 登录
    onLogin() {
      const params = {
        phone: this.dataObj.phone,
        password: this.dataObj.password
      };
      Login(params).then(res => {
        let { data, msg, code } = res;
        this.showMsg(msg, code);
        console.log(res);
        if (code === 1) {
          // 存储用户信息
          this.$store.commit("login", {
            id: data.user_id,
            phone: data.phone
          });
          this.ifLogin = true;
          this.reload();
          // this.handleClose();
        }
      });
    },
    // 忘记密码
    onForget() {
      const params = {
        phone: this.dataObj.phone,
        password: this.dataObj.password,
        password_confirm: this.dataObj.password,
        code: this.dataObj.code
      };
      ForgetPwd(params).then(res => {
        let { data, msg, code } = res;
        this.showMsg(msg, code);
        console.log(res);
        if(code === 1){
          this.handleClose();
        }
      });
    },
    onLogout(){
      Logout().then(res => {
        let { data, msg, code } = res.data;
        this.showMsg(msg, code);
        if(code === 1){
          this.$store.commit('logout');
          this.ifLogin = false;
          this.reload();
        }
      })
    }
  }
};
</script>
<style scoped>
.router-link-active >>> .el-dropdown {
  height: 16px;
  font-size: 16px;
  color: #333333;
}
.el-dropdown-menu {
  top: 92px !important;
}
.el-dropdown-menu__item {
  text-align: center;
}
</style>
<style scoped lang='scss'>
.header {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  z-index: 999;
  .bg-black {
    height: 40px;
    background-color: #000000;
    .cont {
      width: 1200px;
      height: 40px;
      line-height: 40px;
      color: #ffffff;
      margin: 0 auto;
      .switch-lang {
        float: left;
        font-size: 14px;
        cursor: pointer;
        span:hover {
          color: #ff0000;
        }
      }
      .login-box {
        float: right;
        height: 40px;
        span {
          cursor: pointer;
        }
        .after-login {
          height: 100%;

          .bell {
            font-size: 24px;
          }
          .phone {
            margin: 0 10px;
          }
        }
        .avatar {
          width: 30px;
          height: 30px;
          vertical-align: middle;
          margin-left: 40px;
        }
      }
    }
  }
  .nav {
    height: 60px;
    background-color: #ffffff;
    .nav-cont {
      height: 100%;
      width: 1200px;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: space-between;
      .logo-box {
        cursor: pointer;
      }
    }
    .comp-feature {
      h2 {
        font-weight: 700;
        font-size: 18px;
        line-height: 24px;
      }
      span {
        font-size: 13px;
        font-weight: 700;
      }
    }
    .nav-lsit {
      a {
        position: relative;
        display: inline-block;
        min-width: 82px;
        text-align: center;
        color: #333333;
        font-size: 16px;
        .icon {
          position: absolute;
          left: 50%;
          top: 0;
          transform: translateX(-50%);
          opacity: 0;
          font-size: 18px;
          transition: 0.5s;
        }
        .fire {
          position: absolute;
          top: -70%;
          right: -10px;
          color: rgb(250, 41, 1);
          font-size: 18px;
        }
        .en-name {
          position: absolute;
          left: 50%;
          bottom: 0;
          transform: translateX(-50%);
          // width: 100%;
          // text-align: center;
          line-height: normal;
          font-size: 10px;
          opacity: 0;
          transition: 0.5s;
          white-space: nowrap;
        }
        &:hover {
          color: #ff0000;
          .el-dropdown {
            color: #ff0000;
          }
          .en-name {
            opacity: 1;
            bottom: -15px;
          }
          .icon {
            opacity: 1;
            top: -18px;
          }
        }
      }
    }
    .sp-bt {
      a {
        display: inline-block;
        color: #fff;
        text-decoration: none;
        background-color: #ff0000;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 14px;
        text-align: center;
        margin-left: 5px;
        &.kjgj {
          background-color: #ffffff;
          color: #ff0000;
          border: 1px solid #ff0000;
        }
      }
    }
  }
  .dialog {
    .bl {
      color: #0099ff;
    }
    .red {
      color: #ff0000;
    }
    .prot {
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 90%;
      margin: 0 auto;
      i {
        cursor: pointer;
      }
    }
    .submit {
      display: block;
      width: 60%;
      margin: 0 auto 30px;
    }
    .getcode {
      position: absolute;
      right: 0;
      top: 0;
      height: 100%;
      outline: none;
      cursor: pointer;
    }
    .icon-eye {
      position: absolute;
      right: 20px;
      top: 0;
      height: 100%;
      outline: none;
      cursor: pointer;
    }
    .logo-wrap {
      text-align: center;
      margin-bottom: 20px;
    }
  }
}
</style>

<style>
.el-badge__content {
  border: 0;
}
.el-badge__content.is-fixed {
  top: 13px;
}
.el-dropdown {
  height: 40px;
}
</style>
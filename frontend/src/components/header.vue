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
            <span
              class="yangshixiugai"
              @click="dialogVisible = true; isRegister = 1"
              @mouseover="yangshixiugai(1)"
              @mouseout="yangshixiugai1"
            >注册</span>
            <el-divider direction="vertical"></el-divider>
            <span
              class="yangshixiugai"
              @click="dialogVisible = true; isRegister = 2"
              @mouseover="yangshixiugai(2)"
              @mouseout="yangshixiugai1"
            >登录</span>
          </div>
          <div v-else class="after-login">
            <el-badge :value="dingdanSum" :max="99" class="bell">
              <i class="el-icon-bell" v-popover:popover1></i>
            </el-badge>
            <!-- 悬浮 -->
            <el-popover ref="popover1" placement="bottom" width="320" trigger="hover">
              <div>
                <div class="popover-box">
                  <router-link to="demand_order">
                  [订单>软件/定制] 您有
                  <span style="color:#ff0000">24</span>个
                  <!-- <span style="color:#ff0000">软件/定制</span> -->
                  订单流程需及时处理
                  </router-link>
                </div>
                <div class="popover-box">
                  <router-link to="storeIndex">
                  [订单>小程序SaaS] 您有
                  <span style="color:#ff0000">24</span>个
                  <!-- <span style="color:#ff0000">小程序SaaS</span> -->
                  订单流程需及时处理
                  </router-link>
                </div>
                <div class="popover-box">
                  <router-link to="generalizeIndex">
                  [订单>AI推广运营] 您有
                  <span style="color:#ff0000">24</span>个
                  <!-- <span style="color:#ff0000">AI推广运营</span> -->
                  订单流程需及时处理
                  </router-link>
                </div>
                <div class="popover-box">
                  <router-link to="forMelting">
                  [订单>投融介] 您有
                  <span style="color:#ff0000">24</span>个
                  <!-- <span style="color:#ff0000">投融介</span> -->
                  订单流程需及时处理
                  </router-link>
                </div>
                <div class="popover-box" v-if="dis">
                  [售后] 您的年服务费即将到期，请充值
                  <!-- 您有
                  <span style="color:#ff0000">24</span>个
                  <span style="color:#ff0000">普通</span>
                  订单流程需及时处理-->
                </div>
              </div>
            </el-popover>

            <router-link to="afterLoggin" class="dh">
              <el-avatar class="avatar" :src="imgTou"></el-avatar>
              <span class="phone">{{phone}}</span>
            </router-link>
            <span class="out" @click="onLogout">退出</span>
          </div>
        </div>
      </div>
    </el-col>
    <el-col :span="24" class="nav">
      <div class="nav-cont">
        <div class="logo-box">
          <router-link to="/">
            <img :src="require('@/assets/images/logo.png')" width="100" alt />
          </router-link>
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
            <!-- <i class="iconfont icon-remen fire"></i> -->
            <img src="../assets/images/image561611.gif" class="fire" alt />
          </router-link>
          <el-divider direction="vertical"></el-divider>
          <router-link to="/programSaaS">
            <i class="icon iconfont icon-xiaochengxu"></i>
            <span>小程序SaaS</span>
            <p class="en-name">SaaS</p>
          </router-link>
          <el-divider direction="vertical"></el-divider>
          <router-link to="/ai-promotion">
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
          <router-link to="/investment">
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
          <a class="router-link-active" href="javascript:void(0);">
            <el-dropdown @command="handleCommand" placement="bottom">
              <span class="el-dropdown-link">
                <i class="icon iconfont icon-guanyuwomen"></i>
                <span>Siring思锐</span>
                <p class="en-name">About us</p>
              </span>
              <el-dropdown-menu slot="dropdown">
                <el-dropdown-item command="f">
                  <router-link to="/aboutUs" style="color: #333;">关于我们</router-link>
                </el-dropdown-item>
                <!-- <el-dropdown-item command="e">
                  <router-link to="/platformIntroduction" style="color: #333;">多平台介绍</router-link>
                </el-dropdown-item>-->
              </el-dropdown-menu>
            </el-dropdown>
          </a>
        </div>
        <div class="sp-bt">
          <span @click="dinghzi('fillDemand')">定制需求</span>
          <span @click="dinghzi('quickValuation')" class="kjgj">快捷估价</span>
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
              :class="showPwd?'icon-xianshi':'icon-yincang'"
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
          <div class="selectCity">
            <!-- 注册页添加城市三级联动下拉列表 -->
            <span>
              <span style="color:#F56C6C">*</span>城市
            </span>
            <el-select
              v-model="selectItem"
              @change="selectFn($event)"
              placeholder="请选择"
              style="width:157.5px;"
            >
              <!--选择项的value值默认选择项文本 可动态绑定选择项的value值 更改v-model指令绑定数据-->
              <!-- <el-option v-for="(item,index) in items" :value="item.id" :key="index" :id="item.id"></el-option> -->
              <el-option
                v-for="(item,index) in items"
                :key="index+item.name"
                :label="item.name"
                :value="item.id"
              ></el-option>
            </el-select>
            <el-select
              v-model="selectItem1"
              @change="selectFn1($event)"
              placeholder="请选择"
              style="width:157.5px;"
            >
              <!-- <el-option v-for="(item,index) in items1" :value="item.id" :key="index">{{item.name}}</el-option> -->
              <el-option
                v-for="(item,index) in items1"
                :key="index+item.name"
                :label="item.name"
                :value="item.id"
              ></el-option>
            </el-select>
          </div>
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
              :class="showPwd?'icon-xianshi':'icon-yincang'"
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
          <!-- <el-form-item label="确认新密码" prop="password">
            <el-input v-model="dataObj.password" placeholder="请输入新密码"></el-input>
          </el-form-item>-->
        </el-form>
      </template>

      <span slot="footer" class="dialog-footer">
        <el-button
          type="danger"
          class="submit"
          @click="submit('form')"
          style="background:#e62d31"
        >{{isRegister==1?'注册':isRegister==2?'登录':'确定'}}</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
import validCode from "@/components/vaildcode";
import {GetUserMassage} from "@/api/api";
import {
  Login,
  Register,
  GetCode,
  ForgetPwd,
  Logout,
  GetProvince,
  GetCityList
} from "@/api/api";
export default {
  components: {
    validCode
  },
  inject: ["reload"],
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
      validateTime: 60,
      // 城市三级联动下拉框
      selectItem: "请选择",
      items: [],
      selectItem1: "请选择",
      items1: [],
      pid: 0, //省份id
      cid: 0, //市id
      dis: true, //提醒处售后状态控制
      dingdanSum: 50, //提醒出角标数量，即订单总数
      imgTou: ""
    };
  },
  computed: {
    phone() {
      return this.$store.state.phone.replace(/(\d{3})\d{4}(\d{3})/, "$1****$2");
    }
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.userMessage();
      this.isLogin();
      this.ceshi();
      this.getGetProvince();
      this.guoqi();
    },
    // 获取用户信息,头像
    userMessage() {
      const userId = sessionStorage.getItem("user_id");
      const params = {
        user_id: userId
      };
      GetUserMassage(params).then(res => {
        let { data, msg, code } = res;
        console.log(data);
        // this.showMsg(msg,code);
        if (code === 1) {
          // this.userMessage1 = data;
          this.imgTou =
            data.img == null
              ? "https://cube.elemecdn.com/0/88/03b0d39583f48206768a7534e55bcpng.png"
              : data.img;
          // this.imgTou = data.img || this.defaultImg;
          // console.log(this.userMessage1);
        }
      });
    },
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
    // 定制需求等检测是否已经登录
    dinghzi(str) {
      let num = sessionStorage.getItem("user_id");
      let roPath = this.$route.name;
      if (num == null && roPath != "index") {
        this.$router.push({
          name: `index`,
          params: {
            isRegister: "2"
          }
        });
      } else if (roPath == "index" && num == null) {
        console.log(123123);
        this.dialogVisible = true;
        this.isRegister = 2;
        this.$message.error("请登录");
      } else {
        this.$router.push({ name: str });
      }
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
        code: this.dataObj.code,
        pid: this.pid,
        cid: this.cid
      };
      Register(params).then(res => {
        let { data, msg, code } = res;
        this.showMsg(msg, code);
        this.handleClose();
      });
    },
    //获取省份
    getGetProvince() {
      GetProvince().then(res => {
        let { data, code, msg } = res;
        if (code == 1) {
          this.items = data;
        }
      });
    },
    yangshixiugai(num) {
      let yangshiArr = document.getElementsByClassName("yangshixiugai");
      if (num == 1) {
        // console.log(1111)
        yangshiArr[0].style.color = "red";
      } else {
        // console.log(2222)
        yangshiArr[1].style.color = "red";
      }
    },
    yangshixiugai1() {
      let yangshiArr = document.getElementsByClassName("yangshixiugai");
      yangshiArr[0].style.color = "#ffffff";
      yangshiArr[1].style.color = "#ffffff";
    },
    // 测试通过他人邀请码过来
    ceshi() {
      let roPath = this.$route.query.isRegister;
      let yqm = this.$route.query.invitationCode;
      if (roPath == 1) {
        this.dialogVisible = true;
        this.isRegister = 1;
        this.dataObj.invit = yqm;
      }
    },
    //登录过期，弹出登录框
    guoqi() {
      let roPath = this.$route.params.isRegister;
      console.log("112132" + "测试测试" + roPath);
      if (roPath == 2) {
        this.dialogVisible = true;
        this.isRegister = 2;
        Logout().then(res => {
          let { data, msg, code } = res.data;
          if (code === 1) {
            this.$message.error("请登录");
            this.$store.commit("logout");
            this.ifLogin = false;
            // this.reload();
            this.$router.push("/");
          }
        });
      }
    },
    // 城市改变，获取相应的二级城市等
    selectFn() {
      let pid = this.selectItem;
      this.pid = parseInt(pid);
      const params = { pid: pid };
      GetCityList(params).then(res => {
        let { data, code, msg } = res;
        if (code == 1) {
          this.items1 = data;
          this.selectItem1 = data[0].id;
          this.cid = data[0].id;
        }
      });
    },
    //pid,cid
    selectFn1() {
      this.cid = parseInt(this.selectItem1);
      console.log(this.cid);
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
        // console.log(111, res);
        // 登录成功后跳转的页面
        if (code === 1) {
          // 存储用户信息
          // console.log(data);
          this.$store.commit("login", {
            id: data.user_id,
            phone: data.phone,
            avatar: data.user_img
          });
          this.ifLogin = true;
          this.handleClose();
          // this.dialogVisible = false;
          // this.$router.push({ name: "afterLoggin" });
          // this.reload();
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
        // console.log(res);
        if (code === 1) {
          this.handleClose();
        }
      });
    },
    onLogout() {
      Logout().then(res => {
        let { data, msg, code } = res.data;
        this.showMsg(msg, code);
        if (code === 1) {
          this.$store.commit("logout");
          this.ifLogin = false;
          // this.reload();
          this.$router.push("/");
        }
      });
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
.popover-box {
  text-align: left;
  margin: 10px 0;
}
.popover-box a{
  color: #606662;
}
</style>
<style scoped lang='scss'>
.header {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  z-index: 999;
  border-bottom: 2px solid #ffffff;
  box-shadow: 0px 3px 4px rgba(0, 0, 0, 0.2);
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
          .dh {
            .phone {
              margin: 0 10px;
              color: #ffffff;
            }
            .phone:hover {
              color: #ff0000;
            }
          }
          .out {
            color: #ffffff;
          }
          .out:hover {
            color: #ff0000;
          }
        }
        .avatar {
          width: 30px;
          height: 30px;
          vertical-align: middle;
          margin-left: 40px;
          margin-top: -2px;
        }
      }
    }
  }
  .nav {
    height: 60px;
    background-color: rgb(242, 247, 250);
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
        padding-bottom: 2px;
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
          // font-size: 18px;
          width: 20px;
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
          color: rgb(177, 18, 14);
          .el-dropdown {
            color: rgb(177, 18, 14);
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
      span {
        display: inline-block;
        color: #fff;
        text-decoration: none;
        background-color: #ff0000;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 14px;
        text-align: center;
        margin-left: 5px;
        cursor: pointer;
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
  .selectCity {
    display: flex;
    align-items: center;
    padding-bottom: 20px;
    > span {
      width: 70px;
      padding-right: 12px;
      box-sizing: border-box;
      text-align: right;
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
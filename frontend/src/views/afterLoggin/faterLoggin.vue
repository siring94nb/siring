  <template>
  <div>
    <!--<myheader />-->
    <!-- 侧边导航栏菜单 -->
    <div class="box" ref="box" :style="wstyle">
      <div class="imgBox">
        <div style="height:140px;">
          <!-- <div>
            <img :src="imgBUrl" alt />
            <img :src="imgUrl" alt v-if="imgUrl!=''"/>
            <i style="font-size:60px;" class="iconfont icon-touxiang1" v-if="imgUrl==''"></i>
          </div>-->
          <div>
            <el-upload
              name="image"
              class="avatar-uploader"
              action="https://manage.siring.com.cn/api/file/qn_upload"
              :show-file-list="false"
              :on-success="handleAvatarSuccess"
            >
              <img :src="imgBUrl" alt />
              <img :src="imgUrl" alt />
              <!-- <div style="margin-top:25px;margin-left:-10px"><i style="font-size:70px;" class="iconfont icon-touxiang1" v-if="imgUrl == null"></i></div> -->
            </el-upload>
          </div>
          <div class="name">{{name}}</div>
        </div>
        <div style="height: 2px; width: 160px;background: -webkit-linear-gradient(left,rgba(255, 255, 255, 0),rgb(197,150,142),rgba(255,255,255,0));background: linear-gradient(to right, rgba(255, 255, 255, 0),rgb(197,150,142),rgba(255,255,255,0));margin-bottom:6px"></div>
        <div class="xxBox">
          <div>
            <span>￥{{yue}}</span>
            <span>
              <router-link to="/recharge">余额充值</router-link>
            </span>
          </div>
          <div>
            <span>
              专属客服
              <i class="iconfont icon-icon"></i>
            </span>
            <span>
              <a
                id="qq"
                target="_blank"
                href="http://wpa.qq.com/msgrd?v=3&amp;uin=415364124&amp;site=qq&amp;menu=yes"
              >立即联系</a>
            </span>
          </div>
          <div>
            <div style="font-size:12px;width:60px">上次登录</div>
            <div style="font-size:12px;width:100px;text-align:right">{{updated_at}}</div>
          </div>
        </div>
      </div>
      <div class="navBoxa">
        <el-row class="tac">
          <!-- :default-openeds="[num]" -->
          <el-col :span="24">
            <el-menu
              :default-active="ru"
              class="el-menu-vertical-demo"
              @close="handleClose"
              background-color="rgb(0,0,0)"
              active-background-color="#000000"
              text-color="#fff"
              :unique-opened="true"
              :router="true"
              :default-openeds="[num]"
               @open="handleOpen"
            >
              <el-submenu ref="ceshi" :index="index+''" v-for="(item,index) in arr" :key="index+''">
                <!-- 控制中心 -->
                <template slot="title">
                  <div ref="elSubmenu">
                    <div>
                      <i :class="item.classN" style="padding-right:15px;"></i>
                      <span>{{item.title}}</span>
                    </div>
                  </div>
                </template>
                <el-menu-item
                  v-for="(con,index1) in item.con"
                  :key="index1+''"
                  :index="con.rou"
                  style="color:#000;"
                >
                  <div ref="con" class="con">{{con.name}}</div>
                </el-menu-item>
              </el-submenu>
            </el-menu>
          </el-col>
        </el-row>
      </div>
    </div>
  </div>
</template>

<script>
// import Myheader from "@/components/header";
import {
  CityTotal,
  MemberTotal,
  SubcontractTotal,
  GetUserMassage,
  GetRoleCenter,
  UserUpdating
} from "@/api/api";
export default {
  // name: "fater-loggin",
  data() {
    return {
      yue: 0,
      ru:
        this.$route.path == "/afterLoggin" ? "/afterLogginR" : this.$route.path, //确保页面刷新，导航栏选中状态不被清除,刷新就获取一次
      num: "",
      classHuiyuan: 1,
      fenbaoshang: 1,
      tixian: 1,
      arr: [
        {
          title: "控制中心",
          classN: "iconfont icon-kongzhitai",
          con: [{ name: "控制台", rou: "/afterLogginR" }]
        },
        {
          title: "会员中心",
          classN: "iconfont icon-huiyuan",
          con: [
            // "会员信息", "安全中心", "邀请好友"
            { name: "会员信息", rou: "/memberInformation" },
            { name: "安全中心", rou: "/securityCenterIndex" },
            { name: "邀请好友", rou: "/invitationX" }
          ]
        },
        {
          title: "角色中心",
          classN: "iconfont icon-jiaose",
          con: [
            // "城市合伙人", "等级会员", "分包商"
            { name: "城市合伙人", rou: "/CityPartner" },
            { name: "等级会员", rou: "/ClassMembersA" },
            { name: "分包商", rou: "/subContractorSm1" }
          ]
        },
        {
          title: "资金管理",
          classN: "iconfont icon--zijinguanli",
          con: [
            // "资金明细", "充值", "提现", "银行卡管理", "优惠券"
            { name: "资金明细", rou: "/financialDetailsI" },
            { name: "充值", rou: "/recharge" },
            { name: "提现", rou: "/withdraw" },
            { name: "银行卡管理", rou: "/CardManagement" },
            { name: "优惠券", rou: "/discountCoupon" }
          ]
        },
        {
          title: "软件/定制",
          classN: "iconfont icon-dingzhi",
          con: [
            // "定制需求订单", "定制类似订单"
            { name: "定制需求订单", rou: "/demand_order" },
            { name: "定制类似订单", rou: "/customization_analogy" }
          ]
        },
        {
          title: "小程序SaaS",
          classN: "iconfont icon-SaaS",
          con: [
            // "SaaS店铺订单", "增值服务订单"
            { name: "SaaS店铺订单", rou: "/storeIndex" },
            { name: "增值服务订单", rou: "/appreciationIndex" }
          ]
        },
        {
          title: "AI推广运营",
          classN: "iconfont icon-tuiguang",
          con: [
            // "推广订单"
            { name: "推广订单", rou: "/generalizeIndex" }
          ]
        },
        {
          title: "投融介",
          classN: "iconfont icon-tourongziqingkuang  ",
          con: [
            // "我的投融", "中止项目"
            { name: "我的投融", rou: "/forMelting" },
            { name: "中止项目", rou: "/zhongzhi" }
          ]
        }
      ],
      routerValue: this.$route.path,
      imgUrl: require("../../assets/images/头像 (2).png"), //用户头像
      // imgUrl:"",
      imgBUrl: require("../../assets/images/u176.png"),
      name: "未设置", //用户姓名
      dis: true,
      wstyle: "",
      updated_at: "",
      shujuData: []
    };
  },
  components: {},
  mounted() {
    this.init();
    //  window.onresize = () => {
    //   console.log(13212313)
    // };
  },
  methods: {
    handleAvatarSuccess(res, file) {
      this.imgUrl = res.data.filePath;
      this.setUserUpdating();
      this.$router.go(0)
    },
    showMsg(msg, code) {
      this.$message({
        message: msg,
        type: code === 1 ? "success" : "error"
      });
    },
    init() {
      console.log(document.getElementsByClassName("imgBox")[0].offsetHeight);
      this.cityHehuorenX(),
        this.classHuiyuanX(),
        this.fenbaoshangX(),
        this.withdrawX();
      // this.zhankai();
      this.userMessage();
      this.chaxun();
    },
    // 保持侧边栏对应路由展开状态
    zhankai() {
      let arr = this.arr;
      let val = this.$route.path;
      for (var i = 0; i < arr.length; i++) {
        for (var j = 0; j < arr[i].con.length; j++) {
          if (arr[i].con[j].rou == val) {
            // }else if(val =="/safetyTabControl"){

            // }else{
            const num = String(i);
            // console.log(num)
            this.num = String(i);
            // console.log(val)
            // }
          } else if (val == "/addEnterprise" || val == "/enterpriseList") {
            if (arr[i].con[j].rou.indexOf("/memberInformation") != -1) {
              // console.log(i);
            }
          }
        }
      }
      return -1;
    },
    // 城市合伙人
    cityHehuorenX() {
      // 因为前期想法错误，当前修改较麻烦
      // const params = {
      //   type: 1
      // };
      CityTotal().then(res => {
        let { data, msg } = res;
        console.log(res);
        if (data.code == 1) { 
          this.arr[2].con[0].rou = "/CityPartner";
        }
        // else if(data.code == 3){
        //   this.showMsg(msg,code);
        //   this.$router.push({
        //     name:`index`,
        //     params:{
        //       isRegister:'2'
        //     }
        //   })
        // }
        else if (data.code == 0) {
          // this.arr[2].con[0].rou = "/CityPartner";
          this.arr[2].con[0].rou = "/partnerCityX";
          // 13260676780
        }
      });
    },
    // 等级会员
    classHuiyuanX() {
      // const params = {
      //   type: 2
      // };
      MemberTotal().then(res => {
        let { data, msg } = res;
        if (data.code == 1) {
          this.arr[2].con[1].rou = "/ClassMembersA";
        }
        // else if(data.code == 3){
        //   // this.showMsg(msg,code);
        //   this.$router.push({
        //     name:`index`,
        //     params:{
        //       isRegister:'2'
        //     }
        //   })
        // }
        else if (data.code == 0) {
          this.arr[2].con[1].rou = "/ClassMembersX";
          // this.arr[2].con[1].rou = "/ClassMembersA";
          // 13260676780
        }
      });
    },
    // 分包商
    fenbaoshangX() {
      // const params = {
      //   type: 3
      // };
      SubcontractTotal().then(res => {
        let { data, msg } = res;
        if (data.code == 1) {
          this.arr[2].con[2].rou = "/subContractorSm1";
        }
        // else if(data.code == 3){
        //   // this.showMsg(msg,code);
        //   this.$router.push({
        //     name:`index`,
        //     params:{
        //       isRegister:'2'
        //     }
        //   })
        // }
        else if (data.code == 0) {
          this.arr[2].con[2].rou = "/subContractorIndex";
          // this.arr[2].con[2].rou = "/subContractorSm1";
          // 13260676780
        }
      });
    },
    //提现
    withdrawX() {
      if (this.tixian === 0) {
        this.arr[3].con[2].rou = "/withdraw";
        // console.log(1111)
      } else {
        this.arr[3].con[2].rou = "/withdrawX";
        // console.log(2222)
      }
    },
    chaxun() {
      let sum = 0;
      for (let i = 0; i < this.$refs.elSubmenu.length; i++) {
        sum +=
          this.$refs.elSubmenu[i].offsetHeight + this.$refs.con[i].offsetHeight;
      }
      // console.log(window.innerHeight)
      // console.log(sum)
      if (window.innerHeight < sum + 100 || window.innerHeight == sum + 100) {
        this.wstyle =
          "overflow-y:scroll;height:" + (window.innerHeight - 20) + "px";
        // console.log(1111)
      } else {
        this.wstyle = "";
        // console.log(2222)
      }
      // }, 1000);
    },
    handleOpen(key, keyPath) {
      console.log(20200302);
      console.log(document.body.offsetHeight-102)
    },
    handleClose(key, keyPath) {
        console.log(2212);
    },
    // 获取用户信息
    userMessage() {
      const userId = sessionStorage.getItem("user_id");
      const params = {
        user_id: userId
      };
      GetUserMassage(params).then(res => {
        let { data, msg, code } = res;
        console.log(data);
        if (code === 1) {
          this.yue = data.money;
          this.imgUrl =
            data.img == null? require("../../assets/images/头像 (2).png"): data.img;
          this.name = data.realname || this.name;
          this.updated_at = data.updated_at;
          this.shujuData = data;
        }
      });
    },
    // 更换头像
    setUserUpdating() {
      const params = {
        user_id: this.shujuData.id,
        name: this.shujuData.realname,
        id_card: this.shujuData.id_card,
        id_card_just: this.shujuData.id_card_just,
        id_card_back: this.shujuData.id_card_back,
        province: this.shujuData.add_province,
        city: this.shujuData.add_city,
        enterprise_id: this.shujuData.enterprise_id,
        area: this.shujuData.add_area,
        address: this.shujuData.address,
        img: this.imgUrl, //12312313
        sex: this.shujuData.sex
      };
      UserUpdating(params).then(res => {
        let { data, msg, code } = res;
        console.log(res);
        if (code === 1) {
          this.showMsg(msg, msg);
        }
      });
    }
  }
};
</script>
<style lang="scss" scoped>
.box {
  // height: 300px;
  position: relative;
  z-index: 555;
  width: 160px;
  margin-left: 1px;
  // overflow-y:scroll;
}
.box::-webkit-scrollbar {
  display: none;
}
.tac {
  width: 160px;
  height: 82px;
  el-menu-item {
    width: 123px;
  }
  i {
    color: rgba($color: #ffffff, $alpha: 1);
  }
  .el-menu-item.is-active {
    // font-size: 16px;
    // font-weight: 700;
    color: #d79e94 !important;
  }
  li {
    width: 100%;
    padding: 0 !important;
    box-sizing: border-box;
  }
}
.imgBox {
  margin-top:5px;
  margin-bottom: 10px;
  text-align: center;
  // height: 200px;
  background: #000000;
  color: #ffffff;
  position: relative;
  border-radius: 10px;
  font-size: 13px;
  .name {
    position: absolute;
    top: 115px;
    left: 55px;
  }
  img {
    position: absolute;
    &:nth-of-type(1) {
      display: inline-block;
      // width: 110px;
      // height: 110px;
      width: 100px;
      height: 100px;
      border-radius: 50%;
      // top: 5px;
      // left: 25px;
      top: 10px;
      left: 30px;
    }
    &:nth-of-type(2) {
      display: inline-block;
      width: 70px;
      height: 70px;
      border-radius: 50%;
      top: 25px;
      left: 45px;
    }
  }
}
.xxBox {
  > div {
    display: flex;
    justify-content: space-between;
    align-content: center;
    padding: 5px;
    &:nth-of-type(1) {
      > span:nth-last-child(1) {
        padding: 5px;
        background: rgb(238, 189, 101);
        border-radius: 3px;
        a {
          color: #ffffff;
        }
      }
    }
    &:nth-of-type(2) {
      > span:nth-last-child(1) {
        padding: 5px;
        background: rgb(114, 124, 164);
        border-radius: 3px;
      }
      a {
        color: #ffffff;
      }
    }
    &:nth-of-type(3) {
      color: rgba(255, 255, 255, 0.64);
      display: flex;
      justify-content: space-between;
    }
  }
}
.con {
  background: #ffffff;
  width: 120px;
  margin-left: 18px;
}
.navBoxa{
  height: 560px;
  overflow-y: scroll;
  border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
}
.navBoxa::-webkit-scrollbar{
    display:none;
}
</style>
<style>
/* .el-submenu__title{
    height: 200px;
} */
.el-submenu .el-menu-item {
  min-width: 121px;
  text-align: center;
  background-color: rgb(255, 255, 255) !important;
}
.tac ul {
  border-radius: 10px !important;
}
.tac ul li:nth-of-type(1) > div {
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
}
.tac ul li:nth-last-of-type(1) > div {
  border-bottom-left-radius: 10px;
  border-bottom-right-radius: 10px;
}
</style>
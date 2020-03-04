<template>
  <div>
    <div>
      <logginHeader>
        <i class="iconfont icon-huiyuan"></i>
        <span>会员中心</span>
        <span>&gt;</span>
        <span>会员信息</span>
      </logginHeader>
      <div style="display: flex;">
        <div class="boxM">
          <div style=" display: flex">
            <div class="defaultImg">
              <el-upload
                name="image"
                class="avatar-uploader"
                action="https://manage.siring.com.cn/api/file/qn_upload"
                :show-file-list="false"
                :on-success="handleAvatarSuccess"
              >
                <!-- <img :src="imgBUrl" alt /> -->
                <img :src="imgTou" alt="用户头像" v-if="imgTou!=''" />
                <!-- <div style="margin-top:25px;margin-left:-10px"><i style="font-size:70px;" class="iconfont icon-touxiang1" v-if="imgUrl == null"></i></div> -->
              </el-upload>
              <!-- <img :src="imgTou" alt="用户头像" v-if="imgTou!=''"/>
              <i class="iconfont icon-touxiang1" v-if="imgTou==''"></i>-->
            </div>
            <div class="biaozhi">
              <i class="iconfont icon-huaban_fuzhi"></i>
              <ul>
                <li v-for="(item,index) in arr" :key="index">
                  <img :src="require('../../assets/images/'+(index+6)+'.png')" />
                </li>
              </ul>
            </div>
            <div class="account">
              <ul>
                <li>
                  <span>账号：</span>
                  <span>{{userMessage1.phone}}</span>
                </li>
                <li>
                  <span>{{userMessage1.type===1?"普通会员":userMessage1.type===2?"合伙人":"分包商"}}：</span>
                  <span>升级会员获佣金</span>
                </li>
                <li style="padding-top:10px;">
                  <span>邀请码：</span>
                  <span>{{userMessage1.invitation }}</span>
                  <!-- <span>详细</span> -->
                </li>
              </ul>
            </div>
            <div class="anquan">
              <img style="width:116px;height:116px" :src="require('../../assets/images/u194.png')" />
              <div>
                <span>安全等级：</span>
                <span>中</span>
              </div>
            </div>
          </div>
        </div>
        <div class="yue">
          <div>
            <div>
              <i class="iconfont icon--zijinguanli"></i>
            <span>余额</span>
            </div>
             <div class="tx">
              <router-link to="withdrawX" style="color:#0889f5">余额提现</router-link>
            </div>
          </div>
          <div>
            <div class="yueBox">
              <span style="font-size:24px;padding-right:10px;">{{userMessage1.money}}</span>
              <span style="font-size:13px;">元</span>
              <i class="el-icon-arrow-right"></i>
            </div>
            <div class="chongzhi">
              <router-link to="recharge" style="color:#ffffff">余额充值</router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
    <gnmk>我的订单</gnmk>
    <div class="dinDanCL" style="display: flex; flex:1">
      <ding-dan />
    </div>
    <gnmk1>角色收益</gnmk1>
  </div>
</template>
<script>
import Myheader from "@/components/header";
import faterLoggin from "@/views/afterLoggin/faterLoggin";
import logginHeader from "@/components/logginHeader";
import gnmk from "@/components/gnmk";
import gnmk1 from "@/components/gnmk1";
import dingDan from "@/components/dingDan";
import { GetUserMassage, GetSumIndent,UserUpdating } from "@/api/api";
export default {
  name: "afer-logginR",
  data() {
    return {
      userMessage1: {},
      arr: [1, 2],
      imgTou: require("../../assets/images/头像 (2).png"),
      defaultImg: require("../../assets/images/u158.png")
    };
  },
  mounted() {
    this.userMessage();
  },
  methods: {
    showMsg(msg, code) {
      this.$message({
        message: msg,
        type: code === 1 ? "success" : "error"
      });
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
        // this.showMsg(msg,code);
        if (code === 1) {
          this.userMessage1 = data;
          this.imgTou =
            data.img == null
              ? require("../../assets/images/头像 (2).png")
              : data.img;
          // this.imgTou = data.img || this.defaultImg;
          // console.log(this.userMessage1);
        }
      });
    },
    handleAvatarSuccess(res, file) {
      this.imgTou= res.data.filePath;
      this.setUserUpdating();
      // this.$router.push("/afterLoggin")
      this.$router.go(0)
    },
    setUserUpdating() {
      const params = {
        user_id: this.userMessage1.id,
        name: this.userMessage1.realname,
        id_card: this.userMessage1.id_card,
        id_card_just: this.userMessage1.id_card_just,
        id_card_back: this.userMessage1.id_card_back,
        province: this.userMessage1.add_province,
        city: this.userMessage1.add_city,
        enterprise_id: this.userMessage1.enterprise_id,
        area: this.userMessage1.add_area,
        address: this.userMessage1.address,
        img: this.imgTou, //12312313
        sex: this.userMessage1.sex
      };
      UserUpdating(params).then(res => {
        let { data, msg, code } = res;
        console.log(res);
        if (code === 1) {
          this.showMsg(msg, msg);
        }
      });
    }
  },
  components: {
    gnmk,
    gnmk1,
    dingDan,
    logginHeader
  }
};
</script>
<style lang="scss" scoped>
.boxM {
  background: #fff;
  margin: 10px 0 0 20px;
  padding: 70px 40px 40px 40px ;
  .defaultImg {
    img {
      width: 120px;
      height: 123px;
      border-radius: 50%;
    }
    i {
      font-size: 120px;
    }
  }
  .biaozhi {
    margin-left: 85px;
    margin-right: 20px;
    i {
      width: 80px;
      height: 23px;
      color: rgb(252, 193, 45);
      font-size: 20px;
    }
    img {
      width: 30x;
      height: 30px;
      padding: 30px 0 0 20px;
      // padding-top: 10px;
    }
  }
  .account {
    margin-right: 90px;
    width: 280px;
    li {
      padding-bottom: 35px;
      > span {
        font-size: 20px;
        &:nth-of-type(1) {
          display: inline-block;
          width: 120px;
          color: #949494;
          padding-right: 10px;
        }
      }
      &:nth-of-type(2) {
        span {
          &:nth-of-type(2) {
            background: rgb(204, 235, 253);
            color: #0766bc;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 18px;
          }
        }
      }
      &:nth-of-type(3) {
        span {
          &:nth-of-type(3) {
            font-size: 14px;
            color: #bcbcbc;
            font-weight: 700;
            padding: 5px 15px;
            border-radius: 5px;
            border: 1px solid #bbccbc;
            margin-left: 15px;
          }
        }
      }
    }
  }
  .anquan {
    > div {
      text-align: center;
      span {
        &:nth-of-type(1) {
          font-size: 16px;
          color: #bcbcbc;
        }
        &:nth-of-type(2) {
          font-size: 18px;
          color: #669900;
          font-weight: 700;
        }
      }
    }
  }
}
.yue {
  padding: 70px 50px 50px 50px;
  margin: 10px 0 0 10px;
  background: #ffffff;
  display: flex;
  div:nth-of-type(1) {
    margin-right: 45px;
    width: 200px;
    position: relative;
  }
  i {
    font-size: 32px;
    color: rgb(216, 30, 6);
    padding-right: 10px;
  }
  span {
    color: rgb(216, 30, 6);
    font-size: 20px;
  }
  .tx {
    color: #0889f5;
    border: 1px solid #0889f5;
    padding: 5px 10px;
    border-radius: 5px;
    width: 66px;
    // font-weight: 700;
    position: absolute;
    top: 92px
  }
  .chongzhi {
    color: #ffffff;
    border: 1px solid rgb(233,193,122);
    background: rgb(233,193,122);
    padding: 5px 10px;
    border-radius: 5px;
    width: 66px;
    margin-top: 10px;
    // font-weight: 700;

  }
  .yueBox {
    padding-bottom: 50px;
  }
}
</style>
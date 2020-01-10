<template>
  <div>
    <logginHeader>
      <i class="iconfont icon-huiyuan"></i>
      <span>会员中心</span>
      <span>&gt;</span>
      <span>邀请好友</span>
      <span>&gt;</span>
      <span>{{title}}</span>
    </logginHeader>
    <div class="bottomBox">
      <el-tabs v-model="activeName">
        <el-tab-pane label="邀请方法" name="first" :key="'first'">
          <div class="smBox">
            <div>方法一</div>
            <div>链接邀请</div>
            <div>
              <el-input v-model="userLink" disabled="disabled"></el-input>
              <el-button
                v-clipboard:copy="userLink"
                v-clipboard:success="onCopy"
                v-clipboard:error="onError"
              >复制</el-button>
            </div>
            <div>
              您使用的网站链接来邀请好友注册，注册之后将自动成为您下级用户；快快推荐给您的好友吧，分享好友注册，彼此可分别获得
              <span>10元现金</span>
              <span>优惠券！</span>
            </div>
          </div>
          <div class="smBox">
            <div>方法二</div>
            <div>分享邀请码</div>
            <div>
              <el-input v-model="invitationCode" disabled="disabled"></el-input>
              <el-button
                v-clipboard:copy="invitationCode"
                v-clipboard:success="onCopy"
                v-clipboard:error="onError"
              >复制</el-button>
            </div>
            <div>
              系统为您生成专属6位邀请码，您可妥善保存；快快推荐给您的好友吧，分享好友注册，彼此可分别获得
              <span>10元现金</span>
              <span>优惠券！</span>
            </div>
          </div>
        </el-tab-pane>

        <el-tab-pane label="邀请记录" name="second" :key="'second'">
          <div class="bottomBoxTab">
            <el-table :data="tableData" border style="width: 100%" :header-cell-style="{background:'rgb(249,250,252)',color:'#666666',fontWeight: '700'}">
              <el-table-column prop="HerID" label="你邀请的用户ID（会员/邀请码）" width="230" align="center">
                <template slot-scope="scope">
                  <div>{{scope.row.HerID}}</div>
                </template>
              </el-table-column>
              <el-table-column prop="HerPhone" label="用户账号（手机号）" width="230" align="center">
                <template slot-scope="scope">
                  <div>{{scope.row.HerPhone.replace(scope.row.HerPhone.substring(3,7),"****")}}</div>
                </template>
              </el-table-column>
              <el-table-column prop="HerImg" label="头像" width="180" align="center">
                <template slot-scope="scope">
                  <img :src="scope.row.HerImg" width="100" height="100" class="herImg" />
                </template>
              </el-table-column>
              <el-table-column prop="acquisitionTime" label="获得时间" width="230" align="center">
                <template slot-scope="scope">
                  <div>{{scope.row.acquisitionTime}}</div>
                </template>
              </el-table-column>
              <el-table-column prop="useTime" label="使用时间" width="230" align="center">
                <template slot-scope="scope">
                  <div>{{scope.row.useTime}}</div>
                </template>
              </el-table-column>
              <el-table-column prop="discountCoupon" label="获得优惠券" width="339" align="center">
                <template slot-scope="scope">
                  <div class="yhqBox">
                    <img :src="scope.row.discountCoupon" width="300" height="100" />
                    <div>
                      <div :style="{'color':(scope.row.useTime==='未使用'?'#03b1d8':'#797979')}">
                        <div>100元</div>
                        <div>满任意金额可用</div>
                      </div>
                      <div>
                        <div>分享优惠券</div>
                        <div>有效期永久</div>
                        <div>适用范围：所有会员</div>
                        <div>{{scope.row.useTime==="未使用"?"立即使用>>":"已使用"}}</div>
                      </div>
                    </div>
                  </div>
                </template>
              </el-table-column>
            </el-table>
          </div>
        </el-tab-pane>
      </el-tabs>
    </div>
  </div>
</template>
<script>
import logginHeader from "@/components/logginHeader";
import { GetInvitationCode } from "@/api/api";
export default {
  data() {
    return {
      activeName: "first",
      title: "邀请方法",
      userLink: "https://manage.siring.com.cn/#/index?isRegister=1&invitationCode=",
      // userLink: "http://localhost:8080/#/index?isRegister=1",
      invitationCode: "",
      // table数据
      tableData: [
        {
          HerID: "11112",
          HerPhone: "12345678978",
          HerImg:require("../../../assets/images/u158.png"),
          acquisitionTime: "2019年06月18日 12:08:45",
          useTime: "未使用",
          discountCoupon:
            require("../../../assets/images/youhuiquan1.png")
        },
        {
          HerID: "11112",
          HerPhone: "12345678978",
          HerImg:require("../../../assets/images/u158.png"),
          acquisitionTime: "2019年06月18日 12:08:45",
          useTime: "2019年06月18日 12:08:45",
          discountCoupon:
            require("../../../assets/images/youhuiquan2.png")
        }
      ]
    };
  },
  mounted() {
    this.InvitationCode();
  },
  components: {
    logginHeader
  },
  methods: {
    // 获取邀请码
    InvitationCode() {
      GetInvitationCode({ user_id: sessionStorage.getItem("user_id") }).then(
        res => {
          let { data, msg, code } = res;
          // this.showMsg(msg,code);
          //  console.log(sessionStorage.getItem("user_id"))
          if (code === 1) {
            this.userLink = this.userLink+ data.invitation 
            this.invitationCode = data.invitation;
          }
        }
      );
    },
    // 链接处写死，复制成功后跳转路由同时传参
    toLink(){
      this.$router.push({
          name: 'index',
          params: {
            id: 123123123
          }
        })
    },
    // 一键复制
    onCopy(e) {
      // 复制成功
      this.$message({
        message: "复制成功！",
        type: "success"
      });
    },
    onError(e) {
      // 复制失败
      this.$message({
        message: "复制失败！",
        type: "error"
      });
    }
  },
  watch: {
    activeName: function(val) {
      //监听切换状态-计划单
      if (val === "first") {
        this.title = "邀请方法";
      } else {
        this.title = "邀请记录";
      }
    }
  }
};
</script>
<style lang="scss" scoped>
.bottomBox {
  font-family: "Arial Negreta", "Arial Normal", "Arial";
  background: #ffffff;
  margin: 5px 0 0 20px;
  padding: 10px;
  min-height: 81vh;
  .smBox {
    margin-bottom: 20px;
    div {
      &:nth-of-type(1) {
        font-weight: 700;
        font-style: normal;
        font-size: 20px;
        color: #ff0000;
        text-align: center;
        padding-bottom: 25px;
      }
      &:nth-of-type(2) {
        text-align: center;
        font-size: 16px;
        color: #5e5e5e;
        padding-bottom: 25px;
      }
      &:nth-of-type(3) {
        text-align: center;
        .el-input {
          width: 709px;
          margin-right: 30px;
        }
        .el-button {
          font-size: 13px;
          width: 102px;
          background: #ff0000;
          color: #ffffff;
        }
      }
      &:nth-of-type(4) {
        font-size: 13px;
        color: #797979;
        text-align: center;
        span {
          color: #ff0000;
          &:nth-of-type(1) {
            font-size: 23px;
          }
          &:nth-of-type(2) {
            font-size: 13px;
          }
        }
      }
    }
  }
  // 邀请记录
  .bottomBoxTab {
    // .el-table_2_column_11{
    div.cell {
      div {
        text-align: center;
        font-size: 12px !important;
      }
      .yhqBox {
        position: relative;
        > div:nth-of-type(1) {
          position: absolute;
          top: 0;
          left: 25px;
          display: flex;
          > div {
            &:nth-of-type(1) {
              margin-right: 20px;
              color: #03b1d8;
              font-size: 12px;
              padding: 30px 0 0;
              > div:nth-of-type(1) {
                font-size: 28px !important;
                font-family: "Arial Negreta", "Arial Normal", "Arial";
                font-weight: 700;
              }
            }
            &:nth-of-type(2) {
              padding: 10px 0 0;
              div {
                height: 18px;
                &:nth-of-type(1) {
                  font-size: 16px !important;
                  color: #5e5e5e;
                  font-weight: 700;
                  font-style: normal;
                  font-family: "Arial Negreta", "Arial Normal", "Arial";
                  height: 23px;
                }
                &:nth-of-type(4){
                  width: 100%;
                  margin: 0 0 0 70px;
                }
              }
            }
          }
        }
      }
    }
    // }
  }
}
</style>
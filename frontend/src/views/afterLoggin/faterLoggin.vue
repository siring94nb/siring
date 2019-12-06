<template>
  <div>
    <!--<myheader />-->
    <!-- 侧边导航栏菜单 -->
    <el-row class="tac">
      <el-col :span="12">
        <el-menu
          default-active="/afterLogginR"
          class="el-menu-vertical-demo"
          @open="handleOpen"
          @close="handleClose"
          background-color="red"
          text-color="#fff"
          :default-openeds="['0','1','2','3','4','5','6','7']"
          router
        >
          <el-submenu :index="index+''" v-for="(item,index) in arr" :key="index+''">
            <!-- 控制中心 -->
            <template slot="title">
              <i class="el-icon-location"></i>
              <span>{{item.title}}</span>
            </template>
            <el-menu-item
              v-for="(con,index1) in item.con"
              :key="index1+''"
              :index="con.rou"
            >{{con.name}}
            </el-menu-item>
          </el-submenu>
        </el-menu>
      </el-col>
    </el-row>
  </div>
</template>

<script>
// import Myheader from "@/components/header";
export default {
  name: "fater-loggin",
  data() {
    return {
      arr: [
        { title: "控制中心", con: [{ name: "控制台", rou: "/afterLogginR" }] },
        {
          title: "会员中心",
          con: [
            // "会员信息", "安全中心", "邀请好友"
            { name: "会员信息", rou: "/memberInformation"},
            { name: "安全中心", rou: "/securityCenterIndex" },
            { name: "邀请好友", rou: "/invitationX" }
          ]
        },
        {
          title: "角色中心",
          con: [
            // "城市合伙人", "等级会员", "分包商"
            { name: "城市合伙人", rou: "/partnerCityX" },
            { name: "等级会员", rou: "/CityPartner" },
            { name: "分包商", rou: "/ceshi" }
          ]
        },
        {
          title: "资金管理",
          con: [
            // "资金明细", "充值", "提现", "银行卡管理", "优惠券"
            { name: "资金明细", rou: "/ceshi" },
            { name: "充值", rou: "/ceshi" },
            { name: "提现", rou: "/ceshi" },
            { name: "银行卡管理", rou: "/ceshi" },
            { name: "优惠券", rou: "/ceshi" }
          ]
        },
        {
          title: "软件/定制",
          con: [
            // "定制需求订单", "定制类似订单"
            { name: "定制需求订单", rou: "/ceshi" },
            { name: "定制类似订单", rou: "/ceshi" }
          ]
        },
        {
          title: "小程序SaaS",
          con: [
            // "SaaS店铺订单", "增值服务订单"
            { name: "SaaS店铺订单", rou: "/ceshi" },
            { name: "增值服务订单", rou: "/ceshi" }
          ]
        },
        {
          title: "AI推广运营",
          con: [
            // "推广订单"
            { name: "推广订单", rou: "/ceshi" }
          ]
        },
        {
          title: "投融介",
          con: [
            // "我的投融", "中止项目"
            { name: "我的投融", rou: "/ceshi" },
            { name: "我的投融", rou: "/ceshi" }
          ]
        }
      ]
    };
  },
  components: {
    // Myheader
  },
  methods: {
    handleOpen(key, keyPath) {
      //   console.log(key, keyPath);
    },
    handleClose(key, keyPath) {
      //   console.log(key, keyPath);
    }
  }
};
</script>

<style lang="scss" scoped>
.tac {
  margin-top: 100px;
  width: 300px;
  height: 82px;
  el-menu-item {
    width: 123px;
  }
  .el-icon-location {
    color: rgba($color: #ffffff, $alpha: 1);
  }
  .el-submenu .el-menu-item {
    min-width: 121px;
    text-align: center;
    background-color: #ffffff !important;
    color: black !important;
  }
  li {
    width: 100%;
    padding: 0 !important;
    box-sizing: border-box;
  }
}
</style>
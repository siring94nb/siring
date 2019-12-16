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
          background-color="#C0D8E7"
          active-background-color="#000000"
          text-color="#fff"
          :default-openeds="[num]"
          router
          active-text-color="#ffd04b"
        >
          <el-submenu :index="index+''" v-for="(item,index) in arr" :key="index+''">
            <!-- 控制中心 -->
            <template slot="title">
              <i :class="item.classN"></i>
              <span>{{item.title}}</span>
            </template>
            <el-menu-item
              v-for="(con,index1) in item.con"
              :key="index1+''"
              :index="con.rou"
            >{{con.name}}</el-menu-item>
          </el-submenu>
        </el-menu>
      </el-col>
    </el-row>
  </div>
</template>

<script>
// import Myheader from "@/components/header";
export default {
  // name: "fater-loggin",
  data() {
    return {
      num: '0',
      cityHehuoren: 1,
      classHuiyuan: 1,
      fenbaoshang: 1,
      tixian: 1,
      arr: [
        {
          title: "控制中心",
          classN: "el-icon-s-platform",
          con: [{ name: "控制台", rou: "/afterLogginR" }]
        },
        {
          title: "会员中心",
          classN: "el-icon-user-solid",
          con: [
            // "会员信息", "安全中心", "邀请好友"
            { name: "会员信息", rou: "/memberInformation" },
            { name: "安全中心", rou: "/securityCenterIndex" },
            { name: "邀请好友", rou: "/invitationX" }
          ]
        },
        {
          title: "角色中心",
          classN: "el-icon-postcard",
          con: [
            // "城市合伙人", "等级会员", "分包商"
            { name: "城市合伙人", rou: "/partnerCityX" },
            { name: "等级会员", rou: "/ClassMembersX" },
            { name: "分包商", rou: "/subContractorIndex" }
          ]
        },
        {
          title: "资金管理",
          classN: "el-icon-s-finance",
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
          classN: "el-icon-edit-outline",
          con: [
            // "定制需求订单", "定制类似订单"
            { name: "定制需求订单", rou: "/demand_order" },
            { name: "定制类似订单", rou: "/ceshi" }
          ]
        },
        {
          title: "小程序SaaS",
          classN: "el-icon-magic-stick",
          con: [
            // "SaaS店铺订单", "增值服务订单"
            { name: "SaaS店铺订单", rou: "/ceshi" },
            { name: "增值服务订单", rou: "/ceshi" }
          ]
        },
        {
          title: "AI推广运营",
          classN: "el-icon-s-promotion",
          con: [
            // "推广订单"
            { name: "推广订单", rou: "/ceshi" }
          ]
        },
        {
          title: "投融介",
          classN: "el-icon-bank-card",
          con: [
            // "我的投融", "中止项目"
            { name: "我的投融", rou: "/ceshi" },
            { name: "我的投融", rou: "/ceshi" }
          ]
        }
      ],
      routerValue: this.$route.path
    };
  },
  components: {},
  mounted() {
    this.cityHehuorenX(),
      this.classHuiyuanX(),
      this.fenbaoshangX(),
      this.withdrawX();
      this.zhankai();
  },
  methods: {
    // 保持侧边栏对应路由展开状态
    zhankai() {
      let arr = this.arr;
      let val= this.$route.path
      for (var i = 0; i < arr.length; i++) {
        for (var j = 0; j < arr[i].con.length; j++) {
          if (arr[i].con[j].rou == val) {
            this.num=String(i);
            // console.log(String(i))
          }
        }
      }
      return -1;
    },
    // 城市合伙人
    cityHehuorenX() {
      if (this.cityHehuoren === 0) {
        this.arr[2].con[0].rou = "/partnerCityX";
      } else {
        this.arr[2].con[0].rou = "/CityPartner";
      }
    },
    // 等级会员
    classHuiyuanX() {
      if (this.classHuiyuan === 0) {
        this.arr[2].con[1].rou = "/ClassMembersX";
      } else {
        this.arr[2].con[1].rou = "/ClassMembersA";
      }
    },
    // 分包商
    fenbaoshangX() {
      if (this.fenbaoshang === 0) {
        this.arr[2].con[2].rou = "/subContractorIndex";
      } else {
        this.arr[2].con[2].rou = "/subContractorSm1";
      }
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
  i {
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
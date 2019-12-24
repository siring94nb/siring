<template>
<div style="display:flex">
  <div class="dingDanBox">
    <el-row>
      <el-col :span="20">{{daifukuanDD[0].name}}</el-col>
      <el-col :span="4">
        (
        <span>{{daifukuanDD[0].biaozhi}}</span>)
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="6" v-for="(item,index) in daifukuanDD" :key="index"><div v-if="index>0">{{item.name}}(<span>{{item.biaozhi}}</span>)</div></el-col>
    </el-row>
  </div>
   <div class="dingDanBox">
    <el-row>
      <el-col :span="20">{{daichuliDD[0].name}}</el-col>
      <el-col :span="4">
        (
        <span>{{daichuliDD[0].biaozhi}}</span>)
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="6" v-for="(item,index) in daichuliDD" :key="index"><div v-if="index>0">{{item.name}}(<span>{{item.biaozhi}}</span>)</div></el-col>
    </el-row>
  </div>
   <div class="dingDanBox">
    <el-row>
      <el-col :span="20">{{houxufuwuDD[0].name}}</el-col>
      <el-col :span="4">
        (
        <span>{{houxufuwuDD[0].biaozhi}}</span>)
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="6" v-for="(item,index) in houxufuwuDD" :key="index"><div v-if="index>0">{{item.name}}(<span>{{item.biaozhi}}</span>)</div></el-col>
    </el-row>
  </div>
</div>
  
</template>
<script>
import { PendingPayment,PendingDisposal,AfterService } from "@/api/api";
export default {
  name: "dingDan",
  data() {
    return {
      daifukuanDD:[
        {
          "name":"待付款订单",
          "biaozhi":"total"
        },
        {
          "name":"定制",
          "biaozhi":"total_customized"
        },
        {
          "name":"投融",
          "biaozhi":"total_investment"
        },
        {
          "name":"AI推广",
          "biaozhi":"total_promotion"
        },
        {
          "name":"小程序",
          "biaozhi":"total_xcx"
        },
      ],
      daichuliDD:[
        {
          "name":"待处理订单",
          "biaozhi":"total"
        },
        {
          "name":"定制",
          "biaozhi":"total_customized"
        },
        {
          "name":"投融",
          "biaozhi":"total_investment"
        },
        {
          "name":"AI推广",
          "biaozhi":"total_promotion"
        },
        {
          "name":"小程序",
          "biaozhi":"total_xcx"
        },
      ],
      houxufuwuDD:[
        {
          "name":"待处理后续订单",
          "biaozhi":"total"
        },
        {
          "name":"定制",
          "biaozhi":"total_customized"
        },
        {
          "name":"投融",
          "biaozhi":"total_investment"
        },
        {
          "name":"AI推广",
          "biaozhi":"total_promotion"
        },
        {
          "name":"小程序",
          "biaozhi":"total_xcx"
        },
      ]
    };
  },
  mounted() {
    this.getPendingPayment();
  },
  methods: {
    getPendingPayment(){
      const userId = sessionStorage.getItem("user_id");
      const params = {
        user_id: userId
      };
      PendingPayment(params).then(res => {
        let { data, msg, code } = res;
        // this.showMsg(msg,code);
        if (code === 1) {
          const newArr = this.daifukuanDD.map(item => {
            item.biaozhi = data[item.biaozhi];
            return item;
          });
          this.daifukuanDD = newArr;
        }
      });
      PendingDisposal(params).then(res => {
        let { data, msg, code } = res;
        // this.showMsg(msg,code);
        if (code === 1) {
          const newArr = this.daichuliDD.map(item => {
            item.biaozhi = data[item.biaozhi];
            return item;
          });
          this.daichuliDD = newArr;
        }
      });
      AfterService(params).then(res => {
        let { data, msg, code } = res;
        // this.showMsg(msg,code);
        if (code === 1) {
          const newArr = this.houxufuwuDD.map(item => {
            item.biaozhi = data[item.biaozhi];
            return item;
          });
          this.houxufuwuDD = newArr;
        }
      })
    }
  }
};
</script>
<style lang="scss" scoped>
.dingDanBox {
  font-size: 13px !important;
  font-family: "微软雅黑";
  margin: 0 30px;
  width: 295px;
  .el-row:nth-of-type(1) {
    border-bottom: 1px solid rgb(242, 242, 242);
    padding: 10px 0;
    margin-bottom: 10px;
  }
  .el-col span {
    color: red;
  }
}
</style>
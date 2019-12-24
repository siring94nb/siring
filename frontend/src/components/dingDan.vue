<template>
  <div class="dingDanBox">
    <el-row>
      <el-col :span="20">{{dfk[0].name}}</el-col>
      <el-col :span="4">
        (
        <span>{{dfk[0].num}}</span>)
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="6" v-for="(item,index) in dfk" :key="index"><div>{{item.name}}(<span>{{item.num}}</span>)</div></el-col>
      <!-- <el-col :span="6">
        <div>
          定制(
          <span>0</span>)
        </div>
      </el-col>
      <el-col :span="6">
        <div>
          小程序(
          <span>0</span>)
        </div>
      </el-col>
      <el-col :span="6">
        <div>
          AI推广(
          <span>0</span>)
        </div>
      </el-col>
      <el-col :span="6">
        <div>
          投融(
          <span>0</span>)
        </div>
      </el-col> -->
    </el-row>
  </div>
</template>
<script>
import { PendingPayment } from "@/api/api";
export default {
  name: "dingDan",
  data() {
    return {
      dfk:[
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
          const newArr = this.dfk.map(item => {
            console.log(data["total"]);
            item.biaozhi = data[item.biaozhi];
            return item;
          });
          this.dfk = newArr;
          // console.log(this.dfk)
        }
      });
    }
  }
};
</script>
<style lang="scss" scoped>
.dingDanBox {
  font-size: 13px !important;
  font-family: "微软雅黑";
  padding: 0 20px 30px 30px !important;
  margin: 0 30px;
  .el-row:nth-of-type(1) {
    border-bottom: 1px solid rgb(242, 242, 242);
    padding: 10px 0;
    margin-bottom: 10px;
  }
  .el-col {
    padding-left: 20px;
  }
  .el-col span {
    color: red;
  }
}
</style>
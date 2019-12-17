<template>
  <div class="dingDanBox">
    <el-row>
      <el-col :span="20">{{ceshi}}</el-col>
      <el-col :span="4">
        (
        <span>0</span>)
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="6" v-for="(item,index) in ceShiArr" :key="index"><div>定制(<span>0</span>)</div></el-col>
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
export default {
  name: "dingDan",
  data() {
    return {
      ceShiArr: [1, 2, 3, 4]
    };
  },
  props: {
    ceshi: {
      type: String,
      default: "待付款订单"
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
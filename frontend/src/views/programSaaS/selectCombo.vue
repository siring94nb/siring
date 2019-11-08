<template>
  <div class="index">
    <myheader />
    <div class="steps">
      <el-steps :active="2" align-center>
        <el-step title="选择行业模板"></el-step>
        <el-step title="选择套餐"></el-step>
      </el-steps>
    </div>
    <div class="line"></div>
    <div>
        <img src="" alt="">
        <span>温馨提示：您可以选择年套餐更实惠，您还可以选择月套餐逐步熟练和熟悉后再用年套餐！</span>
    </div>
    <div>
        <div>
            <div>标准年套餐</div>
            <div>适合小微团队开店、个人或三个人以下运营的团队开店，满足本行业内的基础经营需求</div>
        </div>
        <div>￥3888/年</div>
        <div>
            
        </div>
    </div>
  </div>
</template>

<script>
import Myheader from "@/components/header";
import { GetTemplate } from "@/api/api";
import config from "../../../../web/build/config";

export default {
  name: "selectCombo",
  components: {
    Myheader
  },
  data() {
    return {};
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {}
  }
};
</script>

<style lang="scss" scoped>
.index {
  margin: auto;
  margin-top: 100px;
  width: 1200px;
  .steps {
    width: 500px;
    margin: auto;
  }
  .line{
      width: 1100px;
      margin: 10px auto;
      height: 2px;
      background-color: rgb(26,188,156);
  }
}
</style>
<template>
  <div class="jdyh">
    <h2 class="title">经典用户</h2>
    <div class="swiper-box">
      <el-carousel height="125px" indicator-position="none" arrow="never">
        <el-carousel-item v-for="(item, index) in imgs" :key="index">
          <img :src="item" alt />
        </el-carousel-item>
      </el-carousel>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      imgs: [
        require("@/assets/images/user1.png"),
        require("@/assets/images/user2.png"),
        require("@/assets/images/user3.png"),
        require("@/assets/images/user4.png")
      ]
    };
  }
};
</script>

<style scoped lang='scss'>
.swiper-box{
  width: 1200px;
  margin: 0 auto;
  text-align: center;
}
</style>
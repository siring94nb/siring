<template>
  <div class="recomment-left">
    <div class="quick-desc">
      <div class="desc-title">
        <i class="iconfont icon-jisuanqi"></i>
        <span>快捷估价</span>
      </div>
      <div class="desc-dit">很多朋友对开发费用多少没有大致概念，往往被不良开发商所蒙蔽，在这里我们为您提供便捷的快捷估价服务，让您放心开发！</div>
    </div>
    <div class="recomment-cont">
      <div class="recomment-title">
        <i class="iconfont icon-hua"></i>
        <span>定制案例欣赏</span>
      </div>
      <div class="recomment-list">
        <div class="recomment-item" v-for="item in 6" :key="item">
          <el-image style="width: 160px; height: 160px" :src="require('@/assets/images/u2337.png')"></el-image>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style scoped lang='scss'>
.recomment-left {
  float: left;
  width: 225px;
  .quick-desc {
    height: 220px;
    background: url("~@/assets/images/u2173.png") no-repeat;
    background-size: 100% 100%;
    padding: 15px 0 0 15px;
    box-sizing: border-box;
    .desc-title {
      .icon-jisuanqi {
        font-size: 36px;
        color: #666666;
        vertical-align: middle;
      }
      span {
        font-size: 20px;
        color: #333333;
        font-weight: bold;
        vertical-align: middle;
      }
    }
    .desc-dit {
      font-size: 14px;
      color: #6b6b6b;
      line-height: 2;
      width: 80%;
    }
  }
  .recomment-cont {
    background-color: #ffffff;
    padding-top: 15px;
    width: 205px;
    .recomment-title {
      width: 90%;
      margin: 0 auto 15px;
      background-color: rgb(246, 246, 246);
      height: 34px;
      line-height: 34px;
      box-sizing: border-box;
      .icon-hua {
        font-size: 24px;
        color: rgb(216, 30, 6);
        vertical-align: middle;
        margin: 0 10px 0 15px;
      }
      span {
        vertical-align: middle;
        font-size: 14px;
      }
    }
    .recomment-list {
      margin: 0 auto;
      height: 520px;
      overflow-y: auto;
      &::-webkit-scrollbar {
        width: 0;
      }
      .recomment-item {
        width: 160px;
        margin: 0 auto 15px;
      }
    }
  }
}
</style>
<template>
  <div class="container">
    <div class="name">快捷入口</div>
    <div class="item">
      <div class="circle">
        <img :src="require('@/assets/images/u4685.png')" alt />
      </div>
      <router-link to="/city">合伙人</router-link>
    </div>
    <div class="item">
      <div class="circle">
        <img :src="require('@/assets/images/u4679.png')" alt />
      </div>
      <router-link to="/member">等级会员</router-link>
    </div>
    <div class="item">
      <div class="circle">
        <img :src="require('@/assets/images/u4692.png')" alt />
      </div>
      <router-link to="/contractor">分包商</router-link>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style scoped lang='scss'>
.container {
  position: fixed;
  right: 0;
  top: 50%;
  transform: translateY(-50%);
  z-index: 999;
  .name {
    width: 36px;
    height: 36px;
    background-color: #000000;
    color: #ffffff;
    font-size: 14px;
    line-height: 16px;
    text-align: center;
    display: table-cell;
    vertical-align: middle;
    font-weight: 300;
  }
  .item {
    width: 36px;
    height: 110px;
    border-top: 1px solid #ffffff;
    background-color: rgb(86, 174, 244);
    cursor: pointer;
    .circle {
      background-color: transparent;
      border: 1px solid #ffffff;
      width: 25px;
      height: 25px;
      border-radius: 50%;
      margin: 5px auto;
      line-height: 28px;
      text-align: center;
      box-sizing: border-box;
      img {
        width: 16px;
        height: 16px;
      }
    }
    a {
      display: block;
      color: #ffffff;
      width: 20px;
      margin: 0 auto;
      text-align: center;
    }
  }
}
</style>
<template>
  <div>
     <logginHeader>
        <i class="iconfont icon-SaaS"></i>
        <span>小程序SaaS</span>
        <span>&gt;</span>
        <span>小程序管理</span>
      </logginHeader>
    <div class="box">
      <div class="zhanshi">
        <img src="../../../assets/images/zaox.png"/>
        <div>
          <div>此功能暂未开放，敬请期待......</div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import logginHeader from "@/components/logginHeader";
export default {
  components: {
    logginHeader
  }
};
</script>
<style lang="scss" scoped>
.box{
  background: #ffffff;
  margin: 10px 0 0 20px;
  .zhanshi{
      display: flex;
      padding: 300px 440px;
      >div:nth-of-type(1){
        box-sizing: border-box;
        padding-top: 100px;
        >div:nth-of-type(1){
          margin-bottom: 20px;
          font-size: 14px;
          color: #333333;
        }
        .button{
          display: block;
          border: 1px solid rgba(201, 0, 0, 1);
          background: #ffffff;
          color: rgba(201, 0, 0, 1);
          width: 197px;
          height: 35px;
          border-radius: 3px;
          text-align: center;
          padding: 10px 0;
          box-sizing: border-box;
        }
      }
  }
}
</style>
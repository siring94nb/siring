<template>
  <div>
    <logginHeader>
      <i class="iconfont icon-jiaose"></i>
      <span>角色中心</span>
      <span>&gt;</span>
      <span>等级会员</span>
    </logginHeader>
    <div class="box">
      <div class="zhanshi">
        <img src="../../../assets/images/zaox.png"/>
        <div>
          <div>亲，您暂时还是普通会员，赶紧去升级会员等级吧！</div>
          <div><router-link to="member" class="button"> 升级等级会员</router-link></div>
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
      padding: 300px  280px;
      >div:nth-of-type(1){
        box-sizing: border-box;
        padding-top: 50px;
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
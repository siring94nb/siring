<template>
  <div class="sjhy">
    <h2 class="title">角色加盟</h2>
    <div class="sjhy-cont">
      <!-- <img :src="require('@/assets/images/u327.png')" width="1200" alt /> -->
      <!-- <img :src="require('@/assets/images/u266.png')" width="1200" alt /> -->
      <div class="imgBox">
        <img :src="require('@/assets/images/u395.png')" width="128" alt />
        <span>
          <span>我要成为城市合伙人</span>
          <span>等级城市代理享有城市利润分红的权益</span>
        </span>
        <span>
          <!-- <img :src="require('@/assets/images/u275.png')" width="100" alt />
          <img :src="require('@/assets/images/u276.png')" width="85" alt /> -->
          <router-link to="city"> GO</router-link>
        </span>
        
      </div>
      <router-link to="/city" class="tocity"></router-link>
      <div class="upgrade-apply">
        <div class="upgrade-inner-box">
          <div>
            <img :src="require('@/assets/images/u189.png')" width="44px" height="56px" />
            <span>等级会员——不同等级会员享有的购买折扣不相同，同时还能通过分享获得收益</span>
            <router-link to="/member">&gt;&gt;立即申请</router-link>
          </div>
          <div>
            <img :src="require('@/assets/images/u188.png')" width="44px" height="56px" />
            <span>分包商——愿意挑战的您，获得平台分配的部分任务获得佣金，可以是个人也可以是企业哟</span>
            <router-link to="/contractor">&gt;&gt;立即申请</router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style scoped lang='scss'>
.title{
  background: #ffffff;
  width: 100%;
  padding-bottom: 30px;
}
.sjhy-cont {
  position: relative;
  width: 1200px;
  margin: 0 auto;
  .tocity{
    position: absolute;
    top: 20px;
    right: 110px;
    width: 90px;
    height: 90px;
    border-radius: 50%;
  }
  .upgrade-apply {
    position: relative;
    // border: 1px solid #3bafda;
    border-top: 0;
    // border-bottom-left-radius: 5px;
    // border-bottom-right-radius: 5px;
    margin-top: -4px;
    padding-top: 20px;
    .upgrade-inner-box {
      width: 90%;
      margin: 0 auto;
      border-top: 1px solid #3bafda;
      div {
        height: 80px;
        line-height: 80px;
        margin-left: 50px;
        font-size: 18px;
        color: #3bafda;
        img {
          vertical-align: middle;
          margin-right: 100px;
        }
        a{
          float: right;
          margin-right: 20px;
          color: #ff0000;
        }
      }
    }
  }
}
.imgBox{
  padding: 0 70px;
  display: flex;
  justify-content: space-between;
  >span{
    &:nth-of-type(1){
      text-align: center;
      color: #ffffff;
      >span{
        &:nth-of-type(1){
          font-size: 40px;
          font-weight: 700;
          display: block;
          padding: 30px 0 10px 0;
        }
        &:nth-of-type(2){
          font-size: 24px;
          font-weight: 700;
        }
      }
    }
    &:nth-of-type(2){ 
      padding-top: 50px;
      a{
        color: #ffffff;
        font-size: 45px;
        font-weight: 700;
      }
    }
    
   
    // img{
    //   &:nth-of-type(1){
    //     margin-top: 25px;
    //   }
    //  &:nth-of-type(2){
    //    position: relative;
    //    z-index: 5;
    //    margin-left: -92px;
    //  }
    // }
  }
}
</style>
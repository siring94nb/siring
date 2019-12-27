<template>
  <div class="bigBox">
    <div class="smBox">
      <div><i class="iconfont icon--zijinguanli"></i></div>
      <div>温馨提示：</div>
      <div>为了您的资金安全您需要设施资金密码</div>
      <div>
        <button>返回</button>
        <button><router-link :to="{path:'/safetyTabControl',query:{canshu:'third',title:'信息修改'}}">确定</router-link></button>
      </div>
    </div>
  </div>
</template>
<style lang="scss" scoped>
.bigBox{
  position: absolute;
  left: 0;
  width: 100%;
  z-index: 555;
  padding:10px;
  background: rgba(92,92,92,0.4);
  height: 100vh;
  .smBox{
    background: #ffffff;
    width: 695px;
    height: 395px;
    position: absolute;
    top: 50%;
    left: 50%;
    margin-left: -347px;
    margin-top: -320px;
    div{
      text-align: center;
      &:nth-of-type(1){
        display: flex;
        justify-content: flex-end;
        margin-bottom: 20px;
        i{
          font-size: 32px;
          color: rgb(178, 178, 178)
        }
      }
      &:nth-of-type(2){
        font-size: 28px;
        color: #363636;
        margin-bottom: 80px;
      }
      &:nth-of-type(3){
        font-size: 20px;
        color: #666666;
        margin-bottom: 100px;
      }
      &:nth-of-type(4){
        button{
          padding: 15px 70px;
          border-radius: 5px;
          border: 1px solid #ffffff;
          color: #ffffff;
          outline: none;
          &:nth-of-type(1){
            background: #c9c9c9;
            margin-right: 80px;
          }
          &:nth-of-type(2){
            background: #e62d31;
            a{
              color: #ffffff;
            }
          }
        }
      }
    }
  }
}
</style>
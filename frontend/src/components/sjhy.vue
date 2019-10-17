<template>
  <div class="sjhy">
    <h2 class="title">升级会员</h2>
    <div class="sjhy-cont">
      <img :src="require('@/assets/images/u327.png')" width="1200" alt />
      <div class="upgrade-apply">
        <div class="upgrade-inner-box">
          <div>
            <img :src="require('@/assets/images/u188.png')" width="48px" height="44px" />
            <span>提供专业的1对1技术咨询，结合强大的系统保障能力，帮助会员在垂直市场获得领先优势</span>
          </div>
          <div>
            <img :src="require('@/assets/images/u189.png')" width="48px" height="44px" />
            <span>强大的平台系统，所有项目进度均实现可视化流程，保障代理及用户切身利益。</span>
          </div>
        </div>
        <a href="javascript:void(0);">&gt;&gt;立即申请</a>
      </div>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style scoped lang='scss'>
.sjhy-cont {
  width: 1200px;
  margin: 0 auto;
  .upgrade-apply {
    position: relative;
    border: 1px solid #3bafda;
    border-top: 0;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
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
      }
    }
    a {
      position: absolute;
      right: 100px;
      bottom: 28px;
      color: #f00;
      font-size: 18px;
    }
  }
}
</style>
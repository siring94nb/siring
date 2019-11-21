<template>
  <div class="index">
    <div class="line">基础信息</div>
    <div class="main-top">
      <table>
        <tr>
          <td class="td-one">用户账号：</td>
          <td>139228300809</td>
          <td class="td-one">订单号：</td>
          <td>2018062803890</td>
        </tr>
        <tr>
          <td class="td-one">商品名称：</td>
          <td>139228300809</td>
          <td class="td-one">订单类型</td>
          <td>2018062803890</td>
        </tr>
        <tr>
          <td class="td-one">下单时间：</td>
          <td>139228300809</td>
          <td class="td-one">订单金额：</td>
          <td>2018062803890</td>
        </tr>
        <tr>
          <td class="td-one">终端版本：</td>
          <td>139228300809</td>
          <td class="td-one">合同金额：</td>
          <td>2018062803890</td>
        </tr>
        <tr>
          <td class="td-one">项目剩余金额</td>
          <td>139228300809</td>
          <td class="td-one">项目剩余时间</td>
          <td>2018062803890</td>
        </tr>
      </table>
    </div>
    <div class="line">内容回复</div>
    <div class="content-reply">
      <div class="content-main">
        <div class="content-title">定制需求</div>
        <div class="content-tips">
          <img src="../../images/u3829.png" style="width:100%;height:100%;" alt />
          <div class="content-text">等待需求确认</div>
        </div>
        <div style="width:40px;height:40px;margin:auto;">
          <img src="../../images/u3830.png" style="width:100%;height:100%;" alt />
        </div>
      </div>
      <div class="all-line g-line"></div>
      <div class="all-line h-line"></div>
      <div class="content-main">
        <div class="content-title">平台报价</div>
      </div>
      <div class="all-line h-line line-w"></div>
      <div class="content-main">
        <div class="content-title">签订合同</div>
      </div>
      <div class="all-line h-line line-w"></div>
      <div class="content-main">
        <div class="content-title">原型/UI确认</div>
      </div>
      <div class="all-line h-line line-w"></div>
      <div class="content-main">
        <div class="content-title">项目上线</div>
      </div>
      <div class="all-line h-line line-w"></div>
      <div class="content-main">
        <div class="content-title">项目验收</div>
      </div>
      <div class="all-line h-line line-w"></div>
      <div class="content-main">
        <div class="content-title">项目年服务</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },
  created() {
    this.init();
  },
  methods: {
    init() {
      console.log(this.$route.params.status);
    }
  }
};
</script>

<style lang="less" scoped>
.index {
  width: 100%;
  background-color: #fff;
  padding: 10px 20px;
  font-style: normal;
  .line {
    background-color: rgb(242, 242, 242);
    font-weight: 700;
    margin-top: 20px;
    font-size: 16px;
    color: #000000;
  }
  .main-top {
    table {
      width: 100%;
    }
    table,
    td {
      border: 1px solid rgb(242, 242, 242);
      border-collapse: collapse;
      border-spacing: 0;
      text-align: center;
      line-height: 28px;
    }
    .td-one {
      width: 20%;
      font-weight: 700;
      font-size: 12px;
    }
  }
  .content-reply {
    display: flex;
    justify-content : center;
    margin-top: 30px;
    .content-main {
      text-align: center;
      width: 122px;
      .content-title {
        width: 122px;
        height: 33px;
        line-height: 33px;
        background: inherit;
        background-color: rgba(161, 161, 161, 1);
        border: none;
        border-radius: 63px;
        font-weight: 700;
        font-style: normal;
        font-size: 16px;
        color: #ffffff;
        text-align: center;
      }
      .content-tips {
        width: 125px;
        height: 85px;
        position: relative;
        .content-text {
          position: absolute;
          color: red;
          top: 35px;
          left: 15px;
          font-size: 16px;
        }
      }
    }
    .all-line {
      height: 3px;
      width: 18px;
      margin-top: 15px;
    }
    .g-line {
      background-color: rgb(102, 153, 0);
    }
    .h-line {
      background-color: rgb(161, 161, 161);
    }
    .line-w {
      width: 36px;
    }
  }
}
</style>
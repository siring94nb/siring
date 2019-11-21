<template>
  <div class="index">
    <div class="line">
      基础信息
    </div>
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
    <div class="line">
      内容回复
    </div>
    <div class="content-reply">

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
  .main-top{
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
  .content-reply{
      
  }
}
</style>
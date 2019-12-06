<template>
  <div class="gnmkBox">
    <div style="background: rgb(242,247,250);padding:5px">
      <div class="gnmkSmBox1">
        <span>
          <slot></slot>
        </span>
        <el-date-picker v-if="pd" v-model="yearValue" type="year" placeholder="2019"></el-date-picker>
      </div>
      <div class="gnmkSmBox2">
        <el-row>
          <el-col :span="6" v-for="(item,index) in SumIndent" :key="index">
            <img
              :src="require('../assets/images/'+item+'.png')"
            />
            <div>
              <div>
                <span></span>
              </div>
              <div>0</div>
              <div v-if="index==3">点击推广</div>
            </div>
          </el-col>
        </el-row>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "gnmk",
  data() {
    return {
      yearValue: "",
    };
  },
  props: ['pd',"tuiguang","SumIndent"],
};
</script>
<style lang="scss" scoped>
.gnmkBox {
  width: 100%;
  background: #ffffff;
  padding: 10px 20px;
  margin-top: 5px;
  box-sizing: border-box;
  font-family: "微软雅黑 Bold", "微软雅黑 Regular", "微软雅黑";
  .gnmkSmBox1 {
    padding: 10px 15px;
    font-weight: 700;
    font-style: normal;
    color: #000000;
    text-align: left;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .gnmkSmBox2 {
    background: rgb(242, 247, 250);
    // background: #ffffff;
    .el-row {
      background: rgb(242, 247, 250);
      height: 150px;
    }
    .el-col {
      background: #ffffff;
      // margin:0 5px;
      box-sizing: border-box;
      display: flex;
      padding: 20px 10px;
      border-right: 5px solid rgb(242, 247, 250);
      img {
        margin-right: 20px;
      }
      div {
        font-size: 16px;
        color: #999999;
        div:nth-of-type(2) {
          font-size: 20px;
          color: #666666;
        }
        div:nth-of-type(3) {
          margin-top: 10px;
          color: #ff0000;
        }
      }
      div:first-child {
        padding: 20px 0;
        box-sizing: border-box;
      }
    }
    .el-col:nth-of-type(2n) {
      margin: 0;
    }
  }
}
</style>
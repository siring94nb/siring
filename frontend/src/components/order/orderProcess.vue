<template>
  <div class="content-reply">
    <template v-for="(item,index) in statusData">
      <div class="content-main" :key="index">
        <div class="content-title" :class="{'content-sel-color': status - 1 > index}">{{item.name}}</div>
        <div v-if="status - 1 == index">
          <div class="content-tips">
            <img src="../../assets/images/u3829.png" style="width:100%;height:100%;" alt />
            <div class="content-text">{{item.tips}}</div>
          </div>
          <div class="content-arrow">
            <img src="../../assets/images/u3830.png" style="width:100%;height:100%;" alt />
          </div>
        </div>
        <div class="content-zip" v-if="status - 1 > index">
          <div class="zip-main">
            <span class="zip-text">预览</span>
            <img style="vertical-align: middle;" src="../../assets/images/u587.gif" alt />
            <span class="zip-text">下载</span>
            <div>**需求表.zip</div>
          </div>
          <i></i>
        </div>
      </div>
      <div
        class="all-line"
        :key="'l'+index"
        :class="{'h-line': status - 1 < index + 2, 'g-line' :  status - 1 > index}"
        v-if="index < statusData.length-1"
      ></div>
      <div
        class="all-line"
        :key="'s'+index"
        :class="{'h-line': status - 1 < index + 2, 'g-line' : status - 1 > index + 1}"
        v-if="index < statusData.length-1"
      ></div>
    </template>
  </div>
</template>

<script>
export default {
    name:"orderProcess",
  props: ["statusData", "status"],
  data() {
    return {};
  },
  computed: {},
  methods: {}
};
</script>

<style scoped lang='scss'>
 //流程
  .content-reply {
    display: flex;
    justify-content: center;
    // margin-top: 30px;
    margin-top: 15px;
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
      .content-sel-color {
        background-color: rgb(102, 153, 0);
      }
      .content-zip {
        box-sizing: border-box;
        position: relative;
        display: table-cell;
        padding-top: 10px;
        min-height: 60px;
        .zip-main {
          background-color: rgb(242, 242, 242);
          width: 122px;
          height: 75px;
          border-radius: 5px;
          background-color: rgb(242, 242, 242);
          padding-top: 15px;
          box-sizing: border-box;
          .zip-text {
            color: rgb(0, 51, 102);
            line-height: 16px;
          }
        }
      }
      .content-zip i {
        width: 0;
        height: 0;
        border-left: 12px solid transparent;
        border-right: 12px solid transparent;
        position: absolute;
        top: 0;
        border-bottom: 10px solid rgb(242, 242, 242);
        left: 45%;
      }
      .content-tips {
        width: 125px;
        height: 85px;
        position: relative;
        .content-text {
          position: absolute;
          color: red;
          top: 32px;
          // left: 15px;
          text-align: center;
          width: 125px;
          font-size: 16px;
        }
      }
      .content-arrow {
        width: 40px;
        height: 40px;
        margin: auto;
      }
    }
    .all-line {
      height: 3px;
      // width: 18px;
      width: 50px;
      margin-top: 15px;
    }
    .g-line {
      background-color: rgb(102, 153, 0) !important;
    }
    .h-line {
      background-color: rgb(161, 161, 161);
    }
    .line-w {
      width: 36px;
    }
  }
</style>
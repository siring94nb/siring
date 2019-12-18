<template>
  <div ref="box">
    <Myheader />
    <div class="afLogginBox clearfix">
      <div class="left" ref="leftBox">
        <faterLoggin />
      </div>
      <div class="right" ref="rightBox">
        <router-view class="view"></router-view>
        <afterLogginR v-if="rName=='afterLoggin'" />
      </div>
    </div>
  </div>
</template>
<script>
import Myheader from "@/components/header";
import faterLoggin from "@/views/afterLoggin/faterLoggin";
import afterLogginR from "@/views/afterLoggin/afterLogginR";
export default {
  data() {
    return {
      rName: ""
    };
  },
  components: {
    Myheader,
    faterLoggin,
    afterLogginR
  },
  mounted() {
    const that = this;
    that.changeSize();
    window.onresize = () => {
      that.changeSize();
    };
  },
  watch: {
    $route: {
      handler: function(route) {
        this.rName = route.name;
        // console.log(this.$refs.rightBox.clientWidth);
        // console.log(this.rName)
      },
      immediate: true
    }
  },
  methods: {
    changeSize() {
      return (() => {
        let screenWidth = document.body.clientWidth;
        let leftBox = this.$refs.leftBox;
        let rightBox = this.$refs.rightBox;
        // console.log(this.$route.path)
        // if(this.$route.path === "/demand_order"){
        //     rightBox.style.maxWidth = "1340px"
        //     console.log(this.$route.path)
        //     console.log( rightBox.style.maxWidth)
        // }else{
        //   console.log(this.$route.path)
        //     rightBox.style.maxWidth = "1100px"
        // }
        if (screenWidth > 1260) {
          leftBox.style.marginLeft =
            (screenWidth - (leftBox.clientWidth + rightBox.clientWidth)) / 2 -
            20 +
            "px";
          rightBox.style.marginLeft =
            (screenWidth - (leftBox.clientWidth + rightBox.clientWidth)) / 2 +
            leftBox.clientWidth +
            "px";
        } else {
          leftBox.style.marginLeft = "0px";
          rightBox.style.marginLeft = leftBox.clientWidth + "px";
        }
      })();
    }
  }
};
</script>
<style lang="scss" scoped>
.afLogginBox {
  min-height: 98.5vh;
  background: rgb(242, 247, 250);
  padding: 5px 10px;
  border-top: 2px solid #ffffff;
  // max-width: 1260px;
  min-width: 1500px;
  .left {
    width: 123px;
    float: left;
  }
  .right {
    margin-left: 150px;
    // padding-left: 10px;
    margin-top: 100px;
    max-width: 1100px;
  }
  // 伪元素清除浮动
  .clearfix:after {
    /*伪元素是行内元素 正常浏览器清除浮动方法*/
    content: "";
    display: block;
    height: 0;
    clear: both;
    visibility: hidden;
  }
  .clearfix {
    *zoom: 1; /*ie6清除浮动的方式 *号只有IE6-IE7执行，其他浏览器不执行*/
  }
}
</style>
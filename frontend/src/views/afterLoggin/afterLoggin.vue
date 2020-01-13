<template>
  <div ref="box">
    <Myheader />
    <div class="afLogginBox clearfix">
      <div class="left" ref="leftBox">
        <faterLoggin ref="faterLoggin"/>
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
    // const that = this;
    this.init()
    window.onresize = () => {
      this.changeSize();
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
    init(){
      this.changeSize();
    },
    changeSize() {
      console.log(12123)
      // 触发子组件方法，屏幕大小改变同时，改变侧边栏高度
      this.$refs.faterLoggin.chaxun()
      // setInterval(() => {
      let screenWidth = document.body.clientWidth;
      let leftBox = this.$refs.leftBox;
      let rightBox = this.$refs.rightBox;
      return (() => {
        if (screenWidth > 1500) {
          rightBox.style.marginLeft =
            (screenWidth - (leftBox.clientWidth + rightBox.clientWidth)) / 2 -10 +
            leftBox.clientWidth +
            "px";
            document.body.style.width = "100%";
            // console.log( rightBox.style.marginLeft,11111)
        } else {
          // leftBox.style.marginLeft = "0px";
          // console.log(1111)
          rightBox.style.marginLeft = leftBox.clientWidth+ 20  + "px";
          document.body.style.width = leftBox.clientWidth + rightBox.clientWidth +"px";
          // console.log( rightBox.style.marginLeft,2222)
        }
      })();
      // }, 1000);
    },
    //防抖函数，控制函数触发次数
    debounce(fn, wait) {    
      var timeout = null;    
      return function() {        
          if(timeout !== null)   clearTimeout(timeout);        
          timeout = setTimeout(fn, wait);    
      }
    }
  }
};
</script>
<style lang="scss" scoped>

.afLogginBox {
  min-height: 98.5vh;
  background: rgb(242, 247, 250);
  padding: 5px 10px 10px 0;
  border-top: 2px solid #ffffff;
  // max-width: 1260px;
  // width: 1480px;
  .left {
    width: 160px;
    // float: left;
    // position: relative;
    z-index: 100;
    position: fixed;
    left: 0;
    height: 30px;
    
  }
  .right {
    margin-left: 160px;
    // padding-left: 10px;
    margin-top: 100px;
    width: 1480px;
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
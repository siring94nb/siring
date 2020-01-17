<template>
  <div class="aside">
    <div class="square">
      <i class="icon iconfont icon-dianhua" />
      <p>热线</p>
      <div class="float-cont">
        <div class="float-title">
          <i class="icon iconfont icon-rexiandianhua" />热线电话：
        </div>
        <p class="contact-number">0755-36609873</p>
      </div>
    </div>
    <div class="square">
      <i class="icon iconfont icon-erweima" />
      <p>顾问</p>
      <div class="float-cont">
        <div class="float-title">
          <i class="icon iconfont icon-weixin" />专家顾问：
          <p class="aside-text">扫一扫</p>
        </div>
        <p class="contact-number interactive-bg">
          19925374651
          <span class="wx-qrcode">
            <img :src="require('@/assets/images/u388.png')" width="150" height="150" alt />
          </span>
        </p>
        <p class="contact-number interactive-bg">
          13922830809
          <span class="wx-qrcode">
            <img :src="require('@/assets/images/u388.png')" width="150" height="150" alt />
          </span>
        </p>
      </div>
    </div>
    <div class="square">
      <i class="icon iconfont icon-kefu" />
      <p>客服</p>
      <div class="float-cont">
        <div class="float-title">
          <i class="iconfont icon-icon" />QQ客服：
        </div>
        <p class="contact-number interactive-bg">
          <a
            id="qq"
            target="_blank"
            href="http://wpa.qq.com/msgrd?v=3&amp;uin=50087335&amp;site=qq&amp;menu=yes"
          >50087335</a>
        </p>
        <p class="contact-number interactive-bg">
          <a
            id="qq"
            target="_blank"
            href="http://wpa.qq.com/msgrd?v=3&amp;uin=415364124&amp;site=qq&amp;menu=yes"
          >415364124</a>
        </p>
      </div>
    </div>
    <div class="square"  @mouseover="showLevelMsg" @mouseout="showLevelMsg">
      <div>
         <i class="el-icon-edit icon" />
        <p @click.self="showLevelMsg">留言</p>
      </div>
     
      <div class="float-cont" v-show="levelMsgBool" style="width:300px">
        <div class="float-title" style="float: left;"> 
          <i class="iconfont icon-lianxifangshi"/>联系方式：
        </div>
        <input v-model="lianxi" class="levelmsg levelmsg-input" type="text" placeholder="您的联系方式" />
        <div class="float-title" style="float: left;">
          <i class="iconfont icon-liuyan" />留言反馈：
        </div>
        <textarea v-model="liuyan" class="levelmsg" placeholder="您的需求或反馈，我们将在48个小时内，联系您" style="margin-bottom:10px;"></textarea>
        <button class="send-lm" @click="sendMsg">发送</button>
      </div>
    </div>
    <div class="square" style="opacity: 0;" :class="{'topBtn': showBtnTop}" @click="backTop">
      <i class="icon el-icon-caret-top" />
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      levelMsgBool: false,
      showBtnTop: false,
      lianxi:"",
      liuyan:''
    };
  },
  mounted() {
    window.addEventListener("scroll", this.scrollTop);
  },
  methods: {
    showLevelMsg() {
      if(this.levelMsgBool){
        // setTimeout(()=>{
          // square
          this.levelMsgBool = false
        // },1000)
      }else{
        // console.log(1023123)
        this.levelMsgBool = true
      }
    },
    sendMsg() {
      this.showLevelMsg();
    },
    scrollTop() {
      let scrollTop =
        window.pageYOffset ||
        document.documentElement.scrollTop ||
        document.body.scrollTop;
      this.scrollTop = scrollTop;
      if (this.scrollTop > 100) {
        this.showBtnTop = true;
      } else {
        this.showBtnTop = false;
      }
    },
    backTop() {
      const that = this;
      let timer = setInterval(() => {
        let ispeed = Math.floor(-that.scrollTop / 5);
        document.documentElement.scrollTop = document.body.scrollTop =
          that.scrollTop + ispeed;
        if (that.scrollTop === 0) {
          clearInterval(timer);
        }
      }, 16);
    }
  }
};
</script>

<style scoped lang='scss'>
.aside {
  position: fixed;
  right: 0;
  top: 50%;
  transform: translateY(-50%);
  z-index: 999;
  .square {
    position: relative;
    width: 60px;
    height: 60px;
    background-color: #b83733;
    text-align: center;
    margin-bottom: 8px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #fff;
    .icon {
      vertical-align: middle;
      font-size: 24px;
      margin-bottom: 4px;
    }
    .float-cont {
      position: absolute;
      top: 0;
      right: 60px;
      border: 1px solid #e5e5e5;
      padding: 0px 10px 10px 10px;
      width: 184px;
      box-sizing: border-box;
      background-color: #fff;
      display: none;
      .float-title {
        font-size: 16px;
        color: #b83733;
        margin: 10px 0;
        // float: left;
        i{
          font-size: 30px;
          padding-right: 5px;
        }
        .aside-text {
          font-size: 12px;
        }
      }
      .contact-number,
      .contact-number a {
        font-size: 20px;
        color: #333333;
        position: relative;
        line-height: 28px;
      }
      .interactive-bg {
        background-color: #ebf3f8;
        margin-bottom: 10px;
        &:last-of-type {
          margin-bottom: 0;
        }
        .wx-qrcode {
          position: absolute;
          left: 6px;
          bottom: 100%;
          display: none;
        }
        &:hover .wx-qrcode {
          display: block;
        }
      }
      .levelmsg {
        width: 100%;
        resize: none;
        background-color: #ebf3f8;
        height: 80px;
        border: 0;
      }
      .levelmsg-input {
        height: 40px;
      }
      .send-lm {
        float: right;
        cursor: pointer;
        background-color: #b83733;
        border: 0;
        padding: 3px 6px;
        border-radius: 3px;
        color: #fff;
      }
    }
    &:nth-last-child(2) .float-cont {
      display: block;
    }
    &:not(:nth-last-child(2)):hover .float-cont {
      display: block;
    }
  }
  .topBtn {
    opacity: 1 !important;
    transition: opacity 0.4s;
  }
}
</style>
<template>
  <div style="background:rgb(246,246,246);padding-top:10px">
    <Myheader />
    <div style="margin:100px 0 0 15px;">
      <div class="topHeader">
        <div>发稿推广</div>
      </div>
      <div class="bottomBox">
        <div class="left">
          <div class="jianjie">
            <div>
              <i class="el-icon-s-claim"></i>
              <span>提交稿件</span>
            </div>
            <div>本平台针对您提交的需求，从数万家媒介中AI智能筛选推广，做到搜索引擎收录高，媒介覆盖精准，从而达到“少花钱宣传广的效果”！如需帮助，我们还有专业写手为您撰写稿件，扫除您的撰写烧脑之忧！</div>
          </div>
          <div class="anli">
            <div>
              <i class="el-icon-cold-drink"></i>案例欣赏
            </div>
            <div class="anliBox">
              <a href="#">
                <img src="../../assets/images/u158.png" alt />
                <span>新浪网娱乐</span>
              </a>
              <a href="#">
                <img src="../../assets/images/u158.png" alt />
                <span>新浪网娱乐</span>
              </a>
              <a href="#">
                <img src="../../assets/images/u158.png" alt />
                <span>新浪网娱乐</span>
              </a>
              <a href="#">
                <img src="../../assets/images/u158.png" alt />
                <span>新浪网娱乐</span>
              </a>
              <a href="#">
                <img src="../../assets/images/u158.png" alt />
                <span>新浪网娱乐</span>
              </a>
              <a href="#">
                <img src="../../assets/images/u158.png" alt />
                <span>新浪网娱乐</span>
              </a>
              <a href="#">
                <img src="../../assets/images/u158.png" alt />
                <span>新浪网娱乐</span>
              </a>
              <a href="#">
                <img src="../../assets/images/u158.png" alt />
                <span>新浪网娱乐</span>
              </a>
            </div>
          </div>
        </div>
        <div class="right">
          <h1>右边</h1>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Myheader from "@/components/header";
export default {
  data() {
    return {};
  },
  components: {
    Myheader
  },
  mounted() {},
  methods: {}
};
</script>
<style lang="scss" scoped>
.topHeader {
  background: #ffffff;
  font-size: 28px;
  padding: 10px;
}
.bottomBox {
  margin-top: 10px;
  display: flex;
}
.jianjie {
  width: 240px;
  height: 210px;
  background-image: url("../../assets/images/u2173.png");
  color: #6b6b6b;
  font-size: 14px;
  border-left: 3px solid rgb(201, 0, 0);
  div {
    padding: 0 10px;
    &:nth-of-type(1) {
      padding-top: 10px;
      padding-bottom: 5px;
      font-size: 18px;
      color: #000000;
      font-weight: 700;
      i {
        font-size: 48px;
        color: rgb(138, 138, 138);
      }
    }
    &:nth-of-type(2) {
      width: 200px;
      line-height: 20px;
    }
  }
}
.anli{
  background: #ffffff;
  padding: 10px 0 0 0;
  margin-top: 10px;
  width: 220px;
  div{
    &:nth-of-type(1){
      padding:10px;
      text-align: center;
      background: rgb(246,246,246);
      width: 180px;
      margin-left: 10px;
      margin-bottom: 10px;
    }
  }
}
.anliBox::-webkit-scrollbar { width: 0 !important }
.anliBox {
  display: flex;
  flex-direction: column;
  height: 889px;
  overflow-y:auto;
  width: 220px;
  a {
    display: inline-block;
    width: 180px;
    height: 180px;
    position: relative;
    margin-bottom: 10px;
    margin-left: 20px;
    img{
      width: 180px;
      height: 180px;
    }
    span {
      position: absolute;
      top: 0;
      left: 0;
      z-index: 55;
      background: rgba(0, 0, 0, 0.6);
      color: #ffffff;
      display: inline-block;
      width: 180px;
      padding: 10px  0;
      text-align: center;
    }
  }
}
</style>
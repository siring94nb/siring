<template>
  <div class="quickval">
    <myheader />
    <div class="anlixiangxi">
      <div class="xxSmBox">
        <div class="xiangxiBox">定制案例</div>
        <div class="xuqiuBox">
          <span>
            <img :src="require('../../assets/images/u2606.png')" alt="">
            <img :src="require('../../assets/images/u2607.png')" alt="">
          </span>
          <span>需求提交</span>
          <span>
            <img :src="require('../../assets/images/u2607.png')" alt="">
            <img :src="require('../../assets/images/u2606.png')" alt="">
          </span>
        </div>
        <div class="xiuqiujieshao">
          <img :src="require('../../assets/images/rz.jpg')" alt="" style="width:135px;height:135px;border-radius:50%">
          <div class="xiuqiujieshaoc">
            <div>需求名称：<span style="padding-left:10px">千寻</span></div>
            <div>需求类型：<span style="font-weight: normal;padding-left:10px">娱乐生活</span></div>
            <div style="display:flex" class="xz">终端选择：
              <span v-for="(item,index) in typeList" :key="index" style="font-weight: normal;color:#797979;padding-left:40px;display:flex;flex-direction: column;text-align:center;font-size:18px">
                <i :class="item.className" style="padding-bottom:5px"></i>
                <span>{{item.name}}</span>
              </span>
            </div>
            <div style="display:flex"><span style="min-width:100px">需求描述：</span><span style="margin-top:-10px;font-weight: normal;padding-left:10px;line-height:2em">我司需要制作一款区块链+项目，打造全球首款的区块链知识奖励APP，详细需求已附件方式发给贵司</span></div>
            <div><span style="width:100px;display: inline-block;text-align:right">预算：</span><span style="font-weight: normal;padding-left:10px">40万~60万</span></div>
          </div>
        </div>
        <div class="xuqiuBox">
          <span>
            <img :src="require('../../assets/images/u2606.png')" alt="">
            <img :src="require('../../assets/images/u2607.png')" alt="">
          </span>
          <span>开发流程</span>
          <span>
            <img :src="require('../../assets/images/u2607.png')" alt="">
            <img :src="require('../../assets/images/u2606.png')" alt="">
          </span>
        </div>
        <div class="xuqiuliucheng">
        </div>
        <div class="xuqiuBox">
          <span>
            <img :src="require('../../assets/images/u2606.png')" alt="">
            <img :src="require('../../assets/images/u2607.png')" alt="">
          </span>
          <span>成品欣赏</span>
          <span>
            <img :src="require('../../assets/images/u2607.png')" alt="">
            <img :src="require('../../assets/images/u2606.png')" alt="">
          </span>
        </div>
        <div class="swiperBox">
          <el-carousel :interval="4000" type="card" height="500px">
            <el-carousel-item v-for="item in 6" :key="item">
              <div>
                <img :src="require('../../assets/images/u2.png')" alt="">
              </div>
            </el-carousel-item>
          </el-carousel>
        </div>
      </div>
    </div>
    <div class="xuanfuBox">
      <img :src="require('../../assets/images/u2623.png')" alt="">
      <div>立即定制</div>
    </div>
    <Jdyh/>
      <myfooter />

    
  </div>
</template>

<script>
import Myheader from "@/components/header";
import Myfooter from "@/components/footer";
import Jdyh from "@/components/jdyh";
import { needOrderAdd ,GetDevlopType} from "@/api/api";
export default {
  components: {
    Myheader,
    Myfooter,
    Jdyh
  },
  data() {
    return {
    };
  },
  mounted() {
  },
  methods: {
  }
};
</script>
<style>
  .swiperBox .el-carousel{
    width: 852px ;
    height: 646px;
    /* padding-left: 20px; */
  }
  /* el-carousel el-carousel--horizontal el-carousel--card */
</style>
<style scoped lang='scss'>
.anlixiangxi{
  background: #ffffff;
  margin-top:100px;
  padding-bottom: 30px;
  .xxSmBox{
    padding: 0 100px;
    .xiangxiBox{
      border-bottom: 20px solid #f2f2f2;
      text-align: center;
      font-size: 33px;
      padding: 30px 0;
    }
    .xuqiuBox{
      padding: 30px 0;
      font-size: 33px;
      display: flex;
      justify-content: space-between;
      >span{
        display: flex;
        align-items: center;
        &:nth-of-type(1){
          img{
            &:nth-of-type(2){
              margin-left: -5px;
            }
          }
        }
        &:nth-of-type(3){
          img{
            &:nth-of-type(1){
              margin-right: -5px;
            }
          }
        }
      }
    }
    .xiuqiujieshao{
      display: flex;
      justify-content: center;
      padding-bottom: 30px;
      >div{
        >div{
          font-size: 20px;
          color: #333333;
          font-weight: 700;
          &:nth-of-type(1){
            span{
              font-size: 28px;
              font-weight: normal;
            }
          }
        }
      }
      .xiuqiujieshaoc{
        background: url("../../assets/images/u2531.png") no-repeat;
        margin-left: 50px;
        height: 441px;
        box-sizing: border-box;
        max-width: 949px;
        >div{
          margin: 40px 30px 0 60px;
        }
      }
    }
    .xuqiuliucheng{
      background-color: rgb(246,246,246);
      background-image: url("../../assets/images/备用.png");
      background-repeat: no-repeat;
      height: 756px;
     
    }
  }
  .xz{
    >span:nth-of-type(1){
      padding-left: 10px !important;
    }
  }
}
.xuanfuBox{
  background: rgb(254,87,87);
  width: 170px;
  height: 170px;
  color: #ffffff;
  font-size: 28px;
  font-weight: 700;
  border-radius: 50%;
  text-align: center;
  position: fixed;
  right: 50px;
  bottom: 170px;
  z-index: 500;
  img{
    padding: 30px 0 10px 0;
  }
}
.swiperBox{
  height: 700px;
  display: flex;
  justify-content: center;
  border-bottom: 20px solid #f2f2f2;
  img{
    width: 412px;
    height: 646px;
  }
  .el-carousel__item >div {
    color: #475669;
    font-size: 14px;
    opacity: 0.75;
    line-height: 200px;
    margin: 0;
    text-align: center;
    height: 700px;
  }
  .el-carousel__item {
    background: #ffffff;
    width: 412px;
    height: 646px;
  }
}
</style>
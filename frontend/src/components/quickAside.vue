<template>
  <div class="recomment-left">
    <div class="quick-desc">
      <div class="desc-title">
        <i
          :class="{'iconfont':true,'icon-jisuanqi':rou=='quickValuation','i1':rou=='quickValuation','icon-xuqiubaosong':rou=='fillDemand','icon-wenwangwenbanli':rou=='ai-promotion'}"
          v-if="rou !='newInvestment'"
        ></i>
        <i
          :class="{'iconfont':true,'icon-xuqiubaosong':rou=='newInvestment'}"
          v-if="rou =='newInvestment'"
        ></i>
        <span
          style="font-size:18px"
        >{{type == 1? '定制需求':rou=="ai-promotion"?'提交稿件':rou=="newInvestment"?'投融说明':'快捷估价'}}</span>
      </div>
      <div
        :class=" {'desc-dit1':rou=='ai-promotion','desc-dit':rou!='ai-promotion'&& rou !='newInvestment','nI':rou=='newInvestment'}"
      >
        {{type == 1?'请详细填写右边需求信息，提交需求后，系统将根据信息需求情况，及时走公司需求的梳理分析，以及报价、合同、设计等流程；为您提供完美的用户体验！':rou=="ai-promotion"?
        '本平台针对您提交的需求，从数万家媒介中AI智能筛选推广，做到搜索引擎收录高，媒介覆盖精准，从而达到“少花钱宣传广的效果”！如需帮助，我们还有专业写手为您撰写稿件，扫除您的撰写烧脑之忧！':rou=="newInvestment"?
        '平台提供线上服务与线下服务功能，让资本与项目精准对话和线下对接，提高资本找项目、项目找资本的效率和成功率。您可查阅项目，也可发布项目，当您打赏查阅项目后，还能直接与创业者沟通'
        :'很多朋友对开发费用多少没有大致概念，往往被不良开发商所蒙蔽，在这里我们为您提供便捷的快捷估价服务，让您放心开发！'}}
      </div>
    </div>
    <div class="recomment-cont">
      <div class="recomment-title">
        <!-- <i class="iconfont icon-shouye" v-if="rou!='fillDemand'||rou!='quickValuation'"></i> -->
        <i class="iconfont icon-hua"></i>
        <span v-if="rou != 'newInvestment'">定制案例欣赏</span>
        <span v-if="rou == 'newInvestment'">投融介见面会</span>
      </div>
      <div class="recomment-list" v-if="rou != 'newInvestment'">
        <div class="recomment-item" v-for="(item,index) in recommentList" :key="item.id" @click="jump" >
          <div v-if="index<10">
            <el-image class="cover-img" :src="item.img"></el-image>
            <el-image :src="require('@/assets/images/u2337.png')"></el-image>
            <div class="jianjie">
              <span>{{item.goods_name}}</span>
            </div>
          </div>
        </div>
        <div class="ckgd">查看更多</div>
      </div>
      <div class="recomment-list" v-if="rou == 'newInvestment'">
        <div class="recomment-item" v-for="(item,index) in recommentList" :key="item.id" @click="jump1">
          <div v-if="index<10">
            <el-image class="cover-img" :src="item.img"></el-image>
            <el-image :src="require('@/assets/images/u2337.png')"></el-image>
            <div class="jianjie">
              <span>{{item.goods_name}}</span>
            </div>
          </div>
        </div>
        <div class="ckgd">查看更多</div>
      </div>
    </div>
  </div>
</template>

<script>
import { GetCustomCase } from "@/api/api";
export default {
  props: ["type"],
  data() {
    return {
      recommentList: [],
      rou: ""
    };
  },
  mounted() {
    this.getCustomCase();
    this.init();
  },
  methods: {
    init() {
      this.rou = this.$route.name;
      console.log(this.rou);
    },
    getCustomCase() {
      GetCustomCase().then(res => {
        console.log(res.data.data);
        let { code, msg, data } = res.data;
        if (code === 1) {
          this.recommentList = data;
        }
      });
    },
    // 定制案例详情
    jump(){
      this.$router.push({
        name:'fillDemandNew',
        params: ""
      })
    },
    // 投融介跳转
    jump1(){
      this.$router.push({
        name:'newManuscriptC',
        params: ""
      })
    }
  }
};
</script>

<style scoped lang='scss'>

.recomment-left {
  float: left;
  display: flex;
  flex-direction: column;
  width: 225px;
  height: 100%;
  .quick-desc {
    height: 230px;
    background: url("~@/assets/images/u2173.png") no-repeat;
    background-size: 100% 100%;
    padding: 15px 0 0 15px;
    box-sizing: border-box;
    .desc-title {
      i {
        font-size: 36px;
        color: #666666;
        margin-right: 10px;
        vertical-align: middle;
        // margin-left: -5px;
      }
      .i1 {
        font-size: 36px;
        color: #666666;
        margin-right: 10px;
        vertical-align: middle;
        margin-left: -5px;
      }
      span {
        font-size: 20px;
        color: #333333;
        font-weight: bold;
        vertical-align: middle;
      }
    }
    .desc-dit {
      font-size: 14px;
      color: #6b6b6b;
      line-height: 2;
      width: 80%;
    }
    .desc-dit1 {
      font-size: 14px;
      color: #6b6b6b;
      line-height: 1.5;
      width: 80%;
    }
    .nI {
      font-size: 14px;
      color: #6b6b6b;
      line-height: 1.45;
      width: 180px;
    }
  }
  .recomment-cont {
    flex: 1;
    background-color: #ffffff;
    padding-top: 15px;
    width: 205px;
    .recomment-title {
      width: 90%;
      margin: 0 auto 15px;
      background-color: rgb(246, 246, 246);
      height: 34px;
      line-height: 34px;
      box-sizing: border-box;
      .icon-hua {
        font-size: 24px;
        color: rgb(216, 30, 6);
        vertical-align: middle;
        margin: 0 10px 0 15px;
      }
      span {
        vertical-align: middle;
        font-size: 14px;
      }
    }
    .recomment-list {
      margin: 0 auto;
      height: 520px;
      overflow-y: auto;
      &::-webkit-scrollbar {
        width: 0;
      }
      .recomment-item {
        position: relative;
        width: 160px;
        margin: 0 auto 15px;
        &:hover .cover-img {
          transform: rotateY(-90deg);
        }
        &:hover .jianjie {
          transform: rotateY(-90deg);
        }
        .el-image {
          width: 160px;
          height: 160px;
          img {
            width: 100%;
            height: 100%;
          }
        }
        .cover-img {
          position: absolute;
          top: 0;
          left: 0;
          right: 0;
          z-index: 2;
          transition: transform 0.7s;
        }
      }
    }
  }
}
.jianjie {
  position: absolute;
  z-index: 30;
  bottom: 0px;
  width: 100%;
  padding: 8px 0;
  background: rgba(0, 0, 0, 0.8);
  text-align: center;
  span {
    color: #ffffff;
    font-size: 14px;
  }
}
.ckgd {
  text-align: center;
  padding-bottom: 15px;
  font-size: 13px;
  color: #169bd5;
}
</style>
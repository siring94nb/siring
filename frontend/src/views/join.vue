<template>
  <div class="join">
    <myheader />
    <myaside />
    <myswiper />

    <div class="join-cont">
      <h2 class="title">城市合伙人</h2>
      <div class="join-step">
        <h3 class="step-title">加盟流程</h3>
        <div class="step-list">
          <div
            :class="{'step-item': true, 'step-on': stepFlag==index}"
            v-for="(item, index) in stepList"
            :key="index"
            @mouseenter="stepMouseEnter(index)"
          >
            <div class="step-name-box">
              <div class="step-name">{{ item.name }}</div>
              <span class="step-num">{{ index+1 }}</span>
            </div>
            <div class="step-desc">{{ item.desc }}</div>
          </div>
        </div>
      </div>
      <div class="support">
        <h3 class="support-title">城市合伙人支持</h3>
        <div class="support-list">
          <div class="support-item">
            <img :src="require('@/assets/images/u4414.png')" alt />
            <p>专业客服答疑</p>
            <p>7*24小时专业指导</p>
          </div>
          <div class="symbol">+</div>
          <div class="support-item">
            <img :src="require('@/assets/images/u4415.png')" alt />
            <p>运营特训</p>
            <p>线下指导，轻松运营</p>
          </div>
          <div class="symbol">+</div>
          <div class="support-item">
            <img :src="require('@/assets/images/u4419.png')" alt />
            <p>城市合伙人交流</p>
            <p>分享会，商家联盟</p>
          </div>
          <div class="symbol">=</div>
          <div class="support-item">
            <img :src="require('@/assets/images/u4442.png')" alt />
            <p>加盟城市全年全部利润比例</p>
            <p>收益分红<span>&lt;收益预测&gt;</span></p>
          </div>
        </div>
      </div>
    </div>

    <myfooter />
  </div>
</template>

<script>
import Myheader from "@/components/header";
import Myaside from "@/components/aside";
import Myswiper from "@/components/mySwiper";
import Myfooter from "@/components/footer";
export default {
  components: {
    Myheader,
    Myaside,
    Myswiper,
    Myfooter
  },
  data() {
    return {
      stepList: [
        {
          name: "选择城市",
          desc: "不同的城市收益比例不同 ，城市等级越高，收益越大！"
        },
        {
          name: "缴费申请",
          desc: "不同等级城市，费用不同通过权益双方利益保障"
        },
        {
          name: "成为城市合伙人",
          desc: "一旦升级为城市合伙人后您的账号将会有等级图标显示"
        }
      ],
      stepFlag: 0
    };
  },
  methods: {
    stepMouseEnter(index) {
      this.stepFlag = index;
    }
  }
};
</script>

<style scoped lang='scss'>
.join {
  margin-top: 100px;
  .join-cont {
    width: 1200px;
    margin: 0 auto 80px;
    .title {
      height: 100px;
      line-height: 100px;
      // border-bottom: 10px solid #E2E2E2;
      text-align: center;
      font-size: 34px;
      margin-bottom: 30px;
    }
    .join-step {
      margin-bottom: 50px;
      .step-title {
        text-align: center;
        font-size: 24px;
        color: #333333;
        margin-bottom: 30px;
      }
      .step-list {
        display: flex;
        justify-content: space-around;
        align-items: center;
        .step-item {
          width: 300px;
          height: 200px;
          cursor: pointer;
          .step-name-box {
            position: relative;
            height: 95px;
            border: 2px solid rgb(121, 121, 121);
            box-sizing: border-box;
            color: #333333;
            .step-name {
              width: 100%;
              text-align: center;
              line-height: 95px;
              font-size: 28px;
            }
            .step-num {
              position: absolute;
              left: 0;
              top: 50%;
              transform: translate(-50%, -50%);
              color: rgb(121, 121, 121);
              background-color: #ffffff;
              padding: 10px;
              font-size: 40px;
            }
          }
          .step-desc {
            display: none;
            height: 100px;
            line-height: 1.5;
          }
          &.step-on {
            .step-name-box {
              border-color: rgb(184, 159, 95);
              color: rgb(184, 159, 95);
              .step-num {
                color: rgb(184, 159, 95);
              }
            }
            .step-desc {
              display: table-cell;
              vertical-align: middle;
              color: #ffffff;
              background-color: rgb(184, 159, 95);
              font-size: 20px;
              padding: 0 15px;
            }
          }
        }
      }
    }
    .support {
      .support-title {
        text-align: center;
        font-size: 24px;
        color: #333333;
        margin-bottom: 30px;
      }
      .support-list {
        display: flex;
        justify-content: space-around;
        align-items: center;
        .support-item {
          text-align: center;
          p{
            margin-top: 10px;
            color:#797979;
            font-size: 14px;
            span{
              color: #66CCFF;
              cursor: pointer;
              font-size: 16px;
              font-weight: bold;
            }
          }
        }
        .symbol {
          font-size: 30px;
          font-weight: bold;
          color: #333333;
        }
      }
    }
  }
}
</style>
<template>
  <div class="join">
    <myheader />
    <join-enter />
    <myswiper />

    <div class="join-cont">
      <h2 class="title">等级会员</h2>
      <div class="join-step">
        <h3 class="step-title">升级会员流程</h3>
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

      <div class="new-member">
        <h3 class="title">新升级的等级会员</h3>
        <div class="new-member-box">
          <div class="img">
            <img :src="require('@/assets/images/u4734.png')" alt />
          </div>
          <div class="marquee">
            <ul class="marquee-list clearfix" style="width: 5000px">
              <li class="marquee-item" v-for="item in 6" :key="item">
                重庆会员（邀请码
                <span class="code-color">JU4523</span>）升级为金牌会员
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <myfooter />
  </div>
</template>

<script>
import Myheader from "@/components/header";
import JoinEnter from "@/components/join/cmp";
import Myswiper from "@/components/mySwiper";
import Myfooter from "@/components/footer";
export default {
  components: {
    Myheader,
    JoinEnter,
    Myswiper,
    Myfooter
  },
  data() {
    return {
      stepList: [
        {
          name: "选择等级",
          desc: "选择不同等级，获得不同收益等级越高，收益越大"
        },
        {
          name: "缴费申请",
          desc: "为了彼此双赢，通过会员权益双方利益保障"
        },
        {
          name: "成为等级会员",
          desc: "一旦升级为会员后，您的账号将会有等级图标显示"
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
  .join-cont {
    width: 1200px;
    margin: 0 auto 80px;
    .title {
      height: 100px;
      line-height: 100px;
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
              border-color: rgb(0, 189, 189);
              color: rgb(0, 189, 189);
              .step-num {
                color: rgb(0, 189, 189);
              }
            }
            .step-desc {
              display: table-cell;
              vertical-align: middle;
              color: #ffffff;
              background-color: rgb(0, 189, 189);
              font-size: 20px;
              padding: 0 15px;
            }
          }
        }
      }
    }
    .new-member {
      .title {
        font-size: 28px;
        color: #333333;
      }
      .new-member-box {
        .img {
          text-align: center;
        }
        .marquee {
          margin: 0 75px;
          overflow: hidden;
          .marquee-list {
            .marquee-item {
              float: left;
              width: 220px;
              text-align: center;
              margin: 0 20px;
              color: #797979;
              font-size: 22px;
              line-height: 28px;
              .code-color {
                color: #199ed8;
              }
            }
          }
        }
      }
    }
  }
}
</style>
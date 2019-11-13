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

      <div class="package">
        <h3 class="title">请缴费申请等级会员</h3>
        <div class="package-list">
          <div
            class="package-item"
            :class="classList[index === activeClass && index]"
            v-for="(item, index) in 3"
            :key="item"
            @mouseenter="onMouseenter(index)"
          >
            <div class="bg-top">
              <div class="package-head">
                <div class="package-img">
                  <img :src="require('@/assets/images/u1920.png')" width="48" height="48" alt />
                </div>
                <div class="package-name">皇冠会员</div>
              </div>
              <div class="button-price">
                <button @click="onClick">￥35888/年</button>
              </div>
            </div>
            <div class="privilege-service">
              <div class="privilege-title">尊享服务</div>
              <ul class="privilege-list">
                <li class="privilege-on">定制开发，9.5折优惠</li>
                <li class="privilege-on">商业模版，9.5折优惠</li>
                <li class="privilege-on">分享他人，他人获取100元新人优惠券，个人获得200元新人优惠券</li>
                <li class="privilege-on">用户消费专享10%利润提成</li>
              </ul>
            </div>
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
      stepFlag: 0,
      classList: ["crown", "diamond", "gold"],
      activeClass: 0
    };
  },
  methods: {
    stepMouseEnter(index) {
      this.stepFlag = index;
    },
    onMouseenter(index) {
      this.activeClass = index;
    },
    onClick() {
      
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
    .package {
      .title {
        font-size: 28px;
        color: #333333;
        margin-top: 20px;
      }
      .package-list {
        display: flex;
        justify-content: space-between;
        align-items: center;
        .package-item {
          height: 585px;
          width: 365px;
          border: 1px solid #c9c9c9;
          border-radius: 20px;
          overflow: hidden;
          .bg-top {
            background-color: rgb(242, 251, 255);
            .package-head {
              text-align: center;
              margin-bottom: 15px;
              .package-img {
                img {
                  margin-top: 30px;
                }
              }
              .package-name {
                font-size: 20px;
                color: #ffb103;
              }
            }
            .button-price {
              text-align: center;
              border-top: 1px solid #c9c9c9;
              margin: 0 22px;
              button {
                width: 230px;
                height: 40px;
                background-color: #c9c9c9;
                border-radius: 5px;
                font-size: 24px;
                border: 1px solid rgb(228, 228, 228);
                color: #ffffff;
                font-weight: 700;
                margin: 20px 0;
                cursor: pointer;
              }
            }
          }
          .privilege-service {
            background-color: #ffffff;
            margin: 0 20px;
            .privilege-title {
              font-size: 16px;
              color: #aeaeae;
              margin: 20px 0 10px;
            }
            .privilege-list {
              font-size: 14px;
              line-height: 28px;
              .privilege-on::before {
                content: "✔ ";
                color: #669900;
              }
            }
          }
          &.crown {
            border-color: #ffb103;
            box-shadow: 0 0 5px 3px rgba(255, 177, 3, 0.5);
            .bg-top {
              background-color: rgb(255, 248, 230);
              .package-name {
                color: #ffb103;
              }
              .button-price {
                border-top-color: #ffb103;
                button {
                  background-color: rgb(255, 177, 3);
                }
              }
            }
          }
          &.diamond {
            border-color: #4abbfc;
            box-shadow: 0 0 5px 3px rgba(66, 155, 207, 0.5);
            .bg-top {
              background-color: rgb(242, 251, 255);
              .package-name {
                color: #4abbfc;
              }
              .button-price {
                border-top-color: rgb(66, 155, 207);
                button {
                  background-color: rgb(66, 155, 207);
                }
              }
            }
          }
          &.gold {
            border-color: #ff0000;
            box-shadow: 0 0 5px 3px rgba(255, 0, 0, 0.5);
            .bg-top {
              background-color: rgb(255, 238, 238);
              .package-name {
                color: #ff0000;
              }
              .button-price {
                border-top-color: #ff0000;
                button {
                  background-color: #ff0000;
                }
              }
            }
          }
        }
      }
    }
  }
}
</style>
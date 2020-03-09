<template>
  <div class="join">
    <myheader />
    <join-enter />

    <div class="join-cont">
      <h2 class="title ">等级会员</h2>
      <div class="title-bot">（您还可以同时选择其他角色加盟，同时拥有多个角色）</div>
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
      <!-- 会员支持 -->
      <div class="huiyuanzhichi">
        <div style="text-align:center;font-size:28px;color:#333333;margin-bottom:15px">会员支持</div>
        <div class="zhichi">
          <div>
            <div><img :src="require('../../assets/images/u5718.png')" alt=""></div>
            <div>
              <div>各项业务均可享受</div>
              <div>不同等级折扣</div>
            </div>
          </div>
          <div>+</div>
          <div>
            <div><img :src="require('../../assets/images/u5717.png')" alt=""></div>
            <div>
              <div>各项业务均可享受</div>
              <div>不同等级折扣</div>
            </div>
          </div>
          <div>+</div>
          <div>
            <div><img :src="require('../../assets/images/u5715.png')" alt=""></div>
            <div>
              <div>各项业务均可享受</div>
              <div>不同等级折扣</div>
            </div>
          </div>
          <div>=</div>
          <div>
            <div><img :src="require('../../assets/images/u5716.png')" alt=""></div>
            <div>
              <div>各项业务均可享受</div>
              <div>不同等级折扣</div>
            </div>
          </div>
        </div>
      </div>
      <!-- 新升级的等级会员 -->
      <div class="new-member">
        <h3 class="title">新升级的等级会员</h3>
        <div class="new-member-box">
          <div class="img">
            <img :src="require('@/assets/images/u4734.png')" alt />
          </div>
          <div class="marquee">
            <ul class="marquee-list clearfix ydong">
              <li class="marquee-item" v-for="(item,index) in ceshishuju" :key="index">
                <img style="width:43px;height:43px;" :src="item.img" alt="">
                <span>
                {{item.huiyuan}}（邀请码
                <span class="code-color">{{item.yaoqma}}</span>）升级为金牌会员
                </span>
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
            v-for="(item, index) in memberList"
            :key="item.id"
            @mouseenter="onMouseenter(index)"
          >
            <div class="bg-top">
              <div class="package-head">
                <div class="package-img">
                  <img :src="require('@/assets/images/u1920.png')" width="48" height="48" alt />
                </div>
                <div class="package-name">{{item.title}}</div>
              </div>
              <div class="button-price">
                <button @click="getMemberOrderAdd(item.id, item.money)">￥{{item.money}}/年</button>
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
      <div class="protocol">
        <el-checkbox v-model="checked">我已阅读并同意</el-checkbox>
        <span @click="dialogVisible = true">《会员权益》</span>
      </div>

      <el-dialog title="会员权益" center :visible.sync="dialogVisible" width="1000px">
        <div class="protocol-cont">
          <p>本协议下文中的甲方为深圳市思锐信息技术有限公司，乙方为平台授权用户。</p>
          <p>一、合作基础</p>
          <p>（一）甲方为乙方提供产品，全部保证为正品，请您及用户放心使用！您推介的用户，产生利润，系统将自动为您结算酬金；</p>
          <p>（二）甲方免费提供系统所需要的硬件环境、网络带宽、技术支持及后续升级服务，甲方向乙方授权使用系统牌照，牌照等级分为：皇冠、钻石、金牌三个等级；</p>
          <p>（三）乙方必须是具有完全民事行为能力的自然人或法人；</p>
          <p>（四）乙方有权使用本站内各项功能；</p>
          <p>二、酬金支付标准及结算方式</p>
          <p>（一）甲方产品利润指的平台内各项产品的销售毛利，甲方根据乙方实际系统统计业绩情况支付产品利润酬金，明细可查阅【代理中心】--【业绩管理】</p>
          <p>（二）酬金由甲方直接支付到乙方注册时所用的手机账户中，以手机零钱的形式转到乙方在平台登记的银行卡上，乙方如需调整手机银行账户，须及时在平台上添加。</p>
          <p>三、甲方的权利义务</p>
          <p>（一）甲方根据乙方的考核业绩，可帮助推广邀请码方面的支持。</p>
          <p>（二）甲方有权根据乙方造成甲方的声誉损失程度，向乙方追究责任，或解除本协议。</p>
          <p>四、乙方的权利与义务</p>
          <p>（一）、乙方积极服从甲方业务管理和指导，严格执行甲方有关业务规定和资费政策。</p>
          <p>（二）、乙方在经营活动中应恪守信誉，讲究职业道德，树立良好形象。</p>
          <p>（三）、乙方在宣传推广过程中应遵守国家相关法律法规，不得以任何理由进行虚假宣传或故意夸大宣传，如有违反相关规定，后果由乙方自行承担，甲方不承担任何后果。</p>
          <p>（四）未经授权、不得将甲方的商标、企业名称、企业标志、产品包装设计以相同或近似的方式使用于任何包装、广告、网站、宣传资料。</p>
          <p>（五）必须妥善保管个人密码，并同意甲方只须凭“密码相符”即可认定实施行为的主体是其本人，因个人密码保管不当等原因引起的法律责任完全自行承担</p>
          <p>（六）不得擅自把自己的账号出借、转让给他人经营甲方业务。</p>
          <p>五、保密条款和知识产权</p>
          <p>（一）乙方严格保守国家通信秘密，遵守有关的法律、法规。</p>
          <p>（二）甲方完全拥有手机充值营业厅系统的全部知识产权，乙方签署本协议后并未拥有产品的著作权。</p>
          <p>六、平台使用费</p>
          <p>甲方向乙方提供有偿使用服务，并向乙方收取一定的平台年使用费。</p>
          <p>七、责任免除</p>
          <p>甲方对下列事项不作任何陈述与保证：</p>
          <p>1）使用“服务”的，及“服务”与任何其它硬件、软件、系统或数据结合时的，安全性、及时性、不受干扰或不发生错误；</p>
          <p>2）“服务”符合乙方的要求或经验；</p>
          <p>3）缺陷将会被更正；</p>
          <p>4）对“服务”的功能按乙方的要求进行修改。</p>
          <p>八、Internet延迟</p>
          <p>甲方提供的“服务”可能因Internet和电子通信固有的缺陷而产生限制、延迟和其它问题。甲方对因这些问题造成的任何延误、发送失败或其它损失不承担责任。</p>
          <p>九、其他</p>
          <p>（一）如您已支付使用相当费用并已下达订单，表明您认可并同意手机充值营业厅服务协议的任何条款，并具有法律效力，且也受到本协议条款的约束。</p>
          <p>（二）本协议在运作过程中出现的问题，双方应协商解决，并可签订补充协议；如协商不成，甲乙双方均有权向甲方所在的人民法院提出诉讼。</p>
          <p>（三）本协议各方承诺：已完全知晓和理解本协议及所有相关法律文件的所有条款的含义及法律后果，各方自愿签署并完全接受上述条款。</p>
          <p>（四）本协议的任何修改、补充均须以甲方电子文本形式作出，与本协议具同等法律效力。</p>
          <p>（五）乙方委托甲方以电子文本形式保管所有与本协议有关的法律文件，并承诺在发生与本协议相关的所有争议时，对甲方当时保管的电子文本的协议作为证据的真实性无任何异议。</p>
        </div>
        <span slot="footer" class="dialog-footer">
          <el-button type="primary" @click="dialogVisible = false">确 定</el-button>
        </span>
      </el-dialog>

      <payment-bar
        ref="paymentbar"
        :showPaymentFlag="showPaymentFlag"
        :price="price"
        :percent="percent"
        :pay="pay"
        :order="0"
        :scale="0"
        @sendNum="getNum"
        :needCodeDialog="needCodeDialog"
      />
    </div>
    <myfooter />
  </div>
</template>

<script>
import Myheader from "@/components/header";
import JoinEnter from "@/components/join/cmp";
import Myfooter from "@/components/footer";
import { GetMemberList, MemberOrderAdd, GetDiscount } from "@/api/api";
import PaymentBar from "@/components/join/paymentBar";
export default {
  components: {
    Myheader,
    JoinEnter,
    Myfooter,
    PaymentBar
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
      activeClass: 0,
      checked: true,
      memberList: [],
      dialogVisible: false,
      showPaymentFlag: false,
      num: 1,
      price: 0,
      percent: 100,
      needCodeDialog: true,
      gradeId: 0,
      ceshishuju:[
        {img:require('@/assets/images/u1920.png'),huiyuan:"重庆会员1",yaoqma:"JU4523"},
        {img:require('@/assets/images/u1920.png'),huiyuan:"重庆会员2",yaoqma:"JU4523"},
        {img:require('@/assets/images/u1920.png'),huiyuan:"重庆会员3",yaoqma:"JU4523"},
        {img:require('@/assets/images/u1920.png'),huiyuan:"重庆会员4",yaoqma:"JU4523"},
        {img:require('@/assets/images/u1920.png'),huiyuan:"重庆会员5",yaoqma:"JU4523"},
        {img:require('@/assets/images/u1920.png'),huiyuan:"重庆会员6",yaoqma:"JU4523"},
        {img:require('@/assets/images/u1920.png'),huiyuan:"重庆会员7",yaoqma:"JU4523"},
        {img:require('@/assets/images/u1920.png'),huiyuan:"重庆会员8",yaoqma:"JU4523"},
      ],
    };
  },
  mounted() {
    this.init();
  },
  computed: {
    total() {
      return this.price * (this.percent / 100) * this.num;
    }
  },
  methods: {
    init(){
      this.getMemberList();
      this.openhuadong();
    },
    stepMouseEnter(index) {
      this.stepFlag = index;
    },
    onMouseenter(index) {
      this.activeClass = index;
    },
    getMemberList() {
      GetMemberList().then(res => {
        // console.log(res.data);
        let { msg, data, code } = res.data;
        if (code === 1) {
          console.log(data)
          this.memberList = data;
        }
      });
    },
    getdiscount() {
      GetDiscount({ id: 31 }).then(res => {
        let { code, data, msg } = res;
        if (code === 1) {
          this.percent = data.user_discount;
        }
      });
    },
    getMemberOrderAdd(id, money) {
      if (!this.checked) {
        this.$message.error("请勾选会员权益");
      } else {
        this.showPaymentFlag = true;
        this.price = money;
        this.gradeId = id;
      }
    },
    pay() {
      MemberOrderAdd({
        user_id: parseInt(sessionStorage.getItem("user_id")),
        grade: this.gradeId,
        num: this.num,
        price: this.total
      }).then(res => {
        let { code, data, msg } = res;
        console.log(data);
        if (code === 1) {
         this.$router.push({
                name: "comboPay",
                params: {
                  order_amount: this.total,
                  user_id:parseInt(sessionStorage.getItem("user_id")),
                  id: data,
                  order_type: 8
                }
              });
        } else {
          this.$message.error(msg);
        }
      });
    },
    getNum(value) {
      this.num = value;
    },
    // 等级会员左右滑动
    openhuadong(){
      let huadongArr = document.getElementsByClassName("marquee-item");
      let arrA = [];
      let lh = this.ceshishuju.length;
      let marqueeList = document.getElementsByClassName("marquee-list")[0];
      let sum = 0;
      for(let i=0; i<huadongArr.length; i++){
          sum+=huadongArr[i].offsetWidth+40;
      }
      marqueeList.style.width = sum + "px";
      let timeO = setInterval(() => {
        // console.log(123123)
        // marqueeList.scrollLeft += 200;
        // console.log(this.ceshishuju.length)
        arrA.push(this.ceshishuju.shift()) ;
        if(this.ceshishuju.length < 4 || this.ceshishuju.length >lh){
          // this.ceshishuju= arrA;
          // this.ceshishuju.push(arrA);
          // console.log(this.ceshishuju)
          // arrA=[];
          this.ceshishuju.push(arrA.shift()) ;
        }
        // console.log(arrA)
      }, 2000);
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
      text-align: center;
      font-size: 34px;
      margin: 30px 0 0 0;
    }
    .title-bot {
        border-bottom: 20px solid rgb(242, 242, 242);
        // margin-bottom: 30px;
        margin-top: -30px;
        text-align: center;
        padding-bottom: 20px;
        font-size: 13px;
      }
    .join-step {
      margin-bottom: 30px;
      background: rgb(247,250,255);
      padding: 30px 0;
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
              border-radius: 50%;
              height: 40px;
              width: 40px;
              text-align: center;
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
      background: rgb(247,250,255);
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
          // overflow-x: scroll;
          .marquee-list {
            .marquee-item {
              display: flex;
              float: left;
              width: 220px;
              text-align: center;
              margin: 0 20px;
              color: #797979;
              font-size: 16px;
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
    .protocol {
      color: #0099ff;
      margin-top: 50px;
      text-align: center;
      span {
        cursor: pointer;
        &:hover {
          text-decoration: underline;
        }
      }
    }
    .huiyuanzhichi{
      .zhichi{
        display: flex;
        justify-content: space-around;
        align-items: center;
        padding: 0 50px ;
        >div{
          &:nth-of-type(2n){
            font-weight: 700;
            font-size: 32px;
            color: #333;
            margin-top: -40px;

          }
          >div{
            &:nth-of-type(2){
              font-size: 14px;
              color: #797979;
              text-align: center;
              >div{
                margin-top: 10px;
              }
            }
          }
        }
      }
    }
    // .ydong{
    //   // overflow: hidden;
    //   height: 56px;
    //   // display: flex;
    // }
  }
}
</style>
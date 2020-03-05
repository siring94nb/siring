<template>
  <div class="join">
    <myheader />
    <join-enter />

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
            <p>
              收益分红
              <span @click="centerDialogVisible = true">&lt;收益预测&gt;</span>
            </p>
          </div>
        </div>
      </div>

      <div class="new-member">
        <h3 class="title">他们已申请成为城市合伙人</h3>
        <div class="new-member-box">
          <div class="img">
            <img :src="require('@/assets/images/u4734.png')" alt />
          </div>
          <div class="marquee">
            <ul class="marquee-list clearfix" style="width: 5000px">
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

      <div class="sel-city">
        <h3 class="sel-title">请缴费申请等级城市</h3>
        <div class="sel-cont">
          <el-form ref="ruleForm" :model="ruleForm" :rules="rule" label-width="120px">
            <el-form-item label="选择加盟城市：">
              <el-select
                v-model="ruleForm.provVal"
                style="width: 217px;"
                placeholder="请选择"
                @change="provChange"
              >
                <el-option v-for="item in prov" :key="item.id" :label="item.name" :value="item.id"></el-option>
              </el-select>
              <el-select
                v-model="ruleForm.cityVal"
                style="width: 217px;"
                placeholder="请选择"
                @change="cityChange($event)"
              >
                <el-option
                  v-for="(item,index) in city"
                  :key="index"
                  :label="item.name"
                  :value="item.id"
                ></el-option>
              </el-select>
              <el-input style="width: 217px;" v-model="level" placeholder="请等待" :disabled="true" value=""></el-input>
            </el-form-item>
            <el-form-item label="我的优势：" prop="textarea">
              <el-input
                type="textarea"
                :rows="3"
                style="width: 692px;"
                maxlength="100"
                show-word-limit
                placeholder="说明下自己的优势"
                v-model="ruleForm.textarea"
              ></el-input>
            </el-form-item>
          </el-form>
        </div>
      </div>
      
    </div>
    <myfooter />

    <!-- 收益预测弹窗 -->
    <el-dialog title="温馨提示" :visible.sync="centerDialogVisible" width="60%" center>
      <div class="table-box">
        <el-table :data="tableData" border style="width: 100%">
          <el-table-column prop="title" label="等级名称" align="center"></el-table-column>
          <el-table-column label="费用标准" align="center">
            <template slot-scope="scope">{{scope.row.money}}元/年</template>
          </el-table-column>
          <el-table-column label="登记政策" align="center">
            <template slot-scope="scope">
              <span v-html="scope.row.policy"></span>
            </template>
          </el-table-column>
          <el-table-column prop="forecast" label="收益预测" align="center"></el-table-column>
        </el-table>
      </div>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="centerDialogVisible = false">知道了</el-button>
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
</template>

<script>
import Myheader from "@/components/header";
import JoinEnter from "@/components/join/cmp";
import Myfooter from "@/components/footer";
import PaymentBar from "@/components/join/paymentBar";
import {
  GetProvince,
  GetCityList,
  GetLevelList,
  CityOrderAdd,
  Payment,
  GetDiscount,
  GetProfit
} from "@/api/api";
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
      stepFlag: 0,
      centerDialogVisible: false,
      tableData: [],
      prov: [],
      level: '',
      city: [],
      rule: {
        textarea: [
          {
            required: true,
            message: "请说明自己的优势",
            trigger: "blur"
          }
        ]
      },
      ruleForm: {
        textarea: "",
        provVal: "",
        levelVal: "",
        cityVal: ""
      },
      showPaymentFlag: false,
      needCodeDialog: true, //需要显示扫码弹窗
      price: 0,
      percent: 100,
      num: 1,
      payway: {
        way: 1
      },
      wayRule: {
        way: [
          {
            required: true,
            message: "请选择支付方式",
            trigger: "change"
          }
        ]
      },
      payqrcode: "",
      user_id: 0,
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
    init() {
      this.user_id = JSON.parse(sessionStorage.getItem("user_id"));
      this.getProvince();
      this.openhuadong();
      // this.getLevelList();
      // this.getdiscount();
      // this.getProfit();
    },
    stepMouseEnter(index) {
      this.stepFlag = index;
    },
    // 获取省
    getProvince() {
      GetProvince().then(res => {
        let { code, data, msg } = res;
        if (code === 1) {
          this.prov = data;
        }
      });
    },
    // 改变省，获取市区
    provChange() {
      // 清空县市 隐藏结算框
      this.ruleForm.cityVal = "";
      this.ruleForm.levelVal = "";
      this.level ="";
      this.showPaymentFlag = false;
      // if (this.ruleForm.levelVal) {
      this.getCityList();
      // }
    },
    // 市区
    getCityList() {
      GetCityList({
        pid: this.ruleForm.provVal
        // type: this.ruleForm.levelVal
      }).then(res => {
        let { code, data, msg } = res;
        console.log(res);
        if (code === 1) {
          this.city = data;
          console.log(this.level);
        }
      });
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
    },
    getLevelList(num) {
      GetLevelList().then(res => {
        let { code, data, msg } = res;
        if (code === 1) {
          this.showPaymentFlag = true;
          switch (num) {
            case 0:
              this.price = data[3].money
              break;
            case 1:
              this.price = data[0].money
              break;
            case 2:
              this.price = data[1].money
              break;
            default:
             this.price = data[2].money
          }
        }
        this.level = this.ruleForm.levelVal==0?'特级城市':this.ruleForm.levelVal==1?'一级城市':this.ruleForm.levelVal==2?'二级城市':this.ruleForm.levelVal==''?'':'三级城市'
      });
    },
    // levelChange(name) {
    //   // if (this.ruleForm.provVal) {
    //   //   this.getCityList();
    //     // 更新价格
    //     // this.price = this.level[this.ruleForm.levelVal].money;
    //     // 清空县市 隐藏结算框
    //   //   this.ruleForm.cityVal = "";
    //   //   this.showPaymentFlag = false;
    //   // } else {
    //   //   this.$message({
    //   //     message: "请选择加盟城市！",
    //   //     type: "warning"
    //   //   });
    //   // }
    //   console.log(this.level)
    // },

    cityChange(obj) {
      this.showPaymentFlag = false;
      for (let i = 0; i < this.city.length; i++) {
        if ((obj = this.city[i].id)) {
          this.ruleForm.levelVal = this.city[i].type;
        }
      }
      // console.log(this.ruleForm.levelVal);
      this.getLevelList(this.ruleForm.levelVal);
      //  this.levelChange();
    },
    numChange(value) {},

    pay() {
      let vm = this;
      this.$refs["ruleForm"].validate(valid => {
        if (valid) {
          CityOrderAdd({
            city_id: vm.ruleForm.cityVal,
            con: vm.ruleForm.textarea,
            num: vm.num,
            price: vm.total,
            user_id: vm.user_id
          }).then(res => {
            let { code, data, msg } = res;
            if (code === 1) {
              // vm.showPayWayFlag = true; //显示扫码弹窗
              // vm.$refs.paymentbar.getOrderId(data);
              // vm.$refs.paymentbar.selectway(); // 执行子组件 选择支付方法
              vm.$router.push({
                name: "comboPay",
                params: {
                  order_amount: vm.total,
                  user_id: vm.user_id,
                  id: data,
                  order_type: 7
                }
              });
            } else {
              this.$message.error(msg);
            }
          });
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
    getNum(value) {
      this.num = value;
    },
    getProfit() {
      GetProfit({ type: 2 }).then(res => {
        let { msg, code, data } = res;
        console.log(res)
        if (code === 1) {
          this.tableData = data;
        }
      });
    }
  }
};
</script>

<style lang="scss">
.el-table__row {
  td {
    text-align: left;
  }
}
</style>
<style scoped lang='scss'>
.join {
  margin-top: 100px;
  .join-cont {
    width: 1200px;
    margin: 0 auto 80px;
    .title {
      height: 100px;
      line-height: 100px;
      // border-bottom: 20px solid rgb(242, 242, 242);
      text-align: center;
      font-size: 34px;
      // margin-bottom: 30px;
    }
    .join-step {
      margin-bottom: 30px;
      background: rgb(247,250,255);
      padding: 20px 0;
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
      margin-bottom: 50px;
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
          p {
            margin-top: 10px;
            color: #797979;
            font-size: 14px;
            span {
              color: #66ccff;
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
    .sel-city {
      .sel-title {
        text-align: center;
        font-size: 24px;
        color: #333333;
        margin-bottom: 30px;
      }
      .sel-cont {
        width: 70%;
        margin: 0 auto;
        .el-select {
          margin-right: 20px;
          &:last-of-type {
            margin-right: 0;
          }
        }
        .el-textarea {
          width: 692px;
        }
      }
    }
  }
  .new-member {
      background: rgb(247,250,255);
      padding-bottom: 30px;
      margin-bottom: 30px;
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
  .payment {
    display: none;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    height: 80px;
    background-color: rgb(204, 235, 248);
    &.show {
      display: block;
    }
    .payment-inner {
      float: right;
      display: flex;
      align-items: baseline;
      margin-top: 10px;
      margin-right: 40px;
      .bgw {
        background-color: #ffffff;
        padding: 10px 30px;
        color: #ff0000;
        min-width: 120px;
        box-sizing: border-box;
      }
      .symbol {
        margin: 0 20px;
      }
      .el-button {
        margin-left: 20px;
      }
      .tip {
        font-size: 14px;
        color: #999999;
        text-align: center;
        margin-top: 5px;
        .ques {
          display: inline-block;
          width: 20px;
          height: 20px;
          line-height: 20px;
          text-align: center;
          border-radius: 50%;
          background-color: #ff0000;
          color: #ffffff;
          cursor: pointer;
        }
      }
    }
  }
  .code-box {
    text-align: center;
    img {
      width: 300px;
      height: 300px;
    }
  }
}
</style>
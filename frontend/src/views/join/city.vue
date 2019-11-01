<template>
  <div class="join">
    <myheader />
    <join-enter />
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
            <p>
              收益分红
              <span @click="centerDialogVisible = true">&lt;收益预测&gt;</span>
            </p>
          </div>
        </div>
      </div>

      <div class="sel-city">
        <h3 class="sel-title">城市合伙人支持</h3>
        <div class="sel-cont">
          <el-form ref="ruleForm" :model="ruleForm" :rules="rule" label-width="120px">
            <el-form-item label="选择加盟城市：">
              <el-select v-model="ruleForm.provVal" placeholder="请选择" @change="provChange">
                <el-option v-for="item in prov" :key="item.id" :label="item.name" :value="item.id"></el-option>
              </el-select>
              <el-select v-model="ruleForm.levelVal" placeholder="请选择" @change="levelChange">
                <el-option
                  v-for="item in level"
                  :key="item.sort"
                  :label="item.title"
                  :value="item.sort"
                ></el-option>
              </el-select>
              <el-select v-model="ruleForm.cityVal" placeholder="请选择" @change="cityChange">
                <el-option v-for="item in city" :key="item.id" :label="item.name" :value="item.id"></el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="我的优势：" prop="textarea">
              <el-input
                type="textarea"
                :rows="3"
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
          <el-table-column prop="name" label="等级名称" align="center"></el-table-column>
          <el-table-column prop="cost" label="费用标准" align="center"></el-table-column>
          <el-table-column prop="policy" label="登记政策" align="center">
            <template slot-scope="scope">
              <span v-html="scope.row.policy"></span>
            </template>
          </el-table-column>
          <el-table-column prop="income" label="收益预测" align="center"></el-table-column>
        </el-table>
      </div>
      <span slot="footer" class="dialog-footer">
        <el-button type="primary" @click="centerDialogVisible = false">知道了</el-button>
      </span>
    </el-dialog>

    <!-- 结算 -->
    <div :class="{payment: true, show: showPaymentFlag}">
      <div class="payment-inner">
        <div>费用：</div>
        <div>
          <div class="bgw">￥{{price}}</div>
          <p class="tip">金额</p>
        </div>
        <div class="symbol">×</div>
        <div>
          <div class="bgw">{{percent}}%</div>
          <p class="tip">
            会员折扣
            <span class="ques">？</span>
          </p>
        </div>
        <div class="symbol">×</div>
        <el-input-number
          v-model="num"
          controls-position="right"
          @change="numChange"
          :min="1"
          :max="10"
        ></el-input-number>
        <div class="symbol">=</div>
        <div>
          <div class="bgw">￥{{total}}</div>
        </div>
        <el-button type="danger" @click="pay">立即支付</el-button>
      </div>
    </div>

    <!-- 选择支付方式 -->
    <el-dialog title="选择支付方式" :visible.sync="showPayWayFlag" width="500px" center>
      <el-form ref="payway" :model="payway" :rules="wayRule" label-width="80px">
        <el-form-item label="支付方式" prop="way">
          <el-radio-group v-model="payway.way" @change="selectway">
            <el-radio :label="1">微信</el-radio>
            <el-radio :label="2">支付宝</el-radio>
          </el-radio-group>
        </el-form-item>
      </el-form>
      <div class="code-box">
        <img :src="payqrcode" alt />
      </div>

      <span slot="footer" class="dialog-footer">
        <el-button @click="showPayWayFlag = false">取 消</el-button>
        <el-button type="primary" @click="showPayWayFlag = false">确 定</el-button>
      </span>
    </el-dialog>
  </div>
</template>

<script>
import Myheader from "@/components/header";
import JoinEnter from "@/components/join/cmp";
import Myswiper from "@/components/mySwiper";
import Myfooter from "@/components/footer";
import {
  GetProvince,
  GetCityList,
  GetLevelList,
  CityOrderAdd,
  Payment,
  GetDiscount
} from "@/api/api";
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
      tableData: [
        {
          name: "特级城市",
          cost: "5000元/年",
          policy:
            "<p>1.保底佣金：该城市内所有会员消费提成15%</p><p>2.达标佣金：个人发展的会员（除普通会员外），达到一定用户数，还另外奖励5%</p>",
          income: "约50万"
        }
      ],
      prov: [],
      level: [],
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
      num: 1,
      price: 0,
      percent: 100,
      showPayWayFlag: false,
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
      orderId: "",
      payqrcode: ""
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
      this.getProvince();
      this.getLevelList();
      this.getdiscount();
    },
    stepMouseEnter(index) {
      this.stepFlag = index;
    },
    getProvince() {
      GetProvince().then(res => {
        let { code, data, msg } = res;
        if (code === 1) {
          this.prov = data;
        }
      });
    },
    getLevelList() {
      GetLevelList().then(res => {
        let { code, data, msg } = res;
        if (code === 1) {
          this.level = data;
        }
      });
    },
    levelChange(name) {
      if (this.ruleForm.provVal) {
        this.getCityList();
        // 更新价格
        this.price = this.level[this.ruleForm.levelVal].money;
        // 清空县市 隐藏结算框
        this.ruleForm.cityVal = "";
        this.showPaymentFlag = false;
      } else {
        this.$message({
          message: "请选择加盟城市！",
          type: "warning"
        });
      }
    },
    provChange() {
      if (this.ruleForm.levelVal) {
        this.getCityList();
      }
    },
    cityChange() {
      this.showPaymentFlag = true;
    },
    numChange(value) {},
    getCityList() {
      GetCityList({
        pid: this.ruleForm.provVal,
        type: this.ruleForm.levelVal
      }).then(res => {
        let { code, data, msg } = res;
        if (code === 1) {
          this.city = data;
        }
      });
    },
    pay() {
      this.$refs["ruleForm"].validate(valid => {
        if (valid) {
          this.showPayWayFlag = true;
          CityOrderAdd({
            grade: this.ruleForm.cityVal,
            con: this.ruleForm.textarea,
            num: this.num,
            price: this.total,
            user_id: 1
          }).then(res => {
            let { code, data, msg } = res;
            if (code === 1) {
              this.orderId = data;
              this.selectway();
            }
          });
        }
      });
    },
    selectway() {
      this.$refs["payway"].validate(valid => {
        if (valid) {
          Payment({
            type: this.payway.way,
            order_id: this.orderId
          }).then(res => {
            let { code, imgData, msg } = res;
            if (code === 1) {
              this.payqrcode = imgData;
            }
          });
        }
      });
    },
    getdiscount() {
      let data = new FormData();
      data.append("id", 31);
      GetDiscount(data).then(res => {
        let { code, data, msg } = res;
        if (code === 1) {
          this.percent = data.user_discount;
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
        }
        .el-textarea {
          width: 692px;
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
  .code-box{
    text-align: center;
    img{
      width: 300px;
      height: 300px;
    }
  }
}
</style>
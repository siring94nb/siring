<template>
  <div class="join">
    <myheader />
    <join-enter />

    <div class="join-cont">
      <h2 class="title title-bot">分包商</h2>
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
        <h3 class="support-title">分包商工作规范</h3>
        <div class="support-list">
          <div class="support-item">
            <img :src="require('@/assets/images/u5187.png')" alt />
            <p>严格而又标准化的</p>
            <p>开发设计要求</p>
          </div>
          <div class="symbol">+</div>
          <div class="support-item">
            <img :src="require('@/assets/images/u5188.png')" alt />
            <p>分包前的详细咨询分析</p>
            <p>和任务分派</p>
          </div>
          <div class="symbol">+</div>
          <div class="support-item">
            <img :src="require('@/assets/images/u5189.png')" alt />
            <p>平台严格的代码检测和</p>
            <p>质量评估</p>
          </div>
          <div class="symbol">=</div>
          <div class="support-item">
            <img :src="require('@/assets/images/u5190.png')" alt />
            <p>验收合格平台给予分包</p>
            <p>
              酬金奖励
              <span @click="centerDialogVisible = true">&lt;收益预测&gt;</span>
            </p>
          </div>
        </div>
      </div>

      <div class="new-member">
        <h3 class="title">他们已申请成为分包商</h3>
        <div class="new-member-box">
          <div class="img">
            <img :src="require('@/assets/images/u4734.png')" alt />
          </div>
          <div class="marquee">
            <ul class="marquee-list clearfix" style="width: 5000px">
              <li class="marquee-item" v-for="(item,index) in ceshishuju" :key="index">
                <img style="width:43px;height:43px;" :src="item.img" alt />
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
        <h3 class="sel-title">缴纳押金申请分包</h3>
        <div class="sel-cont">
          <el-form ref="ruleForm" :model="ruleForm" label-width="120px">
            <el-form-item
              v-for="(skill, index) in ruleForm.selectSkills"
              :label="'我的专业技能' + (index+1)"
              :key="index"
              :prop="'selectSkills.' + index + '.skillValue'"
              :rules="{required: true, message: '技能不能为空', trigger: 'blur'}"
            >
              <el-select
                v-model="skill.skillValue"
                @change="skillChange(skill.skillValue, index)"
                placeholder="请选择"
              >
                <el-option v-for="i in ruleForm.skills" :key="i.id" :label="i.title" :value="i.id"></el-option>
              </el-select>
              <el-select v-model="skill.lang" placeholder="请选择" @change="langChange">
                <el-option v-for="i in ruleForm.langs" :key="i" :label="i" :value="i"></el-option>
              </el-select>
              <el-button @click.prevent="removeNewSkill(index)" v-if="index!==0">删除</el-button>
            </el-form-item>
            <el-form-item>
              <el-button
                style="margin-left:0px;border:1px solid rgb(14,144,210);color:rgb(14,144,210);width:455px; margin-bottom:30px;"
                @click="addNewSkill"
                v-if="ruleForm.selectSkills.length < 2"
              >再添加一档（可选项，每人最多添加二档）</el-button>
            </el-form-item>
            <!-- 上传 -->
            <!-- <el-form-item> -->
            <el-upload
              v-if="dis"
              name="image"
              class="upload-demo"
              drag
              :show-file-list="false"
              action="https://manage.siring.com.cn/api/file/qn_upload"
              :on-success="handleAvatarSuccess"
              multiple
              style="margin-top: -150px;margin-left: 700px"
            >
              <i class="el-icon-upload"></i>
              <div class="el-upload__text">
                上传证明材料（如介绍等）
                <em>点击上传</em>
              </div>
            </el-upload>
            <!-- </el-form-item> -->
            <div class="wenjian" v-if="!dis">
              <span>
                <!-- <img :src="require('../../assets/images/头像 (2).png')" alt=""> -->
                <span><i class="iconfont icon-Upload"></i></span>
                <!-- <br/> -->
                <!-- <span>{{fileName}}</span> -->
                <span>已上传</span>
              </span>
              <span>
                <span @click.stop="dis=true">修改</span><span @click.stop="dis=true">删除</span>
              </span>
            </div>
            <el-form-item
              label="我的优势："
              :rules="{ required: true, message: '请说明自己的优势', trigger: 'blur'}"
              prop="textarea"
            >
              <el-input
                type="textarea"
                :rows="3"
                style="width: 780px;"
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
    <!-- 收益预测弹窗 -->
    <el-dialog title="温馨提示" :visible.sync="centerDialogVisible" width="60%" center>
      <el-alert
        title="满三年后，如无在开发以及维护期内项目可申请全额退押金"
        type="warning"
        style="margin-bottom: 10px;"
        :closable="false"
      ></el-alert>
      <div class="table-box">
        <el-table :data="tableData" border style="width: 100%">
          <el-table-column prop="title" label="专业技能" align="center"></el-table-column>
          <el-table-column label="押金标准" align="center">
            <template slot-scope="scope">{{scope.row.money}}元/年</template>
          </el-table-column>
          <el-table-column prop="policy" label="开发语言半角“,”隔开" align="center">
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
  </div>
</template>

<script>
import Myheader from "@/components/header";
import JoinEnter from "@/components/join/cmp";
import Myfooter from "@/components/footer";
import { GetJoinClass, GetJoinList, JoinOrderAdd, GetProfit } from "@/api/api";
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
          name: "选择专业技能",
          desc: "部分任务分配给专业技能人士或团体开发，并提供相应报酬"
        },
        {
          name: "缴费申请",
          desc: "为保障开发质量和要求，您需要缴纳一定数额的押金"
        },
        {
          name: "成为分包商",
          desc: "一旦升级为分包商后，您的账号将会有分包商图标显示"
        }
      ],
      stepFlag: 0,
      centerDialogVisible: false,
      tableData: [],
      ruleForm: {
        textarea: "",
        skills: [],
        langs: [],
        selectSkills: [
          {
            skillValue: "",
            lang: ""
          }
        ]
      },
      price: 0,
      showPaymentFlag: false,
      num: 1,
      percent: 100,
      needCodeDialog: true, //需要显示扫码弹窗
      ceshishuju: [
        {
          img: require("@/assets/images/u1920.png"),
          huiyuan: "重庆会员1",
          yaoqma: "JU4523"
        },
        {
          img: require("@/assets/images/u1920.png"),
          huiyuan: "重庆会员2",
          yaoqma: "JU4523"
        },
        {
          img: require("@/assets/images/u1920.png"),
          huiyuan: "重庆会员3",
          yaoqma: "JU4523"
        },
        {
          img: require("@/assets/images/u1920.png"),
          huiyuan: "重庆会员4",
          yaoqma: "JU4523"
        },
        {
          img: require("@/assets/images/u1920.png"),
          huiyuan: "重庆会员5",
          yaoqma: "JU4523"
        },
        {
          img: require("@/assets/images/u1920.png"),
          huiyuan: "重庆会员6",
          yaoqma: "JU4523"
        },
        {
          img: require("@/assets/images/u1920.png"),
          huiyuan: "重庆会员7",
          yaoqma: "JU4523"
        },
        {
          img: require("@/assets/images/u1920.png"),
          huiyuan: "重庆会员8",
          yaoqma: "JU4523"
        }
      ],
      dis:true,//控制上传位置切换
      fileName:""
    };
  },
  mounted() {
    this.getJoinClass();
    this.getProfit();
    this.openhuadong();
  },
  computed: {
    total() {
      return this.price * (this.percent / 100) * this.num;
    }
  },
  methods: {
    // 文件上传
    handleAvatarSuccess(res, file) {
      if(res.code == 1){
        this.dis = false
        this.fileName = res.data.fileName
      }
      console.log(res)
    },
    // 等级会员左右滑动
    openhuadong() {
      let huadongArr = document.getElementsByClassName("marquee-item");
      let arrA = [];
      let lh = this.ceshishuju.length;
      let marqueeList = document.getElementsByClassName("marquee-list")[0];
      let sum = 0;
      for (let i = 0; i < huadongArr.length; i++) {
        sum += huadongArr[i].offsetWidth + 40;
      }
      marqueeList.style.width = sum + "px";
      let timeO = setInterval(() => {
        // console.log(123123)
        // marqueeList.scrollLeft += 200;
        // console.log(this.ceshishuju.length)
        arrA.push(this.ceshishuju.shift());
        if (this.ceshishuju.length < 4 || this.ceshishuju.length > lh) {
          // this.ceshishuju= arrA;
          // this.ceshishuju.push(arrA);
          // console.log(this.ceshishuju)
          // arrA=[];
          this.ceshishuju.push(arrA.shift());
        }
        // console.log(arrA)
      }, 2000);
    },
    stepMouseEnter(index) {
      this.stepFlag = index;
    },
    addNewSkill() {
      this.ruleForm.selectSkills.push({
        skillValue: "",
        lang: ""
      });
    },
    removeNewSkill(index) {
      this.ruleForm.selectSkills.splice(index, 1);
    },
    getJoinClass() {
      GetJoinClass().then(res => {
        let { code, msg, data } = res.data;
        if (code === 1) {
          this.ruleForm.skills = data;
        }
      });
    },
    getLangList(lang) {
      GetJoinList({ cid: lang }).then(res => {
        console.log(res);
        let { code, msg, data } = res;
        if (code === 1) {
          this.ruleForm.langs = data.res;
          this.price = data.money;
        }
      });
    },
    skillChange(value, index) {
      this.ruleForm.skills.forEach(v => {
        if (value === v.id) {
          this.ruleForm.selectSkills[index].skillValue = v.title;
        }
      });
      this.getLangList(value);
    },
    langChange() {
      this.showPaymentFlag = true;
    },
    pay() {
      this.$refs["ruleForm"].validate(valid => {
        if (valid) {
          JoinOrderAdd({
            user_id: parseInt(sessionStorage.getItem("user_id")),
            skill: this.ruleForm.selectSkills,
            price: this.total,
            con: this.ruleForm.textarea,
            num: this.num,
            price: this.total
          }).then(res => {
            let { code, data, msg } = res;
            console.log(data);
            if (code === 1) {
              console.log(123123);
              this.$router.push({
                name: "comboPay",
                params: {
                  order_amount: this.total,
                  user_id: parseInt(sessionStorage.getItem("user_id")),
                  id: data,
                  order_type: 9
                }
              });
            } else {
              this.$message.error(msg);
            }
          });
        }
      });
    },
    getNum(value) {
      this.num = value;
    },
    getProfit() {
      GetProfit({ type: 3 }).then(res => {
        let { msg, code, data } = res;
        if (code === 1) {
          console.log(data);
          this.tableData = data;
        }
      });
    }
  }
};
</script>
<style>
.join .upload-demo {
  /* margin-top: -150px;
  margin-left: 700px; */
  /* position: relative;
  left: 700px;
  top: -150px; */
  width: 200px;
  height: 100px;
  margin-bottom: 22px;
}
.join .el-upload,
.join .el-upload-dragger {
  width: 200px;
  height: 100px;
}
.join .el-upload-dragger {
  font-size: 16px;
}
.join .el-upload-dragger i {
  margin: 0;
  font-size: 32px;
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
      text-align: center;
      font-size: 34px;
      margin-bottom: 30px;
      &.title-bot {
        border-bottom: 20px solid rgb(242, 242, 242);
      }
    }
    .join-step {
      margin-top: -30px;
      margin-bottom: 50px;
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
              border-color: rgb(25, 158, 216);
              color: rgb(25, 158, 216);
              .step-num {
                color: rgb(25, 158, 216);
              }
            }
            .step-desc {
              display: table-cell;
              vertical-align: middle;
              color: #ffffff;
              background-color: rgb(25, 158, 216);
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
        width: 78%;
        margin: 0 auto;
        .el-select {
          margin-right: 20px;
          &:last-of-type {
            margin-right: 0;
          }
        }
        .el-button {
          margin-left: 10px;
        }
        .el-textarea {
          width: 692px;
        }
      }
    }
    .new-member {
      background: rgb(247, 250, 255);
      padding-bottom: 30px;
      margin-bottom: 30px;
      .title {
        font-size: 28px;
        color: #333333;
        margin-bottom: 0;
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
    .wenjian{
      width: 200px;
      height: 100px;
      border: 1px dashed rgb(64,158,255);
      border-radius: 5px;
      margin-top: -150px;
      margin-left: 700px;
      margin-bottom: 22px;
      padding:10px 20px;
      box-sizing: border-box;
      display: flex;
      align-items: center;
      justify-content: space-between;
      // img{
      //   width: 50px;
      //   height: 50px;
      //   margin-right: 10px;
      // }
      >span{
        &:nth-of-type(1){
          span{
            &:nth-of-type(1){
              display: block;
              width: 60px;
              height: 50px;
              i{
                font-size: 60px;
                color: rgb(64,158,255);
              }
            }
            &:nth-last-of-type(1){
              font-size: 14px;
              text-align: center;
              display: block;
              width: 50px;
              // overflow: hidden;
              // text-overflow: ellipsis;
              // white-space: nowrap; //文本不换行，这样超出一行的部分被截取，显示...
            }
           
          }
        }
        &:last-of-type{
          display: flex;
          flex-direction: column ;
          >span{
            display: block;
            padding: 5px 20px;
            color: #ffffff;
            border-radius: 5px;
            &:nth-of-type(1){
              background: rgb(64,158,255);
            }
            &:nth-of-type(2){
              background: rgb(245,108,108);
              margin-top: 10px;
            }
          }
        }
      }
    }
  }
}
</style>
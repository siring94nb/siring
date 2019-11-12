<template>
  <div class="join">
    <myheader />
    <join-enter />
    <myswiper />

    <div class="join-cont">
      <h2 class="title">分包商</h2>
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

      <div class="sel-city">
        <h3 class="sel-title">缴纳押金申请分包</h3>
        <div class="sel-cont">
          <el-form ref="ruleForm" :model="ruleForm" label-width="120px">
            <el-form-item
              v-for="(skill, index) in ruleForm.skills"
              :label="'我的专业技能' + index"
              :key="skill.key"
              :prop="'skills.' + index + '.value'"
              :rules="{required: true, message: '域名不能为空', trigger: 'blur'}"
            >
              <el-select v-model="skill.value" placeholder="请选择">
                <el-option
                  v-for="item in skill.list"
                  :key="item"
                  :label="item"
                  :value="item"
                ></el-option>
              </el-select>
            </el-form-item>
            <el-form-item>
              <el-button @click="addDomain">新增域名</el-button>
            </el-form-item>
            <el-form-item
              label="我的优势："
              :rules="{ required: true, message: '请说明自己的优势', trigger: 'blur'}"
              prop="textarea"
            >
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
      <el-alert
        title="满三年后，如无在开发以及维护期内项目可申请全额退押金"
        type="warning"
        style="margin-bottom: 10px;"
        :closable="false"
      ></el-alert>
      <div class="table-box">
        <el-table :data="tableData" border style="width: 100%">
          <el-table-column prop="name" label="专业技能" align="center"></el-table-column>
          <el-table-column prop="cost" label="押金标准" align="center"></el-table-column>
          <el-table-column prop="policy" label="开发语言半角“,”隔开" align="center">
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
      tableData: [
        {
          name: "前端开发",
          cost: "100",
          policy: "<p>java,c++,php</p>",
          income: "约50万"
        }
      ],
      ruleForm: {
        textarea: "",
        skills: [
          {
            value: '',
            list: [1,2,3]
          }
        ]
      },
      rule: {
        textarea: [
          {
            required: true,
            message: "请说明自己的优势",
            trigger: "blur"
          }
        ]
      }
    };
  },
  methods: {
    stepMouseEnter(index) {
      this.stepFlag = index;
    },
    addDomain() {
      this.ruleForm.skills.push({
        value: "",
        key: Date.now()
      });
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
}
</style>
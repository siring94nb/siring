<template>
  <div style="width:1300px;">
    <logginHeader>
      <i class="el-icon-edit"></i>
      <span>软件/定制</span>
      <span>&gt;</span>
      <span>我的订单</span>
    </logginHeader>
    <div class="index">
      <div class="detail-top">
        <div class="warnings">
          <!-- <i class="el-icon-warning"></i> -->
          <span style="border:1px solid red;color:red;border-radius:50%;">！</span>
        </div>
        <div class="process">
          <ul>
            <li>每项流程确认完成后才能进入下一流程；</li>
            <li>如有疑问可在最下方与在线客服及时互动；</li>
          </ul>
        </div>
        <div class="day-text">
          距离项目上线还有
          <span class="for-day">_ _</span>
          天
        </div>
      </div>

      <div class="content-reply">
        <template v-for="(item,index) in statusData">
          <div class="content-main" :key="index">
            <div
              class="content-title"
              :class="{'content-sel-color': status - 1 > index}"
            >{{item.name}}</div>
            <div v-if="status - 1 == index">
              <div class="content-tips">
                <img src="../../../assets/images/u3829.png" style="width:100%;height:100%;" alt />
                <div class="content-text">{{item.tips}}</div>
              </div>
              <div class="content-arrow">
                <img src="../../../assets/images/u3830.png" style="width:100%;height:100%;" alt />
              </div>
            </div>
            <div class="content-zip" v-if="status - 1 > index">
              <div class="zip-main">
                <span class="zip-text">预览</span>
                <img style="vertical-align: middle;" src="../../../assets/images/u587.gif" alt />
                <span class="zip-text">下载</span>
                <div>**需求表.zip</div>
              </div>
              <i></i>
            </div>
          </div>
          <div
            class="all-line"
            :class="{'h-line': status - 1 < index + 2, 'g-line' :  status - 1 > index}"
            v-if="index < 6"
          ></div>
          <div
            class="all-line"
            :class="{'h-line': status - 1 < index + 2, 'g-line' : status - 1 > index + 1}"
            v-if="index < 6"
          ></div>
        </template>
      </div>

      <div class="line line-vice">内容/合同/协议/确认文书</div>
      <!-- 定制需求 -->
      <div class="determine-box">
        <div class="dzxq-main" v-if="status == 1">
          <el-form ref="form" :model="form" label-width="110px">
            <el-form-item label="需求名称" required>
              <el-input
                v-model="form.need_name"
                maxlength="10"
                show-word-limit
                placeholder="请输入你的项目名，不超过10个字"
              ></el-input>
            </el-form-item>
            <el-form-item label="需求类型" required>
              <el-select v-model="form.need_category" placeholder="请选择">
                <el-option label="智能硬件" value="1"></el-option>
                <el-option label="电子商务" value="2"></el-option>
              </el-select>
            </el-form-item>
            <el-form-item label="需求预算" required>
              <el-col :span="10">
                <el-form-item prop="min">
                  <el-input type="text" v-model.number="form.need_budget_down"></el-input>
                </el-form-item>
              </el-col>
              <el-col class="unit" :span="1">元</el-col>
              <el-col class="lines" :span="2">-</el-col>
              <el-col :span="10">
                <el-form-item prop="max">
                  <el-input type="text" v-model.number="form.need_budget_up"></el-input>
                </el-form-item>
              </el-col>
              <el-col class="unit" :span="1">元</el-col>
            </el-form-item>
            <el-form-item label="开发终端">
              <el-checkbox-group v-model="form.need_terminal">
                <el-checkbox v-for="item in typeList" :key="item.id" :label="item.name" name="type">
                  <div class="terminal">
                    <i :class="item.className"></i>
                    <p>{{ item.name }}</p>
                  </div>
                </el-checkbox>
              </el-checkbox-group>
            </el-form-item>
            <el-form-item label="联系方式">
              <el-row style="margin-bottom: 10px;">
                <el-col :span="12">
                  <el-form-item label="手机号" required>
                    <el-input type="text" v-model.number="form.need_phone"></el-input>
                  </el-form-item>
                </el-col>
                <el-col :span="12">
                  <el-form-item label="QQ号">
                    <el-input type="text" v-model.number="form.need_qq"></el-input>
                  </el-form-item>
                </el-col>
              </el-row>
              <el-row>
                <el-col :span="12">
                  <el-form-item label="微信号">
                    <el-input type="text" v-model.number="form.need_wx"></el-input>
                  </el-form-item>
                </el-col>
                <el-col :span="12">
                  <el-form-item label="其他联系方式">
                    <el-input type="text" v-model.number="form.need_other"></el-input>
                  </el-form-item>
                </el-col>
              </el-row>
            </el-form-item>
            <el-form-item label="需求描述" required>
              <el-input type="textarea" :rows="4" v-model="form.need_desc"></el-input>
            </el-form-item>
            <el-form-item label="添加附件" required>
              <el-upload
                class="upload-demo"
                :action="UploadAction"
                :on-remove="handleRemove"
                :before-upload="beforeUpload"
                :on-success="handleSuccess"
                :limit="1"
                :on-exceed="handleExceed"
                :file-list="fileList"
                name="image"
              >
                <el-button size="small" type="primary">点击上传</el-button>
                <div
                  slot="tip"
                  class="el-upload__tip"
                >最多上传一个文件，多个文件可使用压缩格式；支持txt、ppt、pptx、doc、docx、xls、xlsx、pdf、png、jpg、jpeg，RAR，ZIP附件大小不超过50M。</div>
              </el-upload>
            </el-form-item>
            <el-form-item>
              <el-button type="primary" style="float:right;">确定修改</el-button>
            </el-form-item>
          </el-form>
        </div>
        <div class="ptbj-box" v-if="status == 2">
          <img src="../../../assets/images/u4198.png" width="100%" alt />
        </div>
      </div>
      <div class="line line-vice">平台顾问信息互动</div>
      <!-- 聊天 -->
      <div class="speak_window">
        <div class="speak_box">
          <div class="answer">
            <div class="heard_img left">
              <img src="../../../assets/images/u3830.png" />
              <div>平台顾问</div>
            </div>
            <div class="answer_text">
              <p>fdgfdgfdg</p>
              <i></i>
            </div>
          </div>
          <div class="question">
            <div class="heard_img right">
              <img src="../../../assets/images/u3830.png" />
            </div>
            <div class="question_text clear">
              <p>dgfdgdfgdfg</p>
              <i></i>
            </div>
          </div>
        </div>
        <div class="input-box">
          <Input v-model="value" placeholder="请输入信息(100字以内)..." style="width: 90%;" />
          <button class="lt-btn">发送</button>
        </div>
      </div>
      <div class="obj-btn">
        <div class="btns-all stop-obj" @click="stop_obj(1)">中止，本人放弃该项目</div>
        <div style="flex:1;"></div>
        <div class="btns-all start-obj" @click="stop_obj(2)">确定，本人已确认该需求方案</div>
      </div>
    </div>
  </div>
</template>
<script>
import logginHeader from "@/components/logginHeader";
import { needOrderList } from "@/api/api";
export default {
  data() {
    return {
      userId: "",
      path: "ws://127.0.0.1:3000",
      status: 1,
      socket: "",
      statusData: [
        {
          url: "",
          name: "定制需求",
          tips: "等待需求确认"
        },
        {
          url: "",
          name: "平台报价",
          tips: "等待平台报价及确认"
        },
        {
          url: "",
          name: "签订合同",
          tips: "等待签订合同"
        },
        {
          url: "",
          name: "原型/UI确认",
          tips: "等待原型确认"
        },
        {
          url: "",
          name: "项目上线",
          tips: "等待开发完成"
        },
        {
          url: "",
          name: "项目验收",
          tips: "等待项目验收"
        },
        {
          url: "",
          name: "项目年服务",
          tips: "等待确认服务"
        }
      ],
      form: {
        need_name: "",
        need_category: "",
        need_budget_down: "",
        need_budget_up: "",
        need_terminal: [],
        need_phone: "",
        need_qq: "",
        need_wx: "",
        need_other: "",
        need_desc: "",
        need_file: ""
      },
      typeList: [
        {
          className: "iconfont icon-gongyinglian",
          name: "原型UI",
          id: 1
        },
        {
          className: "iconfont icon-shezhi-",
          name: "后台",
          id: 2
        },
        {
          className: "iconfont icon-diannao",
          name: "PC",
          id: 3
        },
        {
          className: "iconfont icon-h5",
          name: "移动H5",
          id: 4
        },
        {
          className: "iconfont icon-pingguo",
          name: "APP苹果",
          id: 5
        },
        {
          className: "iconfont icon-anzhuologo",
          name: "APP安卓",
          id: 6
        },
        {
          className: "iconfont icon-weixinxiaochengxu",
          name: "小程序",
          id: 7
        }
      ],
      UploadAction: "",
      fileList: []
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.userId = JSON.parse(sessionStorage.getItem("user_id"));
      // this.status = this.$route.params.status;
      // this.id = this.$route.params.id;
      if (typeof WebSocket === "undefined") {
        alert("您的浏览器不支持socket");
      } else {
        // 实例化socket
        this.socket = new WebSocket(this.path);
        // 监听socket连接
        this.socket.onopen = this.open;
        // 监听socket错误信息
        this.socket.onerror = this.error;
        // 监听socket消息
        this.socket.onmessage = this.getMessage;
      }

      var x = 3;
      var y = 1;
      this.rand = parseInt(Math.random() * (x - y + 1) + y);
    },
    open() {
      console.log("socket连接成功");
      var login_data = this.rand + ":我的蝴蝶花";
      ws.send(JSON.stringify(login_data));
    },
    error() {
      console.log("连接错误");
    },
    getMessage(msg) {
      console.log(msg.data);
      var d = JSON.parse(msg.data);
      if (d.type == "msg") {
      }
    },
    send() {
      var login_data = this.rand + ":我的蝴蝶花2";
      this.socket.send(login_data);
    },
    close() {
      console.log("socket已经关闭");
    },
    handleSuccess(response, file, fileList) {
      this.form.need_file = response.data.filePath;
    },
    handleRemove(file, fileList) {
      this.form.need_file = "";
    },
    handleExceed(files, fileList) {
      this.$message.warning(
        `当前限制选择 3 个文件，本次选择了 ${
          files.length
        } 个文件，共选择了 ${files.length + fileList.length} 个文件`
      );
    },
    beforeUpload(file) {
      const size = file.size / 1024 / 1024 < 50;
      if (!size) {
        this.$message.error("上传文件大小不能超过50M！");
      }
      return size;
    },
    stop_obj(e) {
      console.log(e);
      let hr,hr1;
      if (e == 1) {
        hr = "您确定要中止该项目么？！";
      } else {
        hr = "1、需求方案务必与平台顾问详细核实比对；";
        hr1 = "2、平台报价将依据您的需求方案进行报价。";
      }
      const h = this.$createElement;
      this.$msgbox({
        title: "温馨提示：",
        message: h("div", null, [
          h("p", null, hr),
          h("p", null, hr1)
        ]),
        showCancelButton: true,
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        center: true,
        beforeClose: (action, instance, done) => {
          if (action === "confirm") {
            instance.confirmButtonLoading = true;
            instance.confirmButtonText = "执行中...";
            setTimeout(() => {
              done();
              setTimeout(() => {
                instance.confirmButtonLoading = false;
              }, 300);
            }, 3000);
          } else {
            done();
          }
        }
      }).then(action => {
        this.$message({
          type: "info",
          message: "action: " + action
        });
      });
    },
    start_obj() {}
  },
  destroyed() {
    // 销毁监听
    this.socket.onclose = this.close;
  },
  components: {
    logginHeader
  }
};
</script>

<style lang="scss" scoped>
.index {
  background: #ffffff;
  margin: 10px 0 0 20px;
  padding: 15px;
  .line {
    font-weight: 700;
    margin-top: 20px;
    font-size: 16px;
  }
  .line-marst {
    background-color: rgb(242, 242, 242);
    color: #000;
  }
  .line-vice {
    background-color: rgb(207, 234, 239);
    color: rgb(47, 121, 164);
  }
  .detail-top {
    display: flex;
    align-items: center;
    padding-bottom: 15px;
    border-bottom: 1px solid rgb(201, 201, 201);
    .warnings {
      margin-right: 15px;
    }
    .process {
      border: 1px dotted #000 !important;
      border-radius: 5px;
      padding: 10px;
      font-size: 13px;
      color: #333333;
      ul {
        line-height: 18px;
        list-style: disc;
        padding-left: 10px;
      }
    }
    .day-text {
      font-weight: 700;
      font-size: 18px;
      color: #363636;
      margin-left: 15%;
      .for-day {
        background-color: #000;
        color: #ffffff;
        display: inline-block;
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 36px;
      }
    }
  }
  .determine-box {
    height: 600px;
    border: 1px solid rgb(240, 248, 250);
    overflow-y: scroll;
    .dzxq-main {
      padding: 20px;
      .lines,
      .unit {
        text-align: center;
      }
      .terminal {
        display: inline-block;
        text-align: center;
        vertical-align: middle;
      }
    }
  }
  //流程
  .content-reply {
    display: flex;
    justify-content: center;
    margin-top: 30px;
    .content-main {
      text-align: center;
      width: 122px;
      .content-title {
        width: 122px;
        height: 33px;
        line-height: 33px;
        background: inherit;
        background-color: rgba(161, 161, 161, 1);
        border: none;
        border-radius: 63px;
        font-weight: 700;
        font-style: normal;
        font-size: 16px;
        color: #ffffff;
        text-align: center;
      }
      .content-sel-color {
        background-color: rgb(102, 153, 0);
      }
      .content-zip {
        box-sizing: border-box;
        position: relative;
        display: table-cell;
        padding-top: 10px;
        min-height: 60px;
        .zip-main {
          background-color: rgb(242, 242, 242);
          width: 122px;
          height: 75px;
          border-radius: 5px;
          background-color: rgb(242, 242, 242);
          padding-top: 15px;
          .zip-text {
            color: rgb(0, 51, 102);
            line-height: 16px;
          }
        }
      }
      .content-zip i {
        width: 0;
        height: 0;
        border-left: 12px solid transparent;
        border-right: 12px solid transparent;
        position: absolute;
        top: 0;
        border-bottom: 10px solid rgb(242, 242, 242);
        left: 45%;
      }
      .content-tips {
        width: 125px;
        height: 85px;
        position: relative;
        .content-text {
          position: absolute;
          color: red;
          top: 32px;
          // left: 15px;
          text-align: center;
          width: 125px;
          font-size: 16px;
        }
      }
      .content-arrow {
        width: 40px;
        height: 40px;
        margin: auto;
      }
    }
    .all-line {
      height: 3px;
      width: 18px;
      margin-top: 15px;
    }
    .g-line {
      background-color: rgb(102, 153, 0) !important;
    }
    .h-line {
      background-color: rgb(161, 161, 161);
    }
    .line-w {
      width: 36px;
    }
  }
  //聊天框

  .speak_window {
    overflow-y: scroll;
    height: 100%;
    width: 100%;
    background-color: rgb(242, 242, 242);
  }
  .speak_box {
    margin-bottom: 70px;
    padding: 10px;
  }
  .question,
  .answer {
    margin-bottom: 1rem;
  }
  .question {
    text-align: right;
  }
  .question > div {
    display: inline-block;
  }
  .left {
    float: left;
  }
  .right {
    float: right;
  }
  .clear {
    clear: both;
  }
  .heard_img {
    height: 60px;
    width: 60px;
    border-radius: 5px;
    // overflow: hidden;
    background: #ddd;
    div {
      text-align: center;
    }
  }
  .heard_img img {
    width: 100%;
    height: 100%;
  }
  .question_text,
  .answer_text {
    box-sizing: border-box;
    position: relative;
    display: table-cell;
    min-height: 60px;
  }
  .question_text {
    padding-right: 20px;
  }
  .answer_text {
    padding-left: 20px;
  }
  .question_text p,
  .answer_text p {
    border-radius: 10px;
    padding: 0.5rem;
    margin: 0;
    font-size: 14px;
    line-height: 28px;
    box-sizing: border-box;
    vertical-align: middle;
    display: table-cell;
    height: 30px;
    word-wrap: break-word;
  }
  .answer_text p {
    background: #fff;
    color: #000;
  }
  .question_text p {
    // background: #42929d;
    background: rgb(102, 255, 0);
    color: #000;
    text-align: left;
  }
  .question_text i,
  .answer_text i {
    width: 0;
    height: 0;
    border-top: 5px solid transparent;
    border-bottom: 5px solid transparent;
    position: absolute;
    top: 25px;
  }
  .answer_text i {
    border-right: 10px solid #fff;
    left: 10px;
  }
  .question_text i {
    border-left: 10px solid rgb(102, 255, 0);
    right: 10px;
  }
  .answer_text p a {
    color: #42929d;
    display: inline-block;
  }
  .write_list {
    position: absolute;
    left: 0;
    width: 100%;
    background: #fff;
    border-top: solid 1px #ddd;
    padding: 5px;
    line-height: 30px;
  }
  .input-box {
    background-color: rgb(247, 247, 247);
    height: 80px;
    line-height: 80px;
    padding: 0 1%;
  }
  .lt-btn {
    line-height: 28px;
    border: 1px solid rgb(102, 204, 0);
    color: rgb(102, 204, 0);
    background-color: #fff;
    width: 8%;
    margin-left: 10px;
    border-radius: 5px;
    cursor: pointer;
  }
  .lt-btn:hover {
    background-color: rgb(102, 204, 0);
    color: #fff;
  }
  //聊天框 -- zhong

  .obj-btn {
    display: flex;
    padding: 0 45px;
    margin: 30px 0 50px 0;
    .btns-all {
      color: #ffffff;
      font-weight: 700;
      border-radius: 50px;
      text-align: center;
      line-height: 33px;
      padding: 0 20px;
      cursor: pointer;
    }
    .start-obj {
      background-color: red;
    }
    .stop-obj {
      background-color: rgb(51, 153, 255);
    }
  }
}
</style>
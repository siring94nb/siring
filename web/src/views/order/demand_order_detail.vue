<template>
  <div class="index">
    <div class="line line-marst">基础信息</div>
    <div class="main-top">
      <table>
        <tr>
          <td class="td-one">用户账号：</td>
          <td>139228300809</td>
          <td class="td-one">订单号：</td>
          <td>2018062803890</td>
        </tr>
        <tr>
          <td class="td-one">商品名称：</td>
          <td>139228300809</td>
          <td class="td-one">订单类型：</td>
          <td>2018062803890</td>
        </tr>
        <tr>
          <td class="td-one">下单时间：</td>
          <td>139228300809</td>
          <td class="td-one">订单金额：</td>
          <td>2018062803890</td>
        </tr>
        <tr>
          <td class="td-one">终端版本：</td>
          <td>139228300809</td>
          <td class="td-one">合同金额：</td>
          <td>2018062803890</td>
        </tr>
        <tr>
          <td class="td-one">项目剩余金额</td>
          <td>139228300809</td>
          <td class="td-one">项目剩余时间</td>
          <td>2018062803890</td>
        </tr>
      </table>
    </div>
    <div class="line line-marst">内容回复</div>
    <div class="content-reply">
      <template v-for="(item,index) in statusData">
        <div class="content-main" :key="index">
          <div class="content-title" :class="{'content-sel-color': status > index}">{{item.name}}</div>
          <div v-if="status == index">
            <div class="content-tips">
              <img src="../../images/u3829.png" style="width:100%;height:100%;" alt />
              <div class="content-text">{{item.tips}}</div>
            </div>
            <div class="content-arrow">
              <img src="../../images/u3830.png" style="width:100%;height:100%;" alt />
            </div>
          </div>
          <div class="content-zip" v-if="status > index">
            <div class="zip-main">
              <span class="zip-text">预览</span>
              <img style="vertical-align: middle;" src="../../images/u587.gif" alt />
              <span class="zip-text">下载</span>
              <div>**需求表.zip</div>
            </div>
            <i></i>
          </div>
        </div>
        <div
          class="all-line"
          :class="{'h-line': status < index + 2, 'g-line' :  status > index}"
          v-if="index < 6"
        ></div>
        <div
          class="all-line"
          :class="{'h-line': status < index + 2, 'g-line' : status > index + 1}"
          v-if="index < 6"
        ></div>
      </template>
    </div>

    <div class="line line-vice">内容/合同/协议/确认文书</div>
    <!-- 定制需求 -->
    <div class="determine-box">
      <div class="dzxq-main" v-if="status == 0">
        <Form :label-width="80">
          <FormItem label="需求名称：" prop="project_name">
            <Input placeholder="请输入" style="width: 450px;" />
          </FormItem>
          <FormItem label="需求类型：" prop="category_id">
            <Select style="width: 450px;">
              <Option value="1">智能硬件</Option>
              <Option value="2">电子商务</Option>
              <Option value="3">生活娱乐</Option>
              <Option value="4">金融</Option>
              <Option value="5">媒体</Option>
              <Option value="6">企业服务</Option>
              <Option value="7">政府服务</Option>
            </Select>
          </FormItem>
          <FormItem label="需求预算：" prop="project_price_up">
            <Input placeholder="请输入" style="width: 200px;" />元 ~
            <Input placeholder="请输入" style="width: 200px;" />元
          </FormItem>
          <FormItem label="开发终端：" prop="develop">
            <CheckboxGroup>
              <Checkbox label="PC">
                <Icon type="ios-desktop-outline" size="23" />PC
              </Checkbox>
              <Checkbox label="APP安卓">
                <Icon type="logo-android" size="23" />APP安卓
              </Checkbox>
              <Checkbox label="APP苹果">
                <Icon type="logo-apple" size="23" />APP苹果
              </Checkbox>
              <Checkbox label="公众号">
                <Icon type="ios-chatbubbles" size="23" />公众号
              </Checkbox>
              <Checkbox label="小程序">
                <Icon type="ios-code" size="23" />小程序
              </Checkbox>
              <Checkbox label="H5">
                <Icon type="logo-html5" size="23" />H5
              </Checkbox>
              <!-- <Checkbox label="其他"></Checkbox>
              <Input v-model="formValidate.project_price_up" placeholder="说明，不超过10个字" style="width: 200px;" />-->
            </CheckboxGroup>
          </FormItem>
          <FormItem label prop="project_detail">
            <span>手机号</span>
            <Input placeholder="手机号" style="width: 250px;" />
            <span style="margin-left:120px;">其他联系方式</span>
            <Input placeholder="XXX-XXXXXXX" style="width: 250px;" />
          </FormItem>
          <FormItem label prop="project_detail">
            <span>微信号</span>
            <Input placeholder style="width: 250px;" />
          </FormItem>
          <FormItem label="需求描述：" prop="project_detail">
            <Input type="textarea" :autosize="{minRows: 4,maxRows: 8}" style="width:500px;" />
          </FormItem>
          <FormItem label="添加附件：">
            <Upload action="//jsonplaceholder.typicode.com/posts/">
              <Button icon="ios-cloud-upload-outline">Upload files</Button>
            </Upload>
          </FormItem>
        </Form>
      </div>
      <div class="ptbj-box" v-if="status == 1">
        <img src="../../images/u4198.png" width="100%" alt />
      </div>
    </div>
    <div class="line line-vice">平台顾问信息互动</div>
    <div class="speak_window">
      <div class="speak_box">
        <div class="answer">
          <div class="heard_img left">
            <img src="../../images/u3830.png" />
            <div>平台顾问</div>
          </div>
          <div class="answer_text">
            <p>fdgfdgfdg</p>
            <i></i>
          </div>
        </div>
        <div class="question">
          <div class="heard_img right">
            <img src="../../images/u3830.png" />
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

    <div class="foot-box">
      <div class="pt-bj">
        <Button class="upload-btn" :disabled="uploadBtn">上传报价单</Button>
        <div class="audit">
          <div class="arrow left-arrow"></div>
          <div class="arrow-pole"></div>
          <div class="audit-status">等待审核</div>
          <div class="arrow-pole"></div>
          <div class="arrow right-arrow"></div>
        </div>
        <div class="project">
          工期：
          <input
            type="number"
            name="day"
            id
            placeholder="请填写"
            style="width:60px;line-height:30px;color:red;"
          />
          工作日
        </div>
        <div>
          合同额：
          <input
            type="number"
            name="money"
            id
            placeholder="请填写"
            style="width:60px;line-height:30px;color:red;"
          />
          元
        </div>
      </div>
      <div class="audit-opinion">
        <span>审核意见：</span>
        斯卡哈会计师哈克喝啥酒看时间按实际卡不卡时间啊包括把上课吧 
      </div>
      <div class="pt-bj-btn" style="text-align:center;">
        <Button style="margin-right:30px;">返回</Button>
        <Button type="primary">确认</Button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      status: 1,
      value: "",
      path: "ws://127.0.0.1:3000",
      socket: "",
      rand: 0,
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
      uploadBtn: false
    };
  },
  created() {
    this.init();
  },
  methods: {
    init() {
      // console.log(this.$route.params.status);
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
    }
  },
  destroyed() {
    // 销毁监听
    this.socket.onclose = this.close;
  }
};
</script>

<style lang="less" scoped>
.index {
  width: 100%;
  background-color: #fff;
  padding: 10px 20px;
  font-style: normal;
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
  .determine-box {
    height: 600px;
    border: 1px solid rgb(240, 248, 250);
    overflow-y: scroll;
    .dzxq-main {
      padding: 30px 30px 30px 300px;
    }
  }
  .main-top {
    table {
      width: 100%;
    }
    table,
    td {
      border: 1px solid rgb(242, 242, 242);
      border-collapse: collapse;
      border-spacing: 0;
      text-align: center;
      line-height: 28px;
    }
    .td-one {
      width: 20%;
      font-weight: 700;
      font-size: 12px;
    }
  }
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
  //平台报价底部
  .foot-box {
    .pt-bj {
      display: flex;
      font-size: 14px;
      color: #000000;
      font-weight: 400;
      margin: 20px 0;
      padding-bottom: 20px;
      border-bottom: 1px solid rgb(121, 121, 121);
      justify-content: center;
      align-items: center;
      .upload-btn {
        font-size: 13px;
        text-align: center;
        width: 155px;
        height: 40px;
        background-color: rgb(255, 102, 0);
        color: #fff;
        border-radius: 30px;
      }
      .upload-btn-dis{
        background-color: rgb(161, 161, 161) !important; 
      }
      .audit {
        display: flex;
        align-items: center;
        .arrow {
          border-width: 10px;
          border-style: solid;
          height: 20px;
        }
        .left-arrow {
          border-color: transparent rgb(161, 161, 161) transparent transparent;
        }
        .right-arrow {
          border-color: transparent transparent transparent rgb(161, 161, 161);
        }
        .left-arrow-dis{
          border-color: transparent red transparent transparent;
        }
        .right-arrow-dis {
          border-color: transparent transparent transparent red;
        }
        .arrow-pole {
          height: 2px;
          width: 50px;
          background-color: rgb(161, 161, 161);
        }
        .audit-status {
          font-weight: 700;
          font-style: normal;
          font-size: 16px;
          color: #ffffff;
          text-align: center;
          background-color: rgb(161, 161, 161);
          width: 95px;
          height: 33px;
          line-height: 33px;
        }
        .audit-true{
          background-color: red !important;
        }
      }
      .project {
        margin: 0 30px;
      }
    }
    .audit-opinion{
      height: 100px;
      border-bottom: 1px solid rgb(121, 121, 121);
      font-size: 16px;
      margin-bottom: 10px;
      span{
        color: red;
        font-weight: 700;
      }
    }
    .pt-bj-btn {
      text-align: center;
      button {
        width: 150px;
      }
    }
  }


}
</style>
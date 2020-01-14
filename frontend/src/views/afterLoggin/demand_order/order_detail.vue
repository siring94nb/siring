<template>
  <div style="width:1480px;">
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
          <span class="for-day">_&nbsp;_</span>
          天
        </div>
      </div>

      <!-- 流程条 -->
      <orderProcess :statusData="statusData" :status="status" />

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
              <el-button type="primary" style="float:right;" @click="need_submit">确定修改</el-button>
            </el-form-item>
          </el-form>
        </div>
        <div class="ptbj-box" v-if="status == 2">
          <img :src="listData.proposal" width="100%" v-if="listData.proposal != ''" />
          <div class="wait-ptbj" v-else>
            <img src="../../../assets/images/u9830.png" alt />
            <div>请耐心等待平台报价！</div>
          </div>
        </div>
        <div class="contract" v-if="status == 3">
          <p class="serial">合同编号：SR20190202</p>
          <p class="contract-title">软件/定制开发合同</p>
          <div class="identity">
            甲方：
            <input type="text" placeholder="请选择" style="width:390px;" />
            <div>选择企业身份</div>
          </div>
          <p>乙方：深圳市思锐信息技术有限公司 914403001924280274</p>
          <p>
            甲乙双方基于平等互利、公平自愿原则，委托甲方进行
            <span class="focus">装修小程序开发</span> 项目开发。经友好协商一致同意签订如下合同，共同遵守，双方对本合同的所有内容均无任何异议。
          </p>
          <p>
            一、产品名称：
            <span class="focus">装修小程序开发</span>
          </p>
          <p>
            二、终端版本:
            <span class="focus">安卓+苹果+小程序+微信公众号</span>
          </p>
          <p>
            三、项目工期：
            <span class="focus">20个工作。</span>
          </p>
          <p>
            四、合同总金额：
            <span class="focus">{{price}}元（{{convertToChinaNum(price)}}元整）</span>
          </p>
          <p>五、分期付款方式：甲方向乙方支付总开发费用实行分期付款方式。本项目分四期付款，第一期为总合同款的70%，第二期为总合同款的10%，第三期为总合同款10%,第四期为总合同款10%。</p>
          <p class="retract">
            5.1在本合同签订后的3工作日内，第一期甲方支付乙方项目预付款即合同总价的70%，小写：¥__
            <span class="focus">{{price*0.7}}</span>__（大写：人民币：__
            <span class="focus">{{convertToChinaNum(price*0.7)}}</span>__元整）。
          </p>
          <p class="retract">
            5.2甲方在和乙方对完整套项目原型及UI时，经甲方签署原型确认单后，3个工作日内需向乙方支付第二期费用即合同总价的10%，小写：¥__
            <span
              class="focus"
            >{{price*0.1}}</span>（大写：人民币：__
            <span class="focus">{{convertToChinaNum(price*0.1)}}</span>__元整）。
          </p>
          <p class="retract">
            5.3乙方完成项目DEMO版：即可运行90%功能的版本（不排除存在BUG），经甲方确认版本功能无误后，3个工作日内需向乙方支付第三期费用即合同总价的10%，小写：¥__
            <span
              class="focus"
            >{{price*0.1}}</span>__（大写：人民币：__
            <span class="focus">{{convertToChinaNum(price*0.1)}}</span>__元整）。
          </p>
          <p class="retract">
            5.4甲方应于收到乙方交付的最终定稿的产品安装包，之日起3个工作日内向乙方支付本合同第四期费用即合同总价的10%，小写：¥__
            <span
              class="focus"
            >{{price*0.1}}</span>__（大写：人民币：__
            <span class="focus">{{convertToChinaNum(price*0.1)}}</span>__元整）。
          </p>
          <p>六、项目全自动流程：整体项目开发通过线上自动流程确认完成，并系统化管理方式，每个环节均可在我的软件/定制板块订单中跟进完成所有交易流程和步骤。</p>
          <p>七、工期计算方式：甲方确认设计原型并付款之日，为项目开发工期的起始日期，乙方完成项目DEMO版之日，为项目完工日期。</p>
          <p>八、免费维护期： 12个月，免费维护期内，产品出现的原型确认功能范围内的任何bug，乙方需第一时间免费处理。维护期自甲方进行产品确认验收完毕后开始计时。</p>
          <p>九、有偿维护期：超过12个月后，乙方提供有偿技术维护，平台维护费为本合同金额+新增功能需求总计的10%；</p>
          <p>十、新增功能需求： 如果甲方需要对于系统进行非内容性的修改，例如系统功能的添加、修改和删除，或对系统整体风格及页面布局进行调整，其费用根据甲方的具体需求另行商定，该费用不包含在本合同内。</p>
          <p>十一、验收：项目完成，乙方自检完成后，报请甲方验收，甲方接到申请后应在 7 日内进行验收，验收完成后，甲方应在 5日内为乙方办妥竣工验收及结算资料。若甲方未在指定的期限内完成验收工作，到期后即默认视为验收合格。</p>
          <p>十二、违约责任：甲方在项目制作过程中需与乙方积极配合，提供有效的修改意见或确认信息，若在项目进行过程中，甲方处于停滞状态，即对乙方提供的工作成果既不给出有效修改意见也不对其进行肯定确认，如果停滞时间超过20个工作日以上，则视作甲方主动解除本合同，甲方无权要求乙方返还已经支付的费用。</p>
          <p>十三、电子合同：本合同电子档，经过甲方同意，付款后立即生效，合同电子档将长期保存在会员账号平台中。</p>
          <p>十四、纸质合同：如需纸质合同，可将本合同下载打印一式两份，邮寄给乙方，经乙方盖章后，寄还给甲方一份，甲乙双方各执一份。</p>
          <p>十五、免责：因不可抗力或者其他意外事件，或使得本合同的履行不可能、不必要或者无意义的，任一方均可以解除本合同。本合同所称不可抗力、意外事件是指不能预见、不能克服并不能避免且对一方当事人造成重大影响的客观事件，包括但不限于自然灾害以及社会事件如战争、动乱、政府行为等，但受不可抗力影响的一方应当及时通知对方并采取合理措施防止损失的扩大。</p>
          <p>十六、协商：双方当事人对本合同的订立、解释、履行、效力等发生争议的，应友好协商解决；协商不成的，双方同意向乙方所在地有管辖权限的人民法院诉讼解决。</p>
          <p>十七、附件及补充协议：本合同未及事宜，由双方协商作出补充协议，附件及补充协议与本合同具有同等效力。</p>
          <div class="sign">
            <div class="party-sign">
              <p>甲方（签章）：刘德华</p>
              <p>法定或签约代表：</p>
              <p>日期： 2018 年 6 月 19 日</p>
            </div>
            <div style="flex:1;"></div>
            <div class="party-sign" style="margin-right:120px;">
              <p>乙方（签章）：深圳市思锐信息技术有限公司</p>
              <p>法定或签约代表：</p>
              <p>日期： 2018 年 6 月 19 日</p>
            </div>
          </div>
        </div>
        <div class="ptbj-box" v-if="status == 4 || status == 5">
          <div class="wait-ptbj" v-if="status == 4">
            <img src="../../../assets/images/u9830.png" alt />
            <div>请耐心等待原型设计！</div>
          </div>
          <div class="wait-ptbj" v-if="status == 5">
            <img src="../../../assets/images/u9830.png" alt />
            <div style="width:330px;margin:10px auto;">
              项目开发中……
              <span style="color:red;">请积极配合第三方申请，加快项目开发！</span>
            </div>
          </div>
          <!-- <div class="solutions">
            <div class="solutions-h1">原型方案查阅</div>
            <img src="../../../assets/images/u10329.png" alt />
            <div class="solutions-url">
              {{solutions_url}}
              <span v-clipboard:copy="solutions_url" v-clipboard:success="copy">复制</span>
            </div>
          </div>-->
        </div>
      </div>
      <!-- <div class="line line-vice">平台顾问信息互动</div> -->
      <!-- 聊天 -->
      <div class="speak_window">
        <liuyan :pid="form.id" :uid="form.user_id"></liuyan>
        <!-- <div class="speak_box">
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
        </div>-->
      </div>
      <div class="obj-btn">
        <div class="btns-all stop-obj" @click="obj_btn(8)" v-if="status < 4">中止，本人放弃该项目</div>
        <div style="flex:1;"></div>
        <div class="btns-all start-obj" @click="obj_btn(2)" v-if="status == 1">确定，本人已确认该需求方案</div>

        <div class="btns-all no-obj" v-if="status == 2 && listData.examine != 2">等待报价单</div>
        <div
          class="btns-all start-obj"
          @click="obj_btn(3)"
          v-if="status == 2 && listData.examine == 2"
        >确定，本人已确认该报价方案</div>

        <div class="btns-all no-obj" @click="open" v-if="status == 3">等待支付合同款</div>

        <!-- <div class="btns-all no-obj" @click="obj_btn(4)" v-if="status == 4">等待原型确认</div> -->
        <!-- <div class="btns-all start-obj" @click="obj_btn(2)" v-if="status == 4">确定，本人已确认该原型方案</div> -->

        <div class="btns-all no-obj" @click="obj_btn(4)" v-if="status == 5">项目开发中......</div>
      </div>
      <div style="font-size:13px;text-align:center;" v-if="status==4">
        <span style="color:red;">*敬请留意*：</span>所有开发依据原型为依据，如开发完成后提出与原型不一致情况，造成项目费用增加或者项目延迟，均由甲方承担！如无误，可点击确认，供工程师进行开发使用
      </div>
      <payment-bar
        ref="paymentbar"
        :showPaymentFlag="showPaymentFlag"
        :price="price"
        :percent="percent"
        :pay="pay"
        :order="order"
        :scale="scale"
        @sendNum="getNum"
        :needCodeDialog="needCodeDialog"
      />
    </div>
  </div>
</template>
<script>
import logginHeader from "@/components/logginHeader";
import {
  needOrderList,
  getOrderDetail,
  changeStatus,
  confirmNeedOrder,
  getDiscount,
  msgList
} from "@/api/api";
import PaymentBar from "@/components/join/paymentBar";
import orderProcess from "@/components/order/orderProcess";
import liuyan from "@/components/liuyan/leaveAmessage";
export default {
  data() {
    return {
      // userId: "",
      path: "ws://127.0.0.1:3000",
      status: 1,
      // id:0,
      socket: "",
      listData: [],
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
        id: 0,
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
        need_file: "",
        user_id: ""
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
      fileList: [],
      value: "",
      showPaymentFlag: false,
      needCodeDialog: true, //需要显示扫码弹窗
      price: 50000, //合同金额
      percent: 100, //会员折扣
      scale: 70, //支付比例
      order: 2, //支付第几期
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
      solutions_url: "https://oepz25.axshare.com"
    };
  },
  mounted() {
    this.init();
    this.getDetail();
    this.GetDiscount();
  },
  computed: {
    total() {
      return this.price * (this.percent / 100) * (this.scale / 100);
    }
  },
  methods: {
    init() {
      this.form.user_id = JSON.parse(sessionStorage.getItem("user_id"));
      console.log(this.form.user_id)
      this.status = this.$route.params.status;
      this.id = this.$route.params.id;
      if (this.status == 3) {
        this.scale = 70;
        this.order = 2;
      } else if (this.status == 4) {
        this.scale = 10;
        this.order = 3;
      } else if (this.status == 5) {
        this.scale = 10;
        this.order = 3;
      } else if (this.status == 6) {
        this.scale = 10;
        this.order = 3;
      }
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
    obj_btn(status) {
      let vm = this,
        hr,
        hr1;
      switch (status) {
        case 1:
          hr = "您确定要中止该项目么？！";
          break;
        case 2:
          hr = "1、需求方案务必与平台顾问详细核实比对；";
          hr1 = "2、平台报价将依据您的需求方案进行报价。";
          break;
        case 3:
          hr = "您确认该报价单了吗？";
          break;
      }
      const h = this.$createElement;
      this.$msgbox({
        title: "温馨提示：",
        message: h("div", null, [h("p", null, hr), h("p", null, hr1)]),
        showCancelButton: true,
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        center: true,
        beforeClose: (action, instance, done) => {
          if (action === "confirm") {
            instance.confirmButtonLoading = true;
            instance.confirmButtonText = "执行中...";
            vm.modifyState(status);
            setTimeout(() => {
              done();
              setTimeout(() => {
                instance.confirmButtonLoading = false;
              }, 300);
            }, 1000);
          } else {
            done();
          }
        }
      }).then(action => {
        // this.$message({
        //   type: "info",
        //   message: "action: " + action
        // });
      });
    },
    open() {
      this.$alert("请在底部浮框处支付相应合同款项", "温馨提示", {
        confirmButtonText: "确定",
        center: true,
        callback: action => {
          this.showPaymentFlag = true;
        }
      });
    },
    //数字转汉字
    convertToChinaNum(num) {
      var arr1 = new Array(
        "零",
        "一",
        "二",
        "三",
        "四",
        "五",
        "六",
        "七",
        "八",
        "九"
      );
      var arr2 = new Array(
        "",
        "十",
        "百",
        "千",
        "万",
        "十",
        "百",
        "千",
        "亿",
        "十",
        "百",
        "千",
        "万",
        "十",
        "百",
        "千",
        "亿"
      ); //可继续追加更高位转换值
      if (!num || isNaN(num)) {
        return "零";
      }
      var english = num.toString().split("");
      var result = "";
      for (var i = 0; i < english.length; i++) {
        var des_i = english.length - 1 - i; //倒序排列设值
        result = arr2[i] + result;
        var arr1_index = english[des_i];
        result = arr1[arr1_index] + result;
      } //将【零千、零百】换成【零】 【十零】换成【十】
      result = result.replace(/零(千|百|十)/g, "零").replace(/十零/g, "十"); //合并中间多个零为一个零
      result = result.replace(/零+/g, "零"); //将【零亿】换成【亿】【零万】换成【万】
      result = result.replace(/零亿/g, "亿").replace(/零万/g, "万"); //将【亿万】换成【亿】
      result = result.replace(/亿万/g, "亿"); //移除末尾的零
      result = result.replace(/零+$/, ""); //将【零一十】换成【零十】 //result = result.replace(/零一十/g, '零十');//貌似正规读法是零一十 //将【一十】换成【十】
      result = result.replace(/^一十/g, "十");
      return result;
    },
    getNum(value) {
      this.num = value;
    },
    pay() {
      let params = {
        id: this.id,
        order_amount: this.total,
        user_id: this.form.user_id,
        order_type: this.order
      };
      this.$router.push({
        name: "comboPay",
        params: params
      });
    },
    copy() {
      this.$message.success("复制成功");
    },
    // //报价
    // status_next(status){
    //   this.modifyState(status);
    // },
    //修改状态
    modifyState(status) {
      let vm = this,
        data,
        params = {
          id: vm.id,
          user_id: vm.form.user_id,
          status: status
        };
      return changeStatus(params).then(res => {
        let { data, msg, code } = res;
        if (code === 1) {
          vm.status = status;
          vm.$message.success(msg);
          if (status == 0) {
            this.$router.push({
              name: "demand_order"
            });
          }
        } else {
          vm.$message.error(msg);
        }
      });
    },
    //获取表单信息
    getDetail() {
      let vm = this,
        params = {
          id: vm.id,
          status: vm.status
        };
      getOrderDetail(params).then(res => {
        let { data, msg, code } = res;
        if (code === 1) {
          (vm.form.id = data.id),
            (vm.form.need_name = data.need_name),
            (vm.form.need_category = data.need_category),
            (vm.form.need_budget_down = data.need_budget_down),
            (vm.form.need_budget_up = data.need_budget_up),
            (vm.form.need_terminal = data.need_terminal),
            (vm.form.need_phone = data.need_phone),
            (vm.form.need_qq = data.need_qq),
            (vm.form.need_wx = data.need_wx),
            (vm.form.need_other = data.need_other),
            (vm.form.need_desc = data.need_desc),
            (vm.form.need_file = data.need_file);
          vm.fileList = [{ name: "需求文件", url: data.need_file }];
          vm.price = Number(data.need_money);
          vm.listData = data;
        }
      });
    },
    GetDiscount() {
      let vm = this,
        params = {
          uid: vm.form.user_id
        };
      getDiscount(params).then(res => {
        if (res.code == 1) {
          vm.percent = res.data;
        }
      });
    },
    need_submit() {
      let vm = this;
      confirmNeedOrder(vm.form).then(res => {
        let { code, data, msg } = res;
        if (code === 1) {
          vm.$message.success(msg);
        }
      });
    }
  },
  destroyed() {
    // 销毁监听
    this.socket.onclose = this.close;
  },
  components: {
    logginHeader,
    PaymentBar,
    orderProcess,
    liuyan
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
    .ptbj-box {
      text-align: center;
      .wait-ptbj {
        margin-top: 200px;
        img {
          width: 100px;
          height: 100px;
        }
        div {
          margin-top: 20px;
          font-size: 20px;
          color: #c9c9c9;
          text-align: center;
        }
      }
      .solutions {
        img {
          transform: rotate(180deg);
          width: 60px;
          height: 60px;
          margin: 10px 0;
        }
        .solutions-h1 {
          font-family: "Arial Negreta", "Arial Normal", "Arial";
          font-weight: 700;
          font-style: normal;
          font-size: 32px;
          color: #333333;
        }
        .solutions-url {
          font-size: 18px;
          color: #669900;
          span {
            color: #000;
            margin-left: 30px;
            cursor: pointer;
          }
        }
      }
    }
    .contract {
      font-size: 13px;
      color: #333333;
      padding: 25px;
      p {
        line-height: 30px;
      }
      .retract {
        margin-left: 25px;
      }
      .serial {
        float: right;
      }
      .contract-title {
        clear: both;
        font-weight: 700;
        font-style: normal;
        font-size: 22px;
        text-align: center;
        margin: 20px 0 60px 0;
      }
      .identity {
        display: flex;
        align-items: center;
        div {
          background-color: rgb(230, 247, 255);
          border: 1px solid rgb(145, 213, 255);
          font-size: 12px;
          color: #1890ff;
          line-height: 20px;
          width: 100px;
          text-align: center;
        }
      }
      .focus {
        font-weight: 700;
        text-decoration: underline;
      }
      .sign {
        margin-top: 50px;
        display: flex;

        .party-sign {
          p {
            line-height: 35px;
          }
        }
      }
    }
  }
  //流程

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
    margin: 30px 0 70px 0;
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
    .no-obj {
      background-color: rgb(174, 174, 174);
    }
  }
}
</style>
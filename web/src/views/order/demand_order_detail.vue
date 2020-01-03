<template>
  <div class="index">
    <div class="line line-marst">基础信息</div>
    <div class="main-top">
      <table>
        <tr>
          <td class="td-one">用户账号：</td>
          <td>{{information.phone}}</td>
          <td class="td-one">订单号：</td>
          <td>{{information.no}}</td>
        </tr>
        <tr>
          <td class="td-one">商品名称：</td>
          <td>{{information.name}}</td>
          <td class="td-one">订单类型：</td>
          <td>{{information.need_category}}</td>
        </tr>
        <tr>
          <td class="td-one">下单时间：</td>
          <td>{{information.created_at}}</td>
          <td class="td-one">订单金额：</td>
          <td>{{information.order_amount}}</td>
        </tr>
        <tr>
          <td class="td-one">终端版本：</td>
          <td>{{information.terminal}}</td>
          <td class="td-one">合同金额：</td>
          <td>{{information.money}}</td>
        </tr>

        <tr>
          <td class="td-one">项目剩余金额</td>
          <td>{{information.surplus}}</td>
          <td class="td-one">项目剩余时间</td>
          <td>{{information.end_time}}</td>
        </tr>
      </table>
    </div>
    <div class="line line-marst">内容回复</div>
    <orderDetail :statusData="statusData" :status="status" />

    <div class="line line-vice">内容/合同/协议/确认文书</div>
    <!-- 定制需求 -->
    <div class="determine-box">
      <div class="dzxq-main" v-if="status == 1">
        <Form :label-width="80">
          <FormItem label="需求名称：">
            <Input placeholder="请输入" v-model="information.name" style="width: 450px;" />
          </FormItem>
          <FormItem label="需求类型：">
            <Select style="width: 450px;" :v-model="information.need_category">
              <Option value="1">智能硬件</Option>
              <Option value="2">电子商务</Option>
              <Option value="3">生活娱乐</Option>
              <Option value="4">金融</Option>
              <Option value="5">媒体</Option>
              <Option value="6">企业服务</Option>
              <Option value="7">政府服务</Option>
            </Select>
          </FormItem>
          <FormItem label="需求预算：">
            <Input placeholder="请输入" v-model="information.need_budget_down" style="width: 200px;" />元 ~
            <Input placeholder="请输入" v-model="information.need_budget_up" style="width: 200px;" />元
          </FormItem>
          <FormItem label="开发终端：">
            <CheckboxGroup v-model="information.dev">
              <Checkbox label="原型UI">
                <Icon type="ios-snow-outline" size="23" />原型UI
              </Checkbox>
              <Checkbox label="后台">
                <Icon type="ios-cog-outline" size="23" />后台
              </Checkbox>
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
              <Checkbox label="移动H5">
                <Icon type="logo-html5" size="23" />H5
              </Checkbox>
              <!-- <Checkbox label="其他"></Checkbox>
              <Input v-model="formValidate.project_price_up" placeholder="说明，不超过10个字" style="width: 200px;" />-->
            </CheckboxGroup>
          </FormItem>
          <FormItem label>
            <span>手机号</span>
            <Input placeholder="手机号" v-model="information.phone" style="width: 250px;" />
            <span style="margin-left:120px;">其他联系方式</span>
            <Input placeholder="XXX-XXXXXXX" v-model="information.other" style="width: 250px;" />
          </FormItem>
          <FormItem label>
            <span>微信号</span>
            <Input placeholder v-model="information.wx" style="width: 250px;" />
          </FormItem>
          <FormItem label="需求描述：">
            <Input
              type="textarea"
              :autosize="{minRows: 4,maxRows: 8}"
              v-model="information.con"
              style="width:500px;"
            />
          </FormItem>
          <FormItem label="添加附件：">
            <Upload action="//jsonplaceholder.typicode.com/posts/">
              <Button icon="ios-cloud-upload-outline">Upload files</Button>
            </Upload>
          </FormItem>
        </Form>
      </div>
      <div class="ptbj-box" v-if="status == 2">
        <img :src="information.proposal" width="100%" alt />
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
        <p>五、分期付款方式：甲方向乙方支付总开发费用实行分期付款方式。本项目分四期付款，第一期为总合同款的70%，第二期为总合同款的20%，第三期为总合同款10%,第四期为总合同款10%。</p>
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
        <Upload
          ref="upload"
          :show-upload-list="false"
          :default-file-list="iconList"
          :on-success="handleSuccess"
          :format="['jpg','jpeg','png']"
          :max-size="10240"
          :on-format-error="handleFormatError"
          :on-exceeded-size="handleMaxSize"
          :before-upload="handleBeforeUpload"
          type="drag"
          name="image"
          :action="UploadAction"
          style="display: inline-block;width: auto;"
          v-if="status == 2"
        >
          <Button
            class="upload-btn"
            :class="information.proposal != null ? 'upload-btn-dis': ''"
            :disabled="information.proposal != null"
          >上传报价单</Button>
        </Upload>
        <div class="audit" v-if="information.proposal != null && status == 2">
          <div class="arrow left-arrow" :class="information.examine > 1 ? 'left-arrow-dis':''"></div>
          <div class="arrow-pole" :class="information.examine > 1 ? 'audit-true':''"></div>
          <div class="audit-status" v-if="information.examine == 1">等待审核</div>
          <div class="audit-status audit-true" else>{{information.examine == 2 ? '审核通过':'审核不通过'}}</div>
          <div class="arrow-pole" :class="information.examine > 1 ? 'audit-true':''"></div>
          <div class="arrow right-arrow" :class="information.examine > 1 ? 'right-arrow-dis':''"></div>
        </div>
        <div class="project" v-if="status == 2">
          <div>
            工期：
            <input
              type="number"
              name="day"
              min="0"
              v-model="information.work_day"
              placeholder="请填写"
              style="width:60px;line-height:30px;color:red;"
              :disabled="isWork_day"
            />
            工作日
          </div>
          <div>
            合同额：
            <input
              type="number"
              name="money"
              min="0"
              v-model="information.money"
              placeholder="请填写"
              style="width:60px;line-height:30px;color:red;"
              :disabled="isNeed_money"
            />
            元
          </div>
        </div>

        <div style="flex:1;" v-if="status == 3"></div>
        <Button class="upload-btn" v-if="status == 3" @click="changeXy">用户要求修改协议</Button>
        <div style="flex:1;" v-if="status == 3"></div>
        <div class="project" v-if="status == 3">
          <div>
            1期：
            <input
              type="number"
              name="one"
              placeholder="请填写"
              v-model="percent.one"
              min="0"
              style="width:60px;line-height:30px;color:red;"
              disabled
            />
            %
          </div>
          <div>
            2期：
            <input
              type="number"
              name="one"
              placeholder="请填写"
              v-model="percent.two"
              min="0"
              style="width:60px;line-height:30px;color:red;"
              disabled
            />
            %
          </div>
          <div>
            3期：
            <input
              type="number"
              name="one"
              placeholder="请填写"
              v-model="percent.three"
              min="0"
              style="width:60px;line-height:30px;color:red;"
              disabled
            />
            %
          </div>
          <div>
            4期：
            <input
              type="number"
              name="one"
              placeholder="请填写"
              min="0"
              v-model="percent.four"
              style="width:60px;line-height:30px;color:red;"
              disabled
            />
            %
          </div>
        </div>
      </div>
      <div></div>
      <div class="audit-opinion" v-if="information.examine == 3">
        <span>审核意见：</span>
        斯卡哈会计师哈克喝啥酒看时间按实际卡不卡时间啊包括把上课吧
      </div>
      <div class="audit" v-if="qualification == 1">
        <textarea
          name="audit"
          v-model="information.examine_opinion"
          style="width:100%;"
          rows="10"
          placeholder="审核意见"
        ></textarea>
        <div class="sel">
          <RadioGroup v-model="information.examine">
            <Radio label="3">
              <span>不通过</span>
            </Radio>
            <Radio label="2">
              <span style="color:red;">通过</span>
            </Radio>
          </RadioGroup>
        </div>
      </div>
      <div
        class="pt-bj-btn"
        style="text-align:center;"
        v-if="information.examine == null && qualification == 0"
      >
        <Button style="margin-right:30px;">返回</Button>
        <Button type="primary" @click="submitObj">确认</Button>
      </div>
      <div class="pt-bj-btn" style="text-align:center;" v-if="  qualification == 1">
        <Button style="margin-right:30px;">返回</Button>
        <Button type="primary" @click="auditObj">确认</Button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import config from "../../../build/config";
import orderDetail from "../main_components/order/orderDetail.vue";
import qs from "qs";
const apiPost = (url, params) => {
  return axios.post(url, qs.stringify(params)).then(res => res.data);
};

export default {
  components: {
    orderDetail
  },
  data() {
    return {
      price: 50000,
      status: 3,
      id: 0,
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
      uploadBtn: false,
      information: {
        //基础信息
        need_phone: "",
        need_order: "",
        need_name: "",
        need_category: "1",
        create_time: "",
        need_order_money: "",
        work_day: 0,
        money: 0,
        proposal: "",
        examine_opinion: "",
        examine: "",
        other:""
      },
      percent: {
        one: 70,
        two: 10,
        three: 10,
        four: 10
      },
      qualification: 0, //审核进来
      // 图片
      UploadAction: "",
      visible: false,
      uploadList: [],
      iconList: [],
      // 图片
      // examine:"2",
      // examine_opinion:'',
      isWork_day: false,
      isNeed_money: false
    };
  },
  created() {
    this.init();
  },
  methods: {
    init() {
      this.status = this.$route.params.status;
      this.id = this.$route.params.id;
      this.qualification = this.$route.params.qualification || 0;
      console.log(this.$route.params);
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
      this.BasicInformation();
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
    //获取基础信息
    BasicInformation() {
      let vm = this,
        params = {
          id: vm.id,
          status: vm.status
        };
      apiPost("NeedOrder/get_need_order_detail", params).then(res => {
        let { code, data, msg } = res;
        // console.log(data.data.need_terminal))
        if (code == 1) {
          // data.data.need_category = (data.data.need_category).toString();
          vm.information = data.data;
          vm.information.dev = data.data.terminal.split('/');
          if (data.data.money) {
            vm.isNeed_money = true;
          }
          if (data.data.work_day) {
            vm.isWork_day = true;
          }
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

    //提交
    submitObj() {
      let vm = this,
        params,
        type;
      if (vm.status == 2) type = 1;
      else if (vm.status == 3) type = 2;
      params = {
        id: vm.id,
        type: type,
        work_day: vm.information.work_day,
        money: vm.information.money,
        proposal: vm.information.proposal
      };
      apiPost("NeedOrder/offer_sure", params).then(res => {
        let { code, data, msg } = res;
        if (code == 1) {
          vm.isWork_day = true;
          vm.isNeed_money = true;
        }
        this.$Message.success(msg);
      });
    },
    //订单审核
    auditObj() {
      let vm = this,
        type,
        params;
      if (vm.status == 2) type = 1;
      else if (vm.status == 3) type = 2;
      if (vm.information.examine < 2) {
        this.$Message.error("请选择通过或不通过");
        return false;
      }
      params = {
        id: vm.id,
        examine_type: type,
        examine: vm.information.examine,
        examine_opinion: vm.information.examine_opinion
      };
      apiPost("NeedOrderAudit/orderAudit_upd", params).then(res => {
        let { code, data, msg } = res;
        this.$Message.success(msg);
        if (code == 1) {
          vm.$router.push({
            name: "review_order"
          });
        }
      });
    },
    //用户修改协议
    changeXy(){
      
    },
    handleRemove(file) {
      const fileList = this.$refs.upload.fileList;
      this.$refs.upload.fileList.splice(fileList.indexOf(file), 1);
      this.information.proposal = "";
    },
    handleSuccess(res, file) {
      file.url = res.data.filePath; //获取图片路径
      this.information.proposal = res.data.filePath;
    },
    handleFormatError(file) {
      this.$Message.error("文件格式不正确, 请选择jpg或者png.");
    },
    handleMaxSize(file) {
      this.$Message.error("文件大小不能超过10M");
    },
    handleBeforeUpload() {
      const check = this.uploadList.length < 2;
      if (!check) {
        this.$Message.error("只能上传一张报价单");
      }
      return check;
    }
  },
  destroyed() {
    // 销毁监听
    this.socket.onclose = this.close;
  },
  mounted() {
    this.UploadAction = config.front_url + "file/qn_upload";
    if(this.status == 2) {
      this.uploadList = this.$refs.upload.fileList;
    }
  }
};
</script>
<style>
.pt-bj .ivu-upload-drag {
  border: 0;
}
</style>
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
      .upload-btn-dis {
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
        .left-arrow-dis {
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
        .audit-true {
          background-color: red !important;
        }
      }
      .project {
        margin: 0 30px;
        display: flex;
        div {
          margin-right: 20px;
        }
      }
    }
    .audit-opinion {
      height: 100px;
      border-bottom: 1px solid rgb(121, 121, 121);
      font-size: 16px;
      margin-bottom: 10px;
      span {
        color: red;
        font-weight: 700;
      }
    }
    .audit {
      position: relative;
      .sel {
        position: absolute;
        bottom: 10px;
        right: 0;
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

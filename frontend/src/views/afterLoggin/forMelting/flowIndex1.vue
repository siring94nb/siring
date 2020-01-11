<template>
  <div class="box">
    <div class="smBox">
      <div class="TopHeader">
        <div>
          <i class="el-icon-warning-outline"></i>
          <div>
            <ul>
              <li>
                <span>·</span>每项流程确认完成后才能进入下一流程；
              </li>
              <li>
                <span>·</span>如有疑问可在最下方与在线客户及时互动；
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div>
        <!-- 流程标签 -->
        <div class="liuchengBiaozhi">
          <div class="liuchnegBox">
            <div :class="{'hFagao':strValue !=1,'qFagao':strValue ==1}">线上沟通</div>
            <div :class="{'xuqiuH':strValue !=1,'xuqiu':strValue == 1}">
              <span v-if="strValue ==1">等待确认</span>
              <i class="iconfont icon-chayueyuanjuan" v-if="strValue !=1"></i>
              <span v-if="strValue !=1">查阅</span>
            </div>
            <img :src="jiantouImgUrl" alt v-if="strValue ==1" />
          </div>
          <div class="henggang">
            <div :class="{'success':strValue>=2,'default':strValue==1}"></div>
            <div :class="{'success':strValue>=3,'default':strValue<=2}"></div>
          </div>
          <div class="liuchnegBox">
            <div :class="{'hFagao':strValue >= 3,'qFagao':strValue <=2}">线下见面会</div>
            <div :class="{'xuqiuH':strValue >= 3,'xuqiu':strValue <=2}">
              <span v-if="strValue <=2">等待确认</span>
              <i class="iconfont icon-chayueyuanjuan" v-if="strValue >=2"></i>
              <span v-if="strValue >=2">查阅</span>
            </div>
            <img :src="jiantouImgUrl" alt v-if="strValue==2" />
          </div>
          <div class="henggang">
            <div :class="{'success':strValue>=3,'default':strValue<4}"></div>
            <div :class="{'success':strValue==4,'default':strValue<5}"></div>
          </div>
          <div class="liuchnegBox">
            <div
              :class="{'hFagao':strValue == 4,'qFagao':strValue <5}"
              style="width:120px"
              v-if="strValue<5"
            >双方托管合同</div>
            <div class="hFagao" v-if="strValue==5">投融已放弃</div>
            <div
              :class="{'xuqiuH':strValue == 4,'xuqiu':strValue<5}"
              style="margin-left:15px;"
              v-if="strValue<5"
            >
              <span v-if="strValue<5">等待确认</span>
              <i class="iconfont icon-chayueyuanjuan" v-if="strValue ==4"></i>
              <span v-if="strValue ==4">查阅</span>
            </div>
            <div class="xuqiuH" style="margin-left:15px;" v-if="strValue==5">
              <span>投融已放弃</span>
            </div>
            <img :src="jiantouImgUrl" alt v-if="strValue>2" style="padding-left:30px;" />
          </div>
        </div>
        <!-- 内容/合同/协议/确认文书 -->
        <div class="content">
          <div class="boxTitle">内容/合同/协议/确认文书</div>
          <div class="bigcontentBox">
            <div class="touziBox" v-if="strValue==1">
              <div class="tishi">
                <div>
                  <i class="iconfont icon-yinliang"></i>
                  <span>温馨提示：为避免个人隐私泄露，以及获得更多打赏金，建议提交资料前，暂时保密联系方式！</span>
                </div>
              </div>
              <div>
                <div class="nameBox">
                  <span class="name">项目名称：</span>
                  <span class="biaozhi">*</span>
                </div>
                <div class="duanluo">{{dataBox.name}}</div>
              </div>
              <!-- 行业领域 -->
              <div style="display:flex;">
                <div style="width:50%">
                  <div class="nameBox">
                    <span class="name">行业领域：</span>
                    <span class="biaozhi">*</span>
                  </div>
                  <div class="duanluo">{{dataBox.industry_field}}</div>
                </div>
                <div>
                  <div class="name nameBox">期待赏金：</div>
                  <div class="duanluo">
                    <span>{{dataBox.surplus}}</span>
                    <span>元</span>
                  </div>
                </div>
              </div>
              <!-- 项目定位 -->
              <div>
                <div class="nameBox">
                  <span class="name">项目定位：</span>
                  <span class="biaozhi">*</span>
                </div>
                <div class="duanluo">{{dataBox.con}}</div>
              </div>
              <!--  项目亮点-->
              <div>
                <div class="nameBox">
                  <span class="name">项目亮点：</span>
                  <span class="biaozhi">*</span>
                </div>
                <div class="duanluo">{{dataBox.resume}}</div>
              </div>
              <!-- 营收模式 -->
              <div>
                <div class="nameBox">
                  <span class="name">营收模式：</span>
                  <span class="biaozhi">*</span>
                </div>
                <div class="duanluo">{{dataBox.other}}</div>
              </div>
              <!-- 目前用户数据 -->
              <div>
                <div class="nameBox">
                  <span class="name">目前用户数据：</span>
                  <span class="biaozhi">*</span>
                </div>
                <div class="duanluo">{{dataBox.proposal}}</div>
              </div>
              <!-- 目前融资阶段，资金需求，估值 -->
              <div>
                <div class="nameBox">
                  <span class="name">目前融资阶段，资金需求，估值：</span>
                  <span class="biaozhi">*</span>
                </div>
                <div class="duanluo">{{dataBox.examine_opinion}}</div>
              </div>
              <!-- 创始人背景-->
              <div>
                <div class="nameBox">
                  <span class="name">创始人背景：</span>
                  <span class="biaozhi">*</span>
                </div>
                <div class="duanluo">{{dataBox.user_clause}}</div>
              </div>
              <!-- 核心优势（竞争壁垒）-->
              <div>
                <div class="nameBox">
                  <span class="name">核心优势（竞争壁垒）</span>
                  <span class="biaozhi">*</span>
                </div>
                <div class="duanluo">{{dataBox.advantage}}</div>
              </div>
              <!-- 商业计划书（BP）-->
              <div>
                <div class="nameBox">
                  <span class="name">商业计划书（BP）:</span>
                  <span class="biaozhi">*</span>
                </div>
                <!-- 这是一个文件，初次点击没有进行打赏时，弹出提示框提示，需打赏才能进行下一步 -->
                <div class="duanluo">
                  <a :href="dataBox.url">
                    <i class="iconfont icon-wenjian fileBox"></i>
                  </a>
                </div>
              </div>
            </div>
            <!-- 会场介绍 -->
            <div :style="strValue==2?blockValue:noneValue">
              <div class="huichangTitle">双方预约投融介线下见面会</div>
              <div class="yuyue">
                <i class="el-icon-warning-outline"></i>
                <span>请双方彼此都预约选定好时间场次，需要融资的项目人还需要提前准备好您的BP，届时会给每个人20分钟介绍各自项目，您的项目也有可能被其他投资人所青睐哟</span>
              </div>
              <div class="contentBoxA" v-for="(item,index) in dataArr" :key="index">
                <div class="lefthuichang">
                  <div>
                    <span class="lBlue">
                      <i class="iconfont icon-zhuti"></i>
                      <span>主题：</span>
                    </span>
                    <span>{{item.title}}</span>
                  </div>
                  <div>
                    <span class="lBlue">
                      <i class="iconfont icon-dizhi"></i>
                      <span>地址：</span>
                    </span>
                    <span>{{item.region}}</span>
                  </div>
                  <div>
                    <span class="lBlue">
                      <i class="iconfont icon-shijian"></i>
                      <span>时间：</span>
                    </span>

                    <span>
                      {{item.add_time}}
                      <span class="lBlue" style="padding:0 20px">到</span>
                      <span>{{item.end_time}}</span>
                    </span>
                  </div>
                  <div>
                    <span class="lBlue">
                      <i class="iconfont icon-renshu"></i>
                      <span>上限人数：</span>
                    </span>
                    <span>{{item.upper_num}}人</span>
                    <span class="lBlue" style="padding-left:30px;">
                      <span>已报名人数：</span>
                    </span>
                    <span>30人</span>
                  </div>
                  <div>
                    <img v-for="(item1,index1) in item.map_img" :key="index1" :src="item1" alt />
                  </div>
                  <div>
                    <span class="lBlue">
                      <i class="iconfont icon-guanli"></i>
                      <span>已报名项目：</span>
                    </span>
                    <span>
                      <span style="color:#ff0000">10</span>
                      <span>项</span>
                    </span>
                  </div>
                </div>
                <div class="righthuichang">
                  <div class="huanjinBox">
                    <span class="lBlue">会务环境一览</span>
                    <span class="lBlue">{{nowTiem >( new Date(item.end_time))?"活动回顾>":"未开始>"}}</span>
                  </div>
                  <div>
                    <img :src="item.field_img" alt />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- 平台交互，即客服 -->
      <div class="service">
        <liuyan :pid="pid" :uid="uid"></liuyan>
      </div>
    </div>
    <div class="tijiaoBox">
      <!-- 提交 -->
      <div class="tjBox">
        <button
          class="xiugai"
          :style="strValue<3?blockValue:noneValue"
          @click.stop="openShadow"
        >中止，本人放弃该项目</button>
        <button class="xiugai" :style="strValue==3?blockValue:noneValue">上传双方合同扫描件</button>
        <div :style="strValue==3?blockValue:noneValue">作为双方留底备案</div>
      </div>
      <div :style="strValue==2?blockValue:noneValue">
        <div class="zhifuBox">
          <div class="leftsmBox">
            <div>
              <div class="leftsmBox">
                <div style="font-size:18px;color:#000000">会务费：</div>
                <div class="redColor redColorB">￥1111</div>
                <div style="font-size:20px;color:#000000;margin:0 10px;">×</div>
              </div>
              <div style="margin-left:-300px">
                <span class="redColor">*</span>
                <span>含食宿（不低于4星）不含交通费，来往交通预定也可联系官方顾问支撑</span>
              </div>
            </div>

            <div>
              <div class="redColor redColorB">98%</div>
              <div>
                <span class="redColor">*</span>
                <span>代理折扣</span>
                <i class="el-icon-question redColor"></i>
              </div>
            </div>
          </div>
          <div style="font-size:20px;color:#000000;margin:0 10px;">=</div>
          <div class="rightsmBox">
            <div class="redColor redColorB" style="padding:14px 10px;margin-right:10px;">￥1212321123</div>
            <button>立即支付</button>
          </div>
        </div>
        <div>
          <el-radio v-model="radio" label="1">我已确认与对方同期见面会时间，支付后执行下一流程</el-radio>
        </div>
      </div>
      <button
        v-if="strValue==1 ||strValue ==3"
        class="tijiao"
        @click.stop="setinvestmentStatus"
      >确定，本人有意向可执行下一步</button>
    </div>
    <!-- 点击中止项目，弹窗 -->
    <el-dialog
      :visible.sync="dialogVisible"
      width="600px;"
      style="margin-top:100px"
      　　　　:append-to-body="true"
      　　　　:before-close="handleClose"
      :close-on-click-modal="false"
    >
      <div>
        <div style="font-size:36px;text-align: center;margin:80px 0 60px 0">温馨提示：</div>
        <div
          style="font-size:16px;text-align: center;margin-bottom:30px;"
        >1、项目中止，如想找回，请在”删除的项目“栏目中找回；</div>
        <div style="font-size:16px;text-align: center;margin-bottom:80px;">2、项目合同签署后，将不再删除。</div>
        <div style="font-size:16px;text-align: center;margin-bottom:80px;" class="btnBox">
          <button
            @click.stop="closeShadow"
            style=" padding: 10px 60px;font-size: 13px;background: rgb(201,201,201);color: #ffffff;border: 1px solid rgb(201,201,201);margin-right:50px;"
          >返回</button>
          <button
            style=" padding: 10px 60px;font-size: 13px;background: rgb(230,45,49);color: #ffffff;border: 1px solid rgb(230,45,49);"
          >确定</button>
        </div>
      </div>
    </el-dialog>
  </div>
</template>
<script>
import {
  promotionDetails,
  promotionUpd,
  promotionStatus,
  manuscriptsUpd,
  projectDetails,
  investmentStatus,
  Activities
} from "@/api/api";
import liuyan from "../../../components/liuyan/leaveAmessage";
export default {
  data() {
    return {
      radio: 1,
      dialogVisible: false,
      dataBox: [],
      blockValue: { display: "block" },
      noneValue: { display: "none" },
      flexValue: { display: "flex" },
      strValue: "",
      styleV: {
        "font-size": "18px",
        color: "#333333",
        "font-weight": "700"
      },
      imgUrl: require("../../../assets/images/u3829.png"),
      jiantouImgUrl: require("../../../assets/images/u3830.png"),
      successImgurl: require("../../../assets/images/u9821.png"), //成功后背景图
      successImgurl1: require("../../../assets/images/u9830.png"), //任务进行中图标
      // 判断是否成功，修改样式用
      beiyong: true,
      title: "", //文章标题
      duixiang: "", //推广对象
      radio: "1", //内容单选框
      fileList: [],
      xiaoxiContent: "", //客户联系区域，客户输入内容
      tableData: [{ name: "1111111111" }, { name: "1111111111" }],
      xieyiArr: [],
      dis: false, //修改稿件按钮显示隐藏
      url: "", //上传获取链接
      orderId: 0,
      dataArr: [
        {
          id: 4,
          title: "3254235",
          region: "天津市,市辖区,和平区",
          address: "3242342",
          add_time: "2019-11-26 00:00:00",
          end_time: "2019-11-30 00:00:00",
          upper_num: 1,
          cost: "1.00",
          field_img: "http://qiniu.siring.com.cn/ce37120191127115011466.jpg",
          map_img: [
            "http://qiniu.siring.com.cn/ce37120191127115011466.jpg",
            "http://qiniu.siring.com.cn/79cf3201911271150115253.png"
          ]
        },
        {
          id: 4,
          title: "3254235",
          region: "天津市,市辖区,和平区",
          address: "3242342",
          add_time: "2019-11-26 00:00:00",
          end_time: "2019-11-30 00:00:00",
          upper_num: 1,
          cost: "1.00",
          field_img: "http://qiniu.siring.com.cn/ce37120191127115011466.jpg",
          map_img: [
            "http://qiniu.siring.com.cn/ce37120191127115011466.jpg",
            "http://qiniu.siring.com.cn/79cf3201911271150115253.png"
          ]
        },
        {
          id: 4,
          title: "3254235",
          region: "天津市,市辖区,和平区",
          address: "3242342",
          add_time: "2019-11-26 00:00:00",
          end_time: "2019-11-30 00:00:00",
          upper_num: 1,
          cost: "1.00",
          field_img: "http://qiniu.siring.com.cn/ce37120191127115011466.jpg",
          map_img: [
            "http://qiniu.siring.com.cn/ce37120191127115011466.jpg",
            "http://qiniu.siring.com.cn/79cf3201911271150115253.png"
          ]
        },
        {
          id: 4,
          title: "3254235",
          region: "天津市,市辖区,和平区",
          address: "3242342",
          add_time: "2019-11-26 00:00:00",
          end_time: "2019-11-30 00:00:00",
          upper_num: 1,
          cost: "1.00",
          field_img: "http://qiniu.siring.com.cn/ce37120191127115011466.jpg",
          map_img: [
            "http://qiniu.siring.com.cn/ce37120191127115011466.jpg",
            "http://qiniu.siring.com.cn/79cf3201911271150115253.png"
          ]
        }
      ], //会场介绍
      pid: 0,
      uid: 0,
      nowTiem: 0
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.strValue = this.$route.params.strValue;
      this.orderId = this.$route.params.orderId;
      this.pid = this.$route.params.orderId;
      this.uid = sessionStorage.getItem("user_id");
      this.getprojectDetails();
      this.getActivities();
      this.nowTiem = new Date().getTime();
      let date = "2019-11-26 00:00:00";
      console.log(this.nowTiem);
    },
    // 弹窗遮罩
    openShadow() {
      this.dialogVisible = true;
    },
    closeShadow() {
      this.dialogVisible = false;
    },
    handleClose(done) {
      this.$confirm("确认关闭？")
        .then(_ => {
          done();
        })
        .catch(_ => {});
    },
    showMsg(msg, code) {
      this.$message({
        message: msg,
        type: code === 1 ? "success" : "error"
      });
    },
    // 获取项目内容
    getprojectDetails() {
      const params = { id: parseInt(this.orderId) };
      projectDetails(params).then(res => {
        let { data, code, msg } = res;
        if (code == 1) {
          this.dataBox = data;
        }
      });
    },
    // 状态改变
    setinvestmentStatus() {
      let params = {
        order_id: parseInt(this.orderId),
        status: parseInt(this.strValue)
      };
      investmentStatus(params).then(res => {
        let { code, msg } = res;
        if (code == 1) {
          this.showMsg(msg, code);
          this.strValue = this.strValue + 1;
        }
      });
    },
    // 会场介绍
    getActivities() {
      Activities().then(res => {
        let { code, data, msg } = res;
        if (code == 1) {
          console.log(data);
          this.dataArr = data;
        }
      });
    }
  },
  components: {
    liuyan
  }
};
</script>
<style lang="scss" scoped>
.box {
  background: rgb(242, 247, 250);
  ul,
  li {
    list-style: none;
  }
  .smBox {
    background: #ffffff;
    padding: 10px 20px;
    .TopHeader {
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid rgb(201, 201, 201);
      padding: 10px 0;
      i {
        color: rgb(216, 30, 6);
        font-weight: 700;
        font-size: 22px;
        padding-right: 15px;
      }
      div {
        &:nth-of-type(1) {
          display: flex;
          align-items: center;
          > div {
            border: 1px dotted rgb(121, 121, 121);
            border-radius: 10px;
            padding: 5px 10px;
            li {
              padding-top: 5px;
              font-size: 13px;
              color: #333333;
              text-align: left;
              &:nth-of-type(1) {
                padding: 0;
              }
              span {
                font-size: 18px;
              }
            }
          }
        }
        &:nth-of-type(2) {
          button {
            background: rgb(255, 0, 0);
            border: 1px solid rgb(255, 0, 0);
            border-radius: 5px;
            color: #ffffff;
            padding: 10px 40px;
            font-size: 18px;
          }
        }
      }
    }
    .liuchengBiaozhi {
      display: flex;
      margin: 10px 0 0 30px;
      .liuchnegBox {
        width: 123px;
        text-align: center;
        .qFagao {
          background: rgb(161, 161, 161);
          padding: 8px 20px;
          border-radius: 15px;
          color: #ffffff;
          font-weight: 700;
        }
        .hFagao {
          background: rgb(102, 153, 0);
          padding: 8px 20px;
          border-radius: 15px;
          color: #ffffff;
          font-weight: 700;
        }
        .xuqiu {
          width: 123px;
          height: 84px;
          background-image: url("../../../assets/images/u3829.png");
          text-align: center;
          line-height: 84px;
          color: #ff0000;
        }
        .xuqiuH {
          width: 123px;
          height: 84px;
          background-image: url("../../../assets/images/u9821.png");
          text-align: center;
          line-height: 84px;
          color: #ff0000;
          i {
            color: rgb(102, 153, 0);
            font-size: 32px;
          }
          span {
            color: rgb(102, 153, 0);
          }
        }
      }
      .henggang {
        display: flex;
        // margin-top: 14px;
        margin: 14px 5px 0 5px;
        .success {
          width: 22px;
          height: 3px;
          background: rgb(102, 153, 0);
        }
        .default {
          width: 22px;
          height: 3px;
          background: rgb(119, 119, 119);
        }
      }
    }
  }
  .boxTitle {
    padding: 5px;
    background: rgb(207, 234, 239);
    color: rgb(47, 121, 140);
    font-weight: 700;
    // margin-bottom: 20px;
  }
  .bigcontentBox {
    border-left: 2px solid rgb(240, 248, 250);
    border-bottom: 2px solid rgb(240, 248, 250);
    border-right: 2px solid rgb(240, 248, 250);
    padding-top: 30px;
    margin-bottom: 15px;
  }
  .contentBox {
    width: 70%;
    margin-left: 15%;
    > div {
      width: 100%;
      margin-bottom: 30px;
      display: flex;
      > div:nth-of-type(1) {
        width: 100px;
        font-size: 13px;
        color: #999999;
        margin-right: 20px;
        text-align: right;
        box-sizing: border-box;
      }
    }
    .titleBox {
      > div {
        &:nth-of-type(1) {
          margin-top: 15px;
        }
        &:nth-of-type(2) {
          width: 100%;
          > div {
            &:nth-of-type(2) {
              font-size: 13px;
              color: #949494;
              margin-top: 5px;
              margin-left: 10px;
            }
          }
        }
      }
    }
    .dengjiBox {
      display: flex;
      align-items: center;
      .dengji {
        display: flex;
        align-items: center;
        > div {
          border: 1px solid rgb(228, 228, 228);
          height: 28.38px;
          box-sizing: border-box;
          padding: 8px 40px;
          font-size: 13px;
          border-left: 0;
          color: #333333;
          &:nth-of-type(2) {
            padding: 8px 48px;
          }
          &:nth-of-type(3) {
            padding: 8px 65px;
          }
        }
      }
    }
  }
  .noneDisplayBox {
    // display: flex;
    // align-items: center;
    height: 500px;
    // justify-content: center;
    text-align: center;
    margin-top: 200px;
    font-size: 20px;
    color: #c9c9c9;
    font-weight: 700;
    img {
      width: 100px;
      height: 100px;
      padding-bottom: 30px;
    }
    > div {
      text-align: center;
    }
  }
  .querenGaojian {
    border-left: 2px solid rgb(240, 248, 250);
    border-bottom: 2px solid rgb(240, 248, 250);
    border-right: 2px solid rgb(240, 248, 250);
    padding: 0 30px;
    color: #333333;
    height: 620px;
    overflow-y: scroll;
    .title {
      margin: 30px 0;
      text-align: center;
      font-size: 20px;
      color: #333333;
      font-weight: 700;
    }
    .suojin {
      text-indent: 35px;
    }
    .fendian {
      margin-top: 20px;
      > div {
        &:nth-of-type(1) {
          font-size: 18px;
          font-weight: 700;
          color: #333333;
        }
      }
    }
  }
  .ZTsucceed {
    border-left: 2px solid rgb(240, 248, 250);
    border-bottom: 2px solid rgb(240, 248, 250);
    border-right: 2px solid rgb(240, 248, 250);
    padding-bottom: 20px;
    overflow-y: scroll;
    height: 620px;
    > div {
      &:nth-of-type(1) {
        font-size: 28px;
        text-align: center;
        color: #333333;
        padding: 20px 0;
      }
      &:nth-of-type(2) {
        width: 80%;
        margin: 0 10%;
      }
    }
  }
  .service {
    border-left: 2px solid rgb(240, 248, 250);
    border-bottom: 2px solid rgb(240, 248, 250);
    border-right: 2px solid rgb(240, 248, 250);
    margin-bottom: 10px;
    .serviceContent {
      height: 350px;
      background: rgb(242, 242, 242);
    }
    .btnValueBox {
      background: rgb(247, 247, 247);
      padding: 20px 50px;
      display: flex;
      align-items: center;
      input {
        height: 45px;
        border-radius: 5px;
        border: 0.5px solid rgb(247, 247, 247);
        width: 80%;
        margin-right: 30px;
      }
      i {
        font-size: 36px;
        color: rgb(121, 121, 121);
        margin-right: 30px;
      }
      .wuButton {
        background: #ffffff;
        color: rgb(102, 204, 0);
      }
      .yButton {
        background: rgb(102, 204, 0);
        color: #ffffff;
      }
      button {
        border-radius: 5px;
        border: 1px solid rgb(102, 204, 0);
        padding: 10px 50px;
      }
    }
  }
  .tijiaoBox {
    background: #ffffff;
    text-align: right;
    padding-bottom: 15px;
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    .tijiao {
      margin-right: 100px;
      background: rgb(255, 0, 0);
      border: 1px solid rgb(255, 0, 0);
      color: #ffffff;
      border-radius: 30px;
      padding: 10px 40px;
      outline: none;
    }
    .xiugai {
      margin-left: 50px;
      background: rgb(0, 0, 255);
      border: 1px solid rgb(0, 0, 255);
      color: #ffffff;
      border-radius: 30px;
      padding: 10px 40px;
      outline: none;
      position: relative;
      z-index: 5;
    }
  }
  .kongzhiBox {
    display: flex;
    margin-left: -155px;
    .shangchuan {
      color: rgba(255, 0, 0, 1);
      border: 1px solid rgb(255, 0, 0);
      padding: 0px 20px;
      border-radius: 3px;
      display: flex;
      align-items: center;
      font-size: 13px;
      height: 30px;
    }
    .xiazai {
      color: rgba(0, 0, 255, 1);
      border: 1px solid rgb(0, 0, 255);
      padding: 0px 20px;
      border-radius: 3px;
      margin-right: 10px;
      display: flex;
      align-items: center;
      font-size: 13px;
      height: 30px;
    }
  }
  .tjBox {
    align-items: center;
  }
}
.touziBox {
  padding: 20px 50px;
  font-size: 13px;
  color: #333333;
  overflow-y: scroll;
  height: 670px;
  > div {
    margin-bottom: 20px;
  }
  .name {
    font-size: 18px;
    color: #000000;
  }
  .nameBox {
    margin-bottom: 15px;
  }
  .biaozhi {
    font-size: 18px;
    color: #ff0000;
  }
  .duanluo {
    padding-left: 30px;
    line-height: 20px;
  }
  .btnBox {
    button {
      padding: 20px;
      font-size: 13px;
      background: rgb(201, 201, 201);
      color: #ffffff;
      border: 1px solid rgb(201, 201, 201);
    }
  }
}
.zhifuBox,
.leftsmBox,
.rightsmBox {
  display: flex;
  align-items: center;
  font-size: 13px;
  color: #797979;
  button {
    color: #ffffff;
    border: 1px solid rgb(230, 45, 49);
    background: rgb(230, 45, 49);
    border-radius: 3px;
    padding: 10px 20px;
    margin-right: 40px;
  }
}
.lefthuichang {
  width: 60%;
  margin-right: 10%;
  img {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    padding-right: 10px;
  }
  > div {
    margin-bottom: 10px;
  }
  i{
    padding-right: 10px;
  }
}
.righthuichang {
  img {
    display: inline-block;
    width: 274px;
    height: 213px;
  }
}
.redColor {
  color: #ff0000;
  font-size: 18px;
}
.redColorB {
  border: 1px solid #797979;
  padding: 5px 10px;
}
.huichangTitle {
  font-size: 24px;
  color: #000000;
  font-weight: 700;
  text-align: center;
  margin-bottom: 10px;
}
.yuyue {
  text-align: center;
  color: #ff0000;
  margin-bottom: 10px;
  i {
    font-weight: 700;
    font-size: 18px;
    padding-right: 5px;
  }
}
.lBlue {
  color: #169bd5;
}
.contentBoxA {
  margin: 20px auto;
  display: flex;
  padding: 10px 10px;
  width: 1200px;
  border: 1px dashed;
  justify-content: space-between;
}
.huanjinBox {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}
</style>
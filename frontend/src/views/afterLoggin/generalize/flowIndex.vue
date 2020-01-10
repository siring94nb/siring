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

        <div>
          <el-button type="button" @click.stop="tiaozhuan">新发稿</el-button>
        </div>
      </div>
      <!-- 代写稿件 -->
      <div>
        <!-- 流程标签 -->
        <div class="liuchengBiaozhi">
          <div class="liuchnegBox" v-if="leixing==1">
            <div :class="{'hFagao':strValue !=1,'qFagao':strValue ==1}">我要发稿</div>
            <div :class="{'xuqiuH':strValue !=1,'xuqiu':strValue == 1}">
              <span v-if="strValue ==1">等待需求确认</span>
              <i class="iconfont icon-chayueyuanjuan" v-if="strValue !=1"></i>
              <span v-if="strValue !=1">查阅</span>
            </div>
            <img :src="jiantouImgUrl" alt v-if="strValue ==1" />
          </div>
          <div class="henggang" v-if="leixing==1">
            <div :class="{'success':strValue>=2,'default':strValue==1}"></div>
            <div :class="{'success':strValue>=4,'default':strValue<=3}"></div>
          </div>
          <div class="liuchnegBox">
            <div :class="{'hFagao':strValue >= 4,'qFagao':strValue <=3}">确认稿件</div>
            <div :class="{'xuqiuH':strValue >= 4,'xuqiu':strValue <=3}">
              <span v-if="strValue <=3">等待稿件确认</span>
              <i class="iconfont icon-chayueyuanjuan" v-if="strValue >=3"></i>
              <span v-if="strValue >=3">查阅</span>
            </div>
            <img :src="jiantouImgUrl" alt v-if="strValue==2" />
          </div>
          <div class="henggang">
            <div :class="{'success':strValue>=4,'default':strValue<4}"></div>
            <div :class="{'success':strValue==5,'default':strValue<5}"></div>
          </div>
          <div class="liuchnegBox">
            <div :class="{'hFagao':strValue == 5,'qFagao':strValue <5}">推广运营</div>
            <div :class="{'xuqiuH':strValue == 5,'xuqiu':strValue<5}">
              <span v-if="strValue<5">发布中</span>
              <i class="iconfont icon-chayueyuanjuan" v-if="strValue ==5"></i>
              <span v-if="strValue ==5">查阅</span>
            </div>
            <img :src="jiantouImgUrl" alt v-if="strValue>2" />
          </div>
        </div>
        <!-- 内容/合同/协议/确认文书 -->
        <div class="content">
          <div class="boxTitle">内容/合同/协议/确认文书</div>
          <div class="bigcontentBox" :style="strValue==1?blockValue:noneValue">
            <div class="contentBox">
              <div class="titleBox">
                <div>文章标题</div>
                <div>
                  <div>
                    <el-input
                      v-model="title"
                      :value="xieyiArr.name"
                      maxlength="15"
                      placeholder="请输入"
                    ></el-input>
                  </div>
                  <div>不超过15字</div>
                </div>
              </div>
              <div class="titleBox">
                <div>推广对象</div>
                <div>
                  <div>
                    <el-input
                      :value="xieyiArr.resume"
                      v-model="duixiang"
                      maxlength="20"
                      placeholder="推广的产品或者公司名称"
                    ></el-input>
                  </div>
                  <div>不超过20字</div>
                </div>
              </div>
              <div>
                <div style="margin-right:10px;padding-right:10px;">内容</div>
                <el-radio label="1" v-model="radio" v-if="xieyiArr.need_status==1">自由型</el-radio>
                <el-radio label="1" v-model="radio" v-if="xieyiArr.need_status==2">采访型</el-radio>
                <el-radio label="1" v-model="radio" v-if="xieyiArr.need_status==3">评论型</el-radio>
                <el-radio label="1" v-model="radio" v-if="xieyiArr.need_status==4">广告型</el-radio>
                <el-radio label="1" v-model="radio" v-if="xieyiArr.need_status==5">炒作型</el-radio>
                <el-radio label="1" v-model="radio" v-if="xieyiArr.need_status==6">故事型</el-radio>
                <el-radio label="1" v-model="radio" v-if="xieyiArr.need_status==7">热点型</el-radio>
                <el-radio label="1" v-model="radio" v-if="xieyiArr.need_status==8">新闻型</el-radio>
              </div>
              <div>
                <div style="margin-top:15px">参考文章链接</div>
                <el-input placeholder="供写手参考的文章地址"></el-input>
              </div>
              <div class="dengjiBox">
                <div style="margin-right:10px;padding-right:10px;">选择高手等级</div>
                <div class="dengji">
                  <el-radio
                    label="1"
                    v-model="radio"
                    style="border:1px solid rgb(228,228,228);padding:5px 10px 5px 25px;margin-right:0 "
                  >&nbsp;</el-radio>
                  <div>{{xieyiArr.grade==1?"普通":xieyiArr.grade==2?"高手":"资深"}}</div>
                  <div>出稿时间1-2工作日，稿件不满意最多只能修改一次，下单前请看好备注！</div>
                </div>
              </div>
              <div>
                <div style="margin-right:10px;padding-right:10px;">字数</div>
                <el-radio label="1" v-if="xieyiArr.num==1">0到500</el-radio>
                <el-radio label="1" v-if="xieyiArr.num==2">500到1000</el-radio>
                <el-radio label="1" v-if="xieyiArr.num==3">1000到1500字</el-radio>
                <el-radio label="1" v-if="xieyiArr.num==4">1500到2000字</el-radio>
              </div>
              <div>
                <div style="margin-right:10px;padding-right:10px;">
                  <span style="color:#ff0000">*</span>
                  <span>上传您要推广的要求</span>
                </div>
                <div>
                  <el-upload
                    name="image"
                    class="upload-demo"
                    action="https://jsonplaceholder.typicode.com/posts/"
                    multiple
                    :limit="1"
                    :on-exceed="handleExceed"
                    :file-list="fileList"
                    :on-success="handleAvatarSuccess"
                  >
                    <el-button size="small" type="primary">点击上传</el-button>
                    <div
                      slot="tip"
                      class="el-upload__tip"
                    >最多一个上传一个文件，多个文件可使用压缩格式；支持txt、ppt、pptx、doc、docx、xls、xlsx、pdf、png、jpg、jpeg，RAR，ZIP附件大小不超过50M。</div>
                  </el-upload>
                </div>
              </div>
            </div>
          </div>
          <!-- 提交成功时，显示任务正在进行， -->
          <div class="noneDisplayBox" :style="strValue==2||strValue==4?blockValue:noneValue">
            <div>
              <img :src="successImgurl1" alt="任务进行中" />
              <div v-if="strValue==2">代写中，请耐心等待</div>
              <div v-if="strValue==4">发布中，请耐心等候</div>
            </div>
          </div>
          <!-- 确认稿件按钮点击后显示 -->
          <div class="querenGaojian" :style="strValue==3?blockValue:noneValue">
            <div class="title">Siring思锐——定制开发运营推广领航者</div>
            <div>
              <div class="suojin">
                每个做产品做项目的人都怀揣梦想，梦想的实现却不是一帆风顺的，总是以为一款APP的面世之后，
                躺着就能把钱赚了，获得丰厚的回报，殊不知这中间要经历太多的过程，深圳市思锐信息技术有限公司（Siring思锐）不单能定制化各类创意项目，
                同时我们在项目推广和运营中也积累了丰富的实战经验，借此机会，我们与所有为了梦想而奋斗的的企业或个人将我们的经验与您共勉。
              </div>
              <div class="fendian">
                <div>1.创意引领项目工程</div>
                <div class="suojin">
                  每个做产品做项目的人都怀揣梦想，梦想的实现却不是一帆风顺的，总是以为一款APP的面世之后，
                  躺着就能把钱赚了，获得丰厚的回报，殊不知这中间要经历太多的过程，深圳市思锐信息技术有限公司（Siring思锐）不单能定制化各类创意项目，
                  同时我们在项目推广和运营中也积累了丰富的实战经验，借此机会，我们与所有为了梦想而奋斗的的企业或个人将我们的经验与您共勉。
                </div>
              </div>
            </div>
          </div>
          <!-- 智推完成结果反馈 -->
          <div class="ZTsucceed" :style="strValue==5?blockValue:noneValue">
            <div>智推报告</div>
            <div>
              <el-table :data="tableData" border style="width: 100%" :header-cell-style="styleV">
                <el-table-column align="center" prop="name" label="媒体分类" width="245"></el-table-column>
                <el-table-column prop="name" align="center" label="媒体名称" width="245"></el-table-column>
                <el-table-column prop="name" align="center" label="价格" width="245"></el-table-column>
                <el-table-column prop="name" align="center" label="入口"></el-table-column>
              </el-table>
            </div>
          </div>
        </div>
      </div>
      <!-- 自撰稿件 -->
      <div style="display:none">
        <div class="liuchengBiaozhi">
          <div class="liuchnegBox">
            <div :class="{hFagao:beiyong,qFagao:!beiyong}">确认稿件</div>
            <div class="xuqiuH">
              <span v-if="false">等待需求确认</span>
              <i class="iconfont icon-chayueyuanjuan" v-if="true"></i>
              <span v-if="true">查阅</span>
            </div>
            <img :src="jiantouImgUrl" alt v-if="false" />
          </div>
          <div class="henggang">
            <div class="success"></div>
            <div class="default"></div>
          </div>
          <div class="liuchnegBox">
            <div class="qFagao">推广运营</div>
            <div class="xuqiu">
              <span v-if="true">等待稿件确认</span>
              <i class="iconfont icon-chayueyuanjuan" v-if="false"></i>
              <span v-if="false">查阅</span>
            </div>
            <img :src="jiantouImgUrl" alt v-if="true" />
          </div>
        </div>
        <div class="boxTitle">内容/合同/协议/确认文书</div>
        <!-- 确认稿件按钮点击后显示 -->
        <div class="querenGaojian" style="display:block">
          <div class="title">Siring思锐——定制开发运营推广领航者</div>
          <div>
            <div class="suojin">
              每个做产品做项目的人都怀揣梦想，梦想的实现却不是一帆风顺的，总是以为一款APP的面世之后，
              躺着就能把钱赚了，获得丰厚的回报，殊不知这中间要经历太多的过程，深圳市思锐信息技术有限公司（Siring思锐）不单能定制化各类创意项目，
              同时我们在项目推广和运营中也积累了丰富的实战经验，借此机会，我们与所有为了梦想而奋斗的的企业或个人将我们的经验与您共勉。
            </div>
            <div class="fendian">
              <div>1.创意引领项目工程</div>
              <div class="suojin">
                每个做产品做项目的人都怀揣梦想，梦想的实现却不是一帆风顺的，总是以为一款APP的面世之后，
                躺着就能把钱赚了，获得丰厚的回报，殊不知这中间要经历太多的过程，深圳市思锐信息技术有限公司（Siring思锐）不单能定制化各类创意项目，
                同时我们在项目推广和运营中也积累了丰富的实战经验，借此机会，我们与所有为了梦想而奋斗的的企业或个人将我们的经验与您共勉。
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- 平台交互，即客服 -->
      <div class="service">
        <liuyan :pid = pid :uid=uid></liuyan>
      </div>
    </div>
    <div class="tijiaoBox">
      <!-- 提交 -->
      <div class="tjBox" :style="strValue==3?flexValue:noneValue">
        <button class="xiugai" @click.stop="xiugaigaojian">我要修改稿件</button>
        <div class="kongzhiBox">
          <div class="xiazai"><a :href="xieyiArr.url">下载</a></div>
          <div class="shangchuan" @click.stop="setmanuscriptsUpd">上传</div>
        </div>
      </div>

      <div :style="strValue!=3?blockValue:noneValue"></div>
      <button class="tijiao" @click="strValue==1?setpromotionUpd:setpromotionStatus">确定，本人已确认该需求方案</button>
    </div>
  </div>
</template>
<script>
import { promotionDetails, promotionUpd, promotionStatus,manuscriptsUpd } from "@/api/api";
import liuyan from "../../../components/liuyan/leaveAmessage"
export default {
  data() {
    return {
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
      dis:false,//修改稿件按钮显示隐藏
      url:"",//上传获取链接
      leixing:"",//判断是自撰稿件还是代写稿件
      pid:"",
      uid:''
    };
  },
  mounted() {
    this.getpromotionDetails();
    this.init();
  },
  methods: {
    init() {
      this.strValue = this.$route.params.strValue;
      this.leixing = this.$route.params.leixing;
      this.pid = this.$route.params.orderId;
      this.uid = sessionStorage.getItem("user_id")
    },
    showMsg(msg, code) {
      this.$message({
        message: msg,
        type: code === 1 ? "success" : "error"
      });
    },
    handleExceed(files, fileList) {
      this.$message.warning(`当前限制仅能选择上传 1 个文件`);
    },
    //新发稿跳转
    tiaozhuan() {
      this.$router.push("/newManuscript");
    },
    // 需求确认，合同协议，确认文书内容，在上一页跳转时带参数传递
    getpromotionDetails() {
      // 上一页面通过路由传参
      let orderId = this.$route.params.orderId;
      let params = { order_id: orderId };
      promotionDetails(params).then(res => {
        let { data, code } = res;
        if (code == 1) {
          this.xieyiArr = data;
          this.fileList = [{ name: "需求文件", url: data.url }];
        }
        console.log(res);
      });
    },
    // 订单修改
    setpromotionUpd() {
      let orderId = this.$route.params.orderId;
      let params = {
        id: orderId,
        name: this.title,
        resume: this.duixiang,
        grade: this.xieyiArr.num,
        url: this.url,
        need_status: this.xieyiArr.need_status,
        num: this.xieyiArr.num
      };
      promotionUpd(params).then(res => {});
    },
    // 确认状态
    setpromotionStatus() {
      let orderId = this.$route.params.orderId;
      let params = {
        order_id: orderId,
        strValue: this.strValue
      };
      promotionStatus(params).then(res => {
        let { code, msg } = res;
        if (code == 1 && this.strValue<5) {
          this.showMsg(msg, code);
          this.strValue = this.strValue+1;
        }
      });
    },
    // 修改稿件按钮点击
    xiugaigaojian(){
      let kongzhiBoxA = document.getElementsByClassName("kongzhiBox")[0];
      if(this.dis){
        kongzhiBoxA.style="margin-left:-155px;transition: all 1s"
        this.dis = false
      }else{
        kongzhiBoxA.style="margin-left:50px; transition: all 1s"
        this.dis = true
      }
      
    },
    // AI修改稿件
    setmanuscriptsUpd(){
      let params = {
        order_id:this.strValue,
        url:this.url
      }
      manuscriptsUpd(params).then(res=>{
        if (code == 1) {
          this.showMsg(msg, code);
        }
      })
    },
    // 测试上传数据回调
    handleAvatarSuccess(res, file) {
      console.log(res.data.filePath)
      this.url = res.data.filePath
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
  .tjBox{
    align-items: center;
  }
}
</style>
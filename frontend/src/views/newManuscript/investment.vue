<template>
  <div style="margin-top:100px;background:rgb(246,246,246);min-height:100vh">
    <Myheader />
    <div style="padding-top:10px; padding-bottom:130px;max-width:1260px;margin:0 auto">
      <div style="margin-bottom: 50px;">
        <div class="title">投融介</div>
        <div class="left">
          <Quickaside />
        </div>
        <div class="right">
          <el-tabs v-model="activeName" style="background:#ffffff; padding:20px 20px 30px 20px;">
            <el-tab-pane label="我要投资" name="first" :key="'first'">
              <div class="touziBox">
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
                  <div class="duanluo">
                    {{dataBox.con}}
                  </div>
                </div>
                <!--  项目亮点-->
                <div>
                  <div class="nameBox">
                    <span class="name">项目亮点：</span>
                    <span class="biaozhi">*</span>
                  </div>
                  <div class="duanluo">
                   {{dataBox.resume}}
                  </div>
                </div>
                <!-- 营收模式 -->
                <div>
                  <div class="nameBox">
                    <span class="name">营收模式：</span>
                    <span class="biaozhi">*</span>
                  </div>
                  <div class="duanluo">
                    {{dataBox.other}}
                  </div>
                </div>
                <!-- 目前用户数据 -->
                <div>
                  <div class="nameBox">
                    <span class="name">目前用户数据：</span>
                    <span class="biaozhi">*</span>
                  </div>
                  <div class="duanluo">
                    {{dataBox.proposal}}
                  </div>
                </div>
                <!-- 目前融资阶段，资金需求，估值 -->·
                <div>
                  <div class="nameBox">
                    <span class="name">目前融资阶段，资金需求，估值：</span>
                    <span class="biaozhi">*</span>
                  </div>
                  <div class="duanluo">
                    {{dataBox.examine_opinion}}
                  </div>
                </div>
                <!-- 创始人背景-->
                <div>
                  <div class="nameBox">
                    <span class="name">创始人背景：</span>
                    <span class="biaozhi">*</span>
                  </div>
                  <div class="duanluo">
                    {{dataBox.user_clause}}
                  </div>
                </div>
                <!-- 核心优势（竞争壁垒）-->
                <div>
                  <div class="nameBox">
                    <span class="name">核心优势（竞争壁垒）</span>
                    <span class="biaozhi">*</span>
                  </div>
                  <div class="duanluo">
                    {{dataBox.advantage}}
                  </div>
                </div>
                <!-- 商业计划书（BP）-->
                <div>
                  <div class="nameBox">
                    <span class="name">商业计划书（BP）:</span>
                    <span class="biaozhi">*</span>
                  </div>
                  <!-- 这是一个文件，初次点击没有进行打赏时，弹出提示框提示，需打赏才能进行下一步 -->
                  <div class="duanluo">
                    <a :href="dataBox.url"><i class="iconfont icon-wenjian fileBox"></i></a>
                  </div>
                </div>
              </div>
            </el-tab-pane>

            <el-tab-pane label="我要融资" name="second" :key="'second'">
              <div class="rongziBox">
                <div class="tishi">
                  <div>
                    <i class="iconfont icon-yinliang"></i>
                    <span>温馨提示：为避免个人隐私泄露，以及获得更多打赏金，建议提交资料前，暂时保密联系方式！</span>
                  </div>
                </div>
                <div>
                  <div class="titleBox">
                    <span class="title">项目名称：</span>
                    <span class="biaozhi">*</span>
                  </div>
                  <div class="miaoshu">对外推广的主体，不超过20个字</div>
                  <el-input v-model="xiangmuName" placeholder="项目主体" maxlength="20"></el-input>
                </div>
                <div style="display:flex">
                  <div style="width:48%">
                    <div class="titleBox">
                      <span class="title">行业领域：</span>
                      <span class="biaozhi">*</span>
                    </div>
                    <div class="miaoshu">项目归属方向</div>
                    <el-select style="width:350px" :value="hangyeItem" @change="selectFn($event)">
                      <el-option v-for="(item,index) in hangye" :value="item.id" :key="index">{{item.title}}</el-option>
                    </el-select>
                  </div>
                  <div>
                    <div class="titleBox">
                      <span class="title">期望打赏金：</span>
                      <span class="biaozhi">*</span>
                    </div>
                    <div class="miaoshu">如不填写，默认要求打赏金10元，款项扣除20%交易费后，将打入您的余额中</div>
                    <div style="display:flex;align-items:center">
                      <el-input v-model="shangjin" style="width:430px" placeholder="不大于100" maxlength="20"></el-input>
                      <span style="color:#ff0000;font-size:18px;padding-left:10px;">元</span>
                    </div>
                  </div>
                </div>
                <!-- 项目定位 -->
                <div>
                  <div class="titleBox">
                    <span class="title">项目定位：</span>
                    <span class="biaozhi">*</span>
                  </div>
                  <div class="miaoshu">垂直细分领域描述（譬如：草本养生的内容电商、人工智能时尚配饰）</div>
                  <el-input v-model="xmDingwei" type="textarea"></el-input>
                </div>
                <!-- 营收模式 -->
                <div>
                  <div class="titleBox">
                    <span class="title">营收模式：</span>
                    <span class="biaozhi">*</span>
                  </div>
                  <div class="miaoshu">表明什么样核心用户在哪些核心场景下进行支付（譬如：一线城市刚毕业的大学生在某某APP购买初入职场必备的知识服务）</div>
                  <el-input v-model="yinghsou" type="textarea"></el-input>
                </div>
                <!-- 目前用户数据 -->
                <div>
                  <div class="titleBox">
                    <span class="title">目前用户数据：</span>
                    <span class="biaozhi">*</span>
                  </div>
                  <div
                    class="miaoshu"
                  >例：APP用户数/微博用户数/微信用户数/其他平台合计用户数（如今日头条、一点资讯等新媒体分发平台，或各类直播平台等）；已有支付行为用户数；客单价；</div>
                  <el-input v-model="dquser" type="textarea"></el-input>
                </div>
                <!-- 目前融资阶段 -->
                 <div style="display:flex">
                  <div style="width:48%">
                    <div class="titleBox">
                      <span class="title">目前融资阶段：</span>
                      <span class="biaozhi">*</span>
                    </div>
                    <div class="miaoshu">表明目前项目处于种子轮、天使轮、A轮、A+等轮次</div>
                    <el-select style="width:350px" :value="rzjieduanItem" @change="selectFn($event)">
                      <el-option v-for="(item,index) in rongzi" :value="item.id" :key="index">{{item.title}}</el-option>
                    </el-select>
                  </div>
                  <div>
                    <div class="titleBox">
                      <span class="title">资金需求：</span>
                      <span class="biaozhi">*</span>
                    </div>
                    <div class="miaoshu">期望融资金额</div>
                    <div style="display:flex;align-items:center">
                      <el-input v-model="rzje" style="width:410px;" maxlength="20"></el-input>
                      <span style="color:#ff0000;font-size:18px;padding-left:10px;">万元</span>
                    </div>
                  </div>
                </div>
                <!-- <div>
                  <div class="titleBox">
                    <span class="title">目前融资阶段，资金需求，估值：</span>
                    <span class="biaozhi">*</span>
                  </div>
                  <div class="miaoshu">表明目前项目处于种子轮、天使轮、A轮、A+等轮次。例如：天使伦/200万/出让10%股权；</div>
                  <el-input v-model="rongzi" type="textarea"></el-input>
                </div> -->
                <!-- 股份出让及估值 -->
                <div style="display:flex">
                  <div style="width:48%">
                    <div class="titleBox">
                      <span class="title">出让股份：</span>
                      <span class="biaozhi">*</span>
                    </div>
                    <div class="miaoshu">例如：10%股份</div>
                   <div style="display:flex;align-items:center">
                      <el-input v-model="gfzhuanrangItem"  style="width:350px;" ></el-input>
                      <span style="color:#ff0000;font-size:18px;padding-left:10px;">%</span>
                    </div>
                  </div>
                  <div>
                    <div class="titleBox">
                      <span class="title">估值：</span>
                      <span class="biaozhi">*</span>
                    </div>
                    <div class="miaoshu">现阶段项目估值</div>
                    <div style="display:flex;align-items:center">
                      <el-input v-model="guzhi"  style="width:410px;" maxlength="20"></el-input>
                      <span style="color:#ff0000;font-size:18px;padding-left:10px;">万元</span>
                    </div>
                  </div>
                </div>
                <!-- 创始人背景 -->
                <div>
                  <div class="titleBox">
                    <span class="title">创始人背景：</span>
                    <span class="biaozhi">*</span>
                  </div>
                  <div class="miaoshu">
                    <div>主要写第一、第二创始人的过往公司和主要负责岗位。</div>
                    <div>譬如：第一创始人 张三 （男）前华谊兄弟集团 发行总监，主管国内发行业务；</div>
                    <div>第二创始人 李四 （女）前百度运营中心副总裁/ 主管新媒体矩阵事业发展；</div>
                  </div>
                  <el-input v-model="beijing" type="textarea"></el-input>
                </div>
                <!-- 项目亮点 -->
                <div>
                  <div class="titleBox">
                    <span class="title">项目亮点：</span>
                    <span class="biaozhi">*</span>
                  </div>
                  <div class="miaoshu">
                    <div>主要写明项目出彩的地方；</div>
                  </div>
                  <el-input v-model="liangdian" type="textarea"></el-input>
                </div>
                <!-- 核心优势（竞争壁垒） -->
                <div>
                  <div class="titleBox">
                    <span class="title">核心优势：</span>
                    <span class="biaozhi">*</span>
                  </div>
                  <div class="miaoshu">
                    <div>主要写明稀有资源或独家技术或版权等；</div>
                    <div>譬如：拥有在全息影像呈现艺术作品精确度上有核心专利技术；</div>
                  </div>
                  <el-input v-model="youshi" type="textarea"></el-input>
                </div>
                <!-- 商业计划书 -->
                <div>
                  <div class="titleBox">
                    <span class="title">商业计划书（BP）：</span>
                    <span class="biaozhi">*</span>
                  </div>
                  <div class="miaoshu">支持ppt, pdf, doc, exl,等格式；最多上传1份方案；</div>
                  <div>
                    <el-upload
                      name="image"
                      class="upload-demo"
                      :action="aUrl"
                      :on-success="handleAvatarSuccess"
                      :before-upload="beforeAvatarUpload"
                    >
                      <el-button size="small" type="primary">点击上传</el-button>
                    </el-upload>
                  </div>
                </div>
                <div class="yulanBox">
                  <button @click="setfinanceAdd">确定上传</button>
                </div>
              </div>
            </el-tab-pane>
          </el-tabs>
        </div>
      </div>
      <!-- <div class="anli">
        <div>成功案例</div>
        <div>
          <el-row :gutter="20">
            <el-col :span="4">
              <div class="grid-content bg-purple">图片1</div>
            </el-col>
            <el-col :span="4">
              <div class="grid-content bg-purple">图片1</div>
            </el-col>
            <el-col :span="4">
              <div class="grid-content bg-purple">图片1</div>
            </el-col>
            <el-col :span="4">
              <div class="grid-content bg-purple">图片1</div>
            </el-col>
            <el-col :span="4">
              <div class="grid-content bg-purple">图片1</div>
            </el-col>
            <el-col :span="4">
              <div class="grid-content bg-purple">图片1</div>
            </el-col>
          </el-row>
        </div>
      </div> -->
      <div style="max-width:1260px" class="inveFooter">
        <Myfooter />
      </div>
    </div>
    <!-- 结算 -->
    <div class="xiadanBox">
      <div class="xiadan">
        <div>
          <span class="yongtu">打赏详谈发布者：</span>
        </div>
        <div>
          <div class="feiyong">￥{{price}}</div>
          <div class="jianshu">
            <span class="biaozhi">*</span>
            <span>赏金</span>
          </div>
        </div>
        <div>
          <span style="font-size:26px; padding-right:10px;padding-left:10px">×</span>
        </div>
        <div>
          <div class="feiyong">￥1111</div>
          <div class="jianshu">
            <span class="biaozhi">*</span>
            <span style="color: #949494; font-size: 13px;">会员折扣</span>
            <i class="el-icon-question" style="color:rgb(230,45,49)"></i>
          </div>
        </div>
        <div style="font-size:26px; padding:0 10px">=</div>
        <div class="feiyong sumJia">￥3333333</div>
        <div>
          <button class="zhifuBtn">立即支付</button>
        </div>
      </div>
      <div class="queren">
        <el-radio v-model="radioYonghu" label="1">本人已确认，支付后执行下一流程</el-radio>
      </div>
    </div>
  </div>
</template>
<script>
import Myheader from "@/components/header";
import Myfooter from "@/components/footer";
import Quickaside from "@/components/quickAside";
import {financeAdd,industryField,projectDetails} from "@/api/api";
export default {
  data() {
    return {
      id:29,//项目id
      activeName: "first",
      xiangmuName: "", //项目名称
      xmDingwei: "", //项目定位内容
      yinghsou: "", //营收模式内容
      dquser: "", //目前用户数据
      rongzi: "", //当前融资阶段
      beijing: "", //创始人背景
      fileList: [], //文件上传列表
      bpUrl:"",//文件上传成功回调
      price:0,
      shangjin:"10",//打赏金
      radioYonghu:"1",
      hangye:[],
      hangyeItem:"",
      rongzi:[],
      rzjieduanItem:"",//融资阶段
      gfzhuanrangItem:"",//股份转让
      liangdian:"",//项目亮点
      youshi:"",//核心优势
      aUrl:"https://manage.siring.com.cn/api/file/qn_upload",
      dataBox:[],
      rzje:"",//期待融资金额
      guzhi:"",//估值
    };
  },
  components: {
    Myheader,
    Myfooter,
    Quickaside
  },
  mounted(){
    this.setindustryField();
    this.getshuju();
    this.getprojectDetails();
  },
  methods: {
    // 行业领域数据获取
    setindustryField(){
      industryField().then(res=>{
        let {data,code,msg} = res
        if(data.code == 1){
          this.hangye = data.data;
          // console.log(this.hangye)
        }
      })
    },
    selectFn(e){
      this.hangyeItem = e;
      // console.log(e)
    },
    // 收跳转携带的参数，控制显示哪个部分，同时，若是我要投资，按照传递过来的id查询项目详细数据
    getshuju(){
      let leixing = this.$route.params.leixing;
      this.id = this.$route.params.id==undefined?29:this.$route.params.id;
      this.getprojectDetails();
      if(leixing == "我要投资"){
        this.activeName = "first"
      }else{
        this.activeName = "second"
      }
      // console.log(123132)
      // console.log(this.$route.params.leixing)
    },
    // 上传检测
    beforeAvatarUpload(file){
      console.log(file)
    },
    // 文件上传成功回掉
    handleAvatarSuccess(res, file) {
      this.bpUrl = res.data.filePath;
      console.log(res)
    },
    // 我要融资上传
    setfinanceAdd(){
      let params = {
        title:this.xiangmuName,
        cid:this.hangyeItem,
        reward:this.shangjin,
        location:this.xmDingwei,
        bright:this.liangdian,
        revenue:this.yinghsou,
        user_data:this.dquser,
        valuation:this.rongzi,
        background:this.beijing,
        advantage:this.youshi,
        bp_url:this.bpUrl
      }
      financeAdd(params).then(res=>{
        let {data,code,msg} = res;
        // console.log(res)
        if(code == 1){
          console.log("上传成功")
        }
      })
    },
    // 获取投资处项目详细内容,通过获取url传递过来的项目id
    getprojectDetails(){
      console.log(this.id)
      const params = {id:parseInt(this.id)}
      projectDetails(params).then(res=>{
        let {data,code,msg} = res
        if(code == 1) {
          this.dataBox = data
        }
      })
    }
  }
};
</script>
<style>
  .inveFooter .footer_info{
    max-width: 1262px;
  }
</style>
<style lang="scss" scoped>
.title {
  font-size: 28px;
  padding-bottom: 10px;
}
.right {
  margin-left: 220px;
  min-width: 1040px;
  .touziBox {
    padding: 20px 50px 30px 50px;
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
  }
  .rongziBox {
    overflow-y: scroll;
    height: 670px;
    padding: 20px 50px;
    font-size: 13px;
    color: #333333;
    > div {
      margin-bottom: 20px;
    }
    .title {
      font-size: 18px;
      color: #000000;
    }

    .biaozhi {
      color: #ff0000;
      font-size: 18px;
    }
    .titleBox {
      margin-bottom: 5px;
    }
    .miaoshu {
      font-size: 13px;
      color: #6b6b6b;
      padding-bottom: 10px;
      > div {
        padding-bottom: 5px;
      }
    }
  }
  .yulanBox {
    display: flex;
    // align-items: center;
    background: #ffffff;
    justify-content: center;
    button {
      border-radius: 5px;
      background: rgb(22, 155, 213);
      color: #ffffff;
      border: 1px solid rgb(22, 155, 213);
      padding: 8px 50px;
    }
  }
  .tishi {
    i {
      color: rgb(255, 0, 0);
      font-size: 20px;
      padding-right: 10px;
    }
  }
  
}
.anli {
  background: #ffffff;
  padding: 50px;
  text-align: center;
  > div {
    &:nth-of-type(1) {
      font-size: 33px;
      padding-bottom: 50px;
    }
    &:nth-of-type {
      width: 100%;
    }
  }
}
.fileBox{
  font-size: 40px;
  color: rgb(51,133,255)
}
//
  .xiadanBox {
    position: fixed;
    bottom: 0;
    z-index: 100;
    width: 100%;
    min-width: 950px;
    padding: 15px;
    background: rgb(204, 235, 248);
    box-shadow:0 -3px 3px rgba(0,0,0,0.2);
    .xiadan {
      display: flex;
      padding: 10px 0 40px 0;
      // margin-left: 950px;
      // position: relative;
      // right: 0;
      float: right;
      margin-right: 180px;
      .feiyong {
        font-size: 18px;
        color: rgb(230, 45, 49);
        display: inline-block;
        background: #ffffff;
        padding: 2px 20px;
      }
      .jianshu {
        text-align: center;
        margin-top: 5px;
        span {
          &:nth-last-child(1) {
            color: #949494;
            font-size: 13px;
          }
        }
      }
      .yongtu {
        font-size: 18px;
      }
      .biaozhi {
        color: rgb(230, 45, 49);
      }
      .kuohao {
        font-weight: 700;
        font-size: 20px;
      }
      .sumJia {
        font-size:18px;
        display: flex;
        align-items: center;
        margin-right: 20px;
        height: 18px;
      }
      .zhifuBtn {
        color: #ffffff;
        background: rgb(230, 45, 49);
        border: 1px solid rgb(230, 45, 49);
        padding: 2px 25px;
        border-radius: 3px;
      }
    }
    .queren {
      position: absolute;
      right: 65px;
      top: 55px;
      // margin-left: 1500px;
    }
  }
</style>
<style>
/* .el-tabs__item {
    font-size: 20px !important;
  
  } */
</style>
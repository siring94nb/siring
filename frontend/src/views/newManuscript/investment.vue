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
          <el-tabs v-model="activeName" style="background:#ffffff; padding:20px;">
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
                  <div class="duanluo">项目name</div>
                </div>
                <!-- 行业领域 -->
                <div style="display:flex;">
                  <div style="width:50%">
                    <div class="nameBox">
                      <span class="name">行业领域：</span>
                      <span class="biaozhi">*</span>
                    </div>
                    <div class="duanluo">行业领域描述</div>
                  </div>
                  <div>
                    <div class="name nameBox">期待赏金：</div>
                    <div class="duanluo">
                      <span>金额</span>
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
                    摇摇车又称摇摆机、摇摆车、儿童投币摇摇机、摇篮车等，是游乐设备中的一种。摇摆机是会摇的，
                    前部可加有屏幕，在摇摆的同时有音乐伴奏。摇摇车又称摇摆机、摇摆车、儿童投币摇摇机、摇篮车等，是游乐设备中的一种。摇摆机是会摇的，前部可加有屏幕，在摇摆的同时有音乐伴奏。
                  </div>
                </div>
                <!--  项目亮点-->
                <div>
                  <div class="nameBox">
                    <span class="name">项目亮点：</span>
                    <span class="biaozhi">*</span>
                  </div>
                  <div class="duanluo">
                    摇摇车又称摇摆机、摇摆车、儿童投币摇摇机、摇篮车等，是游乐设备中的一种。摇摆机是会摇的，
                    前部可加有屏幕，在摇摆的同时有音乐伴奏。摇摇车又称摇摆机、摇摆车、儿童投币摇摇机、摇篮车等，是游乐设备中的一种。摇摆机是会摇的，前部可加有屏幕，在摇摆的同时有音乐伴奏。
                  </div>
                </div>
                <!-- 营收模式 -->
                <div>
                  <div class="nameBox">
                    <span class="name">营收模式：</span>
                    <span class="biaozhi">*</span>
                  </div>
                  <div class="duanluo">
                    摇摇车又称摇摆机、摇摆车、儿童投币摇摇机、摇篮车等，是游乐设备中的一种。摇摆机是会摇的，
                    前部可加有屏幕，在摇摆的同时有音乐伴奏。摇摇车又称摇摆机、摇摆车、儿童投币摇摇机、摇篮车等，是游乐设备中的一种。摇摆机是会摇的，前部可加有屏幕，在摇摆的同时有音乐伴奏。
                  </div>
                </div>
                <!-- 目前用户数据 -->
                <div>
                  <div class="nameBox">
                    <span class="name">目前用户数据：</span>
                    <span class="biaozhi">*</span>
                  </div>
                  <div class="duanluo">
                    摇摇车又称摇摆机、摇摆车、儿童投币摇摇机、摇篮车等，是游乐设备中的一种。摇摆机是会摇的，
                    前部可加有屏幕，在摇摆的同时有音乐伴奏。摇摇车又称摇摆机、摇摆车、儿童投币摇摇机、摇篮车等，是游乐设备中的一种。摇摆机是会摇的，前部可加有屏幕，在摇摆的同时有音乐伴奏。
                  </div>
                </div>
                <!-- 目前融资阶段，资金需求，估值 -->
                <div>
                  <div class="nameBox">
                    <span class="name">目前融资阶段，资金需求，估值：</span>
                    <span class="biaozhi">*</span>
                  </div>
                  <div class="duanluo">
                    摇摇车又称摇摆机、摇摆车、儿童投币摇摇机、摇篮车等，是游乐设备中的一种。摇摆机是会摇的，
                    前部可加有屏幕，在摇摆的同时有音乐伴奏。摇摇车又称摇摆机、摇摆车、儿童投币摇摇机、摇篮车等，是游乐设备中的一种。摇摆机是会摇的，前部可加有屏幕，在摇摆的同时有音乐伴奏。
                  </div>
                </div>
                <!-- 创始人背景-->
                <div>
                  <div class="nameBox">
                    <span class="name">创始人背景：</span>
                    <span class="biaozhi">*</span>
                  </div>
                  <div class="duanluo">
                    摇摇车又称摇摆机、摇摆车、儿童投币摇摇机、摇篮车等，是游乐设备中的一种。摇摆机是会摇的，
                    前部可加有屏幕，在摇摆的同时有音乐伴奏。摇摇车又称摇摆机、摇摆车、儿童投币摇摇机、摇篮车等，是游乐设备中的一种。摇摆机是会摇的，前部可加有屏幕，在摇摆的同时有音乐伴奏。
                  </div>
                </div>
                <!-- 核心优势（竞争壁垒）-->
                <div>
                  <div class="nameBox">
                    <span class="name">核心优势（竞争壁垒）</span>
                    <span class="biaozhi">*</span>
                  </div>
                  <div class="duanluo">
                    摇摇车又称摇摆机、摇摆车、儿童投币摇摇机、摇篮车等，是游乐设备中的一种。摇摆机是会摇的，
                    前部可加有屏幕，在摇摆的同时有音乐伴奏。摇摇车又称摇摆机、摇摆车、儿童投币摇摇机、摇篮车等，是游乐设备中的一种。摇摆机是会摇的，前部可加有屏幕，在摇摆的同时有音乐伴奏。
                  </div>
                </div>
                <!-- 商业计划书（BP）-->
                <div>
                  <div class="nameBox">
                    <span class="name">商业计划书（BP）:</span>
                    <span class="biaozhi">*</span>
                  </div>
                  <!-- 这是一个文件，初次点击没有进行打赏时，弹出提示框提示，需打赏才能进行下一步 -->
                  <div class="duanluo">文件</div>
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
                    <el-select style="width:350px" value="">
                      <option ></option>
                    </el-select>
                  </div>
                  <div>
                    <div class="titleBox">
                      <span class="title">期望打赏金：</span>
                      <span class="biaozhi">*</span>
                    </div>
                    <div class="miaoshu">如不填写，默认要求打赏金10元，款项扣除20%交易费后，将打入您的余额中</div>
                    <div style="display:flex;align-items:center">
                      <el-input v-model="xiangmuName" placeholder="不大于100" maxlength="20"></el-input>
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
                <div>
                  <div class="titleBox">
                    <span class="title">目前融资阶段，资金需求，估值：</span>
                    <span class="biaozhi">*</span>
                  </div>
                  <div class="miaoshu">表明目前项目处于种子轮、天使轮、A轮、A+等轮次。例如：天使伦/200万/出让10%股权；</div>
                  <el-input v-model="rongzi" type="textarea"></el-input>
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
                <!-- 核心优势（竞争壁垒） -->
                <div>
                  <div class="titleBox">
                    <span class="title">创始人背景：</span>
                    <span class="biaozhi">*</span>
                  </div>
                  <div class="miaoshu">
                    <div>主要写明稀有资源或独家技术或版权等；</div>
                    <div>譬如：拥有在全息影像呈现艺术作品精确度上有核心专利技术；</div>
                  </div>
                  <el-input v-model="beijing" type="textarea"></el-input>
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
                      class="upload-demo"
                      action="https://jsonplaceholder.typicode.com/posts/"
                      multiple
                      :limit="1"
                      :on-exceed="handleExceed"
                      :file-list="fileList"
                    >
                      <el-button size="small" type="primary">点击上传</el-button>
                    </el-upload>
                  </div>
                </div>
                <div class="yulanBox">
                  <button>预览</button>
                </div>
              </div>
            </el-tab-pane>
          </el-tabs>
        </div>
      </div>
      <div class="anli">
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
      </div>
      <Myfooter />
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
          <span style="font-size:26px; padding-right:10px">×</span>
        </div>
        <div>
          <div class="feiyong">￥1111</div>
          <div class="jianshu">
            <span class="biaozhi">*</span>
            <span style="color: #949494; font-size: 13px;">会员折扣</span>
            <i class="el-icon-question"></i>
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
export default {
  data() {
    return {
      activeName: "first",
      xiangmuName: "", //项目名称
      xmDingwei: "", //项目定位内容
      yinghsou: "", //营收模式内容
      dquser: "", //目前用户数据
      rongzi: "", //当前融资阶段
      beijing: "", //创始人背景
      fileList: [], //文件上传列表
      price:0,
      radioYonghu:"0"
    };
  },
  components: {
    Myheader,
    Myfooter,
    Quickaside
  },
  methods: {
    handleExceed(files, fileList) {
      this.$message.warning(`仅能上传一个文件`);
    }
  }
};
</script>
<style lang="scss" scoped>
.title {
  font-size: 28px;
  padding-bottom: 10px;
}
.right {
  margin-left: 220px;
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
//
  .xiadanBox {
    position: fixed;
    bottom: 0;
    z-index: 100;
    width: 100%;
    min-width: 950px;
    padding: 15px;
    background: rgb(204, 235, 248);
    .xiadan {
      display: flex;
      padding: 10px 0 40px 0;
      // margin-left: 950px;
      // position: relative;
      // right: 0;
      float: right;
      margin-right: 100px;
      .feiyong {
        font-size: 18px;
        color: #ff0000;
        display: inline-block;
        background: #ffffff;
        padding: 2px 15px;
      }
      .jianshu {
        text-align: center;
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
        color: #ff0000;
      }
      .kuohao {
        font-weight: 700;
        font-size: 20px;
      }
      .sumJia {
        font-size: 20px;
        display: flex;
        align-items: center;
        margin-right: 20px;
      }
      .zhifuBtn {
        color: #ffffff;
        background: rgb(230, 45, 49);
        border: 1px solid rgb(230, 45, 49);
        padding: 10px 25px;
        border-radius: 3px;
      }
    }
    .queren {
      position: absolute;
      right: 120px;
      top: 80px;
      // margin-left: 1500px;
    }
  }
</style>
<style>
/* .el-tabs__item {
    font-size: 20px !important;
  
  } */
</style>
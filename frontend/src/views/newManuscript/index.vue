<template>
  <div style="background:rgb(246,246,246);padding-top:10px;max-width:1260px;margin:0 auto">
    <Myheader />
    <div style="margin:100px 15px 0px 15px;">
      <div class="topHeader">
        <div>发稿推广</div>
      </div>
      <div class="bottomBox">
        <div class="left">
          <div class="jianjie">
            <div>
              <i class="el-icon-s-claim"></i>
              <span>提交稿件</span>
            </div>
            <div>本平台针对您提交的需求，从数万家媒介中AI智能筛选推广，做到搜索引擎收录高，媒介覆盖精准，从而达到“少花钱宣传广的效果”！如需帮助，我们还有专业写手为您撰写稿件，扫除您的撰写烧脑之忧！</div>
          </div>
          <div class="anli">
            <div>
              <i class="el-icon-cold-drink"></i>案例欣赏
            </div>
            <div class="anliBox">
              <a href="#">
                <img src="../../assets/images/u3425.png" alt />
                <span>新浪网娱乐</span>
              </a>
              <a href="#">
                <img src="../../assets/images/u3425.png" alt />
                <span>新浪网娱乐</span>
              </a>
              <a href="#">
                <img src="../../assets/images/u3425.png" alt />
                <span>新浪网娱乐</span>
              </a>
              <a href="#">
                <img src="../../assets/images/u3425.png" alt />
                <span>新浪网娱乐</span>
              </a>
              <a href="#">
                <img src="../../assets/images/u3425.png" alt />
                <span>新浪网娱乐</span>
              </a>
              <a href="#">
                <img src="../../assets/images/u3425.png" alt />
                <span>新浪网娱乐</span>
              </a>
              <a href="#">
                <img src="../../assets/images/u3425.png" alt />
                <span>新浪网娱乐</span>
              </a>
              <a href="#">
                <img src="../../assets/images/u3425.png" alt />
                <span>新浪网娱乐</span>
              </a>
            </div>
          </div>
        </div>
        <div class="right">
          <div class="xuqiu">
            <span>填写需求（*为必填）：</span>
            <el-input v-model="xuqiu" placeholder style="width:80%;border:0"></el-input>
          </div>
          <div>
            <div>
              <div class="sp">
                <div>
                  <span class="bz">*</span>
                  <span>标题</span>
                </div>
                <el-input v-model="title" placeholder="请输入" style="width:80%;"></el-input>
              </div>
              <div class="beizhu">给自己要推广的产品、网站等起个难忘的标题</div>
            </div>
            <div>
              <div class="sp">
                <div>
                  <span class="bz">*</span>
                  <span>推广对象</span>
                </div>
                <el-input v-model="gsname" placeholder="推广的产品或者公司名称" style="width:80%;"></el-input>
              </div>
              <div class="beizhu">不超过20字</div>
            </div>
            <div style="margin-top:20px;">
              <div class="sp">
                <div>
                  <span class="bz">*</span>
                  <span>推广材料</span>
                </div>
                <div>
                  <el-radio v-model="radio" label="1">委托代写</el-radio>
                  <el-radio v-model="radio" label="2">自有稿件</el-radio>
                </div>
              </div>
              <div class="beizhu">您可以找平台代写稿，也可使用自己的稿件</div>
            </div>
          </div>
          <div class="wtDaixie">
            <div class="daixieyaoq">
              <div class="sp">
                <div>
                  <span class="bz">*</span>
                  <span>代写要求</span>
                </div>
                <div>
                  <el-radio v-model="radio1" label="1">自由型</el-radio>
                  <el-radio v-model="radio1" label="2">采访型</el-radio>
                  <el-radio v-model="radio1" label="3">评论型</el-radio>
                  <el-radio v-model="radio1" label="4">广告型</el-radio>
                  <el-radio v-model="radio1" label="5">炒作型</el-radio>
                  <el-radio v-model="radio1" label="6">故事型</el-radio>
                  <el-radio v-model="radio1" label="7">热点型</el-radio>
                  <el-radio v-model="radio1" label="8">新闻型</el-radio>
                </div>
              </div>
            </div>
            <div class="linkClass">
              <div class="sp">
                <div>
                  <span class="bz">*</span>
                  <span>参考链接</span>
                </div>
                <el-input style="width:80%" v-model="linkValue" placeholder="供写手参考的文章地址"></el-input>
              </div>
            </div>
            <div>
              <div class="sp">
                <div>
                  <span class="bz">*</span>
                  <span>选择等级</span>
                </div>
                <div>
                  <!-- 等级表格 -->
                  <div class="dengjiHeader">
                    <span>选择</span>
                    <span>等级分类</span>
                    <span>价格</span>
                    <span>备注</span>
                  </div>
                  <div class="dengjiContent">
                    <el-radio
                      v-model="radio2"
                      label="1"
                      style="display:block;padding:0px 0 10px 30px;margin:15px 0;border-bottom:1px solid rgb(228,228,228);"
                    >
                      <span class="djXuanxiang">
                        <span>普通</span>
                        <span>300元/500字</span>
                        <span>出稿时间1-2工作日，稿件不满意最多只能修改一次，下单前请看好备注！</span>
                      </span>
                    </el-radio>
                    <el-radio
                      v-model="radio2"
                      label="2"
                      style="display:block;padding:0px 0 10px 30px;margin:15px 0;border-bottom:1px solid rgb(228,228,228);"
                    >
                      <span class="djXuanxiang">
                        <span>普通</span>
                        <span>300元/500字</span>
                        <span>出稿时间1-2工作日，稿件不满意最多只能修改一次，下单前请看好备注！</span>
                      </span>
                    </el-radio>
                    <el-radio
                      v-model="radio2"
                      label="3"
                      style="display:block;padding:0px 0 0px 30px;margin:15px 0"
                    >
                      <span class="djXuanxiang">
                        <span>普通</span>
                        <span>300元/500字</span>
                        <span>出稿时间1-2工作日，稿件不满意最多只能修改一次，下单前请看好备注！</span>
                      </span>
                    </el-radio>
                  </div>
                </div>
              </div>
            </div>
            <!-- 字数 -->
            <div>
              <div class="sp">
                <div>
                  <span class="bz">*</span>
                  <span>字数</span>
                </div>
                <div>
                  <el-radio v-model="radio3" label="1">0到500</el-radio>
                  <el-radio v-model="radio3" label="2">500到1000</el-radio>
                  <el-radio v-model="radio3" label="3">1000到1500</el-radio>
                  <el-radio v-model="radio3" label="4">1500到2000</el-radio>
                </div>
              </div>
            </div>
            <!-- 素材上传 -->
            <div>
              <div class="sp">
                <div>
                  <span class="bz">*</span>
                  <span>相关素材</span>
                </div>
                <div>
                  <el-upload
                    class="upload-demo"
                    action="https://jsonplaceholder.typicode.com/posts/"
                    :before-remove="beforeRemove"
                    multiple
                    :limit="1"
                    :on-exceed="handleExceed"
                    :file-list="fileList"
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
          <div class="shuoming">
            <div>原创软文说明：</div>
            <div>
              <span>●</span>
              <span>软文代写服务为虚拟交易产品，且为文案人员知识产权所有。故软文代写需要用户 提前支付相关费用且不接受试稿 。</span>
            </div>
            <div>
              <span>●</span>
              <span>为保证软文代写质量，支付撰稿费用后执行下一流程，您还可与平台详细沟通您的代写需求。</span>
            </div>
          </div>
        </div>
      </div>
      <div class="bFooter">
        <div style="font-size:33px;">合作媒介</div>
        <div class="hzs">
          <img src="../../assets/images/u2173.png" alt="">
          <img src="../../assets/images/u2173.png" alt="">
          <img src="../../assets/images/u2173.png" alt="">
          <img src="../../assets/images/u2173.png" alt="">
          <img src="../../assets/images/u2173.png" alt="">
        </div>
        <Myfooter/>
        <!-- 业务介绍 -->
        <!-- <div class="ywjieshao">
          <div>
            <div class="title">定制开发</div>
            <img :src="borderImg" alt="">
            <div>
              <div>IOS APP开发</div>
              <div>安卓APP开发</div>
              <div>Html5 开发</div>
              <div>微信开发</div>
              <div>小程序开发</div>
              <div>区块链+开发</div>
            </div>
          </div>
          <div>
            <div class="title">云平台</div>
            <img :src="borderImg" alt="">
            <div>
              <div>小程序SaaS平台</div>
              <div>支付平台</div>
              <div>短信平台</div>
            </div>
          </div>
          <div>
            <div class="title">模板商城</div>
            <img :src="borderImg" alt="">
            <div>
              <div>智能硬件</div>
              <div>电子商务</div>
              <div>生活娱乐</div>
              <div>金融</div>
              <div>媒体</div>
              <div>企业服务</div>
              <div>政府公益</div>
            </div>
          </div>
          <div>
            <div class="title">投融介</div>
            <img :src="borderImg" alt="">
            <div>
              <div>项目融资申请</div>
              <div>融资评审会</div>
            </div>
          </div>
          <div>
            <div class="title">代理加盟</div>
            <img :src="borderImg" alt="">
            <div>
              <div>申请代理</div>
            </div>
          </div>
          <div>
            <div class="title">联系我们</div>
            <img :src="borderImg" alt="">
            <div>
              <div>座机：0755-36609873</div>
              <div>专家顾问直线：</div>
              <div>19925374651</div>
              <div>邮箱</div>
              <div>zhq@siring.com.cn</div>
              <div>地址</div>
              <div>深圳市福田区新闻路1</div>
              <div>号中电信息大厦东座</div>
              <div>1518</div>
            </div>
          </div>
          <div>
            <div class="title">快速登录</div>
            <img :src="borderImg" alt="">  
            <br>
            <span v-for="(item,index) in carouselData1" :key="index+item.url" class="qh">
              <img :src="item.url" alt="">
            </span>
            <div v-for="(item,index) in carouselData1a" :key="index+item.url" class="erweima">
              <img :src="item.url" alt="">
            </div>
            <div class="dpu">淘宝店铺</div>
          </div>
        </div> -->
        <!-- 友情链接 -->
        <!-- <div class="youqingLink">
          <div style="font-size:28px;width:200px;padding-left:10px;">友情链接</div>
          <div>
            <a href="">微信公众平台</a>
            <a href="">微信开放平台</a>
            <a href="">微信支付平台</a>
            <a href="">微信</a>
            <a href="">快递100</a>
            <a href="">阿里云</a>
            <a href="">腾讯云</a>
            <a href="">西部数据</a>
            <a href="">新浪微博</a>
            <a href="">极光推送</a>
            <a href="">支付宝</a>
            <a href="">七牛云</a>
            <a href="">银联</a>
            <a href="">神箭手云</a>
            <a href="">PayPal</a>
            <a href="">360移动开放平台</a>
            <a href="">蒲公英</a>
            <a href="">腾讯开放平台</a>
            <a href="">苹果开发者  </a>
            <a href="">阿里云市场 </a>
            <a href="">17素材</a>
            <a href="">CSDN</a>
            <a href="">亚马逊云</a>
          </div>
        </div> -->
      </div>
    </div>
  </div>
</template>
<script>
import Myheader from "@/components/header";
import Myfooter from "@/components/footer";
export default {
  data() {
    return {
      radio: "1", //推广材料单选框 
      radio1: "1", //代写要求单选框
      radio2: "1", //等级单选框
      radio3: "1", //字数单选框
      fileList: [], //文件上传
      title: "",
      xuqiu: "",
      gsname: "",
      linkValue: "", //供写手参考的文章地址
      borderImg:require('../../assets/images/slide.png'),
      // 多个图片那个位置
      carouselData:[
        {uel:require('../../assets/images/slide.png')},
        {uel:require('../../assets/images/slide.png')},
        {uel:require('../../assets/images/slide.png')},
      ],
      // 快速登录
      carouselData1:[
        {url:require('../../assets/images/u857.png')},
        {url:require('../../assets/images/u847.png')},
      ],
      carouselData1a:[
        {url:require('../../assets/images/u844.png')},
        {url:require('../../assets/images/taobao.png')},
      ]
      
    };
  },
  components: {
    Myheader,
    Myfooter
  },
  mounted() {},
  methods: {
    // 文件上传
    handleExceed(files, fileList) {
      this.$message.warning(
        `当前限制选择 1 个文件，本次选择了 ${
          files.length
        } 个文件，共选择了 ${files.length + fileList.length} 个文件`
      );
    },
    beforeRemove(file, fileList) {
      return this.$confirm(`确定移除 ${file.name}？`);
    }
  }
};
</script>
<style lang="scss" scoped>
.topHeader {
  background: #ffffff;
  font-size: 28px;
  padding: 10px;
}
.bottomBox {
  margin-top: 10px;
  display: flex;
}
.jianjie {
  width: 240px;
  height: 210px;
  background-image: url("../../assets/images/u2173.png");
  color: #6b6b6b;
  font-size: 14px;
  border-left: 3px solid rgb(201, 0, 0);
  div {
    padding: 0 10px;
    &:nth-of-type(1) {
      padding-top: 10px;
      padding-bottom: 5px;
      font-size: 18px;
      color: #000000;
      font-weight: 700;
      i {
        font-size: 48px;
        color: rgb(138, 138, 138);
      }
    }
    &:nth-of-type(2) {
      width: 200px;
      line-height: 20px;
    }
  }
}
.anli {
  background: #ffffff;
  padding: 10px 0 0 0;
  margin-top: 10px;
  width: 220px;
  div {
    &:nth-of-type(1) {
      padding: 10px;
      text-align: center;
      background: rgb(246, 246, 246);
      width: 180px;
      margin-left: 10px;
      margin-bottom: 10px;
    }
  }
}
.anliBox::-webkit-scrollbar {
  width: 0 !important;
}
.anliBox {
  display: flex;
  flex-direction: column;
  height: 889px;
  overflow-y: auto;
  width: 220px;
  a {
    display: inline-block;
    width: 180px;
    height: 180px;
    position: relative;
    margin-bottom: 10px;
    margin-left: 20px;
    img {
      width: 180px;
      height: 180px;
    }
    span {
      position: absolute;
      top: 0;
      left: 0;
      z-index: 55;
      background: rgba(0, 0, 0, 0.6);
      color: #ffffff;
      display: inline-block;
      width: 180px;
      padding: 10px 0;
      text-align: center;
    }
  }
}
.right {
  background: #ffffff;
  width: 100%;
  .xuqiu {
    border-bottom: 1px solid rgb(228, 228, 228);
    padding: 20px 30px;
    display: flex;
    margin-bottom: 30px;
    font-size: 14px;
    color: #333333;
    font-weight: 600;
    display: flex;
    align-items: center;
    > span {
      width: 146px;
    }
  }
  .sp {
    display: flex;
    align-items: center;
    font-size: 13px;
    color: #999999;
    .bz {
      color: #ff0000;
    }
    > div {
      &:nth-of-type(1) {
        width: 80px;
        text-align: right;
        margin-right: 20px;
      }
    }
  }
  .beizhu {
    margin-left: 120px;
    font-size: 13px;
    color: #949494;
    padding: 10px 5px;
  }
  .wtDaixie {
    margin-top: 20px;
    border-bottom: 1px solid rgb(228, 228, 228);
    > div {
      margin-bottom: 20px;
    }
    .dengjiHeader {
      background: rgb(255, 255, 204);
      border: 1px solid rgb(228, 228, 228);
      border-bottom: none;
      span {
        display: inline-block;
        padding: 10px 0;
        border-right: 1px solid rgb(228, 228, 228);
        &:nth-of-type(1) {
          padding: 10px 24px;
        }
        &:nth-of-type(2) {
          padding: 10px 18px;
        }
        &:nth-of-type(3) {
          padding: 10px 56px;
        }
        &:nth-of-type(4) {
          border: none;
          padding: 10px 250px;
        }
      }
    }
    .dengjiContent {
      border: 1px solid rgb(228, 228, 228);
      .djXuanxiang {
        > span {
          // padding-right: 20px;
          padding: 15px 30px;
          border-left: 1px solid rgb(228, 228, 228);
          &:nth-of-type(1) {
            margin-left: 20px;
          }
        }
      }
    }
  }
  .shuoming {
    font-size: 13px;
    color: #333333;
    padding: 20px 20px;
    font-family: "Arial Normal", "Arial";
    > div {
      // &:nth-of-type(1) {
      margin: 0 0 10px 0;
      // }
      span {
        &:nth-of-type(2) {
          padding: 0 0 0 10px;
        }
      }
    }
  }
}
.bFooter{
  background: #ffffff;
  width: 100%;
  padding: 30px 0; 
  text-align: center;
  position: relative;
  margin-top: -220px;
  z-index: 60;
  .hzs{
    margin: 50px;
    img{
       width: 150px;
        height: 90px;
        margin: 0 20px;
    }
  }
  .ywjieshao{
    background: rgb(81,81,81);
    display: flex;
    color: #d7d7d7;
    padding: 20px 20px;
    .title{
      font-size: 20px;
      font-weight: 700;
    }
    img{
      padding: 10px 0;
    }
    >div{
      margin-right: 50px;
      &:nth-last-of-type(1){
        margin-right: 0;
      }
      >div:nth-of-type(2){
        text-align: center;
        div{
          padding:10px;
          font-size: 14px;
        }
      }
    }
  }
  .qh{
    padding: 0 18px;
    display: inline-block;
    img{
      padding: 0;
    }
  }
  .erweima{
    &:nth-of-type(2){
        height: 200px;
      }
     &:nth-of-type(3){
        position: relative;
        top: -170px;
      }
    img{
      padding: 0;
    }
  }
  .dpu{
    position: relative;
    top: -165px;
    color: #b1120e;
    font-size: 18px;
    font-weight: 700;
  }
  .youqingLink{
    display: flex;
    padding: 10px 0;
    a{
      display: inline-block;
      color: #0099ff;
      padding: 10px;
    }
  }
}
</style>
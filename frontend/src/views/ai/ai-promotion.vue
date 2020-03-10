<template>
  <div class="quickval">
    <myheader />
    <div class="quick-main">
      <h3 class="title" style="padding-left:5px;">发稿推广</h3>
      <div class="quick-cont clearfix">
        <quickaside />
        <div class="types-right">
          <h4 class="title">填写需求（*为必填）</h4>
          <div class="form-box">
            <el-form ref="form" :model="form" :rules="rules" label-width="110px">
              <el-form-item label="标题" required>
                <el-input v-model="form.title" placeholder="请输入自己要推广的产品名、网站等起个难忘的标题"></el-input>
              </el-form-item>
              <el-form-item label="推广对象" required>
                <el-input
                  v-model="form.name"
                  maxlength="20"
                  show-word-limit
                  placeholder="推广的产品或公司名称（不超过20个字）"
                ></el-input>
              </el-form-item>
              <el-form-item label="推广材料" required>
                <el-radio-group v-model="form.material" @change="changeMaterial">
                  <el-radio label="1">委托代写</el-radio>
                  <el-radio label="2">自有稿件</el-radio>
                </el-radio-group>
                <div class="tip">您可以找平台代写稿，也可使用自己的稿件</div>
              </el-form-item>
              <template v-if="mater">
                <el-form-item label="代写要求" required>
                  <el-radio-group v-model="form.claim">
                    <el-radio label="1">自由型</el-radio>
                    <el-radio label="2">采访型</el-radio>
                    <el-radio label="3">评论型</el-radio>
                    <el-radio label="4">广告型</el-radio>
                    <el-radio label="5">炒作型</el-radio>
                    <el-radio label="6">故事型</el-radio>
                    <el-radio label="7">热点型</el-radio>
                    <el-radio label="8">新闻型</el-radio>
                  </el-radio-group>
                </el-form-item>
                <el-form-item label="参考链接" required>
                  <el-input v-model="form.link" placeholder="供写手参考的文章地址"></el-input>
                </el-form-item>
                <el-form-item label="选择等级" required>
                  <el-table :data="form.tableData" border style="width: 100%">
                    <el-table-column label="选择" width="120">
                      <template slot-scope="scope">
                        <el-radio
                          class="radio"
                          v-model="isSelected"
                          :label="scope.row.id"
                        >{{scope.row.classify}}</el-radio>
                      </template>
                    </el-table-column>
                    <el-table-column label="价格" width="130">
                      <template slot-scope="scope">
                        {{scope.row.price}}元/{{scope.row.count}}字
                      </template>
                    </el-table-column>
                    <el-table-column prop="remarks" label="备注"></el-table-column>
                  </el-table>
                </el-form-item>
                <el-form-item label="字数" required>
                  <el-radio-group v-model="form.wordcount">
                    <el-radio label="1">0到500</el-radio>
                    <el-radio label="2">500到1000</el-radio>
                    <el-radio label="3">1000到1500</el-radio>
                    <el-radio label="4">1500到2000</el-radio>
                  </el-radio-group>
                </el-form-item>
              </template>
              <template v-else>
                <el-form-item label="阅览显示">
                  <tinymce-editor
                    ref="editor"
                    v-model="tinymceHtml"
                    :disabled="disabled"
                    @onClick="onClick"
                    v-loading="loadingBool"
                  />
                </el-form-item>
              </template>
              <el-form-item label="提供尽可能多的相关素材" class="lh20" required>
                <el-upload
                  name="image"
                  class="upload-demo"
                  action="https://manage.siring.com.cn/api/file/qn_upload"
                  :on-remove="handleRemove"
                  :before-upload="beforeUpload"
                  :limit="1"
                  :on-exceed="handleExceed"
                  :on-success="handleAvatarSuccess1"
                  :file-list="fileList"
                >
                  <el-button size="small" type="primary">点击上传</el-button>
                  <div
                    slot="tip"
                    class="el-upload__tip"
                  >最多一个上传一个文件，多个文件可使用压缩格式；支持txt、ppt、pptx、doc、docx、xls、xlsx、pdf、png、jpg、jpeg，RAR，ZIP附件大小不超过50M。</div>
                </el-upload>
              </el-form-item>
            </el-form>
            <div class="tips">
              <p>原创软文代写说明：</p>
              <p>● 软文代写服务为虚拟交易产品，且为文案人员知识产权所有。故软文代写需要用户 提前支付相关费用且不接受试稿 。</p>
              <p>● 为保证软文代写质量，支付撰稿费用后执行下一流程，您还可与平台详细沟通您的代写需求。</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <myfooter />
    <!-- payment -->
    <div class="payment">
      <div class="payment-top">
        <i class="brackets">(</i>
        <div class="package-btn" @click="dialogVisible = true">
          <p>体验套餐费:</p>
          <i class="el-icon-caret-bottom"></i>
        </div>
        <div>
          <p class="bgw">￥{{packagePrice}}</p>
          <p class="require-star tip" style="margin-top:5px;">套餐费</p>
        </div>
        <div class="symbol">+</div>
        <div>撰稿费用：</div>
        <div>
          <p class="bgw">￥{{writingCost}}</p>
          <p class="require-star tip" style="margin-top:5px;">稿费</p>
        </div>
        <i class="brackets">)</i>
        <div class="symbol">×</div>
        <div>
          <p class="bgw">{{percent}}%</p>
          <p class="require-star tip">
            会员折扣
            <span class="ques"><i class="el-icon-question" style="font-size:16px;"></i></span>
          </p>
          <p></p>
        </div>
        <div class="symbol">=</div>
        <div class="bgw">￥{{total}}</div>
        <el-button style="background:rgb(230,45,49);padding:6.5px 15px" type="danger" @click="setdemandAdd">立即支付</el-button>
      </div>
      <div class="payment-bot">
        <!-- <el-checkbox v-model="checked">本人已确认，支付后执行下一流程</el-checkbox> -->
        <el-radio v-model="radioYonghu" label="1">本人已确认，支付后执行下一流程</el-radio>
      </div>
    </div>
    <!-- pop -->
    <el-dialog title :visible.sync="dialogVisible" width="600px">
      <el-tabs>
        <el-tab-pane v-for="item in packageList" :label="item.name" :key="item.id">
          <div class="packages" v-html="item.con"></div>
          <div class="set-meal">
            <div class="set-meal-price">
              <span class="through-price">￥{{item.money}}</span>
              <span class="sale-price">￥{{item.price}}</span>
            </div>
            <div class="choose" @click="choosePackage(item)">&gt;&gt;选择套餐</div>
          </div>
        </el-tab-pane>
      </el-tabs>
    </el-dialog>       
  </div>
</template>

<script>
import TinymceEditor from "@/components/tinymce";
import Myheader from "@/components/header";
import Myfooter from "@/components/footer";
import Quickaside from "@/components/quickAside";
import { GetSetMeal,demandAdd } from "@/api/api";
export default {
  components: {
    Myheader,
    Myfooter,
    Quickaside,
    TinymceEditor
  },
  data() {
    return {
      isSelected: "1",
      mater: true, //推广材料切换
      tinymceHtml: "",
      disabled: false,
      loadingBool: false,
      form: {
        title: "",
        name: "",
        material: "1",
        claim: "",
        link: "",
        tableData: [
          {
            classify: "普通",
            price: 300,
            count: 500,
            id: 1,
            remarks:
              "出稿时间1-2工作日，稿件不满意最多只能修改一次，下单前请看好备注！"
          },
          {
            classify: "高手",
            price: 600,
            count: 500,
            id: 2,
            remarks:
              "出稿时间1-4工作日，稿件不满意最多只能修改一次，下单前请看好备注！"
          },
          {
            classify: "资深写手",
            price: 1000,
            count: 500,
            id: 3,
            remarks:
              "出稿时间1-6工作日，稿件不满意最多只能修改一次，下单前请看好备注！"
          }
        ],
        wordcount: "1"
      },
      rules: {
        min: [
          { required: true, message: "请输入预算", trigger: "change" },
          { type: "number", message: "只能输入数字", trigger: "blur" }
        ],
        max: [
          { required: true, message: "请输入预算", trigger: "change" },
          { type: "number", message: "只能输入数字", trigger: "blur" }
        ]
      },
      fileList: [],
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
      radioYonghu: "1",
      packagePrice: 0,
      writingCost: 0,
      percent: 100,
      dialogVisible: false,
      packageList: [],
      resume:"",
      tid:0
    };
  },
  mounted() {
    this.getSetMeal();
  },
  computed: {
    total() {
      return (this.packagePrice + this.writingCost) * this.percent /100;
    }
  },
  methods: {
     handleAvatarSuccess1(res, file) {
       console.log(res);
       console.log(file)
       console.log(res.data.filePath);
       this.resume = res.data.filePath;
    },
    changeMaterial(value) {
      this.mater = value == 1 ? true : false;
    },
    onClick(e, editor) {},
    handleRemove(file, fileList) {
      console.log(file, fileList);
    },
    handleExceed(files, fileList) {
      this.$message.warning(
        `当前限制选择 1 个文件，本次选择了 ${
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
    getSetMeal() {
      GetSetMeal().then(res => {
        console.log(res);
        let { code, data, msg } = res.data;
        if (code === 1) {
          this.packageList = data;
        }
      });
    },
    choosePackage(item) {
      this.dialogVisible = false;
      this.packagePrice =item.price;
      this.tid = item.id
    },
    // 上传，付款
    // 数据上传
    setdemandAdd(){
      let con = ""
      if(this.radio == 1){
        con = ""
      }else{
        con = "232323"
      }
      let params = {
        role_type:parseInt(this.form.material),
        title :this.form.title,
        object:this.form.name,
        tid:this.tid,
        num:parseInt(this.form.wordcount),
        ask:parseInt(this.form.claim),
        price:this.total,
        grade:parseInt(this.isSelected),
        url:this.form.link,
        resume:this.resume,
        con	:""
      }
      demandAdd(params).then(res=>{
        console.log(this.total)
        let {code,msg,data} = res
        if(code == 1) {
          // this.showMsg(msg,code);
          this.$router.push({
                name: "comboPay",
                params: {
                  type:10,
                  id: data,
                  order_amount:this.total,
                  user_id: sessionStorage.getItem("user_id"),
                  order_type: 1
                }
              });
          // console.log(res)
        }
      })
    }
  }
};
</script>
<style lang="scss">
.lh20 {
  .el-form-item__label,
  .el-upload__tip {
    line-height: 20px;
  }
}
</style>
<style scoped lang='scss'>
.quickval {
  background-color: rgb(246, 246, 246);
  margin-bottom: 80px;
  .quick-main {
    width: 1200px;
    margin: 100px auto 0;
    padding-top: 10px;
    h3.title {
      font-size: 28px;
      background-color: #ffffff;
      height: 50px;
      line-height: 50px;
      margin-bottom: 10px;
    }
    .quick-cont {
      margin-bottom: 20px;
      height: 973px;
      .types-right {
        float: left;
        width: 975px;
        background-color: #ffffff;
        .title {
          font-size: 14px;
          font-weight: 700;
          color: #333333;
          height: 59px;
          line-height: 60px;
          border-bottom: 1px solid rgb(228, 228, 228);
          padding-left: 40px;
        }
        .form-box {
          padding: 15px 20px 0 0;
          .el-form {
            width: 900px;
            .line,
            .unit {
              text-align: center;
            }
            .terminal {
              display: inline-block;
              text-align: center;
              vertical-align: middle;
            }
            .tip {
              font-size: 13px;
              color: #666666;
              line-height: normal;
            }
          }
          .tips {
            font-size: 13px;
            color: #333333;
            border-top: 1px solid rgb(215, 215, 215);
            padding: 24px 0;
            margin: 0 20px;
            line-height: 28px;
          }
        }
      }
    }
  }
  .payment {
    box-shadow: 0px -2px 3px rgba(0,0,0,0.1);
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background-color: rgb(204, 235, 248);
    height: 80px;
    z-index: 99;
    .payment-top {
      display: flex;
      align-items: baseline;
      font-size: 18px;
      & > div {
        text-align: center;
      }
      .package-btn {
        cursor: pointer;
      }
      .brackets {
        font-size: 32px;
        color: #333333;
      }
      .el-icon-caret-bottom {
        color: rgb(17, 196, 255);
        font-size: 28px;
        margin-top: -5px;
      }
      .bgw {
        color: rgb(245,108,108);
        padding: 4px 20px;
        border: 1px solid rgb(201, 201, 201);
        background-color: #ffffff;
        margin: 0 5px;
      }
      .symbol {
        font-size: 20px;
        font-weight: 700;
        margin: 0 10px;
      }
      .tip {
        color: #949494;
        font-size: 13px;
        margin-top: 2px;
      }
      .require-star::before {
        content: "*";
        color: #ff0000;
      }
      .ques {
        display: inline-block;
        width: 16px;
        height: 16px;
        // line-height: 20px;
        text-align: center;
        border-radius: 50%;
        // background-color: #ffffff;
        color: rgb(245,108,108);
        cursor: pointer;
        font-size: 22px ;
      }
    }
    .payment-bot {
      position: relative;
      z-index: 30px;
      width: 700px;
      text-align: right;
      margin-top: -18px;
      padding-left:320px;
    }
  }
  .packages {
    color: #333333;
    line-height: 33px;
  }
  .set-meal {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 15px;
    .through-price {
      color: #ccc;
      font-size: 18px;
      text-decoration: line-through;
    }
    .sale-price {
      color: #ff0e35;
      font-size: 24px;
      font-weight: 700;
    }
    .choose {
      font-size: 18px;
      color: #f00;
      border: 1px solid #f00;
      border-radius: 4px;
      padding: 5px 20px;
      cursor: pointer;
    }
  }
}
</style>
<template>
  <div class="quickval">
    <myheader />
    <div class="quick-main">
      <h3 class="title">发稿推广</h3>
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
                  <el-radio label="2">自由稿件</el-radio>
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
                      <template scope="scope">
                        <el-radio
                          class="radio"
                          v-model="isSelected"
                          :label="scope.row.id"
                        >{{scope.row.classify}}</el-radio>
                      </template>
                    </el-table-column>
                    <el-table-column prop="price" label="价格" width="130"></el-table-column>
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
                  class="upload-demo"
                  action="https://jsonplaceholder.typicode.com/posts/"
                  :on-remove="handleRemove"
                  :before-upload="beforeUpload"
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
  </div>
</template>

<script>
import TinymceEditor from "@/components/tinymce";
import Myheader from "@/components/header";
import Myfooter from "@/components/footer";
import Quickaside from "@/components/quickAside";
export default {
  components: {
    Myheader,
    Myfooter,
    Quickaside,
    TinymceEditor
  },
  data() {
    return {
      isSelected: "普通",
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
            price: "300元/500字",
            id: 1,
            remarks:
              "出稿时间1-2工作日，稿件不满意最多只能修改一次，下单前请看好备注！"
          },
          {
            classify: "高手",
            price: "600元/500字",
            id: 2,
            remarks:
              "出稿时间1-4工作日，稿件不满意最多只能修改一次，下单前请看好备注！"
          },
          {
            classify: "资深写手",
            price: "1000元/500字",
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
      ]
    };
  },
  methods: {
    changeMaterial(value) {
      this.mater = value == 1 ? true : false;
    },
    onClick(e, editor) {},
    handleRemove(file, fileList) {
      console.log(file, fileList);
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
      height: 938px;
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
}
</style>
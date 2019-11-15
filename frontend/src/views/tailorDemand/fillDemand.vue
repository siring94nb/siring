<template>
  <div class="quickval">
    <myheader />
    <div class="quick-main">
      <h3 class="title">快捷估价</h3>
      <div class="quick-cont clearfix">
        <quickaside />
        <div class="types-right">
          <h4 class="title">填写需求（*为必填）</h4>
          <div class="form-box">
            <el-form ref="form" :model="form" :rules="rules" label-width="110px">
              <el-form-item label="需求名称" required>
                <el-input
                  v-model="form.name"
                  maxlength="10"
                  show-word-limit
                  placeholder="请输入你的项目名，不超过10个字"
                ></el-input>
              </el-form-item>
              <el-form-item label="需求类型" required>
                <el-select v-model="form.type" placeholder="请选择">
                  <el-option label="智能硬件" value="shanghai"></el-option>
                  <el-option label="电子商务" value="beijing"></el-option>
                </el-select>
              </el-form-item>
              <el-form-item label="需求预算" required>
                <el-col :span="10">
                  <el-form-item prop="min">
                    <el-input type="text" v-model.number="form.min"></el-input>
                  </el-form-item>
                </el-col>
                <el-col class="unit" :span="1">元</el-col>
                <el-col class="line" :span="2">-</el-col>
                <el-col :span="10">
                  <el-form-item prop="max">
                    <el-input type="text" v-model.number="form.max"></el-input>
                  </el-form-item>
                </el-col>
                <el-col class="unit" :span="1">元</el-col>
              </el-form-item>
              <el-form-item label="开发终端">
                <el-checkbox-group v-model="form.terminal">
                  <el-checkbox
                    v-for="item in typeList"
                    :key="item.id"
                    :label="item.name"
                    name="type"
                  >
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
                      <el-input type="text" v-model.number="form.phone"></el-input>
                    </el-form-item>
                  </el-col>
                  <el-col :span="12">
                    <el-form-item label="QQ号">
                      <el-input type="text" v-model.number="form.qq"></el-input>
                    </el-form-item>
                  </el-col>
                </el-row>
                <el-row>
                  <el-col :span="12">
                    <el-form-item label="微信号">
                      <el-input type="text" v-model.number="form.wechat"></el-input>
                    </el-form-item>
                  </el-col>
                  <el-col :span="12">
                    <el-form-item label="其他联系方式">
                      <el-input type="text" v-model.number="form.other"></el-input>
                    </el-form-item>
                  </el-col>
                </el-row>
              </el-form-item>
              <el-form-item label="需求描述" required>
                <el-input type="textarea" :rows="4" v-model="form.desc"></el-input>
              </el-form-item>
              <el-form-item label="添加附件" required>
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
                  >最多上传一个文件，多个文件可使用压缩格式；支持txt、ppt、pptx、doc、docx、xls、xlsx、pdf、png、jpg、jpeg，RAR，ZIP附件大小不超过50M。</div>
                </el-upload>
              </el-form-item>
              <el-form-item>
                <el-button type="danger">确认无误，提交需求</el-button>
              </el-form-item>
            </el-form>
          </div>
        </div>
      </div>
    </div>
    <myfooter />
  </div>
</template>

<script>
import Myheader from "@/components/header";
import Myfooter from "@/components/footer";
import Quickaside from "@/components/quickAside";
export default {
  components: {
    Myheader,
    Myfooter,
    Quickaside
  },
  data() {
    return {
      form: {
        name: "",
        type: "",
        min: "",
        max: "",
        terminal: [1, 2],
        phone: "",
        qq: "",
        wechat: "",
        other: "",
        desc: ""
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
      .types-right {
        float: left;
        width: 975px;
        height: 804px;
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
            width: 800px;
            .line,
            .unit {
              text-align: center;
            }
            .terminal {
              display: inline-block;
              text-align: center;
              vertical-align: middle;
            }
          }
        }
      }
    }
  }
}
</style>
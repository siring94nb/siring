<template>
  <div class="quickval">
    <myheader />
    <div class="quick-main">
      <h3 class="title">定制需求</h3>
      <div class="quick-cont clearfix">
        <quickaside :type="1" />
        <div class="types-right">
          <h4 class="title">填写需求（*为必填）</h4>
          <div class="form-box">
            <el-form ref="form" :model="form" :rules="rules" label-width="110px">
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
                <el-col class="line" :span="2">-</el-col>
                <el-col :span="10">
                  <el-form-item prop="max">
                    <el-input type="text" v-model.number="form.need_budget_up"></el-input>
                  </el-form-item>
                </el-col>
                <el-col class="unit" :span="1">元</el-col>
              </el-form-item>
              <el-form-item label="开发终端">
                <el-checkbox-group v-model="form.need_terminal">
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
                      <el-popover
                        placement="top"
                        width="150"
                        trigger="manual"
                        content="手机号格式有误,请修改"
                        v-model="disabled">
                        <el-input slot="reference" class="phone" type="text" v-model.number="form.need_phone" @input="checkPhone" ></el-input>
                      </el-popover>
                      <!-- <el-tooltip class="item"   :disabled="disabled" effect="dark" content="手机号格式有误" placement="top-start">
                        <el-input class="phone" type="text" v-model.number="form.need_phone" @input="checkPhone" ></el-input>
                      </el-tooltip> -->
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
                <el-input type="textarea" :rows="3" v-model="form.need_desc"></el-input>
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
                  :multiple="false"

                >
                  <el-button size="small" type="primary">点击上传</el-button>
                  <div
                    slot="tip"
                    class="el-upload__tip"
                  >最多上传一个文件，多个文件可使用压缩格式；支持txt、ppt、pptx、doc、docx、xls、xlsx、pdf、png、jpg、jpeg，RAR，ZIP附件大小不超过50M。</div>
                </el-upload>
              </el-form-item>
              <el-form-item>
                <el-button type="danger" @click="need_submit">确认无误，提交需求</el-button>
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
import { needOrderAdd ,GetDevlopType} from "@/api/api";
export default {
  components: {
    Myheader,
    Myfooter,
    Quickaside
  },
  data() {
    return {
      form: {
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
        user_id: "",
        need_status: 1,
        img:""
      },
      rules: {
        need_budget_down: [
          { required: true, message: "请输入预算", trigger: "change" },
          { type: "number", message: "只能输入数字", trigger: "blur" }
        ],
        need_budget_up: [
          { required: true, message: "请输入预算", trigger: "change" },
          { type: "number", message: "只能输入数字", trigger: "blur" }
        ]
      },
      fileList: [],
      typeList: [
        {
          className: "iconfont icon-yuanxingtu",
          name: "原型UI",
          id: 1
        },
        {
          className: "iconfont icon-shezhi2",
          name: "后台",
          id: 2
        },
        {
          className: "iconfont icon-pc1",
          name: "PC",
          id: 3
        },
        {
          className: "iconfont icon-h",
          name: "移动H5",
          id: 4
        },
        {
          className: "iconfont icon-pingguo",
          name: "APP苹果",
          id: 5
        },
        {
          className: "iconfont icon-anzhuo",
          name: "APP安卓",
          id: 6
        },
        {
          className: "iconfont icon-xiaochengxu",
          name: "小程序",
          id: 7
        }
      ],
      UploadAction: "",
      disabled:false,//手机号悬浮提示
      typeList1:[],
    };
  },
  mounted() {
    this.init();
  },
  methods: {
     showMsg(msg, code) {
      this.$message({
        message: msg,
        type: code === 1 ? "success" : "error"
      });
    },
    init() {
      let vm = this;
      this.form.user_id = JSON.parse(sessionStorage.getItem("user_id"));
      vm.UploadAction = "https://manage.siring.com.cn/api/file/qn_upload";
      this.getDevlopType();
    },
    handleSuccess(response, file, fileList) {
      this.form.need_file = response.data.filePath;
    },
    handleRemove(file, fileList) {
      this.form.need_file = "";
    },
    handleExceed(files, fileList) {
      this.$message.warning(
        // `当前限制选择 3 个文件，本次选择了 ${
        //   files.length
        // } 个文件，共选择了 ${files.length + fileList.length} 个文件`
        `限制上传，仅支持上传一个文件`
      );
    },
    beforeUpload(file) {
      const size = file.size / 1024 / 1024 < 50;
      if (!size) {
        this.$message.error("上传文件大小不能超过50M！");
      }
      return size;
    },
    getDevlopType() {
      GetDevlopType().then(res => {
        let { code, data, msg } = res.data;
        console.log(123123)
        if (code === 1) {
          console.log(data)
          this.typeList1 = data;
        }
      });
    },
    // 获取图片链接
    handleAvatarSuccess(res, file) {
      this.form.img= res.data.filePath;
      // this.$router.push("/afterLoggin")
    },
    checkPhone(){
     
      if (!/^1[3456789]\d{9}$/.test(this.form.need_phone)) {
        // alert("手机号码有误，请重填");
        // return false;
        // console.log("错误错误");
        // this.showMsg("手机号码输入错误","0")
        // this.form.need_phone=""
        this.disabled = true;

      } else {
        this.disabled = false;
      }
    },
    need_submit() {
      let vm = this;
      // 添加手机号码验证
      if(this.disabled){
        needOrderAdd(vm.form).then(res => {
          let { code, data, msg } = res;
          if (code === 1) {
            this.$message.success(msg);
            this.$router.push({
              name: "demand_order"
            });
            // this.packageList = data;
          }
        });
      }else{
        this.showMsg("手机号格式有误，请修正","0")
      }
        
    }
  }
};
</script>
<style>
.form-box .avatar-uploader .el-upload {
    border: 1px dashed rgb(64,179,255);
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }
  .form-box .avatar-uploader .el-upload:hover {
    border-color: #409EFF;
  }
  .form-box .avatar-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 178px;
    height: 178px;
    line-height: 178px;
    text-align: center;
  }
   .form-box .avatar {
    width: 178px;
    height: 178px;
    display: block;
  }
  .form-box .el-upload{
    width: 36px;
    height: 36px;
  }
  .form-box .fimg{
    width: 36px;
    height: 36px;
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
      padding-left: 15px;
      margin-bottom: 10px;
    }
    .quick-cont {
      margin-bottom: 20px;
      .types-right {
        float: left;
        width: 975px;
        height: 814px;
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
          }
        }
      }
    }
  }
}
</style>
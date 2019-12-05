<template>
  <div>
    <logginHeader>
      <i class="el-icon-edit"></i>
      <span>会员中心</span>
      <span>&gt;</span>
      <span>会员信息</span>
    </logginHeader>
    <div class="boxM">
      <div>
        <span>*</span>
        <span>用户绑定手机号：</span>
        <span>{{userMessage1.phone}}</span>
        <button class="btnChaneg">修改绑定手机号</button>
      </div>
      <div>
        <span class="xg" style="margin-right:25px">我的邀请码：</span>
        <span class="MyInvitationCode">{{userMessage1.invitation}}</span>
      </div>
      <!-- 下方邀请码，看是否已存在，存在就直接value没有则显示 placeholder-->
      <div class="inputContent">
        <span class="xg" style="margin-right:25px">上级邀请码：</span>
        <div>
          <input type="text" placeholder="合适的时机再填写吧，确认上级之后不可修改" />
          <div>*可选项</div>
        </div>
      </div>
      <div class="inputContent">
        <span>*</span>
        <span class="xg">姓名：</span>
        <div>
          <input type="text" placeholder="请输入姓名" />
          <div>*请输入真实姓名，确保电子合同或协议，身份真实有效，保障会员权益</div>
        </div>
      </div>
      <div class="inputContent">
        <span>*</span>
        <span class="xg">身份证号</span>
        <div>
          <input type="text" placeholder="请输入身份证号" />
          <div>*请输入真实身份证号，身份真实有效，保障会员权益</div>
        </div>
      </div>

      <div style="display:flex">
        <span>*</span>
        <span class="xg">身份认证：</span>
        <div style="display:flex">
          <!-- action为上传到哪里去，headers上传到服务器时设置请求头即token -->
          <el-upload
            class="avatar-uploader"
            action="https://jsonplaceholder.typicode.com/posts/"
            :show-file-list="false"
            :on-success="handleAvatarSuccess"
            :before-upload="beforeAvatarUpload"
          >
            <img v-if="imageUrl" :src="imageUrl" class="avatar" />
            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
          </el-upload>
          <el-upload
            class="avatar-uploader"
            action="https://jsonplaceholder.typicode.com/posts/"
            :show-file-list="false"
            :on-success="handleAvatarSuccess"
            :before-upload="beforeAvatarUpload"
          >
            <img v-if="imageUrl" :src="imageUrl" class="avatar" />
            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
          </el-upload>
        </div>
      </div>
      <!-- 城市选择 -->
      <div style="display:flex">
        <span>*</span>
        <span class="xg">所在地区：</span>
        <div>
          <el-dropdown>
            <span class="el-dropdown-link">
              下拉菜单
              <i class="el-icon-arrow-down el-icon--right"></i>
            </span>
            <el-dropdown-menu slot="dropdown">
              <el-dropdown-item>用循环</el-dropdown-item>
            </el-dropdown-menu>
          </el-dropdown>
          <el-dropdown>
            <span class="el-dropdown-link">
              下拉菜单
              <i class="el-icon-arrow-down el-icon--right"></i>
            </span>
            <el-dropdown-menu slot="dropdown">
              <el-dropdown-item>用循环</el-dropdown-item>
            </el-dropdown-menu>
          </el-dropdown>
          <el-dropdown>
            <span class="el-dropdown-link">
              下拉菜单
              <i class="el-icon-arrow-down el-icon--right"></i>
            </span>
            <el-dropdown-menu slot="dropdown">
              <el-dropdown-item>用循环</el-dropdown-item>
            </el-dropdown-menu>
          </el-dropdown>
        </div>
      </div>
      <!-- 详细地址 -->
      <div class="inputContent">
        <span>*</span>
        <span class="xg">详细地址：</span>
        <div>
          <input type="text" placeholder="请输入地址" />
          <div>*请输入真实地址，如需纸质合同或协议，将会邮寄到该地址</div>
        </div>
      </div>
      <!-- 企业身份 -->
      <div class="inputContent">
        <span class="xg" style="margin-right:25px">企业身份：</span>
        <div class="company">
          <div style="display:flex; margin-bottom: 3px">
            <select>
              <option value="用循环">用循环</option>
            </select>
            <div>
              <router-link to="addEnterprise">
                <span>*</span>添加企业身份
              </router-link>
            </div>
            <div>
              <router-link to="enterpriseList">
                企业身份列表
              </router-link>
            </div>
          </div>
          <div>*可选项，请添加真实企业身份，确保电子合同或协议，身份真实获取，保障会员权益，点击"添加身份"可添加多个企业身份</div>
        </div>
      </div>
      <!-- 性别 -->
      <div class="inputContent">
        <span>*</span>
        <span class="xg">性别:</span>
        <div class="sex">
          <label>
            <input type="radio" name="sex" value="男生" checked="checked" />男生
          </label>
          <label>
            <input type="radio" name="sex" value="女生" />女生
          </label>
        </div>
      </div>
      <!-- 更改头像 -->
      <div class="inputContent shangchuan">
        <span>*</span>
        <span class="xg">更改头像：</span>
        <div style="width:72px;height:72px;background: #000000"></div>
        <div>上传头像</div>
        <span>（备注：图片不得大于500k）</span>
      </div>
      <div class="affirm">确认</div>
    </div>
  </div>
</template>
<script>
import logginHeader from "@/components/logginHeader";
import { GetUserMassage } from "@/api/api";
export default {
  data() {
    return {
      userMessage1: {},
      dialogImageUrl: "",
      dialogVisible: false,
      imageUrl: "" //上传图片
    };
  },
  mounted() {
    this.userMessage();
  },
  methods: {
    handleRemove(file, fileList) {
      console.log(file, fileList);
    },
    handlePictureCardPreview(file) {
      this.dialogImageUrl = file.url;
      this.dialogVisible = true;
    },
    showMsg(msg, code) {
      this.$message({
        message: msg,
        type: code === 1 ? "success" : "error"
      });
    },
    // 获取用户信息
    userMessage() {
      const userId = sessionStorage.getItem("user_id");
      const params = {
        user_id: userId
      };
      GetUserMassage(params).then(res => {
        let { data, msg, code } = res;
        // this.showMsg(msg, code);
        if (code === 1) {
          this.userMessage1 = data;
          // console.log(this.userMessage1);
        }
      });
    },
    // 身份证上传
    handleAvatarSuccess(res, file) {
      this.imageUrl = URL.createObjectURL(file.raw);
    },
    beforeAvatarUpload(file) {
      const isJPG = file.type === "image/jpeg";
      const isLt2M = file.size / 1024 / 1024 < 2;

      if (!isJPG) {
        this.$message.error("上传头像图片只能是 JPG 格式!");
      }
      if (!isLt2M) {
        this.$message.error("上传头像图片大小不能超过 2MB!");
      }
      return isJPG && isLt2M;
    }
  },
  components: {
    logginHeader
  }
};
</script>
<style lang="scss" scoped>
.boxM {
  background: #fff;
  margin: 10px 0 0 20px;
  padding: 40px;
  > div {
    font-size: 13px;
    color: #333333;
    margin-bottom: 25px;
    &:last-child {
      margin: 0;
    }
    > span:nth-of-type(1) {
      color: red;
    }
    span.xg {
      color: #333333;
      margin-right: 20px;
      width: 78px;
    }
    .btnChaneg {
      background: #669900;
      color: #ffffff;
      margin-left: 50px;
      padding: 15px 25px;
      border: 1px solid #ffffff;
      border-radius: 5px;
    }
  }
  .inputContent {
    display: flex;
    input {
      width: 462px;
      height: 34px;
      box-sizing: border-box;
      padding: 5px 10px;
      margin-bottom: 3px;
    }
    div > div {
      color: #5e5e5e;
    }
    .sex {
      input {
        width: 13px;
        height: 13px;
      }
      label {
        margin-right: 80px;
      }
    }
    .company {
      select {
        width: 438px;
        padding: 5px 10px;
      }
      div:nth-of-type(1) div:nth-of-type(1) {
        border: 1px solid rgba(14, 144, 210, 1);
        font-size: 13px;
        border-radius: 3px;
        margin: 0 20px;
        text-align: center;
        padding: 10px;
      }
      div:nth-of-type(1) div:nth-of-type(1) a{
          color: rgba(14, 144, 210, 1);
      }
      div:nth-of-type(1) div:nth-of-type(1):hover {
        font-weight: 700;
      }
      div:nth-of-type(1) div:nth-of-type(2) {
        border: 1px solid rgba(14, 144, 210, 1);
        background-color: rgba(42, 153, 212, 1);
        color: #fff;
        font-size: 13px;
        border-radius: 3px;
        text-align: center;
        padding: 10px;
      }
      div:nth-of-type(1) div:nth-of-type(2) a{
          color:rgb(255, 255, 255);
      }
      div:nth-of-type(1) div:nth-of-type(2):hover {
        font-weight: 700;
      }
    }
  }
  .shangchuan {
    div:nth-of-type(2) {
      border: 1px solid rgba(14, 144, 210, 1);
      background-color: rgba(42, 153, 212, 1);
      width: 158px;
      height: 18px;
      padding: 15px 0;
      color: #fff;
      border-radius: 5px;
      text-align: center;
      margin: 0 50px;
    }
    span:nth-of-type(3) {
      height: 18px;
      padding: 15px 0;
    }
  }
  // 上传
  .avatar-uploader .el-upload {
    border: 1px dashed black;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }
  .avatar-uploader .el-upload:hover {
    border-color: #409eff;
  }
  .avatar-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 178px;
    height: 178px;
    line-height: 178px;
    text-align: center;
  }
  .avatar {
    width: 178px;
    height: 178px;
    display: block;
  }
  // 城市列表
  .el-dropdown-link {
    cursor: pointer;
    color: #000000;
    border: 1px solid black;
    margin-right: 10px;
    padding: 10px;
    box-sizing: border-box;
    &:last-child {
      margin: 0;
    }
  }
  .el-icon-arrow-down {
    font-size: 12px;
  }
  .affirm {
    background: red;
    color: #fff;
    height: 18px;
    padding: 15px 0;
    text-align: center;
    width: 400px;
    margin-left: 98px !important;
    border-radius: 5px;
  }
}
</style>
<template>
  <div>
    <logginHeader>
      <i class="el-icon-edit"></i>
      <span>会员中心</span>
      <span>&gt;</span>
      <span>会员信息</span>
      <span>&gt;</span>
      <span>添加企业身份</span>
    </logginHeader>
    <div class="boxBottom">
      <div class="inputContent">
        <span>*</span>
        <span class="xg">企业名称:</span>
        <div>
          <input type="text" placeholder="请输入企业名称" value="" v-model="name"/>
          <div>*请输入真实公司名，确保电子合同或协议，身份真实获取，保障会员权益</div>
        </div>
      </div>
      <div class="inputContent">
        <span>*</span>
        <span class="xg">企业税号:</span>
        <div>
          <input type="text" placeholder="请输入纳税人识别号（唯一社会信用代码）" value="" v-model="num"/>
          <div>*请输入真实税号，确保电子合同或协议，身份真实获取，保障会员权益</div>
        </div>
      </div>
      <div class="inputContent">
        <span>*</span>
        <span class="xg">上传营业执照:</span>
        <div class="zhiZhaoBox">
          <div class="zhiZhao">
            <el-upload
              name="image"
              class="avatar-uploader"
              list-type="picture-card"
              action="https://manage.siring.com.cn/api/file/qn_upload"
              :show-file-list="false"
              :on-preview="handlePictureCardPreview"
              :on-success="handleAvatarSuccess"
              :before-upload="beforeAvatarUpload"
            >
              <img v-if="yyZhizhaoImg" :src="yyZhizhaoImg" class="avatar" />
              <i v-else class="el-icon-plus avatar-uploader-icon"></i>
            </el-upload>
          </div>
        </div>
      </div>
      <!-- 法人身份证-->
      <div class="inputContent">
        <span style="margin-right:60px;color:#5e5e5e">法人身份证:</span>
        <div class="shenFenZhengBox">
          <div class="shenFenZhengZ">
            <el-upload
              name="image"
              class="avatar-uploader"
              list-type="picture-card"
              action="https://manage.siring.com.cn/api/file/qn_upload"
              :show-file-list="false"
              :on-preview="handlePictureCardPreview"
              :on-success="handleAvatarSuccess1"
              :before-upload="beforeAvatarUpload"
            >
              <img v-if="identityCardZImg" :src="identityCardZImg" class="avatar" />
              <i v-else class="el-icon-plus avatar-uploader-icon"></i>
            </el-upload>
          </div>
          <div class="shenFenZhengF">
            <el-upload
              name="image"
              class="avatar-uploader"
              list-type="picture-card"
              action="https://manage.siring.com.cn/api/file/qn_upload"
              :show-file-list="false"
              :on-preview="handlePictureCardPreview"
              :on-success="handleAvatarSuccess2"
              :before-upload="beforeAvatarUpload"
            >
              <img v-if="identityCardFImg" :src="identityCardFImg" class="avatar" />
              <i v-else class="el-icon-plus avatar-uploader-icon"></i>
            </el-upload>
          </div>
        </div>
      </div>
      <button class="btn" @click="ceshi">确定</button>
    </div>
  </div>
</template>
<script>
import logginHeader from "@/components/logginHeader";
import { EnterpriseAdd} from "@/api/api";
export default {
  data() {
    return {
      name:"",//企业名称
      num:"",//企业税号
      yyZhizhaoImg: require("../../assets/images/yingyezhizhao.png"),
      identityCardZImg: require("../../assets/images/shengFzz.png"),
      identityCardFImg: require("../../assets/images/shengFzf.png")
    };
  },
  components: {
    logginHeader
  },
  mounted() {
    this.SetSS();
  },
  methods: {
    // 进入修改上传样式
    SetSS() {
      let ceshi = document.getElementsByClassName("el-upload--picture-card");
      ceshi[0].style.cssText = "width:140px;height:183px;border:0";
      ceshi[1].style.cssText = "width:162px;height:107px;border:0";
      ceshi[2].style.cssText = "width:162px;height:107px;border:0";
    },
    // 图片上传测试
    handlePictureCardPreview(file) {
      this.dialogImageUrl = file.url;
      this.dialogVisible = true;
    },
    handleAvatarSuccess(res, file) {
      this.yyZhizhaoImg = res.data.filePath;
      console.log(this.yyZhizhaoImg)
    },
    handleAvatarSuccess1(res, file) {
      this.identityCardZImg = res.data.filePath;
      console.log(this.identityCardZImg)
    },
    handleAvatarSuccess2(res, file) {
      this.identityCardFImg = res.data.filePath;
      console.log(this.identityCardFImg)
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
    },
    ceshi(){
      console.log( typeof(this.name) )
       console.log(typeof(this.num))
        console.log(this.yyZhizhaoImg)
         console.log(this.identityCardZImg)
          console.log(this.identityCardFImg)
    },
    //企业信息新增
    GetEnterpriseAdd() {
      const params = {
        title:this.name,
        duty:this.num,
        business_license:this.yyZhizhaoImg,
        id_card_just:this.identityCardZImg,
        id_card_back:this.identityCardFImg
      };
      EnterpriseAdd(params).then(res => {
        let { data, msg, code } = res;
        this.showMsg(msg, code);
        if (code === 1) {
          // console.log(123123);
          this.$router.push("/memberInformation")
        }
      });
    },
     // 返回
    showMsg(msg, code) {
      this.$message({
        message: msg,
        type: code === 1 ? "success" : "error"
      });
    }
  }
};
</script>
<style lang="scss" scoped>
.boxBottom {
  background: #fff;
  margin: 0 0 0 20px;
  .inputContent {
    background: #fff;
    padding: 10px 30px;
    display: flex;
    align-items: center;
    font-size: 13px;
    margin: 0 0 0 20px;
    color: #5e5e5e;
    span {
      font-size: 13px;
    }
    span:nth-of-type(1) {
      color: red;
    }
    span.xg {
      display: flex;
      width: 120px;
      //   margin-right: 20px;
    }
    input {
      width: 475px;
      padding: 10px 5px;
      margin-bottom: 5px;
    }
    .zhiZhaoBox.zhiZhao {
      width: 139px;
      height: 182px;
      box-sizing: border-box;
    }
    .zhiZhaoBox span {
      display: inline-block;
      color: #a1a1a1;
      padding: 10px 0 0 25px;
    }
    .shenFenZhengBox {
      display: flex;
      div span {
        display: inline-block;
        padding: 10px 0 0 35px;
        color: #a1a1a1;
      }
      .shenFenZhengZ {
        margin-right: 50px;
      }
    }
  }
  .inputContent:nth-of-type(1) {
    margin: 5px 0 0 20px;
  }
  .btn {
    background: red;
    color: #fff;
    width: 404px;
    height: 46px;
    text-align: center;
    line-height: 46px;
    border-radius: 5px;
    border: 1px solid red;
    margin-left: 170px;
  }
  .avatar-uploader .el-upload {
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }
  .avatar-uploader-icon {
    font-size: 28px;
    color: #8c939d;
    width: 72px;
    height: 72px;
    line-height: 72px;
    text-align: center;
  }
  .avatar {
    width: 70px;
    height: 70px;
    display: block;
    border-radius: 6px;
  }
  .zhiZhao {
    .avatar-uploader-icon {
      width: 140px;
      height: 183px;
      line-height: 183px;
    }
    .avatar {
      width: 140px;
      height: 183px;
    }
  }
  .shenFenZhengZ {
    .avatar-uploader-icon {
      width: 162px;
      height: 107px;
      line-height: 107px;
    }
    .avatar {
      width: 162px;
      height: 107px;
    }
  }
  .shenFenZhengF {
    .avatar-uploader-icon {
      width: 162px;
      height: 107px;
      line-height: 107px;
    }
    .avatar {
      width: 162px;
      height: 107px;
    }
  }
}
</style>
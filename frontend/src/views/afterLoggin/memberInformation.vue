<template>
  <div>
    <logginHeader>
      <i class="iconfont icon-huiyuan"></i>
      <span>会员中心</span>
      <span>&gt;</span>
      <span>会员信息</span>
    </logginHeader>
    <div class="boxM">
      <div>
        <span>*</span>
        <span>用户绑定手机号：</span>
        <span>{{userMessage1.phone}}</span>
        <button class="btnChaneg">
          <router-link
            :to="{path:'/safetyTabControl',query:{canshu:'first',title:'信息修改'}}"
            style="color:#ffffff"
          >修改绑定手机号</router-link>
        </button>
      </div>
      <div>
        <span class="xg" style="margin-right:25px">我的邀请码：</span>
        <span class="MyInvitationCode">{{userMessage1.invitation}}</span>
      </div>
      <!-- 下方邀请码，看是否已存在，存在就直接value没有则显示 placeholder-->
      <div class="inputContent">
        <span class="xg" style="margin-right:25px">上级邀请码：</span>
        <div>
          <input type="text" placeholder="合适的时机再填写吧，确认上级之后不可修改" :value="otherCode" id="yaoqm" :disabled="otherCode==''?false:true"/>
          <div>*可选项</div>
        </div>
      </div>
      <div class="inputContent">
        <span>*</span>
        <span class="xg">姓名：</span>
        <div>
          <input type="text" placeholder="请输入姓名" value v-model="name" />
          <div>*请输入真实姓名，确保电子合同或协议，身份真实有效，保障会员权益</div>
        </div>
      </div>
      <div class="inputContent">
        <span>*</span>
        <span class="xg">身份证号</span>
        <div>
          <input type="text" placeholder="请输入身份证号" value v-model="sfzId" />
          <div>*请输入真实身份证号，身份真实有效，保障会员权益</div>
        </div>
      </div>

      <div class="inputContent">
        <span class="xg">身份认证:</span>
        <div class="shenFenZhengBox" style="display:flex">
          <div class="shenFenZhengZ">
            <el-upload
              name="image"
              class="avatar-uploader"
              list-type="picture-card"
              action="https://manage.siring.com.cn/api/file/qn_upload"
              :show-file-list="false"
              :on-preview="handlePictureCardPreview"
              :on-remove="handleRemove"
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
              :on-remove="handleRemove"
              :on-success="handleAvatarSuccess2"
              :before-upload="beforeAvatarUpload"
            >
              <img v-if="identityCardFImg" :src="identityCardFImg" class="avatar" />
              <i v-else class="el-icon-plus avatar-uploader-icon"></i>
            </el-upload>
          </div>
        </div>
      </div>
      <!-- 城市选择 -->
      <div style="display:flex">
        <span>*</span>
        <span class="xg">所在地区：</span>
        <div>
          <v-region @values="regionChange" class="form-control"></v-region>
        </div>
      </div>
      <!-- 详细地址 -->
      <div class="inputContent">
        <span>*</span>
        <span class="xg">详细地址：</span>
        <div>
          <input type="text" placeholder="请输入地址" value v-model="dizhi" />
          <div>*请输入真实地址，如需纸质合同或协议，将会邮寄到该地址</div>
        </div>
      </div>
      <!-- 企业身份 -->
      <div class="inputContent">
        <span class="xg" style="margin-right:25px">企业身份：</span>
        <div class="company">
          <div style="display:flex; margin-bottom: 3px">
            <select v-model="enterpriseName">
              <option value="请选择" selected="selected">请选择</option>
              <option v-for="(item,index) in items" :key="index">{{item.name}}</option>
            </select>
            <div>
              <router-link to="addEnterprise">
                <span>*</span>添加企业身份
              </router-link>
            </div>
            <div>
              <router-link to="enterpriseList">企业身份列表</router-link>
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
          <label v-for="(item, index) in radioData" :key="index">
            <input
              type="radio"
              v-model="radioVal"
              :value="item.value"
            />
            {{ item.value }}
          </label>
        </div>
      </div>
      <!-- 更改头像 -->
      <div class="inputContent shangchuan">
        <span>*</span>
        <span class="xg">更改头像：</span>
        <div>
          <el-upload
            name="image"
            class="avatar-uploader"
            list-type="picture-card"
            action="https://manage.siring.com.cn/api/file/qn_upload"
            :show-file-list="false"
            :on-preview="handlePictureCardPreview"
            :on-remove="handleRemove"
            :on-success="handleAvatarSuccess"
            :before-upload="beforeAvatarUpload"
          >
            <img v-if="imageUrl" :src="imageUrl" class="avatar" />
            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
          </el-upload>
        </div>
        <span>
          个人头像上传，点击头像即可更换
          <br />
          <span>（备注：图片不得大于500k）</span>
        </span>
      </div>
      <div class="affirm" @click="UserUpdatingX()">确认</div>
    </div>
  </div>
</template>
<script>
import logginHeader from "@/components/logginHeader";
import { GetUserMassage, UserUpdating, Qnupload,GetEnterprise } from "@/api/api";
export default {
  data() {
    return {
      userId:sessionStorage.getItem("user_id"),
      imageUrl: require("../../assets/images/u158.png"),
      otherCode:"",//他人邀请码
      name: "",
      userMessage1: {},
      sfzId: "",
      dizhi: "",
      enterpriseName: "请选择",
      items: [],//企业信息
      // sex: "男",
      radioData: [
        { value: '男' },
        { value: '女' },
      ],
      radioVal: '男',
      province: "", //省
      city: "", //市
      area: "", //县市区
      identityCardZImg: require("../../assets/images/shengFzz.png"),
      identityCardFImg: require("../../assets/images/shengFzf.png")
    };
  },
  mounted() {
    this.userMessage();
    this.SetSS();
    this.Enterprise();
  },
  methods: {
    // 进入修改上传样式
    SetSS() {
      let ceshi = document.getElementsByClassName("el-upload--picture-card");
      ceshi[0].style.cssText = "width:162px;height:107px;border:0";
      ceshi[1].style.cssText = "width:162px;height:107px;border:0";
      ceshi[2].style.cssText = "width:72px;height:72px;border:0";
    },

    // 图片上传测试
    handleRemove(file) {
      console.log(file);
    },
    handlePictureCardPreview(file) {
      this.dialogImageUrl = file.url;
      this.dialogVisible = true;
    },
    handleDownload(file) {
      console.log(file);
    },
    handleAvatarSuccess(res, file) {
      // this.valData.imageUrl = res.data.filePath;
      // console.log(res.data.filePath);
      this.imageUrl = res.data.filePath;
    },
    handleAvatarSuccess1(res, file) {
      this.identityCardZImg = res.data.filePath;
    },
    handleAvatarSuccess2(res, file) {
      this.identityCardFImg = res.data.filePath;
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
    // 三级联动插件
    regionChange(data) {
      this.province = data.province === null ? "" : data.province.value;
      this.city = data.city === null ? "" : data.city.value;
      this.area = data.area === null ? "" : data.area.value;
      // console.log(this.province);
      // console.log(this.city);
      // console.log(this.area);
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
          this.imageUrl=data.img||this.imageUrl,
          this.otherCode=data.other_code,//他人邀请码
          this.name=data.realname,
          this.sfzId=data.id_card,
          this.dizhi=data.address,
          this.radioVal=data.sex===1?"男":"女",
          // this.enterpriseName = data
          this.identityCardZImg=data.id_card_just||this.identityCardZImg,
          this.identityCardFImg=data.id_card_back||this.identityCardFImg
          console.log(data.img)
        }
      });
    },
    //用户信息更新
    UserUpdatingX() {
      const userId = sessionStorage.getItem("user_id");
      const params = {
        user_id: userId,
        name: this.name,
        id_card: this.sfzId,
        id_card_just: this.identityCardZImg,
        id_card_back: this.identityCardFImg,
        province: this.province,
        city: this.city,
        enterprise_id:this.enterpriseName,
        area: this.area,
        address: this.dizhi,
        enterprise_id: this.enterpriseName,
        radioVal: this.sex,
        img: this.imageUrl,
        sex:this.radioVal==="男"?"1":"2",
        invitation:document.getElementById("yaoqm").value
      };
      UserUpdating(params).then(res => {
        let { data, msg, code } = res;
        this.showMsg(msg, code);
        if (code === 1) {
          // console.log(123123);
          this.$router.push("/afterLogginR");
        }
      });
    },
    // 获取企业信息
    Enterprise(){
      const params = {user_id:this.userId}
      GetEnterprise(params).then(res=>{
        let {code, data , msg} = res
        if(code == 1) {
          this.items = data
        }
      })
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
      div:nth-of-type(1) div:nth-of-type(1) a {
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
      div:nth-of-type(1) div:nth-of-type(2) a {
        color: rgb(255, 255, 255);
      }
      div:nth-of-type(1) div:nth-of-type(2):hover {
        font-weight: 700;
      }
    }
  }
  .shenFenZhengZ {
    .avatar-uploader-icon {
      font-size: 28px;
      color: #8c939d;
      width: 162px;
      height: 107px;
      line-height: 72px;
      text-align: center;
    }
    .avatar {
      width: 162px;
      height: 107px;
      display: block;
      border-radius: 6px;
    }
  }
  .shenFenZhengF {
    .avatar-uploader-icon {
      font-size: 28px;
      color: #8c939d;
      width: 162px;
      height: 107px;
      line-height: 72px;
      text-align: center;
    }
    .avatar {
      width: 162px;
      height: 107px;
      display: block;
      border-radius: 6px;
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
      display: inline-block;
      height: 60px;
      padding: 20px 0 0 15px;
      box-sizing: border-box;
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
    cursor: pointer;
  }

  // 图片上传
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
  .shenFenZhengBox {
    > div {
      &:nth-of-type(1) {
        margin-right: 50px;
      }
    }
  }
}
</style>
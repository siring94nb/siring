<template>
  <div>
    <v-region @values="regionChange" class="form-control" style="margin-bottom:50px;"></v-region>
    <!-- <v-distpicker type="mobile" @selected='selected' v-show="addInp"></v-distpicker> -->
    <el-upload
      name="image"
      action="https://manage.siring.com.cn/api/file/qn_upload"
      list-type="picture-card"
      :on-preview="handlePictureCardPreview"
      :on-success="handleAvatarSuccess"
      :on-remove="handleRemove"
    >
      <i class="el-icon-plus"></i>
    </el-upload>
    <div class="box">
    <el-upload
      name="image"
      class="avatar-uploader"
      list-type="picture-card"
      action="https://manage.siring.com.cn/api/file/qn_upload"
      :show-file-list="false"
      :on-preview="handlePictureCardPreview"
      :on-remove="handleRemove"
      :on-success="handleAvatarSuccess"
    >
      <img v-if="imageUrl" :src="imageUrl" class="avatar" />
      <i v-else class="el-icon-plus avatar-uploader-icon"></i>
    </el-upload>
    </div>
    <!-- <el-dialog :visible.sync="dialogVisible" size="tiny">
      <img width="100%" :src="valData.imageUrl" alt />
    </el-dialog>--> 
    <el-button type @click="SetSS">存数据</el-button>
    <el-button type @click="GetCityTotal">发送请求</el-button>
  </div>
</template>
<script>
import VDistpicker from "v-distpicker";
import { GetRoleCenter, CityTotal, CityPartner, Qnupload } from "@/api/api";
export default {
  data() {
    return {
      imageUrl: require("../../assets/images/u158.png"),
      city: "请选择",
      addInp: false,
      mask: false,
      fileList: [],
      dialogImageUrl: "",
      dialogVisible: false,
      disabled: false,
      uploadList:[]
    };
  },
  components: { VDistpicker },
  mounted(){
    this.SetSS()
  },
  methods: {
    // 存储用户信息
    SetSS() {
      let ceshi = document.getElementsByClassName("el-upload--picture-card");
      ceshi[1].style.width = "300px"
      console.log(ceshi[1].style.width);
      this.uploadList.push(111111)
      console.log(this.uploadList);
    },
    //获取城市合伙人数据
    GetCityTotal() {
      CityTotal().then(res => {
        let { data, msg, code } = res;
        // this.showMsg(msg, code);
        console.log(res);
        if (code === 1) {
        } else {
        }
      });
    },

    //receive selected region data
    regionChange(data) {
      this.$refs.upload.submit();
    },
    toAddress() {
      this.mask = true;
      this.addInp = true;
    },
    selected(data) {
      this.mask = false;
      this.addInp = false;
      this.city =
        data.province.value + " " + data.city.value + " " + data.area.value;
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
      console.log(res.data.filePath)
      this.uploadList.push(res.data.filePath);
      // this.imageUrl = URL.createObjectURL(file.raw);
      console.log(this.uploadList);
    }
  }
};
</script>
<style lang="scss" scoped>
.box{
  margin-left: 200px;
}
.avatar-uploader{
  width: 300px;
  background: black;
}
.avatar-uploader .el-upload {
  border: 1px dashed #d9d9d9;
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
// div.el-upload.el-upload--picture-card{
// width: 300px !important   ;
// }
</style>
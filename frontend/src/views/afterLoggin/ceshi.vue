<template>
  <div>
    <el-upload
    name="file"
  class="upload-demo"
  action="https://manage.siring.com.cn/api/file/qn_upload"
  multiple
  :limit="3">
  <el-button size="small" type="primary">点击上传</el-button>
  <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过500kb</div>
</el-upload>
<div class="liuyanBox">
  <liuyan :pid = pid :uid=uid></liuyan>
</div>
  <button @click="ceshi">获取</button>  
  </div>
</template>
<script>
import VDistpicker from "v-distpicker";
import liuyan from "../../components/liuyan/leaveAmessage"
import { GetRoleCenter, CityTotal, CityPartner, Qnupload } from "@/api/api";
export default {
  data() {
      return {
        imageUrl: '',
        pid:67,
        uid:sessionStorage.getItem("user_id")
      };
    },
    methods: {
      ceshi(){

          function formatDate(now) { 
          var year=now.getFullYear();  //取得4位数的年份
          var month=now.getMonth()+1;  //取得日期中的月份，其中0表示1月，11表示12月
          var date=now.getDate();      //返回日期月份中的天数（1到31）
          var hour=now.getHours();     //返回日期中的小时数（0到23）
          var minute=now.getMinutes(); //返回日期中的分钟数（0到59）
          var second=now.getSeconds(); //返回日期中的秒数（0到59）
          return year+"-"+month+"-"+date+" "+hour+":"+minute+":"+second; 
          }
        let date = new Date()
        console.log(formatDate(new Date()));
      },
      handleAvatarSuccess(res, file) {
        this.imageUrl = URL.createObjectURL(file.raw);
      },
      beforeAvatarUpload(file) {
        const isJPG = file.type === 'image/jpeg';
        const isLt2M = file.size / 1024 / 1024 < 2;

        if (!isJPG) {
          this.$message.error('上传头像图片只能是 JPG 格式!');
        }
        if (!isLt2M) {
          this.$message.error('上传头像图片大小不能超过 2MB!');
        }
        return isJPG && isLt2M;
      }
    },
    components: {
      liuyan
    }
};
</script>
<style lang="scss" scoped>
.liuyanBox{
  width: 1000px;
  margin-left: 50px;
}
.avatar-uploader .el-upload {
    border: 1px dashed #d9d9d9;
    border-radius: 6px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
  }
  .avatar-uploader .el-upload:hover {
    border-color: #409EFF;
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
</style>
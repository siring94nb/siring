<template>
  <div>
    <v-region @values="regionChange" class="form-control" style="margin-bottom:50px;"></v-region>
    <!-- <v-distpicker type="mobile" @selected='selected' v-show="addInp"></v-distpicker> -->
    <el-upload
    style=" margin-left: 100px;"
      class="upload-demo"
      ref="upload"
      action="https://jsonplaceholder.typicode.com/posts/"
      :on-preview="handlePreview"
      :on-remove="handleRemove"
      :file-list="fileList"
      :auto-upload="false"
    >
      <el-button slot="trigger" size="small" type="primary">选取文件</el-button>
      <el-button style="margin-left: 10px;" size="small" type="success" @click="submitUpload">上传到服务器</el-button>
      <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过500kb</div>
    </el-upload>
  </div>
</template>
<script>
import VDistpicker from "v-distpicker";
export default {
  data() {
    return {
      city: "请选择",
      addInp: false,
      mask: false,
      fileList: []
    };
  },
  components: { VDistpicker },
  methods: {
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
    submitUpload(file,fileList) {
        console.log(file.name)
      },
      handleRemove(file, fileList) {
        console.log(file, fileList);
      },
      handlePreview(file) {
        console.log(file);
      }
  }
};
</script>
<style lang="scss" scoped>
</style>
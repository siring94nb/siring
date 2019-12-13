<template>
  <div>
    <v-region @values="regionChange" class="form-control" style="margin-bottom:50px;"></v-region>
    <!-- <v-distpicker type="mobile" @selected='selected' v-show="addInp"></v-distpicker> -->
    <el-upload
  action="https://manage.siring.com.cn/api/file/qn_upload"
  list-type="picture-card"
  :on-success="handleAvatarSuccess"
  :auto-upload="false">
    <i slot="default" class="el-icon-plus"></i>
    <div slot="file" slot-scope="{file}">
      <img
        class="el-upload-list__item-thumbnail"
        :src="file.url" alt=""
      >
      <span class="el-upload-list__item-actions">
        <span
          class="el-upload-list__item-preview"
          @click="handlePictureCardPreview(file)"
        >
          <i class="el-icon-zoom-in"></i>
        </span>
        <span
          v-if="!disabled"
          class="el-upload-list__item-delete"
          @click="handleDownload(file)"
        >
          <i class="el-icon-download"></i>
        </span>
        <span
          v-if="!disabled"
          class="el-upload-list__item-delete"
          @click="handleRemove(file)"
        >
          <i class="el-icon-delete"></i>
        </span>
      </span>
    </div>
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
      fileList: [],
       dialogImageUrl: '',
        dialogVisible: false,
        disabled: false
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
      this.valData.imageUrl = res.data.filePath;
      this.uploadList.push(res.data.filePath);
      console.log(res)
    },
  }
};
</script>
<style lang="scss" scoped>
</style>
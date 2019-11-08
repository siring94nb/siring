<template>
  <div class="index">
    <myheader />
    <div class="index">
        <div class="steps">
            <el-steps  :active="1" align-center>
            <el-step title="选择行业模板"></el-step>
            <el-step title="选择套餐"></el-step>
            </el-steps>
        </div>
        <div class="title">
            <div class="all" :class="{'hui':diyHui,'selected':diySel}" @click="diyGb">DIY样式</div>
            <div class="all" :class="{'hui':guHui,'selected':guSel}" @click="diyGb">固定样式</div>
            <div style="flex:1"></div>
            <div class="appreciation">增值服务</div>
        </div>
        <div class="abstract">
            <div class="abstract-l">
                <h1>行业模板：{{showTemp.model_name}}</h1>
                <p>模板简介：</p>
                <span>{{showTemp.model_des}}</span>
                <p>模板分类：</p>
                <span>微信小程序</span>
                <!-- <div class="appreciate">
                    <div>样式欣赏:</div>
                    <div style="flex:1;"></div>
                    <div>
                        <img src="../../assets/images/u2945.png" alt="">
                    </div>
                </div> -->
            </div>
            <div class="abstract-img">
                <img :src="showTemp.model_image" alt="">
            </div>
            <div class="abstract-r">
                <div class="input-box">
                    <div style="width:120px;display:inline-block;font-size:18px;">小程序名称<span style="color:red;">*</span></div>
                    <input type="text" placeholder="给即将开通的小程序起个名字吧~！" v-model="valData.prog_name">
                </div>
                <div class="upload-img">
                    <div style="width:150px;font-size:18px;">小程序logo<span style="color:red;">*</span></div>
                    <el-upload
                    name="image"
                      :action="UploadAction"
                      list-type="picture-card"
                      :on-preview="handlePictureCardPreview"
                      :on-success="handleAvatarSuccess"
                      :before-upload="beforeAvatarUpload"
                      :on-remove="handleRemove">
                      <i class="el-icon-plus"></i>
                    </el-upload>
                    <el-dialog :visible.sync="dialogVisible" size="tiny">
                      <img width="100%" :src="valData.imageUrl" alt="">
                    </el-dialog>
                      <!-- <div class="tips">建议长传144*144大小图片</div> -->
                </div>
                <div class="sub-btn">确定，选择套餐</div>
            </div>
        </div>
        <div class="title-bar">
            选择适合自己的行业模板
        </div>
        <div class="stencil">
            <div class="stencil_chil" >
              <el-radio-group v-model="valData.arr" @change="radioChange" v-for="item in tempList" :key="item.id">
                    <img :src="item.model_image" alt="">
                    <div><el-radio  :label="item.id">{{item.model_name}}</el-radio></div>
                </el-radio-group>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
// @ is an alias to /src
import Myheader from "@/components/header";
import { GetTemplate} from "@/api/api";
import config from '../../../../web/build/config';
export default {
  name: "index",
  components: {
    Myheader,
  },
  data() {
    return {
      dialogVisible: false,
        diyHui:true,
        diySel:false,
        guHui:false,
        guSel:true,
        tempList:[],
        showTemp: {},
        valData: {
          arr:"",
          prog_name:"",
          imageUrl:""
        },
        UploadAction: '',
        fileList:[],
        uploadList:[]
    };
  },
  mounted() {
    this.init();
    this.UploadAction = config.front_url+'file/qn_upload';
  },
  methods: {
      init(){
        this.getTemplate();
      },
      getTemplate(){
        var model_type,params;
        if(this.diySel) model_type = 1;
        else model_type = 2;
        GetTemplate(params={"model_type": model_type}).then(res => {
          let { code, data, msg } = res.data;
          if (code === 1) {
            this.tempList = data;
            this.showTemp = data[0];
            this.valData.arr = data[0].id;
          }
        });
      },
      radioChange(val){
        console.log(val)
      },
      handleRemove(file, fileList) {
        this.uploadList.splice(this.uploadList.indexOf(file), 1);
        this.valData.imageUrl = '';
      },
      handleAvatarSuccess(res, file) {
        this.uploadList.push(res.data.filePath);
      },
      beforeAvatarUpload(file) {
        const check = this.uploadList.length < 1;
        if (!check) {
            this.$notify.error({
              title: '错误',
              message:'只能上传一张品牌图'
              });
        }
        return check;
      },
      handlePictureCardPreview(file) {
        this.valData.imageUrl = file.url;
        this.dialogVisible = true;
      },
      diyGb() {
        this.diyHui=!this.diyHui;
        this.diySel=!this.diySel;
        this.guHui=!this.guHui;
        this.guSel=!this.guSel;
        this.getTemplate();
      }
  }
};
</script>
<style lang="scss" scoped>
.index {
  margin: auto;
  margin-top: 100px;
  width: 1200px;
  .steps {
      width: 500px;
      margin: auto;
  }
  .title {
      display: flex;
      border-bottom: 1px solid rgb(26,188,156);
      div{color: #fff;font-size: 18px;text-align: center;}
      .all {width: 150px;line-height: 38px;border-top-left-radius:5px;border-top-right-radius:5px; }
      .hui{background-color: rgb(174,174,174); margin-bottom: -1px;cursor: pointer;}
      .selected {background-color: rgb(26,188,156);cursor: pointer;}
      .appreciation{margin-right: 20px;background-color: rgb(255,153,0);width: 130px;line-height: 36px;height: 36px;font-weight: 700;}
  }
  .abstract{
      display: flex;
      justify-content : space-between;
      div {width: 35%;}
      .abstract-l {
          h1{font-size: 24px;font-weight: 700;margin: 50px 0;}
          p {margin: 30px 0;font-size: 18px;}
          span{font-size: 14px;}
          .appreciate {
              margin-top: 30px;
              width: 100%;
              display: flex;
                div{font-size: 18px;}
                img{display: inline-block;}
          }
      }
      .abstract-img{
        text-align: center;margin: 20px 0;
        img{width: 230px;height: 420px;}
      }
      .abstract-r {
          margin-top: 20px;
          div{width: 100%;}
          .upload-img{display: flex;margin: 20px 0;}
          .tips{text-align: center;color: rgb(199,203,225);font-size: 14px;}
          .sub-btn{color: #fff;width: 200px;background-color: red;text-align: center;line-height: 38px;margin: 20px 0;float: right;}
          .input-box{
              input{width: 230px;padding: 5px;}
          }
      }
  }
  .title-bar {color: rgb(26,188,156);height: 30px;line-height: 30px;background-color: rgb(242,242,242);padding: 8px;font-weight: 700;}
  .stencil{
    padding: 20px 0;
    display: flex;
    flex-wrap:wrap;
    .stencil_chil{
      img{width: 230px;height: 420px;}
      div{
       margin: 20px 10px 0 0;
      }
    }
  }
  /*图片上传 */
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
    width: 144px;
    height: 144px;
    line-height: 144px;
    text-align: center;
  }
  .avatar {
    width: 178px;
    height: 178px;
    display: block;
  }
  /*图片上传 */
}

</style>
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
                <h1>行业模板：餐饮</h1>
                <p>模板简介：</p>
                <span>这是一个针对店铺介绍以及店铺活动点餐还有到店点单的小程序；同城配送、各种美食优惠活动，还有会员专属特权等你领</span>
                <p>模板分类：</p>
                <span>微信小程序</span>
                <div class="appreciate">
                    <div>样式欣赏:</div>
                    <div style="flex:1;"></div>
                    <div>
                        <img src="../../assets/images/u2945.png" alt="">
                    </div>
                </div>
            </div>
            <div class="abstract-img">
                <img src="../../assets/images/u2931.png" alt="">
            </div>
            <div class="abstract-r">
                <div class="input-box">
                    <div style="width:120px;display:inline-block;font-size:18px;">小程序名称<span style="color:red;">*</span></div>
                    <input type="text" placeholder="给即将开通的小程序起个名字吧~！" v-model="prog_name">
                </div>
                <div class="upload-img">
                    <div style="width:150px;font-size:18px;">小程序logo<span style="color:red;">*</span></div>
                    <el-upload
                        class="avatar-uploader"
                        action="https://jsonplaceholder.typicode.com/posts/"
                        :show-file-list="false"
                        :on-success="handleAvatarSuccess"
                        :before-upload="beforeAvatarUpload">
                        <img v-if="imageUrl" :src="imageUrl" class="avatar">
                        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                        <div class="tips">建议长传144*144大小图片</div>
                    </el-upload>
                </div>
                <div class="sub-btn">确定，选择套餐</div>
            </div>
        </div>
        <div class="title-bar">
            选择适合自己的行业模板
        </div>
        <div class="stencil">
            <div class="stencil_chil">
                <img src="../../assets/images/u2931.png" alt="">
                <div><input type="radio" name="bar" v-model="arr"><span>通用模板</span></div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
// @ is an alias to /src
import Myheader from "@/components/header";
import Myaside from "@/components/aside";
import Sjhy from "@/components/sjhy";
import Jdyh from "@/components/jdyh";
import { GetTemplate} from "@/api/api";
export default {
  name: "index",
  components: {
    Myheader,
    Myaside,
    Sjhy,
    Jdyh
  },
  data() {
    return {
        imageUrl:"",
        diyHui:true,
        diySel:false,
        guHui:false,
        guSel:true,
        prog_name:"",
        arr:"",
        typeList:[]
    };
  },
  mounted() {
    this.init();
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
          console.log(res)
          let { code, data, msg } = res.data;
          if (code === 1) {
            this.typeList = data;
          }
        });
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
      },
      diyGb() {
        this.diyHui=!this.diyHui;
        this.diySel=!this.diySel;
        this.guHui=!this.guHui;
        this.guSel=!this.guSel;
        this.getTemplate();
      }
  },
  computed: {},
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
      .abstract-img{text-align: center;margin: 20px 0;}
      .abstract-r {
          margin-top: 150px;
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
      margin-right: 10px;
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
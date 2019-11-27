<template>
  <div class="index">
    <myheader />
    <div @click="shelterHidden" v-if="imgShow" class="shelter-img">
      <div class="images-box" @click.stop>
        <img src="../../assets/images/u2.png" style="width:100%;height:100%;" alt />
        <div class="images-show">
          <img :src="imagesUrl" style="width:100%;" alt />
        </div>
      </div>
    </div>
    <div class="index">
      <div class="steps">
        <div class="lines"></div>
        <div class="dashed"></div>
        <div class="label">
          <div class="label-r label-l">
            <img src="../../assets/images/u3086.png" alt />
            <div class="label-text">选择行业模板</div>
            <span class="label-number">1</span>
          </div>
          <div class="label-r">
            <img src="../../assets/images/u3087.png" alt />
            <div class="no-sel">选择套餐</div>
            <span class="label-number">2</span>
          </div>
        </div>
      </div>
      <div class="title">
        <div class="all" :class="{'hui':diyHui,'selected':diySel}" @click="diyGb">DIY样式</div>
        <div class="all" :class="{'hui':guHui,'selected':guSel}" @click="diyGb">固定样式</div>
        <!-- <el-button class="wh-sty" v-popover:popover2>？</el-button> -->
        <button  class="wh-sty" v-popover:popover2>？</button>
        <div style="flex:1"></div>
        <el-button type="warning" class="appreciation" v-popover:popover1>增值服务</el-button>
      </div>
      <el-popover ref="popover1" placement="bottom" width="450" trigger="click">
        <div style="display:flex;justify-content : space-around;">
          <div class="popover-box">
            <p>小程序办理开通</p>
            <p class="popover-price">￥1000元</p>
          </div>
          <div class="popover-box">
            <p>装修布局界面设计</p>
            <p class="popover-price">￥2000元/20页</p>
          </div>
          <div class="popover-box">
            <p>图片图标美工UI</p>
            <p class="popover-price">￥3000元/50张</p>
          </div>
        </div>
        <p class="popover-p">注：以上视工作复杂程度另行加价，如工作量较大，可多次购买服务</p>
      </el-popover>
      <el-popover
        ref="popover2"
        placement="bottom"
        width="350"
        trigger="click"
        content="DIY样式可对结构板块样式做适当修改，固定样式不能对样式做修改，但可对内容及各元素图文做替换"
      ></el-popover>
      <div class="abstract">
        <div class="abstract-l">
          <h1>行业模板：{{showTemp.model_name}}</h1>
          <p>模板简介：</p>
          <span>{{showTemp.model_des}}</span>
          <!-- <p>模板分类：</p>
          <span>微信小程序</span>
        <div class="appreciate">
                    <div>样式欣赏:</div>
                    <div style="flex:1;"></div>
                    <div>
                        <img src="../../assets/images/u2945.png" alt="">
                    </div>
          </div>-->
        </div>
        <div class="abstract-img" @mouseover="shelter(-1)" @mouseleave="shelterLeave">
          <div class="abstract-show">
            <img src="../../assets/images/u2.png" style="width:100%;height:100%;" alt />
            <div class="show-img">
              <img :src="showTemp.model_image_small" style="width:100%;height:100%;" alt />
            </div>
          </div>
          <div class="shelter" v-if="isShelter">
            <el-button
              @click="shelterShow(showTemp.model_image)"
              icon="el-icon-search"
              style="margin:210px 0;"
              plain
            >预览</el-button>
          </div>
        </div>
        <div class="abstract-r">
          <div class="input-box">
            <div style="width:120px;display:inline-block;font-size:18px;">
              小程序名称
              <span style="color:red;">*</span>
            </div>
            <input type="text" placeholder="给即将开通的小程序起个名字吧~！" style="width:265px;" v-model="valData.prog_name" />
          </div>
          <div class="upload-img">
            <div style="width:170px;font-size:18px;">
              小程序logo
              <span style="color:red;">*</span>
            </div>
            <el-upload
              name="image"
              :action="UploadAction"
              list-type="picture-card"
              :on-preview="handlePictureCardPreview"
              :on-success="handleAvatarSuccess"
              :before-upload="beforeAvatarUpload"
              :on-remove="handleRemove"
            >
              <i class="el-icon-plus"></i>
            </el-upload>
            <el-dialog :visible.sync="dialogVisible" size="tiny">
              <img width="100%" :src="valData.imageUrl" alt />
            </el-dialog>
            <!-- <div class="tips">建议长传144*144大小图片</div> -->
          </div>
          <div class="sub-btn" @click="selCombo">确定，选择套餐</div>
        </div>
      </div>
      <div class="title-bar">选择适合自己的行业模板</div>
      <div class="stencil">
        <div class="stencil_chil">
          <div
            class="stencil-img"
            v-for="(item, index) in tempList"
            :key="item.id"
            @mouseover="shelter(index)"
            @mouseleave="shelterLeave"
          >
            <img :src="item.model_image_small" alt />
            <div class="shelter" v-if="isStencil == index">
              <el-button
                @click="selImage(index, item.id)"
                style="margin:200px auto;background-color:rgb(102,204,0);color:#fff;border:0;"
              >使用</el-button>
            </div>
            <div class="stencil-text">{{item.model_name}}</div>
          </div>
          <!-- <el-radio-group
            v-model="valData.arr"
            v-for="(item, index) in tempList"
            :key="item.id"
            @change="radioChange(index, item.id)"
          >
            <img :src="item.model_image_small" alt />
            <div>
              <el-radio :label="item.id">{{item.model_name}}</el-radio>
            </div>
          </el-radio-group>-->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// @ is an alias to /src
import Myheader from "@/components/header";
import { GetTemplate } from "@/api/api";
export default {
  name: "index",
  components: {
    Myheader
  },
  data() {
    return {
      dialogVisible: false,
      diyHui: true,
      diySel: false,
      guHui: false,
      guSel: true,
      tempList: [],
      showTemp: {},
      valData: {
        arr: "",
        prog_name: "",
        imageUrl: "",
        model_meal_category: 2
      },
      UploadAction: "",
      fileList: [],
      uploadList: [],
      isShelter: false,
      isStencil: -1,
      imgShow: false,
      imagesUrl: ""
    };
  },
  mounted() {
    this.init();
    this.UploadAction = "https://manage.siring.com.cn/api/file/qn_upload";
  },
  methods: {
    init() {
      this.getTemplate();
    },
    getTemplate() {
      var params;
      if (this.diySel) this.valData.model_meal_category = 1;
      else this.valData.model_meal_category = 2;
      GetTemplate(
        (params = { model_type: this.valData.model_meal_category })
      ).then(res => {
        let { code, data, msg } = res.data;
        if (code === 1) {
          this.tempList = data;
          this.showTemp = data[0];
          this.valData.arr = data[0].id;
        }
      });
    },
    //选择模板
    selImage(index, id) {
      this.showTemp = this.tempList[index];
      let top = document.documentElement.scrollTop || document.body.scrollTop;
      // 实现滚动效果
      const timeTop = setInterval(() => {
        document.body.scrollTop = document.documentElement.scrollTop = top -= 50;
        if (top <= 0) {
          clearInterval(timeTop);
        }
      }, 10);
    },
    handleRemove(file, fileList) {
      this.uploadList.splice(this.uploadList.indexOf(file), 1);
      this.valData.imageUrl = "";
    },
    handleAvatarSuccess(res, file) {
      this.valData.imageUrl = res.data.filePath;
      this.uploadList.push(res.data.filePath);
    },
    beforeAvatarUpload(file) {
      const check = this.uploadList.length < 1;
      if (!check) {
        this.$notify.error({
          title: "错误",
          message: "只能上传一张品牌图"
        });
      }
      return check;
    },
    handlePictureCardPreview(file) {
      // this.valData.imageUrl = file.url;
      this.dialogVisible = true;
    },
    diyGb() {
      this.diyHui = !this.diyHui;
      this.diySel = !this.diySel;
      this.guHui = !this.guHui;
      this.guSel = !this.guSel;
      this.getTemplate();
    },
    //确认套餐
    selCombo() {
      if (!this.valData.prog_name) {
        this.$message.error("小程序名称不能为空");
      } else if (!this.valData.arr) {
        this.$message.error("模板不能为空");
      } else if (!this.valData.imageUrl) {
        this.$message.error("小程序logo不能为空");
      } else {
        this.$router.push({
          name: "selectCombo",
          params: this.valData
        });
      }
    },
    shelter(index) {
      if (index < 0) this.isShelter = true;
      else this.isStencil = index;
    },
    shelterLeave() {
      this.isShelter = false;
      this.isStencil = -1;
    },
    shelterShow(url) {
      this.imgShow = true;
      this.imagesUrl = url;
    },

    shelterHidden() {
      this.imgShow = false;
      this.imagesUrl = "";
    }
  }
};
</script>
<style scoped>
/* .el-popper {
  background-color: rgb(219, 255, 255);
} */
.upload-img >>> .el-upload--picture-card {
  width: 100px;
  height: 100px;
  line-height: 100px;
}
.upload-img >>> .el-upload-list--picture-card .el-upload-list__item {
  width: 100px;
  height: 100px;
}
</style>
<style lang="scss" scoped>
.popover-box {
  background-color: rgb(29, 211, 175);
  text-align: center;
  line-height: 24px;
  color: #fff;
  border-radius: 5px;
  padding: 8px;
  font-size: 16px;
  width: 130px;
}
.popover-price {
  font-size: 18px;
  font-weight: 700;
}
.popover-p {
  font-size: 12px;
  color: #ff9191;
  margin-top: 5px;
}
.shelter-img {
  position: fixed;
  background-color: rgba(0, 0, 0, 0.6);
  width: 100%;
  height: 100%;
  z-index: 999;
  top: 0;
  left: 0;
  .images-box {
    width: 24%;
    height: 96%;
    margin: 20px auto;
    position: relative;
    .images-show {
      width: 83%;
      height: 73%;
      overflow-y: scroll;
      position: absolute;
      top: 13%;
      left: 7%;
    }
  }
}
.index {
  margin: auto;
  margin-top: 150px;
  width: 1200px;
  .steps {
    display: flex;
    position: relative;
    margin: 70px auto;
    width: 250px;
    .lines {
      width: 170px;
      border-bottom: 2px solid rgb(26, 188, 156);
    }
    .dashed {
      width: 150px;
      border-bottom: 2px dashed rgb(161, 161, 161);
    }
    .label {
      display: flex;
      position: absolute;
      top: -30px;
      left: -30px;
      .label-r {
        position: relative;
        text-align: center;
        div {
          width: 100px;
          font-weight: 700;
          font-size: 14px;
        }
        .label-text {
          color: rgb(26, 188, 156);
        }
        .no-sel {
          color: rgb(161, 161, 161);
        }
        .label-number {
          color: #fff;
          font-size: 30px;
          position: absolute;
          top: 15px;
          left: 41px;
        }
      }
      .label-l {
        margin-right: 150px;
      }
    }
  }
  .title {
    display: flex;
    border-bottom: 1px solid rgb(26, 188, 156);
    div {
      color: #fff;
      font-size: 18px;
      text-align: center;
    }
    .all {
      width: 150px;
      line-height: 38px;
      border-top-left-radius: 5px;
      border-top-right-radius: 5px;
    }
    .hui {
      background-color: rgb(174, 174, 174);
      margin-bottom: -1px;
      cursor: pointer;
    }
    .selected {
      background-color: rgb(26, 188, 156);
      cursor: pointer;
    }
    .wh-sty {
      background-color: red;
      border-radius: 50%;
      color: #fff;
      border: 0;
      width: 30px;
      height: 30px;
      padding: 0;
      text-align: center;
      margin: 5px 0 0 10px;
      cursor: pointer;
    }
    .appreciation {
      background-color: rgb(255, 153, 0);
      font-weight: 700;
      font-size: 18px;
      height: 36px;
      line-height: 12px;
      margin-right: 20px;
      width: 150px;
    }
  }
  .abstract {
    display: flex;
    justify-content: space-between;
    div {
      width: 35%;
    }
    .abstract-l {
      h1 {
        font-size: 24px;
        font-weight: 700;
        margin: 45px 0 80px 0;
      }
      p {
        margin: 30px 0;
        font-size: 18px;
      }
      span {
        font-size: 14px;
        line-height: 30px;
      }
      .appreciate {
        margin-top: 30px;
        width: 100%;
        display: flex;
        div {
          font-size: 18px;
        }
        img {
          display: inline-block;
        }
      }
    }
    .abstract-img {
      text-align: center;
      margin: 20px 0;
      position: relative;
      .abstract-show {
        position: relative;
        width: 260px;
        height: 480px;
        margin: auto;
        .show-img {
          position: absolute;
          top: 60px;
          left: 20px;
          height: 350px;
          width: 210px;
        }
      }
      .shelter {
        width: 230px;
        height: 450px;
        background-color: rgba(0, 0, 0, 0.6);
        margin: auto;
        position: absolute;
        top: 3%;
        left: 20%;
        border-radius: 35px;
      }
      img {
        width: 230px;
        height: 420px;
      }
    }
    .abstract-r {
      margin-top: 236px;
      div {
        width: 100%;
      }
      .upload-img {
        display: flex;
        margin: 20px 0;
      }
      .tips {
        text-align: center;
        color: rgb(199, 203, 225);
        font-size: 14px;
      }
      .sub-btn {
        color: #fff;
        width: 280px;
        background-color: red;
        border-radius: 5px;
        text-align: center;
        line-height: 38px;
        margin: 20px 0;
        float: right;
        cursor: pointer;
      }
      .input-box {
        margin-bottom: 40px;
        input {
          width: 230px;
          padding: 5px;
        }
      }
    }
  }
  .title-bar {
    color: rgb(26, 188, 156);
    height: 30px;
    line-height: 30px;
    background-color: rgb(242, 242, 242);
    padding: 8px;
    font-weight: 700;
  }
  .stencil {
    padding: 20px 0;
    display: flex;
    flex-wrap: wrap;
    .stencil_chil {
      display: flex;
      flex-wrap: wrap;
      // justify-content : space-between;
      .stencil-img {
        margin: 15px 10px;
        position: relative;
        .shelter {
          width: 220px;
          height: 420px;
          background-color: rgba(0, 0, 0, 0.6);
          margin: auto;
          position: absolute;
          top: 0;
          left: 0;
          text-align: center;
        }
        img {
          width: 220px;
          height: 420px;
        }
        .stencil-text {
          text-align: center;
          line-height: 30px;
        }
      }
    }
  }
}
</style>
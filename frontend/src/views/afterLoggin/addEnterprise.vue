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
          <input type="text" placeholder="请输入企业名称" />
          <div>*请输入真实公司名，确保电子合同或协议，身份真实获取，保障会员权益</div>
        </div>
      </div>
      <div class="inputContent">
        <span>*</span>
        <span class="xg">企业税号:</span>
        <div>
          <input type="text" placeholder="请输入纳税人识别号（唯一社会信用代码）" />
          <div>*请输入真实税号，确保电子合同或协议，身份真实获取，保障会员权益</div>
        </div>
      </div>
      <div class="inputContent">
        <span>*</span>
        <span class="xg">上传营业执照:</span>
        <div class="zhiZhaoBox">
          <div class="zhiZhao">
            <img :src="yyZhizhaoImg" alt="营业执照" style="width:140px;height:183px;" />
          </div>
          <span class="fileinput-button">
            <span>+企业营业执照</span>
            <input
              type="file"
              id="file"
              class="filepath"
              accept="image/jpg, image/jpeg, image/png, image/PNG"
              ref="yyzhizhao"
              @change="changeyyZhizhao($event)"
            />
          </span>
        </div>
      </div>
      <!-- 法人身份证-->
      <div class="inputContent">
        <span class="xg">法人身份证:</span>
        <div class="shenFenZhengBox">
          <div class="shenFenZhengZ">
            <img :src="identityCardZImg" alt="身份证正面照" style="width:162px;height:107px" />
            <br />
            <span class="fileinput-button" style="margin-left:-30px">
              <span>+身份证正面照</span>
              <input
                type="file"
                id="file"
                class="filepath"
                accept="image/jpg, image/jpeg, image/png, image/PNG"
                ref="identityCardZX"
                @change="identityCardZFun($event)"
              />
            </span>
            <div style="margin:10px 0 0 10px">可选项</div>
          </div>
          <div class="shenFenZhengF">
            <img :src="identityCardFImg" alt="身份证反面照" style="width:162px;height:107px"/>
            <br />
            <span class="fileinput-button" style="margin-left:-30px">
              <span>+身份证反面照</span>
              <input
                type="file"
                id="file"
                class="filepath"
                accept="image/jpg, image/jpeg, image/png, image/PNG"
                ref="identityCardFX"
                @change="identityCardFun($event)"
              />
            </span>
          </div>
        </div>
      </div>
      <button class="btn">确定</button>
    </div>
  </div>
</template>
<script>
import logginHeader from "@/components/logginHeader";
export default {
  data() {
    return {
      yyZhizhaoImg: require("../../assets/images/yingyezhizhao.png"),
      identityCardZImg: require("../../assets/images/shengFzz.png"),
      identityCardFImg: require("../../assets/images/shengFzf.png")
    };
  },
  components: {
    logginHeader
  },
  methods: {
    changeyyZhizhao(e) {
      // for(var key in this.$refs){　　//遍历对象的所有属性，包括原型链上的所有属性
      //   if(this.$refs.hasOwnProperty(key)){ //判断是否是对象自身的属性，而不包含继承自原型链上的属性
      //   　　console.log(key);        //键名
      //   　　console.log(this.$refs[key]);   //键值
      // 　}
      // }
      var file = e.target.files[0];
      var reader = new FileReader();
      var that = this;
      reader.readAsDataURL(file);
      reader.onload = function(e) {
        that.yyZhizhaoImg = this.result;
      };
    },
    identityCardZFun(e) {
      var file = e.target.files[0];
      var reader = new FileReader();
      var that = this;
      reader.readAsDataURL(file);
      reader.onload = function(e) {
        that.identityCardZImg = this.result;
      };
    },
    identityCardFun(e) {
      var file = e.target.files[0];
      var reader = new FileReader();
      var that = this;
      reader.readAsDataURL(file);
      reader.onload = function(e) {
        that.identityCardFImg = this.result;
      };
    }
  }
};
</script>
<style lang="scss" scoped>
.boxBottom {
  background: #fff;
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
  // 修改input上传样式
  .fileinput-button {
    position: relative;
    display: inline-block;
    overflow: hidden;
    margin-left: -20px;
  }

  .fileinput-button input {
    position: absolute;
    right: 0px;
    top: 0px;
    /*
    在chrome下input元素中的选择按钮露出来，但是没关系，可以通过后面的设透明的方式把它透明掉。
    但是在IE下确是会把输入框露出来，关键是鼠标移到输入框上时，指针会变成输入状态，这个就很没法处理了。
  通过right的定位方式把输入框移到左边去的方式，可以在IE下回避出现鼠标指针变成输入态的情况。
     */
    opacity: 0;
    -ms-filter: "alpha(opacity=0)";
  }
}
</style>
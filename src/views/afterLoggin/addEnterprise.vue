<template>
  <div>
    <logginHeader>
      <i class="el-icon-edit"></i>
      <span>会员中心</span>
      <span>&gt;</span>
      <span>会员信息</span>
      <span>&gt;</span>
      <span>添加企业信息</span>
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
                    <img src="../../assets/images/yingyezhizhao.png" alt="营业执照">
                </div>
                <span>+企业营业执照</span>
            </div>
      </div>
      <!-- 法人身份证-->
      <div class="inputContent">
            <span class="xg">法人身份证:</span>
            <div class="shenFenZhengBox">
                <div class="shenFenZhengZ">
                    <img src="../../assets/images/shengFzz.png" alt="身份证正面照">
                    <br/>
                    <span>+身份证正面照</span>
                    <div style="margin:10px 0 0 10px">可选项</div>
                </div>
                <div class="shenFenZhengF">
                    <img src="../../assets/images/shengFzf.png" alt="身份证反面照">
                    <br/>
                    <span>+身份证反面照</span>
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
  components: {
    logginHeader
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
    .zhiZhaoBox.zhiZhao{
        width: 139px;
        height: 182px;
        box-sizing: border-box;
    }
    .zhiZhaoBox span{
        display: inline-block;
        color: #a1a1a1;
        padding:10px 0 0 25px ;
    }
    .shenFenZhengBox{
        display: flex;
        div span{
            display: inline-block;
            padding: 10px 0 0 35px ;
            color: #a1a1a1
        }
        .shenFenZhengZ{
            margin-right: 50px;
        }
    }
  }
  .inputContent:nth-of-type(1) {
    margin: 5px 0 0 20px;
  }
  .btn{
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
}
</style>
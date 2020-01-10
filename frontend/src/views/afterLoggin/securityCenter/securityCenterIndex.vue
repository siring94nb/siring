<template>
  <div>
    <logginHeader>
      <i class="iconfont icon-huiyuan"></i>
      <span>会员中心</span>
      <span>&gt;</span>
      <span>安全中心</span>
    </logginHeader>
    <div class="bigBox">
      <div class="aq">
        <el-row :gutter="20">
          <el-col :span="3">
            <img src="../../../assets/images/anquan.png"/>
          </el-col>
          <el-col :span="6">
            <div>您当前的安全等级程度：</div>
          </el-col>
          <el-col :span="9">
            <div>
              <div></div>
            </div>
          </el-col>
          <el-col :span="2">
            <div>中</div>
          </el-col>
        </el-row>
      </div>
      <!-- 绑定手机 -->
      <div class="bindingPhone">
        <el-row :gutter="20">
          <el-col :span="1">
            <i class=" iconfont icon-shouji"></i>
          </el-col>
          <el-col :span="4">
            <div>绑定手机号</div>
          </el-col>
          <el-col :span="15">
            <div>
              当前绑定手机号：
              <span>{{phone.replace(phone.substring(3,7),"****")}}</span>,
              绑定的手机号可以通过短信找回密码，资金交易密码。
            </div>
          </el-col>
          <el-col :span="4">
            <div>
              <i class="iconfont icon-zhengque"></i>
              <span>已设置</span>
              <span>|</span>
              <span><router-link :to="{path:'/safetyTabControl',query:{canshu:'first',title:'信息修改'}}" style="color:lightblue">修改绑定</router-link></span>
            </div>
          </el-col>
        </el-row>
      </div>
      <!-- 设置登录密码 -->
      <div class="bindingPhone">
        <el-row :gutter="20">
          <el-col :span="1">
            <i class=" iconfont icon-mima"></i>
          </el-col>
          <el-col :span="4">
            <div>设置登录密码</div>
          </el-col>
          <el-col :span="15">
            <div>
              网站密码用于用户登录，请妥善保管密码，Siring思锐工作人员不会以任何理由向您索取密码
            </div>
          </el-col>
          <el-col :span="4">
            <div>
              <i class="iconfont icon-zhengque"></i>
              <span>已设置</span>
              <span>|</span>
              <span><router-link :to="{path:'/safetyTabControl',query:{canshu:'second',title:'信息修改'}}" style="color:lightblue">修改密码</router-link></span>
            </div>
          </el-col>
        </el-row>
      </div>
      <!-- 设置资金密码 -->
      <div class="bindingPhone">
        <el-row :gutter="20">
          <el-col :span="1">
            <i class=" iconfont icon-mima"></i>
          </el-col>
          <el-col :span="4">
            <div>设置资金密码</div>
          </el-col>
          <el-col :span="15">
            <div>
              资金密码非常重要，是在资金账户变动时需要输入的密码，要及时设置
            </div>
          </el-col>
          <el-col :span="4" :class="dis?'zanfang1':'zanfang'"> 
            <div>
              <i class="iconfont icon-zhengque"></i>
              <span class="zanfangs">{{dis?"已设置":"未设置"}}</span>
              <span>|</span>
              <span><router-link :to="{path:'/safetyTabControl',query:{canshu:'third',title:'信息修改'}}">设置</router-link></span>
            </div>
          </el-col>
        </el-row>
      </div>
    </div>
  </div>
</template>
<script>
import logginHeader from "@/components/logginHeader";
import {GetBalance} from "@/api/api"
export default {
  data(){
    return{
      phone:sessionStorage.getItem("phone"),
      dis:false//判断是否已设置资金密码
    }
  },
  components: {
    logginHeader
  },
   mounted(){
     this.Balance();
  },
  methods:{
    Balance(){
      const params ={
        uid:sessionStorage.getItem("user_id")
      };
      GetBalance(params).then(res=>{
        let { data, msg, code } = res;
        // this.showMsg(msg, code);
        if (code == 1) {
          console.log(data)
            if(data.pay_password != null){
              console.log(123123)
              this.dis = true;
            }
        }
      })
    }
  }
};
</script>
<style  lang="scss" scoped>
.bigBox{
  background: #ffffff;
  margin:10px 0 0 20px;
  padding: 20px 100px;
  font-size: 18px;
  min-height: 78.5vh;
  .el-row{
      height: 120px;
    }
  .aq{
    border-bottom: 1px dashed rgb(148, 148, 148);
    .el-col:nth-of-type(1){
      text-align:center;
    }
    .el-col:nth-of-type(2){
      color: #333333;
      line-height: 100px;
    }
    .el-col:nth-of-type(3){
      >div:nth-of-type(1){
        border: 1px solid blrgba(215, 215, 215, 1);
        width: 415px;
        height: 25px;
        background: #f2f2f2;
        border-radius: 30px;
        margin-top: 35px;
        div{
          background: red;
          width: 226px;
          height: 25px;
          border-radius: 30px;
        }
      }
    }
    .el-col:nth-of-type(4){
      >div{
        margin-top: 40px;
        color: red;
        margin-left: 100px;
      }
    }
  }
  .bindingPhone{
    // padding: 50px 0;
    line-height: 100px;
    font-size: 13px;
    color: #333333;
    border-bottom: 1px dashed rgb(148, 148, 148);
    i{
      color: #669900;
      margin-right: 5px;
    }
    .el-col:nth-of-type(1){
      i{
        color: #333333;
      }
    }
    .el-col:nth-of-type(4){
      span{
        margin-right: 3px;
        &:nth-of-type(3){
          margin: 0;
        }
      }
      span:nth-of-type(1){
        color: #669900
      }
    }
    .zanfang{
      i,.zanfangs{
        color: red !important;
      }
    }
    .zanfang1{
      i,.zanfangs{
        color: lightblue !important;
      }
    }
  }
}
</style>
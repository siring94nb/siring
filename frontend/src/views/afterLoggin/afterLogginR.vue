<template>
  <div>
    <!-- <Myheader/> -->
    <div class="afLogginBox" style="padding:0">
      <!-- <div class="left" ref="leftBox">
        <faterLoggin />
      </div> -->
      <div class="right" ref="rightBox" style="padding:0">
        <div style="border-bottom:5px solid rgb(242, 247, 250);padding:0 0 10px 5px">
          <p>
            <i class="el-icon-edit"></i>控制中心
            <span>&gt;</span>控制台
          </p>
        </div>

        <div class="account_information">
          <template>
            <div style="width:100%">
              <el-row>
                <el-col :span="18">
                  <div>
                    <el-row>
                      <!-- 最左侧个人头像 -->
                      <el-col :span="4">
                        <img
                          :src="userMessage1.img!==null?userMessage1.img:'http://share.axure.org/gsc/U8YN9Q/60/98/12/609812d8d36b454da0246d5b87ec0482/images/控制台/u5906.png?token=817e8691b12e2626f742d23c8ec618f1'"
                        />
                      </el-col>
                      <!-- 小图标 -->
                      <el-col :span="3">
                        <ul>
                          <li v-for="(item,index) in arr" :key="index">
                            <img
                              src="http://share.axure.org/gsc/U8YN9Q/60/98/12/609812d8d36b454da0246d5b87ec0482/images/控制台/u6035.png?token=c40feff96f64d2209b9b31eea6d0812e"
                              class="hhr"
                            />
                          </li>
                        </ul>
                      </el-col>
                      <!-- 中部账号信息 -->
                      <el-col :span="11" class="middle_message">
                        <el-row>
                          <el-col :span="8" class="mm_left">账号：</el-col>
                          <el-col :span="12" class="mm_right">{{userMessage1.phone}}</el-col>
                        </el-row>
                        <el-row>
                          <el-col :span="8" class="mm_left">{{userMessage1.type===1?"普通会员":userMessage1.type===2?"合伙人":"分包商"}}</el-col>
                          <el-col :span="14" class="mm_right">
                            <span class="upgrade">升级会员获佣金</span>
                          </el-col>
                        </el-row>
                        <el-row>
                          <el-col :span="8" class="mm_left">邀请码：</el-col>
                          <el-col :span="14" class="mm_right invite">
                            <span>{{userMessage1.invitation	}}</span>
                            <span>详细</span>
                          </el-col>
                        </el-row>
                      </el-col>
                      <!-- 安全信息 -->
                      <el-col :span="4" class="aq">
                        <el-row>
                          <el-col :span="24">
                            <el-card :body-style="{ padding: '0px' }" shadow="never">
                              <img
                                style="width:116px;height:116px"
                                src="http://share.axure.org/gsc/U8YN9Q/60/98/12/609812d8d36b454da0246d5b87ec0482/images/控制台/u5924.png?token=a42c73ed8e4c8a85ed322ad02cacb3b3"
                              />
                              <div>
                                <span>安全等级：</span>
                                <span>高</span>
                              </div>
                            </el-card>
                          </el-col>
                        </el-row>
                      </el-col>
                    </el-row>
                  </div>
                </el-col>
                <el-col :span="6" class="mLeft">
                  <div>
                    <el-row>
                      <el-col :span="12">
                        <i class="el-icon-circle-check"></i>
                        <span>余额</span>
                      </el-col>
                      <el-col :span="12">
                        <span>{{userMessage1.money}}</span>
                        <span>元</span>
                        <i class="el-icon-arrow-right"></i>
                      </el-col>
                    </el-row>
                    <el-row>
                      <span>提现</span>
                    </el-row>
                  </div>
                </el-col>
              </el-row>
            </div>
          </template>
        </div>

        <gnmk :pd="false" :SumIndent = "SumIndent">我的订单</gnmk>
        <div class="dinDanCL" style="display: flex; flex:1">
             <ding-dan v-for="(item,index) in arr" :key="index" />
        </div>
        <gnmk :pd="true" :tuiguang="true" :SumIndent = "SumIndent">角色收益</gnmk>
      </div>
    </div>
  </div>
</template>
<script>
import Myheader from "@/components/header";
import faterLoggin from "@/views/afterLoggin/faterLoggin";
import gnmk from "@/components/gnmk";
import dingDan from "@/components/dingDan";
import {GetUserMassage,GetSumIndent} from "@/api/api";
export default {
  name:"afer-logginR",
  data() {
    return {
      userMessage1:{},
      SumIndent:{},
      arr: [1, 2, 3]
    };
  },
  mounted(){
    this.userMessage();
    this.userIndent();
  },
  methods:{
    showMsg(msg, code) {
      this.$message({
        message: msg,
        type: code === 1 ? "success" : "error"
      });
    },
    // 获取用户信息
    userMessage(){
        const userId = sessionStorage.getItem("user_id");
        const params = {
          user_id : userId
        }
        GetUserMassage(params).then(res=>{
          let { data, msg, code } = res;
          // this.showMsg(msg,code);
          if(code === 1 ){
              this.userMessage1 = data;
              // console.log(this.userMessage1);
          }
        })
    },
    //获取订单总数
    userIndent(){
      const userId = sessionStorage.getItem("user_id");
      const params = {
          user_id : userId
      }
      GetSumIndent(params).then(res=>{
        let { data, msg, code } = res;
          // this.showMsg(msg,code);
          if(code === 1 ){
              this.SumIndent = data;
              // console.log(this.SumIndent);
          }
      })
    }
  },
  components: {
    gnmk,
    dingDan
  }
};
</script>
<style lang="scss" scoped>
.afLogginBox {
  background: rgb(242, 247, 250);
  border-top: 2px solid #ffffff; 
  // max-width: 1260px;
  // min-width:1260px;
  height: 1000px;
  .left {
    width: 123px;
    float: left;
  }
  .right {
    // margin-left: 150px;
    padding-left: 10px;
    // margin-top: 100px;
    max-width: 1100px;
    div {
      background: #ffffff;
    }
    div:nth-of-type(1) {
      padding: 10px 10px 0 10px;
      font-size: 18px;
      i {
        margin-right: 10px;
      }
      span:nth-of-type(1) {
        margin: 0 4px;
      }
    }
    .account_information {
      display: flex;
      width: 100%;
      margin-top: 10px;
      border: none;
      img:nth-of-type(1) {
        width: 120px;
        height: 123px;
      }
      .el-row {
        width: 100%;
        padding: 0;
        .el-row {
          ul {
            li {
              margin-bottom: 25px;
            }
          }
        }
        .mm_left {
          font-size: 20px;
          color: #949494;
        }
        .mm_right {
          font-size: 28px;
          .upgrade {
            display: inline-block;
            color: #0766bc;
            font-size: 18px;
            background: rgb(204, 230, 253);
            padding: 10px 20px;
            border-radius: 5px;
          }
        }
        .invite {
          font-size: 20px;
          span:nth-of-type(2) {
            font-size: 14px;
            color: #bcbcbc;
            display: inline-block;
            padding: 6px 12px;
            border: 1px solid #bcbcbc;
            border-radius: 5px;
            margin-left: 20%;
          }
        }
      }
      .middle_message {
        .el-row {
          margin-bottom: 25px;
          &:last-child {
            margin-bottom: 0;
          }
        }
      }
      .el-col {
        padding: 0;
        ul {
          li {
            img {
              width: 30px;
              height: 30px;
              margin-left: 25px;
            }
            .hhr {
              width: 80px;
              height: 23px;
              margin: 0;
            }
          }
        }
      }
    }
  }
  .el-card {
    padding: 0 !important;
    border: 0;
    margin-top: -10px;
    color: #bcbcbc;
    font-size: 16px;
    div {
      padding: 10px 0 0 0 !important;
    }
    span:nth-of-type(2) {
      font-size: 18px;
      color: #669900;
      font-weight: 700;
    }
  }
  .mLeft {
    color: #ff0000;
    font-weight: 400;
    span:nth-of-type(1) {
      font-size: 20px;
    }
    span:nth-of-type(2) {
      font-size: 13px;
    }
    i {
      font-size: 25px;
    }
    .el-row {
      margin-bottom: 50px;
      &:last-child {
        margin-bottom: 0;
      }
    }
    .el-row:nth-of-type(2) span {
      font-size: 18px;
      color: #0889f5;
      // float:right;
      display: inline-block;
      border: 1px solid #0889f5;
      border-radius: 5px;
      padding: 5px 30px;
    }
  }
}
</style>
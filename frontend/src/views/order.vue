<template>
  <div class="box">
    <div class="bottomBox">
      <div class="topHeader">
        <div>
          <span>繁体</span>
          <span>|</span>
          <span>English</span>
        </div>
        <div>
          <el-badge :value="200" :max="99" class="bell">
            <i class="el-icon-bell"></i>
          </el-badge>
          <img :src="require('@/assets/images/u158.png')" alt style="width:22px;height:22px;" />
          <span style="padding-right:10px">{{phone.replace(phone.substring(3,7),"****")}}</span>
          <span>退出</span>
        </div>
      </div>
      <div class="bottomHeader">
        <img :src="require('@/assets/images/logo.png')" width="100" alt />
        <div>
          <span>首页</span>
          <i class="el-icon-s-home"></i>
        </div>
      </div>
      <div class="boxContent">
        <span>订单已提交，请及时支付!</span>
        <div>
          <div>
            <span>支付信息</span>
            <span>（币种：人民币）</span>
          </div>
          <div>
            <span>应付金额：</span>
            <span>￥</span>
            <span>90.00</span>
            <select v-model="selectItem" @change="selectFn($event)">
              <!--选择项的value值默认选择项文本 可动态绑定选择项的value值 更改v-model指令绑定数据-->
              <option>请选择优惠券</option>
              <option v-for="(item,index) in items" :value="item.id" :key="index">{{item.name}}</option>
            </select>
          </div>
          <div>
            <label if="otherCode==''">
              <input type="checkbox" />使用邀请码
              <span>（填写推荐邀请码，优惠30元）</span>
            </label>
          </div>
          <div>
            <input type="text" placeholder="请填写邀请人的会员绑定手机号或邀请码" />
          </div>
          <div>
            <span>选择以下方式支付：</span>
            <span>￥90.00</span>
            <span>（=总价￥90.00-邀请码优惠￥10.00-优惠券￥50.00）</span>
          </div>
          <div>
            <span>支付类型：</span>
            <label v-for="(item, index) in radioData" :key="index">
              <input
                type="radio"
                v-model="radioVal"
                :value="item.value"
                @click="getRadioVal(item.value)"
              />
              {{ item.value }}
            </label>
          </div>
          <div class="smallBox">
            <div class="left">
              <div style="display:flex">
                <span class="bz">*</span>
                <span>支付银行：</span>
                <select v-model="selectItem" @change="selectFn($event)">
                  <!--选择项的value值默认选择项文本 可动态绑定选择项的value值 更改v-model指令绑定数据-->
                  <option v-for="(item,index) in items" :value="item.id" :key="index">{{item.name}}</option>
                </select>
                <div>
                  <span>+</span>
                  <span>银行卡</span>
                </div>
              </div>
              <div>
                <span class="bz">*</span>
                <span>支付时间：</span>
                <el-date-picker v-model="timeValue" type="date" placeholder="选择日期" style="width:268px"></el-date-picker>
              </div>
              <div>
                <span>留言：</span>
                <textarea></textarea>
              </div>
              <div>
                <button>确认</button>
              </div>
            </div>
            <div class="right">
              <div>
                <img
                  :src="require('@/assets/images/u2011.png')"
                  alt
                />
                <div>请选择您转账到平台的一个银行账号（高亮为选中）：</div>
              </div>
              <div></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import {Register,GetUserMassage} from "@/api/api"
export default {
  data() {
    return {
      otherCode:"",//他人邀请码
      phone:sessionStorage.getItem("phone"),
      // 单选框
      radioData: [
        { value: "在线支付" },
        { value: "转账支付" },
        { value: "余额支付" }
      ],
      radioVal: "在线支付",
      // 下拉列表
      selectItem: "请选择优惠券",
      items: [],
      // 时间选择
      timeValue: ""
    };
  },
  components: {},
  mounted() {
    this.GetRegister();
    this.userMessage()
  },
  methods: {
    // 下拉列表测试
    selectFn(e) {
      console.log(e);
      console.log(e.target.selectedIndex); // 选择项的index索引
      console.log(e.target.value); // 选择项的value
    }
    ,
    // 获取优惠券信息
    GetRegister(){
      const params = {
        status : 1 
      }
      Register(params).then(res => {
        let {data,code,msg} = res;
        console.log(res)
        if(code == 1) {
          this.items = data;
        }
      })
    },
    // 获取用户信息
    userMessage() {
      const userId = sessionStorage.getItem("user_id");
      const params = {
        user_id: userId
      };
      GetUserMassage(params).then(res => {
        let { data, msg, code } = res;
        // this.showMsg(msg, code);
        console.log(data)
        if (code === 1) {
          this.otherCode=data.other_code//他人邀请码
        }
      });
    },
  }
};
</script>
<style lang="scss" scoped>
.box{min-width: 1180px;}
// .boxBottom {
.topHeader {
  background: #000000;
  color: #ffffff;
  font-size: 18px;
  width: 100%;
  height: 30px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 3px 50px;
  box-sizing: border-box;
  margin-bottom: 10px;
  i {
    font-size: 20px;
  }
  img {
    width: 22px;
    height: 22px;
    margin: 0 10px 0 30px;
  }
}
.bottomHeader {
  display: flex;
  justify-content: space-between;
  padding: 0 50px;
  img {
    width: 115px;
    height: 47px;
  }
  > div {
    span {
      font-size: 16px;
    }
    i {
      font-size: 32px;
      color: rgb(138, 138, 138);
    }
  }
}
.boxContent {
  // display: flex;
  // flex-direction:column;
  // justify-content: center;
  margin-top: 20px;
  width: 70%;
  margin: 0 15%;
  > span {
    font-size: 33px;
    display: block;
    text-align: center;
    margin-bottom: 10px;
  }
  > div {
    border: 1px solid rgb(118, 118, 118);
    text-align: center;
    // padding: 30px;
    > div {
      &:nth-of-type(1) {
        margin-top: 30px;
        margin-bottom: 40px;
        > span {
          color: #aeaeae;
          &:nth-of-type(1) {
            font-size: 24px;
            color: #000000;
            padding: 0 20px 0 0;
          }
          &:nth-of-type(2) {
            font-size: 16px;
          }
        }
      }
      &:nth-of-type(2) {
        font-size: 23px;
        color: #000000;
        margin-bottom: 10px;
        > span {
          &:nth-of-type(1) {
            font-size: 16px;
            margin-left: 400px;
          }
          &:nth-of-type(3) {
            color: #ff0000;
            margin-right: 300px;
          }
        }
        >select{
          width: 195px;
          height: 28px;
        }
      }
      &:nth-of-type(3){
        label{
          font-size: 13px;
          color: #515151;
          span{
            color: #a1a1a1;
            font-size: 12px;
          }
        }
      }
      &:nth-of-type(4){
        margin: 10px 0;
        input{
           width:  331px;
          height: 31px;
        }
      }
      &:nth-of-type(5){
        padding: 20px 0;
        background: #f2f2f2;
        font-size: 18px;
        color: #ff0000;
        span{
          &:nth-of-type(1){
            color: #333333;
          }
          &:nth-of-type(2){
            font-size: 28px;
            padding: 0 10px;
          }
        }
      }
      &:nth-of-type(6){
        display: flex;
        justify-content: space-around;
        padding: 20px 0;
        border-bottom: 2px solid #cccccc;
        margin-bottom: 20px;
      }
    }
    .smallBox {
      width: 82%;
      margin: 0 9%;
      font-size: 13px;
      display: flex;
      height: 45vh;
      .bz{
        color: #ff0000;
      }
      .left{
        border-right: 1px solid #cccccc;
        padding-right: 10px;
        >div{
          &:nth-of-type(1){
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            select{
              width: 266px;
              height: 35px;
              color: #666666;
            }
            >div{
              border: 1px solid #ff0000;
              color: #ff0000;
              padding: 10px 5px;
              border-radius: 3px;
              margin-left: 15px;
            }
          }
          &:nth-of-type(2){
            text-align: left;
            margin-bottom: 15px;
          }
          &:nth-of-type(3){
            text-align: left;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            span{
              display: inline-block;
              text-align: right;
              width: 70px;
            }
            textarea{
              width: 268px;
              height: 95px;
              box-sizing: border-box;
            }
          }
          &:nth-of-type(4){
            button{
              background: #e62d31;
              border-radius: 3px;
              border: 1px solid #ff0000;
              width: 268px;
              height: 43px;
            }
          }
        }
      }
      .right{
        >div{
          &:nth-of-type(1){
            display: flex;
            img{
              width: 36px;
              height: 36px;
            }
            >div{
              display: flex;
              align-items: center;
              font-size: 14px;
              color: #ff0000;
            }
          }
        }
      }
    }
  }
}

// }
</style>
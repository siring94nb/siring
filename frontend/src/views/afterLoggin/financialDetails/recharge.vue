<template>
  <div>
    <logginHeader>
      <i class="iconfont icon--zijinguanli"></i>
      <span>资金管理</span>
      <span>&gt;</span>
      <span>充值</span>
    </logginHeader>
    <div class="bottomBox">
      <div class="ac active" @click.stop="guangfang('10000','1')">
        <div>10000元</div>
        <div>送开发优惠券50元</div>
      </div>
      <div class="ac" @click.stop="guangfang('20000','2')">
        <div>20000元</div>
        <div>送开发优惠券120元</div>
      </div>
      <div class="ac" @click.stop="guangfang('30000','3')">
        <div>30000元</div>
        <div>送开发优惠券200元</div>
      </div>
      <div class="ac" @click.stop="guangfang('40000','4')">
        <div>40000元</div>
        <div>送开发优惠券260元</div>
      </div>
      <div class="ac" @click.stop="guangfang('50000','5')">
        <div>50000元</div>
        <div>送开发优惠券330元</div>
      </div>
      <div class="ac" @click.stop="guangfang('60000','6')">
        <div>60000元</div>
        <div>送开发优惠券40元</div>
      </div>
    </div>
    <div class="zhedie">
      <!-- v-model="activeName" 绑定为默认展开，数值是什么对应展开同一个name的面板-->
      <el-collapse accordion>
        <el-collapse-item title="我要充值其他金额" name="1" style="color:red !important;">
          <div class="shuru">
            <input type="number" placeholder="请输入您要充值的金额" ref="shuruJe" />
            <button @click.stop="affirm">确定金额</button>
          </div>
          <div class="beizhu">注：不能少于1000元，且无赠送</div>
        </el-collapse-item>
      </el-collapse>
    </div>
    <div class="feiyongSum">
      <div>
        <div>
          <span>充值费：</span>
          <div>
            <div>￥{{chognzhi}}</div>
            <div>
              <span>*</span>
              <span>充值费用</span>
            </div>
          </div>
          <div>x</div>
          <div>
            <div>{{discount}}</div>
            <div>
              <span>*</span>
              <span>会员折扣</span>
              <router-link to>
                <i class="el-icon-question"></i>
              </router-link>
            </div>
          </div>
          <div>=</div>
          <div>￥{{sum}}</div>
          <div>
            <button class="zhifu" @click="getRecharge">立即支付</button>
          </div>
        </div>
        <div>
          <label>
            <input type="radio" value="  本人已确认，支付后执行下一流程" checked />
            本人已确认，支付后执行下一流程
          </label>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import logginHeader from "@/components/logginHeader";
import {Recharge} from "@/api/api"
export default {
  data() {
    return {
      activeName: "1", //折叠面板默认打开数值
      chognzhi: "1000", //充值费用
      discount: "100%", //会员折扣
      sum: "" //充值费用*会员折扣（若是会员的话） 
    };
  },
  components: {
    logginHeader
  },
  mounted() {
    this.sumNum();
  },
  methods: {
    // 官方充值金额选择
    guangfang(src, num) {
      let aDiv = document.getElementsByClassName("ac");
      for(let i=0;i<aDiv.length;i++){
        if(i!=num-1){
          aDiv[i].classList.remove("active");
        }else{
          aDiv[num-1].classList.add("active");
        }
      }
      this.chognzhi = src;
      this.sumNum();
    },
    // 自定义充值金额
    affirm() {
      let num = this.$refs.shuruJe.value;
      if (num > 1000 || num == 1000) {
        this.chognzhi = num;
        this.sumNum();
      } else {
        alert("充值金额需要至少1000元");
      }
      // console.log(this.$refs.shuruJe.value);
    },
    // 最终需要支付的金额
    sumNum() {
      this.sum = (this.chognzhi * this.discount.replace("%", "")) / 100;
      //  console.log(this.chognzhi)
    },
    // 下单，获取订单号
    getRecharge(){
      const params = {
        type:1,
        price:this.sum
      }
      Recharge(params).then(res=>{
        let {data,code} = res;
        if(code == 1){
          console.log(data);
          this.$router.push({
                name: "comboPay",
                params: {
                  type:1,
                  id: data,
                  order_amount:this.sum,
                  user_id: sessionStorage.getItem("user_id"),
                  order_type: 1
                }
              });
        }
      })
    }
  }
};
</script>
<style lang="scss" scoped>
.bottomBox {
  background: #ffffff;
  padding: 20px 0 0 60px;
  margin: 10px 0 0 20px;
  display: flex;
  flex-wrap: wrap;
  .active {
    border: 2px solid rgb(0, 187, 255);
    color: rgb(0, 187, 255);
    > div:nth-last-child(1) {
      color: #ff0000;
    }
  }
  .ac{
    cursor: pointer;
  }
  > div {
    color: #d7d7d7;
    border: 2px solid rgb(228, 228, 228);
    border-radius: 5px;
    width: 300px;
    height: 171px;
    text-align: center;
    margin-right: 30px;
    margin-bottom: 20px;
    &:nth-last-child(1) {
      margin: 0;
    }
    > div {
      &:nth-of-type(1) {
        font-size: 36px;
        // margin-bottom: 15px;
        margin: 50px 0 15px 0;
      }
      &:nth-of-type(2) {
        font-size: 20px;
      }
    }
  }
}
.zhedie {
  background: #ffffff;
  padding: 20px 0 0 60px;
  margin: 0 0 0 20px;
  .shuru {
    input {
      padding: 15px 5px;
      margin-right: 20px;
    }
    button {
      padding: 15px 20px;
      background: #00bfff;
      border: 1px solid #00bfff;
      color: #ffffff;
      border-radius: 5px;
      cursor: pointer;
      outline: none;
    }
  }
  .beizhu {
    color: #ff0000;
    font-size: 16px;
    margin-top: 10px;
  }
}
.feiyongSum {
  width: 100%;
  position: fixed;
  bottom: 0;
  left: 5px;
  background: rgba(204, 235, 248, 1);
  padding: 10px;
  display: flex;
  justify-content: flex-end;
  z-index: 100;
  > div {
    margin-right: 100px;
    > div {
      display: flex;
      font-size: 18px;
      &:nth-of-type(1) {
        margin-bottom: 10px;
      }
      &:nth-of-type(2) {
        font-size: 13px;
        color: #333333;
      }
      > span {
        &:nth-of-type(1) {
          padding-right: 15px;
        }
      }
      > div {
        &:nth-of-type(1) {
          div {
            &:nth-of-type(1) {
              background: #ffffff;
              color: #ff0000;
              padding: 2px 20px;
              margin-right: 10px;
            }
            &:nth-of-type(2) {
              text-align: center;
              margin-top: 5px;
              > span {
                &:nth-of-type(1) {
                  color: #ff0000;
                }
                &:nth-of-type(2) {
                  color: #949494;
                  font-size: 13px;
                }
              }
            }
          }
        }
        &:nth-of-type(2) {
          margin-right: 10px;
        }
        &:nth-of-type(3) {
          margin-right: 10px;
          div {
            &:nth-of-type(1) {
              background: #ffffff;
              color: #ff0000;
              padding: 2px 20px;
              margin-right: 10px;
            }
            &:nth-of-type(2) {
              text-align: center;
              margin-top: 5px;
              > span {
                &:nth-of-type(1) {
                  color: #ff0000;
                }
                &:nth-of-type(2) {
                  color: #949494;
                  font-size: 13px;
                  padding-right: 5px;
                }
              }
              a i {
                color: rgb(230, 45, 49);
              }
            }
          }
        }
        &:nth-of-type(4) {
          margin-right: 10px;
        }
        &:nth-of-type(5) {
          background: #ffffff;
          box-sizing: border-box;
          padding: 15px 10px;
          color: #ff0000;
          margin-right: 15px;
        }
        &:nth-of-type(6) {
          button {
            background: rgb(230, 45, 49);
            border: 1px solid #ff0000;
            color: #ffffff;
            padding: 15px 20px;
            border-radius: 5px;
            outline: none;
          }
        }
      }
    }
  }
  .zhifu{
    a{
      color: #ffffff;
    }
  }
}
</style>
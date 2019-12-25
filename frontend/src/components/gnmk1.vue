<template>
  <div class="gnmkBox">
    <div style="background: rgb(242,247,250);padding:5px">
      <div class="gnmkSmBox1">
        <span>
          <slot></slot>
        </span>
        <el-date-picker v-model="year" type="year" placeholder="2019"></el-date-picker>
      </div>
      <div class="gnmkSmBox2">
        <el-row>
          <el-col :span="6" v-for="(item,index) in SumIndent1" :key="index">
            <img :src="require('../assets/images/'+item.num+'.png')" />
            <div>
              <div>
                <span>{{item.name}}</span>
              </div>
              <div>{{item.biaozhi}}</div>
              <!-- <div v-if="index==3">点击推广</div> -->
            </div>
          </el-col>
        </el-row>
      </div>
    </div>
  </div>
</template>
<script>
import { GetSumIndent } from "@/api/api";
export default {
  name: "gnmk1",
  data() {
    // 这个位置会有问题，貌似没有这个接口，所以数据是我的订单的，不是角色收益的东西
    return {
      year: "",
      SumIndent1: [
        {
          "num": 9,
          "name": "合伙人酬金",
          "biaozhi": "total_customized"
        },
        {
          "num": 6,
          "name": "会员酬金",
          "biaozhi": "total_xcx"
        },
        {
          "num": 7,
          "name": "分包酬金",
          "biaozhi": "total_promotion"
        },
        {
          "num": 8,
          "name": "推广人数",
          "biaozhi": "total_investment"
        }
      ]
    };
  },
  mounted() {
    this.userIndent();
  },
  methods: {
    //获取订单总数
    userIndent() {
      const userId = sessionStorage.getItem("user_id");
      const params = {
        user_id: userId
      };
      GetSumIndent(params).then(res => {
        let { data, msg, code } = res;
        // this.showMsg(msg,code);
        if (code === 1) {
          const newArr = this.SumIndent1.map(item => {
            item.biaozhi = data[item.biaozhi];
            return item;
          });
          this.SumIndent1 = newArr;
        }
      });
    }
  }
};
</script>
<style lang="scss" scoped>
.gnmkBox {
  width: 100%;
  background: #ffffff;
  padding: 10px 20px;
  margin-top: 5px;
  box-sizing: border-box;
  font-family: "微软雅黑 Bold", "微软雅黑 Regular", "微软雅黑";
  .gnmkSmBox1 {
    padding: 10px 15px;
    font-weight: 700;
    font-style: normal;
    color: #000000;
    text-align: left;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .gnmkSmBox2 {
    background: rgb(242, 247, 250);
    // background: #ffffff;
    .el-row {
      background: rgb(242, 247, 250);
      height: 150px;
    }
    .el-col {
      background: #ffffff;
      // margin:0 5px;
      box-sizing: border-box;
      display: flex;
      padding: 20px 10px;
      border-right: 5px solid rgb(242, 247, 250);
      img {
        margin-right: 20px;
      }
      div {
        font-size: 16px;
        color: #999999;
        div:nth-of-type(2) {
          font-size: 20px;
          color: #666666;
        }
        div:nth-of-type(3) {
          margin-top: 10px;
          color: #ff0000;
        }
      }
      div:first-child {
        padding: 20px 0;
        box-sizing: border-box;
      }
    }
    .el-col:nth-of-type(2n) {
      margin: 0;
    }
  }
}
</style>
<template>
  <div>
    <Myheader />
    <div class="box" ref="box">
      <div class="topBox">
        <div style="margin-right:30px; width: 100px; padding:10px 0px; ">行业领域：</div>
        <div style="flexGrow: 1">
          <span class="active">全部</span>
          <span v-for="(item,index) in IndustryField" :key="index+1" :id="item.id">{{item.title}}</span>
          <span style="float: right;">更多&gt;&gt;</span>
        </div>
      </div>
      <div class="shaixuanBox">
        <button>全部排序</button>
        <div>
          <el-select v-model="value" placeholder="请选择" style="width:120px; margin-right:30px;">
            <el-option
              v-for="item in options"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            ></el-option>
          </el-select>
        </div>
        <div class="searchBox">
          <el-input v-model="suoyin" placeholder="请输入名称" prefix-icon="el-icon-search"></el-input>
          <el-button style="background:#ff0000;color:#ffffff">搜索</el-button>
        </div>
        <div class="iBox">
          <i class="el-icon-s-promotion"></i>
          <div>
            创业者发布
            <br />Entrepreneur
          </div>
        </div>
        <div class="guanzhu">
          <i class="iconfont icon-guanzhu Idefault" v-if="false"></i>
          <i class="iconfont icon-guanzhu1 iActive"></i>
          <span>我的关注</span>
        </div>
      </div>
      <div>
        <el-table :data="tableData" style="width: 100%">
          <el-table-column prop="date" label="邀请码" width="200" align="center"></el-table-column>
          <el-table-column prop="name" label="项目名称" width="200" align="center"></el-table-column>
          <el-table-column prop="address" label="行业领域" width="200" align="center"></el-table-column>
          <el-table-column prop="ceshi" label="项目亮点" width="400" align="center"></el-table-column>
          <el-table-column prop="deshi" label="操作" align="center">
            <template  slot-scope="scope">
              <div class="caozuoBox">
                <div><router-link to="/newInvestment" style="color:black">{{scope.row.deshi}}</router-link></div>
                <div class="guanzhu">
                  <i class="iconfont icon-guanzhu Idefault" v-if="false"></i>
                  <i class="iconfont icon-guanzhu1 iActive"></i>
                </div>
              </div>
            </template>
          </el-table-column>
        </el-table>
      </div>
    </div>  
  </div>
</template>
<script>
import Myheader from "@/components/header";
import { industryField } from "@/api/api";
export default {
  data() {
    return {
      IndustryField: [], //添加投融，行业领域数据
      options: [
        {
          value: "1",
          label: "按打赏数量"
        },
        {
          value: "2",
          label: "双皮奶"
        },
        {
          value: "3",
          label: "蚵仔煎"
        },
        {
          value: "4",
          label: "龙须面"
        },
        {
          value: "5",
          label: "北京烤鸭"
        }
      ],
      value: "1",
      suoyin: "",
      // 表格
      tableData: [
        {
          date: "MU3838",
          name: "物联网摇摇车",
          address: "医疗健康",
          ceshi:"非常好的项目",
          deshi:"我要投资"
        },
        {
          date: "MU3838",
          name: "物联网摇摇车",
          address: "医疗健康",
          ceshi:"非常好的项目",
          deshi:"我要投资"
        },
        {
          date: "MU3838",
          name: "物联网摇摇车",
          address: "医疗健康",
          ceshi:"非常好的项目",
          deshi:"我要融资"
        },
        {
          date: "MU3838",
          name: "物联网摇摇车",
          address: "医疗健康",
          ceshi:"非常好的项目",
          deshi:"我要融资"
        },
        {
          date: "MU3838",
          name: "物联网摇摇车",
          address: "医疗健康",
          ceshi:"非常好的项目",
          deshi:"我要融资"
        },
      ]
    };
  },
  components: {
    Myheader,
  },
  mounted() {
    this.getIndustryField();
    this.changeSize();
  },
  methods: {
    getIndustryField() {
      industryField().then(res => {
        let { data, msg } = res;
        if (data.code == 1) {
          this.IndustryField = data.data;
        }
      });
    },
    // 控制屏幕过大，两侧留白
    changeSize() {
      return (() => {
        let screenWidth = document.body.clientWidth;
        let Box = this.$refs.box;
        if (screenWidth > 1260) {
          Box.style.marginLeft = (screenWidth - Box.clientWidth) / 2 + "px";
        } else {
          Box.style.marginLeft = "0px";
        }
      })();
    }
  }
};
</script>
<style lang="scss" scoped>
.box {
  background: rgb(246, 246, 246);
  margin-top: 110px;
  max-width: 1260px;
  .topBox {
    display: flex;
    background: #ffffff;
    font-size: 13px;
    span {
      font-size: 13px;
      display: inline-block;
      padding: 10px 12px;
      margin-bottom: 20px;
      width: 92px;
      text-align: left;
    }
    .active {
      background-image: url("../../../assets/images/u773.png");
      background-repeat: no-repeat;
      color: #ff0000;
    }
  }
  // 头部筛选
  .shaixuanBox {
    position: relative;
    display: flex;
    background: #ffffff;
    padding-left: 135px;
    .searchBox {
      display: flex;
    }
    > button {
      background: #ff0000;
      border: 1px solid #ff0000;
      color: #ffffff;
      width: 90px;
      height: 40px;
      margin-right: 150px;
    }
    .iBox {
      display: flex;
      font-size: 14px;
      align-items: center;
      padding-left: 20px;
      i {
        font-size: 32px;
        color: rgb(91, 156, 254);
      }
    }
    .guanzhu {
      display: flex;
      align-items: center;
      margin-left: 200px;
    }
  }
  .Idefault {
    background: white;
    color: #cccccc;
    font-size: 26px;
  }
  .iActive {
    color: rgb(244, 234, 42);
    font-size: 20px;
  }
  .caozuoBox{
    display: flex;
    justify-content: space-around;
    align-items: center;
    padding: 0 50px;
    >div{
      &:nth-of-type(1){
        padding: 10px 20px;
        border: 1px solid #ff0000;
        border-radius: 5px;
      }
    }
  }
}
</style>
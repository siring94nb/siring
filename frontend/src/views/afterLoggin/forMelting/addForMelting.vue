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
      <div>
        <button>全部排序</button>
        <div>
          <el-select v-model="value" placeholder="请选择">
            <el-option
              v-for="item in options"
              :key="item.value"
              :label="item.label"
              :value="item.value">
            </el-option>
          </el-select>
        </div>
        <div>
          <el-input v-model="suoyin" placeholder="请输入名称"
            prefix-icon="el-icon-search"></el-input>
            <div>搜索</div>
        </div>
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
      options: [{
          value: '1',
          label: '按打赏数量'
        }, {
          value: '2',
          label: '双皮奶'
        }, {
          value: '3',
          label: '蚵仔煎'
        }, {
          value: '4',
          label: '龙须面'
        }, {
          value: '5',
          label: '北京烤鸭'
        }],
        value: '1',
        suoyin:"",
    };
  },
  components: {
    Myheader
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
          console.log(12123123)
          console.log(Box.clientWidth)
          Box.style.marginLeft =
            (screenWidth - Box.clientWidth) / 2 + "px";
        } else {
          console.log(321321321)
          Box.style.marginLeft = "0px";
        }
      })();
    }
  }
};
</script>
<style lang="scss" scoped>
.box {
  background: rgb(246,246,246);
  margin-top: 110px;
  max-width: 1260px;
  .topBox {
    display: flex;
    background: #ffffff;
    font-size: 13px;
    span{
      font-size: 13px;
      display: inline-block;
      padding:10px 12px; 
      margin-bottom: 20px;
      width: 92px;
      text-align: left;
    }
    .active{
      background-image:url("../../../assets/images/u773.png") ;
      background-repeat: no-repeat;
      color: #ff0000;
    }
  }
}
</style>
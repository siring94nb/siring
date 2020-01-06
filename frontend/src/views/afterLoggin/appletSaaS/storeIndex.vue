<template>
  <div>
    <div class="bigBox">
      <logginHeader>
        <i class="iconfont icon-SaaS"></i>
        <span>小程序SaaS</span>
        <span>&gt;</span>
        <span>小程序管理</span>
      </logginHeader>
      <div class="bottomBox">
        <div class="topbox">
          <div>
            <router-link to="/programSaaS" class="addStore">
              <i class="el-icon-plus"></i>
              <span>添加新店铺</span>
            </router-link>
          </div>
          <div class="fuwuBox">
            <router-link to="appreciationIndex">增值服务</router-link>
            <router-link to>登录店铺</router-link>
          </div>
        </div>
        <!-- 表格开始 -->
        <div>
          <!-- 索引框 -->
          <div class="searchBox">
            <div>
              <span>搜索:</span>
              <el-input v-model="nameId" placeholder="订单编号/用户名/用户账号/模板"></el-input>
            </div>
            <div>
              <span>到账情况：</span>
              <el-select v-model="selectItem" @change="selectFn($event)">
                <!--选择项的value值默认选择项文本 可动态绑定选择项的value值 更改v-model指令绑定数据-->
                <el-option v-for="(item,index) in items" :key="index" :value="item.id">{{item.name}}</el-option>
              </el-select>
            </div>
            <div>
              <span>时间范围：</span>
              <el-date-picker
                v-model="timeValue"
                type="daterange"
                range-separator="至"
                start-placeholder="开始日期"
                end-placeholder="结束日期"
              ></el-date-picker>
            </div>
            <div>
              <el-button type="primary" icon="el-icon-search">搜索</el-button>
            </div>
          </div>
          <!-- 分页表格 -->
          <div class="tabBox">
            <div class="xuanxiangBox">
              <span style="background:rgb(140,218,255)">全部</span>
              <span style="background:rgb(204,51,102)">待付款</span>
              <span style="background:rgb(204,0,204)">待开通</span>
              <span style="background:rgb(102,153,0)">已完成</span>
              <span style="background:rgb(161,161,161)">已关闭</span>
            </div>
            <div>
              <el-table
                ref="multipleTable"
                :data="list.slice((currpage-1)*pagesize,currpage*pagesize)"
                tooltip-effect="dark"
                border
                style="width: 98.3%"
                :header-cell-style="{background:'rgb(249,250,252)',color:'#666666',fontWeight: '700'}"
              >
                <el-table-column type="selection" width="40" align="center"></el-table-column>
                <el-table-column prop="name" label="订单编号" width="160" align="center"></el-table-column>
                <el-table-column prop="name" label="行业模板" width="120" align="center"></el-table-column>
                <el-table-column prop="name" label="模板套餐" width="120" align="center"></el-table-column>
                <el-table-column prop="name" label="订单金额" width="90" align="center"></el-table-column>
                <el-table-column prop="name" label="付款方式" width="80" align="center"></el-table-column>
                <el-table-column prop="name" label="账号" width="220" align="center"></el-table-column>
                <el-table-column prop="name" label="下单时间" width="200" align="center"></el-table-column>
                <el-table-column prop="name" label="套餐到期时间" width="200" align="center"></el-table-column>
                <el-table-column prop="name" label="操作" width="165" align="center">
                  <template slot-scope="scope">
                    <span v-if="false">{{scope.row.name}}</span>
                    <span class="default" style="background:rgb(140,218,255)" v-if="false">全部</span>
                    <span class="default"  style="background:rgb(204,51,102)" v-if="false">待付款</span>
                    <span class="default"  style="background:rgb(204,0,204)" v-if="false">待开通</span>
                    <span class="default"  style="background:rgb(102,153,0)" v-if="false">已完成</span>
                    <span class="default"  style="background:rgb(161,161,161)">已关闭</span>
                  </template>
                </el-table-column>
              </el-table>
              <div style="text-align: center;margin-top: 30px;" class="sjTiShiBox">
                <div>
                  <el-checkbox v-model="checked">全选</el-checkbox>
                </div>
                <div class="btnBox">
                    <button>关闭订单</button>
                    <button>删除订单</button>
                  </div>
                <div>
                  <el-pagination
                    @current-change="handleCurrentChange"
                    :current-page="DirectlyTo"
                    :page-sizes="[pagesize]"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total="list.length"
                  ></el-pagination>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import logginHeader from "@/components/logginHeader";
export default {
  data() {
    return {
      // 用户名，编号
      nameId: "",
      // 到账情况select
      selectItem: "全部",
      items: [
        { id: 1, name: "全部" },
        { id: 2, name: "汇款待审核" },
        { id: 3, name: "汇款未到账" },
        { id: 4, name: "汇款已到账" },
        { id: 5, name: "线上已到账" }
      ],
      // 时间范围，返回值会是一个数组，两个值，初始时间与结束时间，获取通过.getTime()转时间戳
      timeValue: "",
      list: [{ name: 123123 }], //分页表格数据
      pagesize: 10,
      currpage: 1,
      DirectlyTo: 1,
      checked: false //全选
    };
  },
  mounted() {},
  methods: {
    // 分页表格切换
    handleCurrentChange(cpage) {
      this.currpage = cpage;
    }
  },
  components: {
    logginHeader
  }
};
</script>
<style lang="scss" scoped>
.bottomBox {
  font-family: "Arial Normal", "Arial";
  background: #ffffff;
  margin-left: 20px;
  margin-top: 10px;
  padding: 20px;
  .topbox {
    display: flex;
    justify-content: space-between;
    //  padding: 10px 15px;
    margin-bottom: 20px;
  }
  .addStore {
    color: #00cccc;
    border: 2px dashed #00cccc;
    padding: 10px 15px;
    border-radius: 3px;
    i {
      font-size: 18px;
      font-weight: 1000;
      padding-right: 10px;
    }
  }
  .fuwuBox {
    a {
      color: #ffffff;
      font-size: 13px;
      padding: 15px 50px;
      &:nth-of-type(1) {
        background: #ff9900;
        border-radius: 3px;
        margin-right: 15px;
      }
      &:nth-of-type(2) {
        background: #00cccc;
        border-radius: 3px;
      }
    }
  }
  .searchBox {
    display: flex;
    background: rgb(243, 243, 243);
    padding: 15px 20px;
    font-size: 13px;
    color: #666666;
    border-left: 4px solid rgb(0, 149, 138);
    > div {
      display: flex;
      margin-right: 30px;
      align-items: center;
      &:nth-of-type(1) {
        span {
          width: 50px;
        }
      }
    }
  }
  .tabBox {
    background: #ffffff;
    padding-top: 20px;
    // 分页表格上选项
    .xuanxiangBox {
      padding-bottom: 20px;
      span {
        padding: 5px 15px;
        color: #ffffff;
        font-size: 13px;
        margin-right: 10px;
      }
    }
    .default{
      padding: 5px 15px;
      color: #ffffff;
      font-size: 13px;
    }
    .sjTiShiBox{
      display: flex;
      align-items: center;
    }
    .btnBox{
      margin: 0 20px;
      button{
        padding: 5px 10px ;
        border-radius: 3px;
        background: #ffffff;
        border: 1px solid #DCDFE6;
        color: #333333;
        &:nth-of-type(1){
          margin-right: 10px;
        }
      }
    }
  }
}
</style>
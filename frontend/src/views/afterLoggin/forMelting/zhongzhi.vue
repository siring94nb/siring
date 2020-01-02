<template>
  <div class="bigBox">
    <div class="topBox">
      <div>
        <span>请搜索：</span>
        <el-input v-model="suoyin" placeholder="请输入索引"></el-input>
      </div>
      <div>
        <span>投融类型：</span>
        <el-select value>
          <option value></option>
        </el-select>
      </div>
      <div>
        <el-input placeholder="请输入索引" suffix-icon="el-icon-search" v-model="suoyin2"></el-input>
      </div>
    </div>
    <div class="tabBox">
      <el-table
        ref="multipleTable"
          :data="tableData.slice((currentPage-1)*pagesize,currentPage*pagesize)"
          tooltip-effect="dark"
          style="width: 100%;font-size:13px;"
          border
         :header-cell-style="hStyle"
      >
        <el-table-column type="selection" width="55" align="center"></el-table-column>
        <el-table-column prop="name" label="序列号" width="120" align="center"></el-table-column>
        <el-table-column prop="name" label="订单类型" width="160" align="center"></el-table-column>
        <el-table-column prop="name" label="项目名称" width="200" align="center"></el-table-column>
        <el-table-column prop="name" label="行业领域" width="200" align="center"></el-table-column>
        <el-table-column prop="name" label="项目亮点" width="280" align="center"></el-table-column>
        <el-table-column prop="name" label="操作" align="center">
          <template>
            <div style="display:flex;justify-content: center">
              <div v-if="true" class="moren default">通过预览</div>
              <div v-if="true" class="moren danger">彻底删除</div>
              <div v-if="true" class="moren default">我要恢复</div>
              <div v-if="false" class="moren defeated">审核不通过</div>
              <div v-if="false" class="moren default">预览</div>
            </div>
          </template>
        </el-table-column>
      </el-table>
      <div class="pagingTabBottom">
          <el-checkbox label="全选" style="margin:0 15px 0 5px;">全选</el-checkbox>
          <el-select v-model="selectValue1" placeholder="请选择" style="width:120px;margin-right:15px;">
            <el-option
              v-for="item in options1"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            ></el-option>
          </el-select>
          <el-button type="button" style="margin-right:15px;">确定</el-button>
           <el-pagination
            background
              @current-change="current_change"
              :page-sizes="[10]"
              :page-size="pagesize"
              layout="total, sizes, prev, pager, next, jumper"
              :total="total">
            </el-pagination>
        </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      hStyle:{background:"rgb(249,250,252)",fontSize:"14px",color:"#666666",fontWeight: "700"},
      suoyin: "",
      suoyin2: "",
      tableData: [
        { name: 123123123 },
        { name: 123123123 },
        { name: 123123123 },
        { name: 123123123 },
        { name: 123123123 },
        { name: 123123123 },
        { name: 123123123 },
        { name: 123123123 },
        { name: 123123123 },
        { name: 123123123 }
      ],
      total: 6,
      pagesize: 10,
      currentPage: 1,
      options1: [
        {
          value: "商品上架",
          label: "商品上架"
        },
        {
          value: "商品下架",
          label: "商品下架"
        },
        {
          value: "移入回收站",
          label: "移入回收站"
        }
      ],
      selectValue1: "商品上架",
    };
  },
  methods: {
    current_change: function(currentPage) {
      this.currentPage = currentPage;
    }
  }
};
</script>
<style lang="scss" scoped>
.bigBox {
  background: #ffffff;
  padding: 10px 20px;
  .topBox {
    display: flex;
    align-items: center;
    padding: 10px 15px;
    margin-bottom: 15px;
    font-size: 13px;
    color: #666666;
    border-left: 4px solid #ff0000;
    background: rgb(243,243,243);
    > div {
      display: flex;
      align-items: center;
      &:nth-of-type(1) {
        width: 30%;
        span {
          width: 70px;
        }
        margin-right: 50px;
      }
      &:nth-of-type(2) {
        margin-right: 300px;
        span{
          width: 100px;
        }
      }
      &:nth-of-type(3) {
        width: 26%;
      }
    }
  }
  .tabBox{
    .moren{
      padding: 5px 12px;
      border-radius: 5px;
      margin-right: 20px;
    }
    .default {
      
      background: rgb(102,153,0);
      color: #ffffff;
    }
    .danger{
      background: rgb(255,0,0);
      color: #ffffff;
    }
    .defeated{
      background: rgb(161,161,161);
      color: #ffffff;
    }
  }
  .pagingTabBottom {
    display: flex;
    align-items: center;
    border: 1px solid rgb(235, 238, 245);
    padding: 15px;
    margin-top: 20px;
  }
}
</style>
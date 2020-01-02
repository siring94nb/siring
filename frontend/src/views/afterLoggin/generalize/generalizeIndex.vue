<template>
  <div>
    <!--推广运营首页  -->
    <logginHeader>
      <i class="iconfont icon-jiaose"></i>
      <span>AI推广运营</span>
      <span>&gt;</span>
      <span>稿件管理</span>
    </logginHeader>
    <div class="bottomBox">
      <div class="suoyin">
        <span>请搜索：</span>
        <el-input style="width:192px;" type="text" name id placeholder="订单编号/标题"></el-input>
        <span>订单类型：</span>
        <el-select v-model="selectValue" placeholder="请选择">
          <el-option
            v-for="item in options"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          ></el-option>
        </el-select>
        <span>时间：</span>
        <el-date-picker
          v-model="value1"
          type="daterange"
          range-separator="至"
          start-placeholder="开始日期"
          end-placeholder="结束日期"
        ></el-date-picker>
        <el-button>
          <i class="el-icon-search"></i>搜索
        </el-button>
      </div>
      <div class="skipScreen">
        <div>
          <router-link to="/flowIndex" style="background:red">需求确认...</router-link>
          <router-link to="/flowIndex" style="background:rgb(102,153,0)">代写中...</router-link>
          <router-link to="/flowIndex" style="background:rgb(0,51,255)">确认稿件</router-link>
          <router-link to="/flowIndex" style="background:rgb(171,147,48)">智推中</router-link>
          <router-link to="/flowIndex" style="background:rgb(134,134,134)">智推完成</router-link>
        </div>
        <div>
          <router-link to="/newManuscript" style="color:#0099ff;border:1px solid #0099ff">
            <i class="el-icon-plus"></i>
            <span>新发稿</span>
          </router-link>
        </div>
      </div>
      <!-- 分页表格数据 -->
      <div class="pagingTab">
        <el-table
          ref="multipleTable"
          :data="tableData.slice((currentPage-1)*pagesize,currentPage*pagesize)"
          tooltip-effect="dark"
          style="width: 100%"
          border
        >
          <el-table-column type="selection" width="59" align="center"></el-table-column>
          <el-table-column prop="name" label="稿件编号" width="140" align="center"></el-table-column>
          <el-table-column prop="name" label="标题" width="200" align="center"></el-table-column>
          <el-table-column prop="name" label="稿件类型" width="170" align="center"></el-table-column>
          <el-table-column prop="name" label="套餐费用" width="200" align="center"></el-table-column>
          <el-table-column prop="name" label="稿件费用" width="180" align="center"></el-table-column>
          <el-table-column prop="name" label="总计费用" width="180" align="center"></el-table-column>
          <el-table-column prop="name" label="创建时间" width="180" align="center"></el-table-column>
          <el-table-column width="150" label="操作" align="center">
            <template>
              <span class="spanDefault spanXuqiu">需求确认...</span>
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
  </div>
</template>
<script>
import logginHeader from "@/components/logginHeader";
export default {
  data() {
    return {
      value: "",
      // 时间选择
      value1: "",
      // 下拉列表
      options: [
        {
          value: "请选择",
          label: "请选择"
        },
        {
          value: "自撰稿件",
          label: "自撰稿件"
        },
        {
          value: "代写稿件",
          label: "代写稿件"
        }
      ],
      selectValue: "请选择",
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
      // 分页表格数据
      tableData: [
        {
          name: 111
        },
        {
          name: 111
        },
        {
          name: 222
        },
        {
          name: 222
        },
        {
          name: 333
        },
        {
          name: 333
        }
      ],
      total: 6,
      pagesize: 10,
      currentPage: 1
    };
  },
  components: {
    logginHeader
  },
  mounted() {},
  methods: {
    current_change: function(currentPage) {
      this.currentPage = currentPage;
    }
  }
};
</script>
<style lang="scss" scoped>
.bottomBox {
  margin: 10px 0 0 20px;
  background: #ffffff;
  font-family: "Arial Normal", "Arial";
  .suoyin {
    display: flex;
    color: #666666;
    font-size: 13px;
    align-items: center;
    background: rgb(243, 243, 243);
    padding: 10px 10px;
    border-left: 3px solid rgb(255, 0, 0);
    span {
      padding: 0 5px 0 10px;
      &:nth-of-type(1) {
        padding-left: 0;
      }
    }
  }
  .skipScreen {
    padding: 10px;
    display: flex;
    justify-content: space-between;
    a {
      display: inline-block;
      padding: 5px 10px;
      color: #ffffff;
      font-size: 13px;
      font-family: "Arial Normal", "Arial";
      margin-right: 10px;
    }
  }
  // 表格内按钮
  .spanDefault {
    display: inline-block;
    border-radius: 5px;
    color: #ffffff;
    padding: 5px;
    font-size: 13px;
    font-family: "Arial Normal", "Arial";
  }
  .spanXuqiu {
    background: #ff0000;
  }
  // 分页表格分页部分
  .pagingTabBottom {
    display: flex;
    align-items: center;
    border: 1px solid rgb(235, 238, 245);
    padding: 15px;
  }
}
</style>
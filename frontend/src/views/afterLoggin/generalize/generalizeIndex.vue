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
        <el-input
          style="width:192px;"
          type="text"
          name
          id
          placeholder="订单编号/标题"
          v-model="titleValue"
        ></el-input>
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
        <el-button @click="userMessage">
          <i class="el-icon-search"></i>搜索
        </el-button>
      </div>
      <div class="skipScreen">
        <div>
          <div style="background:rgb(103,194,58)" @click="xuanze('全部')">全部</div>
          <div style="background:red" @click="xuanze(1)">需求确认</div>
          <div style="background:rgb(102,153,0)" @click="xuanze(2)">代写中</div>
          <div style="background:rgb(0,51,255)" @click="xuanze(3)">确认稿件</div>
          <div style="background:rgb(171,147,48)" @click="xuanze(4)">智推中</div>
          <div style="background:rgb(134,134,134)" @click="xuanze(5)">智推完成</div>
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
          <el-table-column prop="no" label="稿件编号" width="140" align="center"></el-table-column>
          <el-table-column prop="name" label="标题" width="200" align="center"></el-table-column>
          <el-table-column prop="role_type" label="稿件类型" width="170" align="center">
            <template slot-scope="scope">
              <div v-if="scope.row.role_type==1">委托代写</div>
              <div v-if="scope.row.role_type!=1">自有稿件</div>
            </template>
          </el-table-column>
          <el-table-column prop="package_fee" label="套餐费用" width="200" align="center"></el-table-column>
          <el-table-column prop="money" label="稿件费用" width="180" align="center"></el-table-column>
          <el-table-column prop="money" label="总计费用" width="180" align="center"></el-table-column>
          <el-table-column prop="created_at" label="创建时间" width="180" align="center"></el-table-column>
          <el-table-column prop="order_status" width="150" label="操作" align="center">
            <template slot-scope="scope">
              <span
                @click.stop="setorderId(scope.row.order_status,scope.row.id,scope.row.role_type)"
                class="spanDefault spanXuqiu"
                v-if="scope.row.order_status==1"
              >需求确认...</span>
              <span
                @click.stop="setorderId(scope.row.order_status,scope.row.id,scope.row.role_type)"
                class="spanDefault spanDaixie"
                v-if="scope.row.order_status==2"
              >代写中...</span>
              <span
                @click.stop="setorderId(scope.row.order_status,scope.row.id,scope.row.role_type)"
                class="spanDefault spanQuerengaojian"
                v-if="scope.row.order_status==3"
              >确认稿件...</span>
              <span
                @click.stop="setorderId(scope.row.order_status,scope.row.id,scope.row.role_type)"
                class="spanDefault spanZhitui"
                v-if="scope.row.order_status==4"
              >智推中...</span>
              <span
                @click.stop="setorderId(scope.row.order_status,scope.row.id,scope.row.role_type)"
                class="spanDefault spanWancheng"
                v-if="scope.row.order_status==5"
              >智推完成...</span>
            </template>
          </el-table-column>
        </el-table>
        <div class="pagingTabBottom">
          <el-checkbox label="全选" style="margin:0 15px 0 5px;">全选</el-checkbox>
          <el-select
            v-model="selectValue1"
            placeholder="请选择"
            style="width:120px;margin-right:15px;"
          >
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
            @current-change="handleCurrentChange"
            :page-sizes="[10]"
            :page-size="pagesize"
            layout="total, sizes, prev, pager, next, jumper"
            :total="total"
          ></el-pagination>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import logginHeader from "@/components/logginHeader";
import { manuscriptList } from "@/api/api";
export default {
  data() {
    return {
      titleValue: "", //订单号/标题
      value: "",
      // 时间选择
      value1: undefined,
      // 下拉列表
      options: [
        {
          value: "0",
          label: "请选择"
        },
        {
          value: "1",
          label: "自有稿件"
        },
        {
          value: "2",
          label: "委托代写"
        }
      ],
      selectValue: "0",
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
      tableData: [],
      total: 6,
      pagesize: 10,
      currentPage: 1,
      xuanzeValue: "",
      startTime: "",
      endTime: ""
    };
  },
  components: {
    logginHeader
  },
  mounted() {
    // this.getmanuscriptList();
    this.userMessage();
  },

  methods: {
    showMsg(msg, code) {
      this.$message({
        message: msg,
        type: code === 1 ? "success" : "error"
      });
    },
    // 获取列表数据
    xuanze(e) {
      console.log(e);
      let xuanze = e;
      if (xuanze == "全部") {
        this.xuanzeValue = "";
        this.userMessage();
      } else {
        this.xuanzeValue = xuanze;
        this.userMessage();
      }
    },
    userMessage() {
      if (this.value1 != undefined && this.value1 != null) {
        // console.log(this.value);
        this.startTime = this.value[0].getTime();
        this.endTime = this.value[1].getTime();
      } else {
        this.startTime = "";
        this.endTime = "";
      }
      let params = {
        process: parseInt(this.xuanzeValue),
        title: this.title,
        role_type: this.selectValue == 0 ? "" : parseInt(this.selectValue),
        start_time: this.startTime,
        end_time: this.endTime
      };
      manuscriptList(params).then(res => {
        let { data, code, msg } = res;
        console.log(res);
        console.log(data);
        if (code == 1) {
          this.tableData = data.data;
          this.currentPage = data.current_page;
          this.pagesize = data.per_page;
          this.total = data.total;
        }
        // else if(code == 3){
        //   // this.showMsg(msg,code);
        //   this.$router.push({
        //     name:`index`,
        //     params:{
        //       isRegister:'2'
        //     }
        //   })
        // }
      });
    },
    // 路由传递id
    setorderId(str, id, leixing) {
      this.$router.push({
        name: `flowIndex`,
        params: {
          orderId: id,
          strValue: str,
          leixing: leixing
        }
      });
    },
    handleCurrentChange(cpage) {
      this.currpage = cpage;
    },
    handleSizeChange(psize) {
      this.pagesize = psize;
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
    > div {
      div,
      a {
        display: inline-block;
        padding: 5px 10px;
        color: #ffffff;
        font-size: 13px;
        font-family: "Arial Normal", "Arial";
        margin-right: 10px;
      }
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
  .spanDaixie {
    background: rgb(102, 153, 0);
  }
  .spanQuerengaojian {
    background: rgb(0, 51, 255);
  }
  .spanZhitui {
    background: rgb(171, 147, 48);
  }
  .spanWancheng {
    background: rgb(134, 134, 134);
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
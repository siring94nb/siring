<template>
  <div style="width:1500px;">
    <logginHeader>
      <i class="el-icon-edit"></i>
      <span>软件/定制</span>
      <span>&gt;</span>
      <span>定制需求订单</span>
    </logginHeader>
    <div class="index">
      <div class="form-seach">
        <el-form :inline="true" :model="formInline" class="demo-form-inline">
          <el-form-item label="请搜索">
            <el-input v-model="formInline.title" placeholder="订单编号/订单名称"></el-input>
          </el-form-item>
          <!-- <el-form-item label="订单类型">
            <el-select v-model="formInline.order_status" placeholder="全部">
              <el-option label="定制需求" value="1"></el-option>
              <el-option label="定制类似" value="2"></el-option>
              <el-option label="项目新增" value="3"></el-option>
            </el-select>
          </el-form-item>-->
          <el-form-item label="开始时间">
            <el-col :span="11">
              <el-date-picker
                type="date"
                placeholder="year/month/day"
                v-model="formInline.start_time"
                style="width: 100%;"
                :picker-options="pickerOptions"
              ></el-date-picker>
            </el-col>
            <el-col class="line" :span="2" style="text-align:center;">~</el-col>
            <el-col :span="11">
              <el-date-picker
                type="date"
                placeholder="year/month/day"
                v-model="formInline.end_time"
                style="width: 100%;"
                :picker-options="pickerOptions"
              ></el-date-picker>
            </el-col>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="onSubmit" icon="el-icon-search">搜索</el-button>
          </el-form-item>
        </el-form>
      </div>
      <div class="btn-all">
        <el-button size="mini" @click="handleEdit()" class="btns btn-qb">全部</el-button>
        <el-button size="mini" @click="handleEdit()" class="btns btn-dzxq">定制需求</el-button>
        <el-button size="mini" @click="handleEdit()" class="btns btn-ptbj">平台报价</el-button>
        <el-button size="mini" @click="handleEdit()" class="btns btn-qdht">签订合同</el-button>
        <el-button size="mini" @click="handleEdit()" class="btns btn-yxqr">原型确认</el-button>
        <el-button size="mini" @click="handleEdit()" class="btns btn-xmsx">项目上线</el-button>
        <el-button size="mini" @click="handleEdit()" class="btns btn-xmys">项目验收</el-button>
        <el-button size="mini" @click="handleEdit()" class="btns btn-xmnfw">项目年服务</el-button>
        <el-button size="mini" @click="handleEdit()" class="btns btn-xmzz">中止项目</el-button>
      </div>
      <div>
        <el-table
          :data="tableData"
          border
          style="width: 100%;"
          :header-cell-style="{background:'rgb(249,250,252)',color:'rgb(102,106,139)'}"
          @selection-change="handleSelectionChange"
        >
          <el-table-column type="selection" width="55" align="center"></el-table-column>
          <el-table-column prop="need_order" label="订单编号" align="center" width="200"></el-table-column>
          <el-table-column prop="need_name" label="订单名称" align="center"></el-table-column>
          <el-table-column prop="need_category" label="订单类型" align="center"></el-table-column>
          <el-table-column prop="need_terminal" label="终端类型" align="center"></el-table-column>
          <el-table-column prop="need_money" label="合同金额" align="center"></el-table-column>
          <el-table-column prop="need_order_money" label="订单金额" align="center"></el-table-column>
          <el-table-column prop="need_pay_account" label="付款方式" align="center"></el-table-column>
          <el-table-column prop="need_phone" label="付款账号" align="center" width="110"></el-table-column>
          <el-table-column prop="create_time" label="下单时间" align="center" width="110"></el-table-column>
          <el-table-column prop="need_surplus" label="剩余款" align="center"></el-table-column>
          <el-table-column prop="meal_end_time" label="剩余时间" align="center"></el-table-column>
          <el-table-column prop="need_new_info" label="官方最新消息" width="150" align="center"></el-table-column>
          <el-table-column label="操作" align="center">
            <template slot-scope="scope">
              <el-button
                size="mini"
                @click="handleEdit(scope.row.need_status - 1)"
                class="btns"
                :class="btnClassName[scope.row.need_status - 1]"
              >{{btnName[scope.row.need_status - 1]}}</el-button>
            </template>
          </el-table-column>
        </el-table>
      </div>
      <div class="block">
        <el-pagination
          @size-change="handleSizeChange"
          @current-change="handleCurrentChange"
          :current-page="tableShow.currentPage"
          :page-sizes="[10, 20, 30]"
          :page-size="tableShow.size"
          layout="total, sizes, prev, pager, next, jumper"
          :total="tableShow.total"
        ></el-pagination>
      </div>
    </div>
  </div>
</template>
<script>
import logginHeader from "@/components/logginHeader";
import { needOrderList } from "@/api/api";
export default {
  data() {
    return {
      userId: "",
      formInline: {
        title: "",
        start_time: "",
        end_time: ""
      },
      tableShow: {
        currentPage: 1,
        size: 10,
        listCount: 0,
        total: 0
      },
      tableData: [],
      multipleSelection: [],
      btnName: [
        "定制需求",
        "平台报价",
        "签订合同",
        "原型确认",
        "项目上线",
        "项目验收",
        "项目年服务",
        "中止项目"
      ],
      btnClassName: [
        "btn-dzxq",
        "btn-ptbj",
        "btn-qdht",
        "btn-yxqr",
        "btn-xmsx",
        "btn-xmys",
        "btn-xmnfw",
        "btn-xmzz"
      ],
      pickerOptions: {
        disabledDate(time) {
          return time.getTime() > Date.now();
        }
      }
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.userId = JSON.parse(sessionStorage.getItem("user_id"));
      this.orderList();
    },
    //获取订单列表
    orderList() {
      let vm = this,
        params = {
          title: vm.formInline.title,
          start_time: vm.formInline.start_time,
          end_time: vm.formInline.end_time,
          size: vm.tableShow.size,
          page: vm.tableShow.currentPage,
          user_id: vm.userId
        };
      needOrderList(params).then(res => {
        let { code, data, msg } = res.data;
        if (code == 1) {
          vm.tableShow.currentPage = data.current_page;
          vm.tableShow.size = Number(data.per_page);
          vm.tableShow.total = data.total;
          vm.tableData = data.data;
        }
      });
    },
    //条件搜索
    onSubmit() {
      this.orderList();
    },
    //页面显示条数
    handleSizeChange(val) {
      this.tableShow.size = val;
      this.orderList();
    },
    //页数
    handleCurrentChange(val) {
      this.tableShow.currentPage = val;
      this.orderList();
    },
    handleSelectionChange(val) {
      this.multipleSelection = val;
    },
    handleEdit(status) {
      this.$router.push({
        name: "order_derail",
        params: {
          status: status
        }
      });
    }
  },
  components: {
    logginHeader
  }
};
</script>
<style>
.btns {
  color: #fff;
}
.btn-qb {
  background-color: rgb(140, 218, 255);
}
.btn-dzxq {
  background-color: rgb(204, 51, 102);
}
.btn-ptbj {
  background-color: rgb(204, 0, 204);
}
.btn-qdht {
  background-color: rgb(255, 0, 0);
}
.btn-yxqr {
  background-color: rgb(102, 153, 0);
}
.btn-xmsx {
  background-color: rgb(204, 153, 0);
}
.btn-xmys {
  background-color: rgb(0, 102, 255);
}
.btn-xmnfw {
  background-color: rgb(255, 102, 0);
}
.btn-xmzz {
  background-color: rgb(174, 174, 174);
}
</style>
<style lang="scss" scoped>
.index {
  background: #ffffff;
  margin: 10px 0 0 20px;
  padding: 15px;
  .form-seach {
    height: 60px;
    background-color: rgba(243, 243, 243, 1);
    box-sizing: border-box;
    border: 1px solid rgba(228, 228, 228, 1);
    border-left: 2px solid red;
    padding: 10px;
    margin-bottom: 10px;
  }
  .btn-all {
    margin-bottom: 10px;
  }
  .block {
    margin: 10px auto;
    text-align: center;
  }
}
</style>
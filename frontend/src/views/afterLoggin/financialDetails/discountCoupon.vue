<template>
  <div>
    <logginHeader>
      <i class="el-icon-edit"></i>
      <span>资金管理</span>
      <span>&gt;</span>
      <span>优惠券</span>
    </logginHeader>
    <div class="noYhq" style="display:none">
      <div>
        <img src="../../../assets/images/zaox.png" alt="无" />
        <span>亲，您还没有任何优惠券！</span>
      </div>
    </div>
    <div class="xiangqing">
      <div class="shaixuan">
        <span>时间：</span>
        <el-date-picker
          v-model="value1"
          type="monthrange"
          align="right"
          unlink-panels
          range-separator="至"
          start-placeholder="开始月份"
          end-placeholder="结束月份"
        ></el-date-picker>
        <span>消费类型</span>
        <el-select v-model="value" placeholder="请选择" style="width:120px;">
          <el-option
            v-for="item in options"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          ></el-option>
        </el-select>
        <span>适用范围</span>
        <el-select v-model="value2" placeholder="请选择" style="width:120px;">
          <el-option
            v-for="item in options1"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          ></el-option>
        </el-select>
        <el-button type="danger" style="float: right;" @click="gb();Register()">确定</el-button>
      </div>
      <div>
        <el-table
          :data="tableData.slice((currentPage-1)*pageSize,currentPage*pageSize)" 
          border
          style="width: 100%; font-size:13px;color:#797979"
          :header-cell-style="{background:'rgb(249,250,252)',color:'#666666',fontSize:'14px',fontWeight:700 }"
        >
          <el-table-column prop="created_at" label="获得时间" width="180" align="center"></el-table-column>
          <el-table-column prop="end_time" label="到期时间" width="180" align="center"></el-table-column>
          <el-table-column prop="coupon_status" label="优惠券状态" align="center"></el-table-column>
          <el-table-column label="优惠券说明" align="type">
            <template slot-scope="scope">
              <div v-if="scope.row.type == 0">所有商品</div>
              <div v-if="scope.row.type == 1">软件定制类商品</div>
              <div v-if="scope.row.type == 2">固定选择商品</div>
            </template>
          </el-table-column>
          <el-table-column label="获得优惠券" align="center">
            <template slot-scope="scope">
              <div>
                <div>
                  <span>100元</span>
                </div>
                <div>
                  <div>{{scope.row.coupon_name}}</div>
                  <div v-if="scope.row.range == 0">全部</div>
                  <div v-if="scope.row.range == 1">黄金会员</div>
                  <div v-if="scope.row.range == 2">白金会员</div>
                  <div>立即使用&gt;&gt;</div>
                </div>
              </div>
              <div></div>
            </template>
          </el-table-column>
        </el-table>
        <el-pagination
          @size-change="handleSizeChange"
          @current-change="handleCurrentChange"
          :current-page.sync="currentPage"
          :page-size="pageSize"
          　　　　
          layout="total, prev, pager, next,jumper"
          :total="tableData.length"
        ></el-pagination>
      </div>
    </div>
  </div>
</template>
<script>
import logginHeader from "@/components/logginHeader";
import { getRegister } from "@/api/api";
export default {
  data() {
    return {
      dis: true,
      value1: "",
      // select1
      options: [
        {
          value: "选项1",
          label: "全部"
        },
        {
          value: "选项2",
          label: "普通优惠券"
        },
        {
          value: "选项3",
          label: "特殊优惠券"
        }
      ],
      value: "选项1",
      // select2
      options1: [
        {
          value: "选项1",
          label: "全部"
        },
        {
          value: "选项2",
          label: "已使用"
        },
        {
          value: "选项3",
          label: "未使用"
        }
      ],
      value2: "选项1",
      // 表格数据
      tableData: [
      ],
      pageSize: 3,
      currentPage: 1
    };
  },
  components: {
    logginHeader
  },
  mounted() {this.Register()},
  methods: {
    handleSizeChange: function() {},
    handleCurrentChange: function() {},

    gb() {
      // 修改状态判断是否有索引条件
      this.dis = false;
    },
    Register() {
      let params = {};
      if (this.dis) {
        getRegister().then(res => {
          let { data, msg, code } = res;
            console.log(res)
          if (code == 1) {
            this.tableData = data.data;
            console.log(this.tableData)
          }
        });
      } else {
        params = {};
        getRegister(params).then(res => {
          let { data, msg, code } = res;
          if (code == 1) {
            this.tableData = data.data;
          }
        });
      }
    }
  }
};
</script>
<style lang="scss" scoped>
.noYhq {
  background: #ffffff;
  margin: 10px 0 0 20px;
  padding: 260px 0 260px 0;
  height: 100vh;
  box-sizing: border-box;
  > div {
    display: flex;
    align-items: center;
    justify-content: center;
  }
}
.xiangqing {
  background: #ffffff;
  margin: 10px 0 0 20px;
  padding: 20px;
  .shaixuan {
    padding: 10px;
    background: rgb(243, 243, 243);
    border-left: 3px solid #ff0000;
    > span {
      font-size: 13px;
      color: #666666;
      &:nth-of-type(1) {
        padding-right: 10px;
      }
      &:nth-of-type(2) {
        padding: 0 10px 0 40px;
      }
      &:nth-of-type(3) {
        padding: 0 10px 0 40px;
      }
    }
  }
}
</style>
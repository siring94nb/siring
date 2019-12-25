<template>
  <div>
    <el-table :data="tableData" style="width: 100%">
      <el-table-column label="日期" width="180">
        <template slot-scope="scope">
          <i class="el-icon-time"></i>
          <span style="margin-left: 10px">{{ scope.row.date }}</span>
        </template>
      </el-table-column>
      <el-table-column label="姓名" width="180">
        <template slot-scope="scope">
          <el-popover trigger="hover" placement="top">
            <p>姓名: {{ scope.row.name }}</p>
            <p>住址: {{ scope.row.address }}</p>
            <div slot="reference" class="name-wrapper">
              <el-tag size="medium">{{ scope.row.name }}</el-tag>
            </div>
          </el-popover>
        </template>
      </el-table-column>
      <el-table-column label="操作">
        <template slot-scope="scope">
          <el-button size="mini" @click="handleEdit(scope.$index, scope.row)">编辑</el-button>
          <el-button size="mini" type="danger" @click="handleDelete(scope.$index, scope.row)">删除</el-button>
        </template>
      </el-table-column>
    </el-table>
    <el-date-picker
      v-model="value1"
      type="daterange"
      range-separator="至"
      start-placeholder="开始日期"
      end-placeholder="结束日期"
    ></el-date-picker>
    <button @click="ceshi" style="width:200px;">测试时间数据获取</button>
  </div>
</template>
<script>
import VDistpicker from "v-distpicker";
import { GetRoleCenter, CityTotal, CityPartner, Qnupload } from "@/api/api";
export default {
  data() {
    return {
      tableData: [
        {
          date: "2016-05-02",
          name: "王小虎",
          address: "上海市普陀区金沙江路 1518 弄"
        },
        {
          date: "2016-05-04",
          name: "王小虎",
          address: "上海市普陀区金沙江路 1517 弄"
        },
        {
          date: "2016-05-01",
          name: "王小虎",
          address: "上海市普陀区金沙江路 1519 弄"
        },
        {
          date: "2016-05-03",
          name: "王小虎",
          address: "上海市普陀区金沙江路 1516 弄"
        }
      ],
      value1: ""
    };
  },
  components: {},
  mounted() {},
  methods: {
    ceshi() {
      console.log(this.value1 == "");
    },
    handleEdit(index, row) {
      console.log(row.date);
    },
    handleDelete(index, row) {
      console.log(index, row);
    },

    getCapitalDetailed() {
      let params = {};
      let times = this.value;
      // let start_time = this.value[0];
      // let end_time = this.value[1];
      if (this.dis) {
        CapitalDetailed().then(res => {
          let { data, msg, code } = res;
          if (code === 1) {
            this.pagesize = data.per_page;
            this.tableData = data.data;
          }
        });
      } else {
        if (this.value == "") {
          params = {
            budget_type: this.selected1,
            role_type: this.selected2
          };
          this.dis = true;
        } else if (this.selected1 == "0" && this.value != null) {
          let start_time = this.value[0];
          let end_time = this.value[1];
          params = {
            role_type: this.selected2,
            start_time: start_time.getTime(),
            end_time: end_time.getTime()
          };
          this.dis;
        } else {
          params = {
            budget_type: this.selected1,
            role_type: this.selected2,
            start_time: this.value[0].getTime(),
            end_time: this.value[1].getTime()
          };
          this.dis = true;
        }
        CapitalDetailed(params).then(res => {
          let { data, msg, code } = res;
          if (code === 1) {
            this.tableData = data.data;
          }
        });
      }
    },


  }
};
</script>
<style lang="scss" scoped>
.box {
  margin-left: 200px;
}
.avatar-uploader {
  width: 300px;
  background: black;
}
.avatar-uploader .el-upload {
  border: 1px dashed #d9d9d9;
  border-radius: 6px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}
.avatar-uploader .el-upload:hover {
  border-color: #409eff;
}
.avatar-uploader-icon {
  font-size: 28px;
  color: #8c939d;
  width: 72px;
  height: 72px;
  line-height: 72px;
  text-align: center;
}
.avatar {
  width: 70px;
  height: 70px;
  display: block;
  border-radius: 6px;
}
// div.el-upload.el-upload--picture-card{
// width: 300px !important   ;
// }
</style>
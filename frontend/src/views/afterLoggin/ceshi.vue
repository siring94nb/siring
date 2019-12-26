<template>
  <div>
    <el-table
      ref="multipleTable"
      :data="tableData.slice((currentPage-1)*pagesize,currentPage*pagesize)"
      tooltip-effect="dark"
      style="width: 100%"
      @selection-change="changeFun">
      <el-table-column
        type="selection"
        width="55">
      </el-table-column>
      <el-table-column
        prop="name"
        label="姓名"
        width="120">
      </el-table-column>
      <el-table-column
        prop="age"
        label="年龄"
        width="120">
      </el-table-column>
      <el-table-column
        prop="sex"
        label="性别"
        width="120">
      </el-table-column>
      <el-table-column
        prop="department"
        label="部门"
        width="150">
      </el-table-column>
      <el-table-column
        prop="floor"
        label="楼层"
        width="120">
      </el-table-column>
      <el-table-column
        prop="area"
        label="区域"
        width="120">
      </el-table-column>
      <el-table-column label="操作">
        <template slot-scope="scope">
          <el-button
            size="mini"
            @click="handleEdit(scope.$index, scope.row)">修改
          </el-button>
          <el-button
            size="mini"
            type="danger"
            @click="handleDelete(scope.$index, scope.row)">删除
          </el-button>
        </template>
      </el-table-column>
    </el-table>
    <div style="text-align: center;margin-top: 30px;">
      <el-pagination
        background
        layout="prev, pager, next"
        :total="total"
        :page-size="pagesize"
        @current-change="current_change">
      </el-pagination>
    </div>
  </div>
</template>
<script>
import VDistpicker from "v-distpicker";
import { GetRoleCenter, CityTotal, CityPartner, Qnupload } from "@/api/api";
export default {
  name: "dataList",
  data() {
    return {
      tableData: [
        {
          selection:'123123',
          name:"姓名",
          age:'age',
          sex:'sex',
          department:"部门",
          floor:"楼层",
          area:"区域"
        },
         {
          selection:'123123',
          name:"姓名",
          age:'age',
          sex:'sex',
          department:"部门",
          floor:"楼层",
          area:"区域"
        },
         {
          selection:'123123',
          name:"姓名",
          age:'age',
          sex:'sex',
          department:"部门",
          floor:"楼层",
          area:"区域"
        },
         {
          selection:'123123',
          name:"姓名",
          age:'age',
          sex:'sex',
          department:"部门",
          floor:"楼层",
          area:"区域"
        },
         {
          selection:'123123',
          name:"姓名",
          age:'age',
          sex:'sex',
          department:"部门",
          floor:"楼层",
          area:"区域"
        },
        {
          selection:'123123',
          name:"姓名",
          age:'age',
          sex:'sex',
          department:"部门",
          floor:"楼层",
          area:"区域"
        },
        {
          selection:'123123',
          name:"姓名",
          age:'age',
          sex:'sex',
          department:"部门",
          floor:"楼层",
          area:"区域"
        },
        {
          selection:'123123',
          name:"姓名",
          age:'age',
          sex:'sex',
          department:"部门",
          floor:"楼层",
          area:"区域"
        },
        {
          selection:'123123',
          name:"姓名",
          age:'age',
          sex:'sex',
          department:"部门",
          floor:"楼层",
          area:"区域"
        },
        {
          selection:'123123',
          name:"姓名",
          age:'age',
          sex:'sex',
          department:"部门",
          floor:"楼层",
          area:"区域"
        },
      ],
        multipleSelection: [],
        total:10,
        pagesize:5,
        currentPage:1
    };
  },
  computed:{
    //  lengthLong:function(){
    //    return this.total = this.tableData.length;
    //  }
  },
  components: {},
  mounted() {},
  methods: {
      current_change:function(currentPage){
        this.currentPage = currentPage;
        console.log(this.currentPage);
      },
      changeFun(val){
        console.log(val)
      }
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
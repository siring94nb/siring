<template>
  <div>
   <el-dialog :visible.sync="dialogVisible">
    <el-table
      ref="multipleTable"
      :data="tableData.slice((currentPage-1)*pagesize,currentPage*pagesize)"
      tooltip-effect="dark"
      style="width: 100%"
      @selection-change="changeFun">
      <el-table-column
        type="selection"
        width="55"
      >
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
    </el-dialog>
    <div style="text-align: center;margin-top: 30px;">
      <el-pagination
        background
        layout="prev, pager, next"
        :total="total"
        :page-size="pagesize"
        >
      </el-pagination>
    </div>
    <el-checkbox @change="changeFun(tableData)" :indeterminate="Indeterminate" >全选</el-checkbox>
    <button @click="addRoleHandle">gb</button>
    <button @click="checkWord">读取word</button>
    <div></div>
  </div>
</template>
<script>
import VDistpicker from "v-distpicker";
import { GetRoleCenter, CityTotal, CityPartner, Qnupload } from "@/api/api";
export default {
  name: "dataList",
  data() {
    return {
      dialogType: 'new',
      dialogVisible: false,
      checkAll: false,
      Indeterminate: false,
      checkedCities:[],
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
     addRoleHandle() {
        //  this.dialogType = 'new'
         this.dialogVisible = true
     },
      // handleCheckAllChange(val) {
      //   console.log(val)
      //   this.checkedCities = val ? console.log( this.tableData) : [];
      //   this.isIndeterminate = false;
      // },
      // handleCheckedCitiesChange(value) {
      //   let checkedCount = value.length;
      //   this.checkAll = checkedCount === this.tableData.length;
      //   this.isIndeterminate = checkedCount > 0 && checkedCount < this.cities.length;
      // },
      // toggleSelection(rows) {
      //   console.log(112111)
      //   if (rows) {
      //     rows.forEach(row => {
      //       this.$refs.multipleTable.toggleRowSelection(row);
      //     });
      //   } else {
      //     this.$refs.multipleTable.clearSelection();
      //   }
      // },
      changeFun(val){
        // 测试，当if条件成立，会触发两次，目前不知原因
        if(val.length == this.pagesize){
          this.Indeterminate=true;
          console.log(1111111)
        }else{
          this.Indeterminate = false
        }
        console.log(val.length);
        console.log(this.pagesize);
        // console.log(val)
      },
      checkWord(){
        var w = new ActiveXObject('Word.Application');
        var docText;
        var obj;
        if(w != null) {
          w.Visible = true;
          obj = w.Documents.Open("D:\\word\\go.doc");
          docText = obj.Content;
          w.Selection.TypeText("Hello");
          w.Documents.Save();
          document.write(docText);//Print on webpage
          w.Documents.Add();
          w.Selection.TypeText("Writing This Message ....");
          w.Documents.Save("D:\\word\\go.doc");
          w.Quit();
          /*Don't forget
          set w.Visible=false */
        }
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
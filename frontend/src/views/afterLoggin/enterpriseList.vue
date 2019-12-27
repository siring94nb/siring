<template>
  <div>
    <logginHeader>
      <i class="el-icon-edit"></i>
      <span>会员中心</span>
      <span>&gt;</span>
      <router-link to="/memberInformation" style="color:lightBlue">会员信息</router-link>
      <span>&gt;</span>
      <span>企业信息列表</span>
    </logginHeader>
    <div class="boxBottom">
      <div class="addBox">
        <router-link to="addEnterprise">添加企业身份</router-link>
      </div>
      <div>
        <el-table :data="enterpriseList" border style="width: 100%">
          <el-table-column type="selection" width="55"></el-table-column>
          <el-table-column prop="id" label="序列" width="180"></el-table-column>
          <el-table-column prop="name" label="企业身份名" width="180"></el-table-column>
          <el-table-column prop="business_license" label="营业执照" width="180">
            <template slot-scope="scope">
              <img :src="scope.row.business_license" alt  style="width:100px;height:120px"/>
            </template>
          </el-table-column>
          <el-table-column prop="id_card_just" label="法人身份证" width="180">
            <template slot-scope="scope">
              <img :src="scope.row.id_card_just" alt style="width:120px;height:100px" />
            </template>
          </el-table-column>
          <el-table-column label="操作">
            <template slot-scope="scope">
              <span @click="enterprisEdit(scope.row)" style="color:#21a5fa;padding-right:10px;">编辑</span>
              <span @click="deleteEnterprise(scope.row)" style="color:#21a5fa">删除</span>
            </template>
          </el-table-column>
        </el-table>
      </div>
    </div>
  </div>
</template>
<script>
import logginHeader from "@/components/logginHeader";
// import { GetEnterprise } from "@/api/api";
import { GetEnterprise, EnterpriseDel, EnterprisEdit } from "@/api/api";
export default {
  data() {
    return {
      enterpriseList: []
    };
  },
  mounted() {
    this.getEnterpriseList();
    this.ceshi()
  },
  methods: {
    handleRemove(file, fileList) {
      console.log(file, fileList);
    },
    handlePictureCardPreview(file) {
      this.dialogImageUrl = file.url;
      this.dialogVisible = true;
    },
    showMsg(msg, code) {
      this.$message({
        message: msg,
        type: code === 1 ? "success" : "error"
      });
    },
    // 获取企业列表
    getEnterpriseList() {
      const userId = parseInt(sessionStorage.getItem("user_id"));
      const params = {
        user_id: userId
      };
      GetEnterprise(params).then(res => {
        let { data, msg, code } = res;
        console.log(res);
        // this.showMsg(msg, code);
        // 目前来说，知道的就是，后台没有数据，返回的就是获取失败，并不是说代码有错误
        if (code === 1) {
          this.enterpriseList = data;
          console.log(data[0].id);
        }
      });
    },
    // 删除企业信息
    deleteEnterprise(row) {
      let params = { id: parseInt(row.id) };
      EnterpriseDel(params).then(res => {
        let { data, code, msg } = res;
        this.showMsg(msg, code);
      });
    },
    // 企业信息修改,获取数据跳转到新增页面进行修改操作
    enterprisEdit(row) {
      // 当前无数据，无法测试
      this.$router.push({
        path:"/addEnterprise",
        query:{
          id:parseInt(row.id),
          title:row.name,
          duty:row.duty,
          business_license:row.business_license,//营业执照链接
          id_card_just:row.id_card_just,//身份证正面链接
          id_card_back:row.id_card_back//身份证反面链接

        }
      })
      // let params = { id: 1 };
      // EnterprisEdit(params).then(res => {
      //   let { data, code, msg } = res;
      //   this.showMsg(msg, code);
      // });
    },
    ceshi(){
      console.log(this.$route)
    }
    
  },
  components: {
    logginHeader
  }
};
</script>
<style lang="scss" scoped>
.boxBottom {
  background: #fff;
  margin: 10px 0 0 20px;
  padding: 15px;
  .addBox {
    // border: 1px solid;
    width: 143px;
    background-color: rgba(10, 135, 255, 1);
    text-align: center;
    padding: 10px 0;
    border-radius: 3px;
    margin-bottom: 20px;
    a {
      color: #ffffff;
    }
  }
}
</style>
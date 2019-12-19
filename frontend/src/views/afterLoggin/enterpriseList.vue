<template>
  <div>
    <logginHeader>
      <i class="el-icon-edit"></i>
      <span>会员中心</span>
      <span>&gt;</span>
      <span>会员信息</span>
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
              <img :src="scope.row.business_license" alt />
            </template>
          </el-table-column>
          <el-table-column prop="id_card_just" label="法人身份证" width="180">
            <template slot-scope="scope">
              <img :src="scope.row.id_card_just" alt />
            </template>
          </el-table-column>
          <el-table-column label="操作">
            <template>
              <span>编辑</span>
              <span>删除</span>
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
import { GetEnterprise } from "@/api/api";
export default {
  data() {
    return {
      enterpriseList: []
    };
  },
  mounted() {
    this.getEnterpriseList();
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
        this.showMsg(msg, code);
        if (code === 1) {
          this.enterpriseList = data;
          console.log(data);
        }
      });
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
    background-color: rgba(10,135,255,1);
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
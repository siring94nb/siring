<template>
  <div style="background:rgb(246,246,246);min-height:100vh">
    <Myheader />
    <div class="box" ref="box">
      <div class="topBox">
        <div style="margin-right:30px; width: 100px; padding:10px 0px; ">行业领域：</div>
        <div style="flexGrow: 1">
          <span :class="{'active': cid==''}" @click="gbBiaozhi('全部')">全部</span>
          <span
            :class="{'active': cid==item.id}"
            v-for="(item,index) in IndustryField"
            :key="index+1"
            :id="item.id"
            @click="gbBiaozhi(item.id)"
          >{{item.title}}</span>
          <span style="float: right;">更多&gt;&gt;</span>
        </div>
      </div>
      <div class="shaixuanBox">
        <div style="margin-left:250px">
          <el-select
            @change="getindustryList"
            v-model="value"
            placeholder="请选择"
            style="width:120px; margin-right:30px;"
          >
            <el-option
              v-for="item in options"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            ></el-option>
          </el-select>
        </div>
        <div class="searchBox">
          <el-input v-model="suoyin" placeholder="请输入名称" prefix-icon="el-icon-search"></el-input>
          <el-button style="background:#ff0000;color:#ffffff" @click="getindustryList">搜索</el-button>
        </div>
        <div class="iBox" @click="tiaozhuan('','')">
          <i class="el-icon-s-promotion"></i>
          <div>
            创业者发布
            <br />Entrepreneur
          </div>
        </div>
        <div class="guanzhu">
          <i class="iconfont icon-guanzhu Idefault" v-if="false"></i>
          <i class="iconfont icon-guanzhu1 iActive"></i>
          <span>我的关注</span>
        </div>
      </div>
      <div>
        <el-table
          :data="tableData"
          style="width: 100%"
        >
          <el-table-column prop="id" label="邀请码" width="200" align="center"></el-table-column>
          <el-table-column prop="name" label="项目名称" width="200" align="center"></el-table-column>
          <el-table-column prop="resume" label="行业领域" width="200" align="center"></el-table-column>
          <el-table-column prop="resume" label="项目亮点" width="400" align="center"></el-table-column>
          <el-table-column prop="deshi" label="操作" align="center">
            <template slot-scope="scope">
              <div class="caozuoBox">
                <div @click="tiaozhuan(scope.$index, tableData)">{{scope.row.deshi}}</div>
                <div class="guanzhu" @click="setcollectX(tableData,scope.$index)">
                  <i class="iconfont icon-guanzhu1 zhuanhuan" v-if="scope.row.follow==0"></i>
                  <i class="iconfont icon-guanzhu1 iActive zhuanhuan" v-if="scope.row.follow==1"></i>
                  <!-- <i class="iconfont icon-guanzhu1 iActive   zhuanhuan" v-if="scope.row.follow==''">请登录</i> -->
                </div>
              </div>
            </template>
          </el-table-column>
        </el-table>
      </div>
      <div class="fenye">
        <el-pagination
          background
          @current-change="currentChange"
          :page-sizes="[10]"
          :page-size="[pagesize]"
          layout="total, sizes, prev, pager, next, jumper"
          :total="total"
         
        ></el-pagination>
        <!--  @prev-click="prevClick"
          @next-click="nextClick" -->
      </div>
    </div>
  </div>
</template>
<script>
import Myheader from "@/components/header";
import { industryField, industryList, collectX } from "@/api/api";
export default {
  data() {
    return {
      IndustryField: [], //添加投融，行业领域数据
      options: [
        {
          value: "1",
          label: "全部"
        },
        {
          value: "2",
          label: "按打赏数量最高"
        },
        {
          value: "3",
          label: "按打赏数量最低"
        }
      ],
      value: "1",
      suoyin: "",
      cid: 0,
      // 表格
      tableData: [
        {
          id: 29,
          name: "测试项目名称",
          sid: 2,
          resume: "测试项目亮点",
          industry_field: "数字资产",
          deshi: "我要投资"
        },
        {
          id: 29,
          name: "测试项目名称",
          sid: 2,
          resume: "测试项目亮点",
          industry_field: "数字资产",
          deshi: "我要投资"
        },
        {
          id: 29,
          name: "测试项目名称",
          sid: 2,
          resume: "测试项目亮点",
          industry_field: "数字资产",
          deshi: "我要投资"
        },
        {
          id: 29,
          name: "测试项目名称",
          sid: 2,
          resume: "测试项目亮点",
          industry_field: "数字资产",
          deshi: "我要融资"
        },
        {
          id: 29,
          name: "测试项目名称",
          sid: 2,
          resume: "测试项目亮点",
          industry_field: "数字资产",
          deshi: "我要融资"
        }
      ],
      total: 6,
      pagesize: 10,
      currentPage: 1
    };
  },
  components: {
    Myheader
  },
  mounted() {
    this.getIndustryField();
    this.changeSize();
    this.getindustryList();
  },
  methods: {
     // 获取表格信息
    getindustryList() {
      // console.log(this.cid);
      let parmas = {
      };
      if(this.cid == 0){
        parmas = {
          type: this.value,
          title: this.suoyin,
          page:this.currentPage
          // page: 4
        };
      }else{
        parmas = {
          type: this.value,
          cid:parseInt(this.cid),
          title: this.suoyin,
          page:this.currentPage
          // page: 4
        };
      }
      industryList(parmas).then(res => {
        let { data, code, msg } = res;
        // console.log(res);
        if (code == 1) {
          // this.showMsg(msg,code)
          this.tableData = data.data;
          this.total = data.total;
          this.pagesize = data.per_page;
          this.currentPage = data.current_page;
          // console.log(this.tableData)
        }
      });
    },
    getIndustryField() {
      industryField().then(res => {
        let { data, msg } = res;
        if (data.code == 1) {
          this.IndustryField = data.data;
        }
      });
    },
    // 投资，融资跳转传参
    tiaozhuan(index, rows) {
      let leixing = "";
      let id = "";
      console.log(index);
      console.log(rows);
      if (index != "" && rows != "") {
        leixing = rows[index].deshi;
        id = rows[index].id;
      } else {
        leixing = rows[index].deshi;
        id = this.tableData[0].id;
      }
      this.$router.push({
        name: `newInvestment`,
        params: {
          leixing: leixing,
          id: id
          // code: '8989'
        }
      });
    },
    // prevClick(){
    //   this.currentPage = this.currentPage-1;
    //   this.getindustryList();
    // },
    // nextClick(){
    //   this.currentPage = this.currentPage+1;
    //   this.getindustryList();
    // },
    currentChange(currentPage){
      this.currentPage = currentPage;
      this.getindustryList();
    },
    // 控制屏幕过大，两侧留白
    changeSize() {
      return (() => {
        let screenWidth = document.body.clientWidth;
        let Box = this.$refs.box;
        if (screenWidth > 1260) {
          Box.style.marginLeft = (screenWidth - Box.clientWidth) / 2 + "px";
        } else {
          Box.style.marginLeft = "0px";
        }
      })();
    },
    // 获取标识
    gbBiaozhi(str) {
      console.log(str);
      this.suoyin = "";
      if (str == "全部") {
        this.cid = "";
        this.getindustryList();
      } else {
        this.cid = parseInt(str);
        this.getindustryList();
      }
    },
    showMsg(msg, code) {
      this.$message({
        message: msg,
        type: code === 1 ? "success" : "error"
      });
    },
    // 关注操作
    setcollectX(item, index) {
      let zhuanhuanArr = document.getElementsByClassName("zhuanhuan");
      let classListA = zhuanhuanArr[index].classList;
      let params = {
        pid: parseInt(item[index].id),
        type: 1,
        user_id: parseInt(sessionStorage.getItem("user_id"))
      };
      // console.log(params)
      if (classListA.toString().indexOf("iActive") != -1) {
        zhuanhuanArr[index].classList.remove("iActive");
        collectX(params).then(res => {
          let { code, msg } = res;
          if (code == 1) {
            this.showMsg("取消关注", code);
          }
        });
      } else {
        zhuanhuanArr[index].classList.add("iActive");
        collectX(params).then(res => {
          let { code, msg } = res;
          if (code == 1) {
            this.showMsg("关注成功", code);
          }
        });
      }
    }
  }
};
</script>
<style lang="scss" scoped>
.box {
  background: rgb(246, 246, 246);
  // margin-top: 110px;
  width: 1260px;
  margin: 100px auto;
  .topBox {
    display: flex;
    background: #ffffff;
    font-size: 13px;
    padding: 20px 20px 0px 20px;
    // margin-top: 20px;
    // overflow: hidden;
    span {
      font-size: 13px;
      display: inline-block;
      padding: 5px 12px;
      margin-bottom: 20px;
      margin-right: 30px;
      // width: 92px;
      text-align: left;
      text-align: center;
    }
    .active {
      background-image: url("~@/assets/images/arrow-top.png");
      background-position: 100% 0;
      background-repeat: no-repeat;
      color: #ff0000;
      border: 1px solid rgb(230, 45, 49);
      background-size: 10px;
      border-radius: 3px;
    }
  }
  // 头部筛选
  .shaixuanBox {
    position: relative;
    display: flex;
    background: #ffffff;
    padding-left: 135px;
    margin-bottom: 20px;
    padding-bottom: 20px;
    .searchBox {
      display: flex;
    }
    > button {
      background: #ff0000;
      border: 1px solid #ff0000;
      color: #ffffff;
      width: 90px;
      height: 40px;
      margin-right: 150px;
    }
    .iBox {
      display: flex;
      font-size: 14px;
      align-items: center;
      padding-left: 20px;
      i {
        font-size: 32px;
        color: rgb(91, 156, 254);
      }
    }
    .guanzhu {
      display: flex;
      align-items: center;
      margin-left: 200px;
    }
  }
  .Idefault {
    background: white;
    color: #cccccc;
    font-size: 26px;
  }
  .iActive {
    color: rgb(244, 234, 42);
    font-size: 20px;
  }
  .caozuoBox {
    display: flex;
    justify-content: space-around;
    align-items: center;
    padding: 0 50px;
    > div {
      &:nth-of-type(1) {
        padding: 10px 20px;
        border: 1px solid #ff0000;
        border-radius: 5px;
      }
    }
  }
  .fenye{
    margin-top: 10px;
    display: flex;
    justify-content: center;
  }
}
</style>
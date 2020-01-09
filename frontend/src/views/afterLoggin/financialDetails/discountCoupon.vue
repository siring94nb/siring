<template>
  <div>
    <logginHeader>
      <i class="iconfont icon--zijinguanli"></i>
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
          type="daterange"
          align="right"
          unlink-panels
          range-separator="至"
          start-placeholder="开始月份"
          end-placeholder="结束月份">
        </el-date-picker>

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
        <el-button type="danger" style="float: right;" @click="Register()">确定</el-button>
      </div>
      <div>
        <el-table
          :data="tableData"
          border
          style="width: 100%; font-size:13px;color:#797979"
          :header-cell-style="{background:'rgb(249,250,252)',color:'#666666',fontSize:'14px',fontWeight:700 }"
        >
          <el-table-column prop="created_at" label="获得时间" width="240" align="center"></el-table-column>
          <el-table-column prop="end_time" label="到期时间" width="240" align="center"></el-table-column>
          <el-table-column prop="coupon_status" label="优惠券状态" align="center" width="240">
            <template slot-scope="scope">
              <div>{{scope.row.coupon_status==0?"已使用":"未使用"}}</div>
            </template>
          </el-table-column>
          <el-table-column label="优惠券说明（类型）" align="center" width="240">
            <template slot-scope="scope">
              <div v-if="scope.row.type == 0">所有商品</div>
              <div v-if="scope.row.type == 1">软件定制类商品</div>
              <div v-if="scope.row.type == 2">固定选择商品</div>
            </template>
          </el-table-column>
          <el-table-column label="获得优惠券" align="center">
            <template slot-scope="scope">
              <div class="youhuiquan">
                <img :src="img1" alt v-if="scope.row.coupon_status!=0" />
                <img :src="img2" alt v-if="scope.row.coupon_status==0" />
                <div class="yhqBox">
                  <div>
                    <!-- 返回值有个rule:"{\"full\":130,\"reduce\":50}"    \"也就是转义字符-->
                    <div>
                      <span>{{JSON.parse(scope.row.rule).full-JSON.parse(scope.row.rule).reduce}}</span>
                      <span>元</span>
                    </div>
                    <div>满{{JSON.parse(scope.row.rule).full}}减{{JSON.parse(scope.row.rule).reduce}}</div>
                  </div>
                  <div>
                    <div>{{scope.row.coupon_name}}</div>
                    <div v-if="scope.row.range == 0">全部</div>
                    <div v-if="scope.row.range == 1">黄金会员</div>
                    <div v-if="scope.row.range == 2">白金会员</div>
                    <div>
                      <router-link
                        to="/goods"
                        v-if="scope.row.coupon_status==1"
                        style="color:#00b5d2"
                      >立即使用&gt;&gt;</router-link>
                      <span v-if="scope.row.coupon_status==0" style="color:#949494">已使用</span>
                    </div>
                  </div>
                </div>
              </div>
              <div></div>
            </template>
          </el-table-column>
        </el-table>
        <div style="display:flex;justify-content: center">
          <el-pagination
          @size-change="handleSizeChange"
          @current-change="handleCurrentChange"
          :current-page.sync="currentPage"
          :page-size="pageSize"
          layout="total, prev, pager, next,jumper"
          :total="total"
        ></el-pagination>
        </div>
        
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
      value1: undefined,
      // select1
      options: [
        {
          value: "0",
          label: "全部"
        },
        {
          value: "1",
          label: "所有商品"
        },
        {
          value: "2",
          label: "固定选择商品"
        },
        {
          value: "3",
          label: "所有商品"
        }
      ],
      value: "全部",
      // select2
      options1: [
        {
          value: "全部",
          label: "全部"
        },
        {
          value: "0",
          label: "已使用"
        },
        {
          value: "1",
          label: "未使用"
        }
      ],
      value2: "全部",
      // 表格数据
      tableData: [],
      pageSize: 3,
      currentPage: 1,
      total:0,
      img1: require("../../../assets/images/youhuiquan1.png"),
      img2: require("../../../assets/images/youhuiquan2.png"),
      startTime:"",
      endTime:""
    };
  },
  components: {
    logginHeader
  },
  mounted() {
    this.Register();
  },
  methods: {
    handleSizeChange: function() {},
    handleCurrentChange: function(currentPage) {
      this.currentPage =currentPage
    },
    // gb() {
    //   // 修改状态判断是否有索引条件
    //   // if (this.value == "全部" && this.value2 == "全部" && this.value1 == "") {
    //   //   this.dis = true;
    //   // } else if (
    //   //   this.value1 == null &&
    //   //   this.value == "全部" &&
    //   //   this.value2 == "全部"
    //   // ) {
    //   //   this.dis = true;
    //   //   this.value1 = "";
    //   // } else {
    //   //   this.dis = false;
    //   // }
    //   if(this.value2 == "全部"){
    //     this.value2 = ""
    //   }
    // },
    Register() {
      let value2 = 0
      if(this.value2 == "全部"){
        value2 = ""
      }else{
        value2 =parseInt(this.value2)
      }
      // this.gb();
      console.log(value2)
      if (this.value1 != undefined && this.value1 != null) {
        // console.log(this.value);
        this.startTime = this.value1[0].getTime();
        this.endTime = this.value1[1].getTime();
      } else {
        this.startTime = "";
        this.endTime = "";
      }
      let params = {
        status:value2,
        page:this.currentPage,
        start_time:this.startTime,
        end_time:this.endTime
      };
      // let times = this.value1;
      // if (this.dis) {
      //   getRegister().then(res => {
      //     let { data, msg, code } = res;
      //     if (code == 1) {
      //       this.tableData = data.data;
      //       this.pageSize = data.per_page
      //     }
      //   });
      // } else {
      //   if (times == "") {
      //     console.log(this.value2);
      //     params = {
      //       status: this.value2
      //     };
      //     this.dis = true;
      //   } else if (this.value2 == "全部" && times != null) {
      //     let start_time = times[0];
      //     let end_time = times[1];
      //     params = {
      //       start_time: start_time.getTime(),
      //       end_time: end_time.getTime()
      //     };
      //     this.dis;
      //   } else {
      //     let start_time = times[0];
      //     let end_time = ttimes[1];
      //     params = {
      //       status: this.value2,
      //       start_time: times[0].getTime(),
      //       end_time: times[1].getTime()
      //     };
      //     this.dis = true;
      //   }
        getRegister(params).then(res => {
          let { data, msg, code } = res;
          if (code == 1) {
            console.log(data.data)
            this.tableData = data.data;
            this.total=data.total;
            this.pageSize=data.per_page;
          }
        });
      }
    }
  // }
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
  min-height: 78.5vh;
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
.youhuiquan {
  // background-size:100px  160px;
  margin-left: 70px;
  padding-left: 10px;
  position: relative;
  height: 100px;
  img {
    left: 0;
    position: absolute;
    width: 300px;
  }
  .yhqBox {
    position: absolute;
    z-index: 55;
    display: flex;
    >div{
      &:nth-of-type(1){
        padding: 20px; 
        >div{
          &:nth-of-type(1){
            span{
              color: #03b1d8;
              &:nth-of-type(1){
                font-size: 28px;
                font-weight: 700;
              }
               &:nth-of-type(2){
                font-size: 12px;
              }
            }
          }
          &:nth-of-type(2){
             color: #03b1d8;
          }
        }
      }
      &:nth-of-type(2){
        padding:10px 50px;
        >div{
          font-size: 13px;
          color: #949494;
          &:nth-of-type(1){
            font-size: 16px; 
            color: #5e5e5e;
            font-weight: 700;
          }
        }
      }
    }
  }
}
</style>
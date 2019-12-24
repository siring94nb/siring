<template>
  <div>
    <logginHeader>
      <i class="el-icon-edit"></i>
      <span>角色中心</span>
      <span>&gt;</span>
      <span>等级会员</span>
      <span>&gt;</span>
      <span>{{title}}</span>
    </logginHeader>
    <div class="bottomBox">
      <div class="smBox1">
        <div>
          <span>当前会员等级：</span>
          <span>{{hyTime.name}}</span>
          <i class="el-icon-edit"></i>
        </div>
        <div>
          <span>有效期至：</span>
          <span v-if="hyTime.end_time!=null">2019年12月31日</span>
          <span v-if="hyTime.end_time==null" style="color:red">永久</span>
          <span v-if="hyTime.end_time!=null">续费</span>
        </div>
      </div>
      <div class="smBox2">
        <div class="smBox">
          <div>
            <el-row :gutter="20" v-for="(item,index) in topList" :key="index">
              <el-col :span="8">
                <img :src="item.imgUrl" />
              </el-col>
              <el-col :span="16">
                <div class="tt">{{item.title}}</div>
                <div class="num">￥{{item.num}}</div>
              </el-col>
            </el-row>
          </div>
        </div>
      </div>
      <div>
        <el-tabs v-model="activeName">
          <el-tab-pane label="我邀请的会员明细" name="first" :key="'first'">
            <div>
              <div class="suoyinlan">
                <div class="block">
                  <span>时间：</span>
                  <el-date-picker
                    v-model="value"
                    type="daterange"
                    align="right"
                    unlink-panels
                    range-separator="至"
                    start-placeholder="开始日期"
                    end-placeholder="结束日期"
                  ></el-date-picker>
                </div>
                <div>
                  <span>输入搜索：</span>
                  <input type="text" value v-model="suoyin" />
                  <button @click="gb();GetMemberPartner()">搜索</button>
                </div>
              </div>
              <div class="lijifenxiang">
                <div>立即分享邀请</div>
                <div>
                  注：为确保达标佣金的获得，您还需要邀请
                  <span>3000人</span>
                </div>
              </div>
              <div>
                <el-table
                  ref="multipleTable"
                  :data="list.slice((currpage-1)*pagesize,currpage*pagesize)"
                  tooltip-effect="dark"
                  border
                  style="width: 98.3%"
                  :header-cell-style="{background:'rgb(249,250,252)',color:'#666666',fontWeight: '700'}"
                >
                  <el-table-column type="selection" width="40" align="center"></el-table-column>
                  <el-table-column prop="created_at" label="日期" width="160" align="center"></el-table-column>
                  <el-table-column prop="phone" label="邀请人账号" width="160" align="center">
                    <template slot-scope="scope">
                      <div>{{scope.row.phone.replace(scope.row.phone.substring(3,7),"****")}}</div>
                    </template>
                  </el-table-column>
                  <el-table-column prop="ot_yqm" label="邀请人邀请码" width="150" align="center"></el-table-column>
                  <el-table-column prop="entry_name" label="邀请人订单项目" width="180" align="center"></el-table-column>
                  <el-table-column prop="reach_money" label="邀请人购买金额（元）" width="170" align="center"></el-table-column>
                  <el-table-column prop="bottom_money" label="佣金金额（元）" width="180" align="center"></el-table-column>
                </el-table>
                <div style="text-align: center;margin-top: 30px;" class="sjTiShiBox">
                  <div>
                    <el-checkbox v-model="checked">全选</el-checkbox>
                    <select>
                      <option>数据一</option>
                      <option>数据二</option>
                    </select>
                    <button>确定</button>
                  </div>
                  <div>
                    <!-- <span>共</span><span>{{Math.ceil((list.length+1)/pagesize)}}</span><span>页</span>/<span>{{list.length}}</span><span>条数据</span> -->
                    <!-- <el-pagination background layout="prev, pager, next,jumper"  @current-change="handleCurrentChange" :total="list.length+1" :current-page.sync="DirectlyTo" :page-size="pagesize"></el-pagination> -->
                    <el-pagination
                      @current-change="handleCurrentChange"
                      :current-page="DirectlyTo"
                      :page-sizes="[pagesize]"
                      layout="total, sizes, prev, pager, next, jumper"
                      :total="list.length"
                    ></el-pagination>
                  </div>
                </div>
              </div>
            </div>
          </el-tab-pane>
          <el-tab-pane label="等级会员订单" name="second" :key="'second'">
            <div>
              <div class="lijifenxiang">
                <div>立即分享邀请</div>
                <div>
                  注：为确保达标佣金的获得，您还需要邀请
                  <span>3000人</span>
                </div>
              </div>
              <div>
                <el-table
                  ref="multipleTable"
                  :data="list1.slice((currpage-1)*pagesize,currpage*pagesize)"
                  tooltip-effect="dark"
                  border
                  style="width: 98.3%"
                  :header-cell-style="{background:'rgb(249,250,252)',color:'#666666',fontWeight: '700'}"
                >
                  <el-table-column prop="id" label="会员等级" width="120" align="center"></el-table-column>
                  <el-table-column prop="add_time" label="申请时间" width="120" align="center"></el-table-column>
                  <el-table-column prop="end_time" label="到期时间" width="150" align="center"></el-table-column>
                  <el-table-column prop="money" label="年度费用标准" width="170" align="center"></el-table-column>
                  <el-table-column prop="grade_title	" label="等级政策" width="160" align="center"></el-table-column>
                  <el-table-column prop="pay_type" label="支付方式" width="170" align="center"></el-table-column>
                  <el-table-column prop="StandardCommission" label="操作" width="150" align="center"></el-table-column>
                </el-table>
                <div style="text-align: center;margin-top: 30px;" class="sjTiShiBox">
                  <div>
                    <el-checkbox v-model="checked">全选</el-checkbox>
                    <select>
                      <option>数据一</option>
                      <option>数据二</option>
                    </select>
                    <button>确定</button>
                  </div>
                  <div>
                    <!-- <span>共</span><span>{{Math.ceil((list.length+1)/pagesize)}}</span><span>页</span>/<span>{{list.length}}</span><span>条数据</span> -->
                    <!-- <el-pagination background layout="prev, pager, next,jumper"  @current-change="handleCurrentChange" :total="list.length+1" :current-page.sync="DirectlyTo" :page-size="pagesize"></el-pagination> -->
                    <el-pagination
                      @current-change="handleCurrentChange"
                      :current-page="DirectlyTo"
                      :page-sizes="[pagesize]"
                      layout="total, sizes, prev, pager, next, jumper"
                      :total="list1.length"
                    ></el-pagination>
                  </div>
                </div>
              </div>
            </div>
          </el-tab-pane>
        </el-tabs>
      </div>
    </div>
  </div>
</template>
<script>
import logginHeader from "@/components/logginHeader";
import { GetRoleCenter, MemberTotal, MemberPartner } from "@/api/api";
export default {
  data() {
    return {
      hyTime: {},
      checked: false,
      title: "城市累积会员明细",
      topList: [
        {
          imgUrl: require("../../../assets/images/u7230.png"),
          title: "我邀请的会员总数",
          num: "invite_user_total"
        },
        {
          imgUrl: require("../../../assets/images/u7231.png"),
          title: "城市达标佣金总额",
          num: "reach_user_total"
        }
      ],
      activeName: "first",
      value: "",
      // 邀请分页表格
      list: [],
      list1: [],
      pagesize: 3,
      currpage: 1,
      total: 100,
      DirectlyTo: 1,
      suoyin: "",
      dis: true
    };
  },
  components: {
    logginHeader
  },
  mounted() {
    this.RoleCenter();
    this.GetMemberTotal();
    this.GetMemberPartner();
    this.GetMemberPartner1();
  },
  methods: {
    gb() {
      // 修改状态判断是否有索引条件
      this.dis = false;
    },
    handleEdit(index, row) {
      console.log(index, row);
    },
    handleDelete(index, row) {
      console.log(index, row);
    },
    handleCurrentChange(cpage) {
      this.currpage = cpage;
    },
    handleSizeChange(psize) {
      this.pagesize = psize;
    },
    // 获取等级会员数据
    RoleCenter() {
      const params = {
        type: 2
      };
      GetRoleCenter(params).then(res => {
        let { data, msg, code } = res;
        console.log(res)
        if (code === 1) {
          this.hyTime = data;
        }
      });
    },
    // 获取等级会员列表数据
    GetMemberPartner() {
      let params = {};
      if (this.dis) {
        params = {
          type: 2
        };
      } else {
        let start_time = this.value[0].getTime();
        let end_time = this.value[1].getTime();
        params = {
          type: 2,
          title: this.suoyin,
          start_time: start_time,
          end_time: end_time
        };
      }
      MemberPartner(params).then(res => {
        let { data, msg, code } = res;
        console.log(res)
        if (code === 1) {
          this.list = data;
        }
      });
    },
    GetMemberPartner1() {
      const params = {
        type: 3
      };
      MemberPartner(params).then(res => {
        let { data, msg, code } = res;
        console.log(res)
        if (code === 1) {
          this.list1 = data;
        }
      });
    },
    // 获取我邀请的会员总数，佣金总数，get方式
    GetMemberTotal() {
      MemberTotal().then(res => {
        let { data, msg, code } = res;
        // this.showMsg(msg,code);
        console.log(res)
        if (code === 1) {
          const newArr = this.topList.map(item => {
            item.num = data.data[item.num];
            return item;
          });
          this.topList = newArr;
        }
      });
    }
  },
  watch: {
    activeName: function(val) {
      //监听切换状态-计划单
      if (val === "first") {
        this.title = "我邀请的会员明细";
      } else {
        this.title = "等级会员订单";
      }
    }
  }
};
</script>
<style lang="scss" scoped>
.bottomBox {
  background: #ffffff;
  margin: 5px 0 0 20px;
  padding: 20px 0 0 20px;
  button {
    cursor: pointer;
  }
  .smBox1 {
    border-bottom: 1px solid #cccccc;
    padding-bottom: 10px;
    display: flex;
    justify-content: space-between;
    > div {
      &:nth-of-type(1) {
        span:nth-of-type(1) {
          color: #0099ff;
        }
        span:nth-of-type(2) {
          color: #ff0000;
        }
      }
      &:nth-of-type(2) {
        span {
          &:nth-of-type(1) {
            color: #0099ff;
            padding-right: 5px;
          }
          &:nth-of-type(2) {
            color: #ff0000;
            padding-right: 20px;
          }
          &:nth-of-type(3) {
            background: rgb(102, 153, 0);
            color: #ffffff;
            padding: 5px 10px;
            font-size: 13px;
            border-radius: 5px;
            margin-right: 20px;
          }
        }
      }
    }
  }
  .smBox2 {
    padding-top: 20px;
    .smBox {
      > div {
        display: flex;
        .el-row {
          width: 283px;
          height: 114px;
          box-sizing: border-box;
          padding: 25px 0;
          border: 1px solid rgba(228, 228, 228, 1);
          margin: 0 30px 0 0 !important;
          &:nth-last-child(1) {
            margin-right: 20px !important;
          }
          .tt {
            font-size: 16px;
            color: #999999;
            margin-bottom: 10px;
          }
          .num {
            font-size: 20px;
            color: #666666;
          }
        }
      }
    }
  }
  .suoyinlan {
    display: flex;
    background: rgba(243, 243, 243, 1);
    padding: 10px 0 10px 10px;
    font-size: 13px;
    margin-right: 20px;
    color: #666666;
    .block {
      padding: 0 50px 0 0;
    }
    > div:nth-of-type(2) {
      // padding: 10px  0 0 0;
      input {
        border: 1px solid rgba(228, 228, 228, 1);
        height: 40px;
        width: 200px;
        margin-right: 30px;
      }
      button {
        height: 40px;
        width: 115px;
        color: #ffffff;
        background: rgb(22, 155, 213);
        border: 1px solid rgb(22, 155, 213);
      }
    }
  }
  .lijifenxiang {
    display: flex;
    padding: 10px 0;
    align-items: center;
    div {
      &:nth-of-type(1) {
        color: #ffffff;
        background: rgb(255, 153, 0);
        padding: 15px 30px;
        margin-right: 15px;
      }
      &:nth-of-type(2) {
        font-size: 16px;
        color: #949494;
        span {
          color: #ff0000;
        }
      }
    }
  }
  .sjTiShiBox {
    display: flex;
    align-items: center;
    font-size: 14px;
    background: rgba(253, 253, 254, 1);
    border: 1px solid rgba(228, 228, 228, 1);
    padding: 5px 0 5px 10px;
    margin-bottom: 20px;
    margin-right: 20px;
    > div {
      &:nth-of-type(1) {
        color: #999999;
        margin-right: 50px;
        label {
          margin-right: 20px;
        }
        select {
          padding: 5px;
          width: 114px;
          color: #cccccc;
          margin-right: 15px;
          border: 1px solid rgba(228, 228, 228, 1);
        }
        button {
          padding: 5px 30px;
          font-size: 12px;
          background: #ffffff;
          border: 1px solid rgba(204, 204, 204, 1);
          height: 29px;
        }
      }
      &:nth-of-type(2) {
        display: flex;
        align-items: center;
      }
    }
  }
}
</style>
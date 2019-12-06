<template>
  <div>
    <logginHeader>
      <i class="el-icon-edit"></i>
      <span>角色中心</span>
      <span>&gt;</span>
      <span>城市合伙人</span>
      <span>&gt;</span>
      <span>城市累积会员明细</span>
    </logginHeader>
    <div class="bottomBox">
      <div class="smBox1">
        <span>代理城市：</span>
        <span>深圳</span>
      </div>
      <div class="smBox2">
        <div class="smBox">
          <div>
            <el-row :gutter="20" v-for="(item,index) in topList" :key="index">
              <el-col :span="8">
                <img src="../../../assets/images/leijiSum.png" />
              </el-col>
              <el-col :span="16">
                <div>{{item.title}}</div>
                <div>{{item.num}}</div>
              </el-col>
            </el-row>
          </div>
        </div>
      </div>
      <div>
        <el-tabs v-model="activeName">
          <el-tab-pane label="城市累计会员明细" name="first" :key="'first'">
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
                    :picker-options="pickerOptions"
                  ></el-date-picker>
                </div>
                <div>
                  <span>输入搜索：</span>
                  <input type="text" />
                  <button>搜索</button>
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
                  style="width: 100%"
                >
                  <el-table-column prop="date" label="日期" width="120"></el-table-column>
                  <el-table-column prop="InviterAccount" label="邀请人账号" width="120">
                     <template slot-scope="scope">
                      <div>{{scope.row.InviterAccount.replace(scope.row.InviterAccount.substring(3,7),"****")}}</div>
                    </template>
                  </el-table-column>
                  <el-table-column prop="InviterInvitationCode" label="邀请人邀请码" width="120"></el-table-column>
                  <el-table-column prop="InviterLevel" label="邀请人购买会员等级" width="150"></el-table-column>
                  <el-table-column prop="amount" label="邀请人购买金额（元）" width="120"></el-table-column>
                  <el-table-column prop="MinimumCommissions" label="保底佣金金额（元）" width="120"></el-table-column>
                  <el-table-column prop="StandardCommission" label="达标佣金金额（元）" width="120"></el-table-column>
                </el-table>
                <div style="text-align: center;margin-top: 30px;">
                  <el-pagination
                    background
                    layout="prev, pager, next"
                    :total="total"
                
                  ></el-pagination>
                  <!--     @current-change="current_change" -->
                </div>
              </div>
            </div>
          </el-tab-pane>
          <el-tab-pane label="我邀请的会员明细" name="second" :key="'second'">
            <h1>222</h1>
          </el-tab-pane>
          <el-tab-pane label="合伙人入驻订单" name="third" :key="'third'">
            <h1>3333</h1>
          </el-tab-pane>
        </el-tabs>
      </div>
    </div>
  </div>
</template>
<script>
import logginHeader from "@/components/logginHeader";
export default {
  data() {
    return {
      topList: [
        {
          imgUrl: "../../../assets/images/leijiSum.png",
          title: "城市累计会员总数",
          num: "5000"
        },
        {
          imgUrl: "../../../assets/images/leijiSum.png",
          title: "城市累计会员总数",
          num: "5000"
        },
        {
          imgUrl: "../../../assets/images/leijiSum.png",
          title: "城市累计会员总数",
          num: "5000"
        },
        {
          imgUrl: "../../../assets/images/leijiSum.png",
          title: "城市累计会员总数",
          num: "5000"
        }
      ],
      activeName: "first",
      // 时间范围选择
      pickerOptions: {
        shortcuts: [
          {
            text: "最近一周",
            onClick(picker) {
              const end = new Date();
              const start = new Date();
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
              picker.$emit("pick", [start, end]);
            }
          },
          {
            text: "最近一个月",
            onClick(picker) {
              const end = new Date();
              const start = new Date();
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
              picker.$emit("pick", [start, end]);
            }
          },
          {
            text: "最近三个月",
            onClick(picker) {
              const end = new Date();
              const start = new Date();
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
              picker.$emit("pick", [start, end]);
            }
          }
        ]
      },
      value: "",
      // 邀请分页表格
      list: [
        {"date":"2017-07-19","InviterAccount":"12345678945","InviterInvitationCode":"RJT045","InviterLevel":"黄金","amount":"300","MinimumCommissions":"","StandardCommission":"230"}
      ],
			pagesize: 10,
      currpage: 1,
      total: 0,
    };
  },
  components: {
    logginHeader
  },
  methods: {
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
        }
    }
};
</script>
<style lang="scss" scoped>
.bottomBox {
  background: #ffffff;
  margin: 5px 0 0 20px;
  padding: 20px 0 0 20px;
  .smBox1 {
    border-bottom: 1px solid #cccccc;
    padding-bottom: 10px;
    span:nth-of-type(1) {
      color: #0099ff;
    }
    span:nth-of-type(2) {
      color: #ff0000;
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
          padding: 25px 20px;
          border: 1px solid rgba(228, 228, 228, 1);
          margin: 0 30px 0 0 !important;
          &:nth-last-child(1) {
            margin-right: 20px !important;
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
}
</style>
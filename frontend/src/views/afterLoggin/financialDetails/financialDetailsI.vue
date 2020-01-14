<template>
  <div>
    <logginHeader>
      <i class="iconfont icon--zijinguanli"></i>
      <span>资金管理</span>
      <span>&gt;</span>
      <span>资金明细</span>
    </logginHeader>
    <div class="boxBottom">
      <!-- 条件查找筛选 -->
      <div class="screenX">
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
          <span>收支类型</span>
          <select v-model="selected1">
            <option value="0">全部</option>
            <option value="1">支出</option>
            <option value="2">收入</option>
          </select>
        </div>
        <div>
          <span>账单项目</span>
          <select v-model="selected2">
            <option value="0">全部</option>
            <option value="1">会员订单</option>
            <option value="2">合伙人订单</option>
            <option value="3">分包商订单</option>
            <option value="4">软件定制订单</option>
            <option value="5">AI订单</option>
            <option value="6">投融订单</option>
            <option value="8">Saas订单</option>
            <option value="9">充值</option>
            <option value="10">提现</option>
          </select>
        </div>
        <div>
          <button @click="getCapitalDetailed();">查询</button>
        </div>
      </div>
      <div>
        <div class="invoice">
          <span>剩余可开票金额：</span>
          <span>{{surplusMoney}}元</span>
          <button @click.stop="kaipiaoye">申请开票</button>
          <!-- 点击开票，弹出，发票样单 -->
          <el-dialog :visible.sync="dialogVisible" width="830px">
            <div class="popupBox">
              <div>
                <span>我要开票</span>
                <i class="el-icon-edit"></i>
              </div>
              <div>
                <span>开票金额：</span>
                <input v-model="price" type="text" placeholder="请填写要开票的金额" />
                <span style="color:#000000">元</span>
              </div>
              <div>
                <span>发票类型：</span>
                <label v-for="(item, index) in radioData" :key="index">
                  <input type="radio" v-model="radioVal" :value="item.value" />
                  {{ item.value }}
                </label>
              </div>
              <div>
                <span>发票样式：</span>
                <label>
                  <input type="radio" value="纸质" checked />
                  纸质
                </label>
              </div>
              <div>
                <span>发票抬头：</span>
                <select v-model="selected3" @change="selectFn($event)">
                  <option v-for="(item,index) in items" :value="item.id" :key="index">{{item.name}}</option>
                </select>
                <div>
                  <router-link to="addEnterprise">
                    <i class="el-icon-plus"></i>
                    <span>添加企业身份</span>
                  </router-link>
                </div>
              </div>
              <div>
                <span>发票税号：</span>
                <input type="text" placeholder="请填写企业税号/个人无需提供税号" />
              </div>
              <div>
                <span>邮寄详情：</span>
                <div @click="xiugai">
                  <textarea
                    cols="58"
                    rows="2"
                    ref="textXiugai"
                    :disabled="disabledX"
                    title="点击可修改，回车确认修改"
                    @keydown.stop="keyup_submit"
                    v-model="address"
                  ></textarea>
                </div>
                <!-- <input type="text" title="点击可修改" value="广东省 广州市 天河区 珠吉街道 珠吉路58号津安创意园  (李三  收)    18451401025"> -->
                <!-- <div @click="xiugai"><textarea cols="58" rows="2" ref="textXiugai" :disabled="disabledX" :title="disabledX">广东省 广州市 天河区 珠吉街道 珠吉路58号津安创意园  (李三  收)    18451401025</textarea></div> -->
              </div>
              <div>
                <span>发票类型：</span>
                <label v-for="(item, index) in radioData1" :key="index">
                  <input
                    type="radio"
                    @click="ceshi(item.id)"
                    v-model="radioVal1"
                    :value="item.value"
                  />
                  {{ item.value }}
                </label>
              </div>
              <div>温馨提示：请确认好开票信息，发票一经开出，不再重开！</div>
              <div>
                <div>
                  <div>
                    <span>合计：</span>
                    <span>￥{{parseInt(this.price)+30.00}}</span>
                  </div>
                  <div>
                    <span>税费：</span>
                    <span>￥20.00</span>
                    <span>+</span>
                    <span>快递费：</span>
                    <span>￥10.00</span>
                  </div>
                </div>
                <div>
                  <button>确认</button>
                </div>
              </div>
            </div>
          </el-dialog>
          <!-- 分页表格 -->
          <div style="margin-top:15px;">
            <el-table
              ref="multipleTable"
              :data="tableData"
              tooltip-effect="dark"
              border
              style="width: 100%;font-size: 14px"
              :header-cell-style="{background:'rgb(249,250,252)',color:'#666666',fontWeight: '700'}"
            >
              <el-table-column type="selection" width="40" align="center"></el-table-column>
              <el-table-column prop="created_at" label="日期" width="240" align="center">
                <template slot-scope="scope">
                  <div>{{scope.row.created_at==null?"未知":(new Date(parseInt(scope.row.created_at) * 1000).toLocaleString().replace(/:\d{1,2}$/,' '))}}</div>
                </template>
              </el-table-column>
              <el-table-column prop="income" label="收入（元）" align="center" width="240">
                <template slot-scope="scope">
                  <div>{{scope.row.income==null?0:scope.row.income}}</div>
                </template>
              </el-table-column>
              <el-table-column prop="phone" align="center" width="240" label="收入账号"></el-table-column>
              <el-table-column prop="money" label="支出（元）" align="center" width="240">
                <template slot-scope="scope">
                  <div>{{scope.row.money==null?0:scope.row.income}}</div>
                </template>
              </el-table-column>
              <el-table-column prop="pay_type" align="center" label="支付类型">
                <template slot-scope="scope">
                  <div v-if="scope.row.pay_type == 1||scope.row.pay_type == null">支付宝</div>
                  <div v-if="scope.row.pay_type == 2">微信</div>
                  <div v-if="scope.row.pay_type == 3">汇款</div>
                  <div v-if="scope.row.pay_type == 4">余额</div>
                </template>
              </el-table-column>
            </el-table>
            <div style="text-align: center;margin-top: 30px;" class="sjTiShiBox">
              <div>
                <el-pagination
                  @current-change="handleCurrentChange"
                  :current-page="DirectlyTo"
                  :page-sizes="[pagesize]"
                  layout="total, sizes, prev, pager, next, jumper"
                  :total="total"
                ></el-pagination>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import logginHeader from "@/components/logginHeader";
import {
  CapitalDetailed,
  InvoiceAmount,
  MyInvoice,
  GetEnterprise
} from "@/api/api";
export default {
  data() {
    return {
      dialogVisible: false,
      dis: true,
      // 分页表格参数
      pagesize: 10,
      currpage: 1,
      total: 100,
      DirectlyTo: 1,
      // select参数
      selected1: "0",
      selected2: "0",
      items: [], //企业列表
      selected3: "",
      value: undefined, //时间选择
      startTime: "",
      endTime: "",
      // 单选框
      radioData: [{ value: "企业" }, { value: "个人" }],
      radioVal: "企业",
      //发票种类
      radioData1: [
        {
          id: 0,
          value: "普通发票（电子发票）"
        },
        {
          id: 1,
          value: "普通发票（纸质发票）"
        },
        {
          id: 2,
          value: "专用发票"
        },
        {
          id: 3,
          value: "收购发票（电子票）"
        },
        {
          id: 4,
          value: "收购发票（纸质发票）"
        }
      ],
      radioVal1: "普通发票（电子发票）",
      fpys: "纸质",
      disabledX: true, //地址输入框禁用
      surplusMoney: "",
      // 表格数据占位
      tableData: [],
      price: 0,
      address:
        "广东省 广州市 天河区 珠吉街道 珠吉路58号津安创意园  (李三  收)    18451401025"
    };
  },
  components: {
    logginHeader
  },
  mounted() {
    this.getInvoiceAmount();
    this.Enterprise();
    this.getCapitalDetailed();
  },
  methods: {
    // 发票类型
    gbfplx(num) {
      // console.log(num)
      this.radioVal1 = parseInt(num);
    },
    gb() {
      // 修改状态判断是否有索引条件
      if (this.selected1 == "0" && this.selected2 == "0" && this.value == "") {
        this.dis = true;
      } else if (
        this.value == null &&
        this.selected1 == "0" &&
        this.selected2 == "0"
      ) {
        this.dis = true;
        this.value = "";
      } else {
        this.dis = false;
      }
    },
    handleCurrentChange(cpage) {
      this.currpage = cpage;
    },
    handleSizeChange(psize) {
      this.pagesize = psize;
    },
    // 获取资金明细数据
    getCapitalDetailed() {
      let params = {};
      if (this.value != undefined && this.value != null) {
        // console.log(this.value);
        this.startTime = this.value[0].getTime();
        this.endTime = this.value[1].getTime();
        params = {
          budget_type: this.selected1 == 0 ? "" : parseInt(this.selected1),
          role_type: this.selected2 == 0 ? "" : parseInt(this.selected2),
          page: parseInt(this.currpage),
          start_time: parseInt(this.startTime),
          end_time: parseInt(this.endTime)
        };
      } else {
        params = {
          budget_type: this.selected1 == 0 ? "" : parseInt(this.selected1),
          role_type: this.selected2 == 0 ? "" : parseInt(this.selected2),
          page: parseInt(this.currpage)
        };
      }
      params = {
        budget_type: this.selected1 == 0 ? "" : parseInt(this.selected1),
        role_type: this.selected2 == 0 ? "" : parseInt(this.selected2),
        page: parseInt(this.currpage),
        start_time: parseInt(this.startTime),
        end_time: parseInt(this.endTime)
      };
      CapitalDetailed(params).then(res => {
        let { data, msg, code } = res;
        if (code === 1) {
          this.tableData = data.data;
          this.pagesize = data.per_page;
          this.total = data.total;
        }
      });
      // let times = this.value;
      // let start_time = this.value[0];
      // let end_time = this.value[1];
      // if (this.dis) {
      //   CapitalDetailed().then(res => {
      //     let { data, msg, code } = res;
      //     if (code === 1) {
      //       this.pagesize = data.per_page;
      //       this.tableData = data.data;
      //     }
      //   });
      // } else {
      //   if (this.value == "") {
      //     params = {
      //       budget_type: this.selected1,
      //       role_type: this.selected2
      //     };
      //     this.dis = true;
      //   } else if (this.selected1 == "0" && this.value != null) {
      //     let start_time = this.value[0];
      //     let end_time = this.value[1];
      //     params = {
      //       role_type: this.selected2,
      //       start_time: start_time.getTime(),
      //       end_time: end_time.getTime()
      //     };
      //     this.dis;
      //   } else {
      //      let start_time = this.value[0];
      //     let end_time = this.value[1];
      //     params = {
      //       budget_type: this.selected1,
      //       role_type: this.selected2,
      //       start_time: this.value[0].getTime(),
      //       end_time: this.value[1].getTime()
      //     };
      //     this.dis = true;
      //   }
      //   CapitalDetailed(params).then(res => {
      //     let { data, msg, code } = res;
      //     if (code === 1) {
      //       this.tableData = data.data;
      //     }
      //   });
      // }
    },
    // 剩余开票金额
    getInvoiceAmount() {
      InvoiceAmount().then(res => {
        let { data, msg, code } = res;
        console.log(data);
        if (code === 1) {
          this.surplusMoney = data;
        } else {
          this.surplusMoney = 0;
        }
      });
    },
    // 开票
    getMyInvoice() {
      let params = {
        price: this.price,
        type: this.radioVal == "企业" ? 1 : 2,
        status: 2,
        rise: this.selected3,
        invoiceLine: parseInt(this.radioVal1),
        address: this.address
      };
      MyInvoice(params).then(res => {
        let { data, msg, code } = res;
        console.log(data);
        if (code === 1) {
          this.surplusMoney = data;
        } else {
          this.surplusMoney = 0;
        }
      });
    },
    // 点击输入框，释放禁用
    xiugai() {
      // console.log(121231)
      this.disabledX = false;
    },
    // 修改地址，回车确认事件
    keyup_submit(e) {
      var evt = window.event || e;
      if (evt.keyCode == 13) {
        //回车事件
        // console.log(11111)
        this.disabledX = true;
      }
    },
    // 控制开票页显隐
    kaipiaoye() {
      // let gb = document.getElementsByClassName("popupBox")[0];
      // if (gb.style.display === "none") {
      //   gb.style.display = "block";
      // } else {
      //   gb.style.display = "none";
      // }
      this.dialogVisible = true;
    },
    // 企业列表信息
    selectFn(e) {
      this.selected3 = e.target.value;
    },
    Enterprise() {
      let userId = sessionStorage.getItem("user_id");
      let params = { user_id: userId };
      GetEnterprise(params).then(res => {
        let { data, msg, code } = res;
        if (code === 1) {
          console.log(data);
          this.items = data;
        }
      });
    }
  }
};
</script>
<style lang="scss" scoped>
.boxBottom {
  background: #ffffff;
  padding: 10px;
  margin: 10px 0 0 20px;
  min-height: 80vh;
  .screenX {
    display: flex;
    background: #f3f3f3;
    border-left: 3px solid #ff0000;
    padding: 10px;
    font-size: 13px;
    color: #666666;
    align-items: center;
    margin-bottom: 10px;
    > div {
      margin-right: 20px;
      &:nth-of-type(2) {
        span {
          padding-right: 10px;
        }
        select {
          padding: 8px 5px;
          width: 127px;
        }
      }
      &:nth-of-type(3) {
        margin-right: 520px;
        span {
          padding-right: 10px;
        }
        select {
          padding: 8px 5px;
          width: 127px;
        }
      }
      &:nth-of-type(4) {
        margin: 0;
        button {
          background: rgb(230, 45, 49);
          color: #ffffff;
          padding: 10px 20px;
          border-radius: 5px;
          border: 1px solid #ff0000;
        }
      }
    }
  }
  .invoice {
    position: relative;
    span {
      color: #5e5e5e;
      font-size: 13px;
      &:nth-of-type(2) {
        color: #ff0000;
        font-size: 18px;
        padding-right: 20px;
      }
    }
    button {
      background: rgb(22, 155, 213);
      color: #ffffff;
      border: 1px solid rgb(22, 155, 213);
      padding: 5px 15px;
      border-radius: 3px;
    }
    .popupBox {
      // z-index: 5;
      font-size: 18px;
      color: #a1a1a1;
      // position: absolute;
      background: #ffffff;
      // padding: 35px;
      border-radius: 10px;
      width: 790px;
      // top: 50px;
      // left: 180px;
      > div {
        margin-bottom: 25px;
        &:nth-of-type(1) {
          border-bottom: 1px solid rgb(188, 188, 188);
          padding-bottom: 20px;
          display: flex;
          justify-content: space-between;
          span {
            font-size: 28px;
            font-weight: 700;
          }
          i {
            font-size: 32px;
          }
        }
        &:nth-of-type(2) {
          input {
            padding: 10px 5px;
            margin-right: 20px;
          }
        }
        > span {
          font-size: 18px;
          &:nth-of-type(1) {
            color: #000000;
            padding-right: 20px;
          }
        }
        &:nth-of-type(3) {
          label:nth-of-type(1) {
            margin-right: 100px;
          }
        }
        &:nth-of-type(5) {
          display: flex;
          align-items: center;
          select {
            width: 286px;
            padding: 10px 0;
            margin-right: 10px;
          }
          > div {
            border: 1px solid rgba(14, 144, 210, 1);
            // color:#35BDFF;
            border-radius: 5px;
            padding: 10px;
            span,
            i {
              color: #35bdff;
              font-size: 13px;
            }
          }
        }
        &:nth-of-type(6) {
          input {
            width: 417px;
            padding: 10px 5px;
          }
        }
        &:nth-of-type(7) {
          display: flex;
          align-items: center;
          textarea {
            border: none;
          }
          textarea[disabled] {
            background: #ffffff;
          }
        }
        &:nth-of-type(8) {
          label {
            &:nth-of-type(1),
            &:nth-of-type(2),
            &:nth-of-type(3) {
              padding-right: 50px;
            }
            &:nth-of-type(4) {
              padding: 0 68px 0 110px;
            }
          }
        }
        &:nth-of-type(9) {
          font-size: 13px;
          color: #ff0000;
          border-bottom: 1px solid rgb(188, 188, 188);
          padding: 0 0 5px 0;
        }
        &:nth-of-type(10) {
          display: flex;
          justify-content: flex-end;
          div {
            &:nth-of-type(1) {
              margin-right: 20px;
              div {
                &:nth-of-type(1) {
                  span {
                    color: #ff0000;
                    &:nth-of-type(1) {
                      font-size: 18px;
                    }
                    &:nth-of-type(2) {
                      font-size: 28px;
                    }
                  }
                }
                &:nth-of-type(2) {
                  span {
                    font-size: 12px;
                    color: #333333;
                    padding: 0;
                  }
                }
              }
            }
            &:nth-of-type(2) {
              button {
                background: #ff0000;
                width: 152px;
                border: 1px solid #ff0000;
                padding: 10px 0;
                font-size: 16px;
              }
            }
          }
        }
      }
    }
  }
}
</style>
<style lang="scss">
.popupBox {
  .el-dialog__body {
    width: 100px !important;
  }
}
</style>
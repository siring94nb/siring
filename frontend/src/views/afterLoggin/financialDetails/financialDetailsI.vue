<template>
  <div>
    <logginHeader>
      <i class="el-icon-edit"></i>
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
            :picker-options="pickerOptions"
          ></el-date-picker>
        </div>
        <div>
          <span>收支类型</span>
          <select v-model="selected1">
            <option value="全部">全部</option>
            <option value="测试1">测试1</option>
            <option value="测试2">测试2</option>
          </select>
        </div>
        <div>
          <span>账单项目</span>
          <select v-model="selected2">
            <option value="全部">全部</option>
          </select>
        </div>
        <div>
          <button>查询</button>
        </div>
      </div>
      <div>
        <div class="invoice">
          <span>剩余可开票金额：</span>
          <span>85875元</span>
          <button @click.stop="kaipiaoye">申请开票</button>
          <!-- 点击开票，弹出，发票样单 -->
          <div class="popupBox" style="display:none;">
            <div>
              <span>我要开票</span>
              <i class="el-icon-edit" @click.stop="kaipiaoye"></i>
            </div>
            <div>
              <span>开票金额：</span>
              <input type="text" placeholder="请填写要开票的金额" />
              <span style="color:#000000">元</span>
            </div>
            <div>
              <span>发票类型：</span>
              <label v-for="(item, index) in radioData" :key="index">
                <input
                  type="radio"
                  v-model="radioVal"
                  :value="item.value"
                  @click="getRadioVal(item.value)"
                />
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
              <select v-model="selected3">
                <option value="深圳市沃达峰">深圳市沃达峰</option>
                <option value="深圳市思锐">深圳市思锐</option>
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
                >广东省 广州市 天河区 珠吉街道 珠吉路58号津安创意园  (李三  收)    18451401025</textarea>
              </div>
              <!-- <input type="text" title="点击可修改" value="广东省 广州市 天河区 珠吉街道 珠吉路58号津安创意园  (李三  收)    18451401025"> -->
              <!-- <div @click="xiugai"><textarea cols="58" rows="2" ref="textXiugai" :disabled="disabledX" :title="disabledX">广东省 广州市 天河区 珠吉街道 珠吉路58号津安创意园  (李三  收)    18451401025</textarea></div> -->
            </div>
            <div>
              <span>发票类型：</span>
              <label v-for="(item, index) in radioData1" :key="index">
                <input
                  type="radio"
                  v-model="radioVal1"
                  :value="item.value"
                  @click="getRadioVal(item.value)"
                />
                {{ item.value }}
              </label>
            </div>
            <div>温馨提示：请确认好开票信息，发票一经开出，不再重开！</div>
            <div>
              <div>
                <div>
                  <span>合计：</span>
                  <span>￥30.00</span>
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
          <!-- 分页表格 -->
          <div style="margin-top:15px;">
            <el-table
              ref="multipleTable"
              :data="tableData.slice((currpage-1)*pagesize,currpage*pagesize)"
              tooltip-effect="dark"
              border
              style="width: 100%;font-size: 12px"
              :header-cell-style="{background:'rgb(249,250,252)',color:'#666666',fontWeight: '700'}"
            >
              <el-table-column type="selection" width="40" align="center"></el-table-column>
              <el-table-column prop="date" label="日期" width="180" align="center"></el-table-column>
              <el-table-column prop="name" label="收入（元）" align="center" width="160"></el-table-column>
              <el-table-column prop="address" align="center" width="180" label="收入账号"></el-table-column>
              <el-table-column prop="date" label="支出（元）" align="center" width="180"></el-table-column>
              <el-table-column prop="name" label="支出账号" align="center" width="180"></el-table-column>
              <el-table-column prop="address" align="center" label="账单项目"></el-table-column>
            </el-table>
            <div style="text-align: center;margin-top: 30px;" class="sjTiShiBox">
              <div>
                <el-pagination
                  @current-change="handleCurrentChange"
                  :current-page="DirectlyTo"
                  :page-sizes="[pagesize]"
                  layout="total, sizes, prev, pager, next, jumper"
                  :total="tableData.length"
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
export default {
  data() {
    return {
      // 分页表格参数
      pagesize: 6,
      currpage: 1,
      total: 100,
      DirectlyTo: 1,
      // select参数
      selected1: "全部",
      selected2: "全部",
      selected3: "深圳市沃达峰",
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
      // 单选框
      radioData: [{ value: "企业" }, { value: "个人" }],
      radioVal: "企业",
      //发票种类
      radioData1: [{ value: "普通发票" }, { value: "增值税发票" }],
      radioVal1: "普通发票",
      fpys: "纸质",
      disabledX: true, //地址输入框禁用
      // 表格数据占位
      tableData: [
        {
          date: "2017-07-19 14:48:38 ",
          name: "3000.00",
          address: "招商银行：838383399399"
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
      ]
    };
  },
  components: {
    logginHeader
  },
  methods: {
    handleCurrentChange(cpage) {
      this.currpage = cpage;
    },
    handleSizeChange(psize) {
      this.pagesize = psize;
    },
    getRadioVal(value) {
      console.log(value);
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
      let gb = document.getElementsByClassName("popupBox")[0];
      if (gb.style.display === "none") {
        gb.style.display = "block";
      } else {
        gb.style.display = "none";
      }
    }
  }
};
</script>
<style lang="scss" scoped>
.boxBottom {
  background: #ffffff;
  padding: 10px;
  margin: 10px 0 0 20px;
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
        margin-right: 160px;
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
      z-index: 5;
      font-size: 18px;
      color: #a1a1a1;
      position: absolute;
      background: #ffffff;
      padding: 35px;
      border-radius: 10px;
      width: 614px;
      top: 50px;
      left: 180px;
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
            &:nth-of-type(1) {
              padding-right: 70px;
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
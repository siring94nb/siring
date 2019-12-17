<template>
  <div>
    <logginHeader>
      <i class="el-icon-edit"></i>
      <span>角色中心</span>
      <span>&gt;</span>
      <span>分包商</span>
      <span>&gt;</span>
      <span>{{title}}</span>
    </logginHeader>
    <div class="bottomBox">
      <div class="smBox1">
        <div>
          <span>我的专业技能：</span>
          <span>后端开发：</span>
          <span style="padding-right:20px;">Java</span>
          <span>移动开发：</span>
          <span>ios</span>
        </div>
        <div>
          <span>有效期至：</span>
          <span>永久</span>
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
                <div class="num">{{item.num}}</div>
              </el-col>
            </el-row>
          </div>
          <!-- 分包项目视窗 -->
          <div class="fengbaoshang" :style="{'display':fbxm}">
            <div>分包项目</div>
            <div>
              <div class="fengbaoName">
                <span>
                  项目名称：
                  <span>直播电商</span>
                </span>
                <span>
                  酬金：
                  <span style="color:#ff0000">￥100000</span>
                </span>
                <span>
                  预计时间：
                  <span>20190819至20191019</span>
                </span>
              </div>
              <div>
                <div>功能需求：</div>
                <div>开发需求响应型公交系统,是雄安交通先行示范区的一大亮点,是为了推行需求即时响应、一人一座、免换乘的高品质公交服务系统。 交通专班相关开发需求响应型公交系统,是雄安交通先行示范区的一大亮点,了……</div>
              </div>
              <div style="display: flex; justify-content:space-between">
                <div style="color: #FF9900;">详情</div>
                <div>
                  <span
                    style="padding-right:30px;color: #66CC00; cursor:pointer"
                    @click.stop="ShowHidden"
                  >我要接单</span>
                  <span style="color: #169BD5; padding-right:10px;">下一条</span>
                </div>
              </div>
              <!-- display: none; -->
              <div class="orderReceiving" ref="orderReceiving" style="display:none">
                <div class="triangle"></div>
                <div>
                  <div>
                    <span>请确认联系方式</span>
                    <span style="float:right">
                      <i class="el-icon-edit" @click.stop="ShowHidden"></i>
                    </span>
                  </div>
                  <div>
                    <div>
                      <span>
                        <span>手机号：</span>
                        <span title="点击可修改" @click.stop="xiugai('phone')">
                          <input
                            type="text"
                            value
                            v-model="phone"
                            disabled="true"
                            ref="phone"
                            maxlength="11"
                          />
                        </span>
                        <!-- 方法传递参数，例如此处传递，phone，下放if判断，然后修改相应的input框的disabled值 -->
                        <span
                          class="confirm"
                          ref="confirm"
                          style="display:none"
                          @click.stop="affirmBtn('phone')"
                        >确定</span>
                        <span class="ac active" @click.stop="firstChoice('phone')">首选</span>
                      </span>
                    </div>
                    <div>
                      <span>
                        <span>微信号：</span>
                        <span title="点击可修改" @click.stop="xiugai('WXnum')">
                          <input
                            type="text"
                            value
                            v-model="WXnum"
                            disabled="true"
                            ref="WXnum"
                            maxlength="11"
                          />
                        </span>
                        <span
                          class="confirm"
                          ref="confirm"
                          style="display:none"
                          @click.stop="affirmBtn('WXnum')"
                        >确定</span>
                        <span class="ac" @click.stop="firstChoice('WXnum')">首选</span>
                      </span>
                    </div>
                    <div>
                      <span>
                        <span>QQ号：</span>
                        <span title="点击可修改" @click.stop="xiugai('QQnum')">
                          <input
                            type="text"
                            value
                            v-model="QQnum"
                            disabled="true"
                            ref="QQnum"
                            maxlength="11"
                          />
                        </span>
                        <span
                          class="confirm"
                          ref="confirm"
                          style="display:none"
                          @click.stop="affirmBtn('QQnum')"
                        >确定</span>
                        <span class="ac" @click.stop="firstChoice('QQnum')">首选</span>
                      </span>
                    </div>
                  </div>
                  <button class="confirmBtn">确定，我要接单联系我吧！</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div>
        <el-tabs v-model="activeName">
          <el-tab-pane label="我承接的项目明细" name="first" :key="'first'">
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
              <div>
                <el-table
                  ref="multipleTable"
                  :data="list.slice((currpage-1)*pagesize,currpage*pagesize)"
                  tooltip-effect="dark"
                  border
                  style="width: 98.3%"
                  :header-cell-style="{background:'rgb(249,250,252)',color:'#666666',fontWeight: '700'}"
                  @selection-change="handleSelectionChange"
                >
                  <el-table-column type="selection" width="40" align="center"></el-table-column>
                  <el-table-column prop="date" label="项目订单编号" width="130" align="center"></el-table-column>
                  <el-table-column prop="InviterAccount" label="订单名称" width="130" align="center"></el-table-column>
                  <el-table-column
                    prop="InviterInvitationCode"
                    label="承接时间"
                    width="170"
                    align="center"
                  ></el-table-column>
                  <el-table-column prop="InviterLevel" label="要求完成时间" width="160" align="center"></el-table-column>
                  <el-table-column prop="amount" label="项目开发文档" width="160" align="center"></el-table-column>
                  <el-table-column
                    prop="MinimumCommissions"
                    label="延期扣款"
                    width="125"
                    align="center"
                  ></el-table-column>
                  <el-table-column
                    prop="StandardCommission"
                    label="佣金金额（元）"
                    width="125"
                    align="center"
                  ></el-table-column>
                </el-table>
                <div style="text-align: center;margin-top: 30px;" class="sjTiShiBox">
                  <div>
                    <el-checkbox class="quanxuan" @change="toggleSelection(list)">全选</el-checkbox>
                    <select>
                      <option>数据一</option>
                      <option>数据二</option>
                    </select>
                    <button>确定</button>
                  </div>
                  <div>
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
          <el-tab-pane label="分包商申请订单" name="second" :key="'second'">
            <div>
              <div style="padding-bottom:20px;">
                <el-table
                  :data="list.slice((currpage-1)*pagesize,currpage*pagesize)"
                  tooltip-effect="dark"
                  border
                  style="width: 98.3%"
                  :header-cell-style="{background:'rgb(249,250,252)',color:'#666666',fontWeight: '700'}"
                >
                  <el-table-column prop="date" label="申请专业技能" width="200" align="center"></el-table-column>
                  <el-table-column prop="InviterAccount" label="技能语言" width="220" align="center"></el-table-column>
                  <el-table-column
                    prop="InviterInvitationCode"
                    label="申请时间"
                    width="220"
                    align="center"
                  ></el-table-column>
                  <el-table-column prop="InviterLevel" label="技能押金" width="200" align="center"></el-table-column>
                  <el-table-column prop="amount" label="支付方式" width="200" align="center"></el-table-column>
                </el-table>
              </div>
            </div>
          </el-tab-pane>
        </el-tabs>
      </div>
    </div>
    <div class="aba"></div>
  </div>
</template>
<script>
import logginHeader from "@/components/logginHeader";
import { GetRoleCenter } from "@/api/api";
export default {
  data() {
    return {
      multipleSelection: [],
      phone: "12345678912",
      WXnum: "12345674891",
      QQnum: "12345678912",
      title: "我承接的项目明细",
      topList: [
        {
          imgUrl: require("../../../assets/images/u8228.png"),
          title: "我的剩余押金",
          num: "￥5000.00"
        },
        {
          imgUrl: require("../../../assets/images/u7231.png"),
          title: "佣金总额",
          num: "￥500.00"
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
        {
          date: "SR20170719",
          InviterAccount: "B2C购物商城",
          InviterInvitationCode: "2017-07-19 14:48:38",
          InviterLevel: "2017-07-19 14:48:38",
          amount: "http://uqaovd.share.axure.org    ",
          MinimumCommissions: "",
          StandardCommission: ""
        },
        {
          date: "SR20170719",
          InviterAccount: "B2C购物商城",
          InviterInvitationCode: "2017-07-19 14:48:38",
          InviterLevel: "2017-07-19 14:48:38",
          amount: "http://uqaovd.share.axure.org    ",
          MinimumCommissions: "",
          StandardCommission: ""
        },
        {
          date: "SR20170719",
          InviterAccount: "B2C购物商城",
          InviterInvitationCode: "2017-07-19 14:48:38",
          InviterLevel: "2017-07-19 14:48:38",
          amount: "http://uqaovd.share.axure.org    ",
          MinimumCommissions: "",
          StandardCommission: ""
        },
        {
          date: "SR20170719",
          InviterAccount: "B2C购物商城",
          InviterInvitationCode: "2017-07-19 14:48:38",
          InviterLevel: "2017-07-19 14:48:38",
          amount: "http://uqaovd.share.axure.org    ",
          MinimumCommissions: "",
          StandardCommission: ""
        }
      ],
      pagesize: 3,
      currpage: 1,
      total: 100,
      DirectlyTo: 1,
      fbxm: "flex" //控制分包项目位置显示隐藏
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
    // 根据官网制作全选功能
    /*
    *Element-ui 中table 默认选中 toggleRowSelection
    *结合vue的特殊属性ref引用到Dom元素上，再执行dom上的toggleRowSelection方法。
    *toggleRowSelection(row, selected)接受两个参数，row传递被勾选行的数据，selected设置是否选中
    *注意：调用toggleRowSelection这个方法 需要获取真实dom 所以需要注册 ref 来引用它 
     */
    toggleSelection(rows) {
      // 当前有问题，会串联，虽然能实现全选全不选功能，但是但已有部分选中时会出现正反选的效果而不是全选
      if (rows) {
        rows.forEach(row => {
          console.log(this.$refs.multipleTable)
          this.$refs.multipleTable.toggleRowSelection(row);
        });
      } else {
        //  console.log(this.$refs.multipleTable.toggleRowSelection)
        this.$refs.multipleTable.clearSelection();
      }
    },
    handleSelectionChange(val) {
      this.multipleSelection = val;
    },    
    // 获取分包商数据
    RoleCenter() {
      const params = {
        type: 1
      };
      GetRoleCenter(params).then(res => {
        let { data, msg, code } = res;
        this.showMsg(msg, code);
        if (code === 1) {
          this.handleClose();
        }
      });
    },
    // 控制我要联系显示隐藏
    ShowHidden() {
      let dp = this.$refs.orderReceiving.style;
      // dp.display = "none"
      if (dp.display === "" || dp.display === "none") {
        dp.display = "block";
      } else {
        dp.display = "none";
      }
      //  this.$refs.orderReceiving.style.display = "none";
    },
    // 修改电话显示确认按钮显示隐藏
    xiugai(src) {
      let spanArr = document.getElementsByClassName("confirm");
      if (src === "phone") {
        spanArr[0].style.display = "inline-block";
        this.$refs.phone.disabled = false;
        this.$refs.phone.focus();
      } else if (src === "WXnum") {
        spanArr[1].style.display = "inline-block";
        this.$refs.WXnum.disabled = false;
        this.$refs.WXnum.focus();
      } else {
        spanArr[2].style.display = "inline-block";
        this.$refs.QQnum.disabled = false;
        this.$refs.QQnum.focus();
      }
    },
    // 修改完成，确定，控制输入框禁用，确认按钮消失
    affirmBtn(src) {
      let spanArr = document.getElementsByClassName("confirm");
      if (src === "phone") {
        spanArr[0].style.display = "none";
        this.$refs.phone.disabled = true;
      } else if (src === "WXnum") {
        spanArr[1].style.display = "none";
        this.$refs.WXnum.disabled = true;
      } else {
        spanArr[2].style.display = "none";
        this.$refs.QQnum.disabled = true;
      }
    },
    // 首选项选择
    firstChoice(src) {
      let spanArr = document.getElementsByClassName("ac");
      if (src === "phone") {
        spanArr[0].classList.add("active");
        spanArr[1].classList.remove("active");
        spanArr[2].classList.remove("active");
      } else if (src === "WXnum") {
        spanArr[1].classList.add("active");
        spanArr[0].classList.remove("active");
        spanArr[2].classList.remove("active");
      } else {
        spanArr[2].classList.add("active");
        spanArr[1].classList.remove("active");
        spanArr[0].classList.remove("active");
      }
    }
  },
  watch: {
    activeName: function(val) {
      //监听切换状态-计划单
      if (val === "first") {
        this.title = "我承接的项目明细";
        this.fbxm = "flex";
        // console.log(this.fbxm)
      } else if (val === "second") {
        this.title = "分包商申请订单";
        this.fbxm = "none";
        //  console.log(this.fbxm)
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
        }
      }
    }
  }
  .smBox2 {
    padding-top: 20px;
    .smBox {
      display: flex;
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
      .fengbaoshang {
        position: relative;
        font-size: 13px;
        color: #5e5e5e;
        > div {
          &:nth-of-type(1) {
            background: rgba(102, 204, 255, 1);
            color: #ffffff;
            font-size: 14px;
            line-height: 26px;
            text-align: center;
            margin-right: 20px;
          }
          &:nth-of-type(2) {
            > div {
              margin-bottom: 10px;
              &:nth-last-child(1) {
                margin-bottom: 0;
              }
            }
          }
        }
        .orderReceiving {
          position: absolute;
          background: #ffffff;
          color: #000000;
          z-index: 5;
          border: 1px solid #cccccc;
          border-radius: 5px;
          padding: 20px 50px;
          // 三角形绘制
          // .triangle {
          //   width: 0;
          //   height: 0;
          //   border: 40px solid #ffffff;
          //   border-bottom-color: #ffffff;
          //   border-top: none;
          //   border-left-color: transparent;
          //   border-right-color: transparent;
          //   color: #ffffff;
          // }
          .confirmBtn {
            background: rgba(22, 155, 213, 1);
            color: #ffffff;
            border-radius: 5px;
            border: 1px solid rgba(22, 155, 213, 1);
            padding: 10px 20px;
            margin: 10px 0 10px 30px;
          }
          > div {
            &:nth-of-type(2) {
              > div {
                &:nth-of-type(1) {
                  border-bottom: 1px solid #cccccc;
                  padding-bottom: 10px;
                  margin-bottom: 20px;
                  span {
                    &:nth-of-type(1) {
                      font-size: 28px;
                      padding-right: 50px;
                    }
                    &:nth-of-type(2) {
                      font-size: 32px;
                    }
                  }
                }
                &:nth-of-type(2) {
                  font-size: 18px;
                  border-bottom: 1px solid #cccccc;
                  padding-bottom: 10px;
                  > div {
                    margin-bottom: 30px;
                    &:nth-last-child(1) {
                      margin: 0;
                    }
                    > span {
                      > span {
                        &:nth-of-type(1) {
                          display: inline-block;
                          width: 72px;
                        }
                        &:nth-of-type(2) {
                          color: #868686;
                          padding: 0 10px;
                          input {
                            background: #ffffff;
                            border: none;
                            font-size: 18px;
                            width: 120px;
                          }
                        }
                        &:nth-of-type(3),
                        &:nth-of-type(4) {
                          font-size: 13px;
                          display: inline-block;
                          padding: 5px;
                          border-radius: 5px;
                          cursor: pointer;
                        }
                      }
                    }
                    .ac {
                      color: #e4e4e4;
                      border: 1px solid #e4e4e4;
                    }
                    .active {
                      color: #66cc00;
                      border: 1px solid #66cc00;
                    }
                    .confirm {
                      color: #66cc00;
                      border: 1px solid #66cc00;
                      margin-right: 15px;
                    }
                  }
                }
              }
            }
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
<template>
  <div>
    <logginHeader>
      <i class="iconfont icon-jiaose"></i>
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
          <span v-for="(item,index) in skillArr.name" :key="index">{{item.skillValue}}{{item.lang}}</span>
        </div>
        <div>
          <span>有效期至：</span>
          <span v-if="skillArr.end_time!=null">2019年12月31日</span>
          <span v-if="skillArr.end_time==null" style="color:red">永久</span>
          <span v-if="skillArr.end_time!=null">续费</span>
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
          <!-- 分包项目视窗 -->
          <!-- <div class="fengbaoshang" :style="{'display':fbxm}"> -->
             <div class="fengbaoshang" :style="{'display':fbxm}">
            <div>分包项目视窗</div>
            <!-- <div>
              <div class="fengbaoName">
                <span>
                  项目名称：
                  <span>{{shichuang[0].name}}</span>
                </span>
                <span>
                  酬金：
                  <span style="color:#ff0000">￥100000</span>
                </span>
                <span>
                  预计时间：
                  <span>{{shichuang[0].created_at}}</span>
                </span>
              </div>
              <div>
                <div>功能需求：</div>
                <div v-html="shichuang[0].con"></div>
              </div>
              <div style="display: flex; justify-content:space-between">
                <div style="color: #FF9900;">详情</div>
                <div>
                  <span
                    style="padding-right:30px;color: #66CC00; cursor:pointer"
                    @click.stop="ShowHidden"
                  >我要接单</span>
                  <span
                    style="color: #169BD5; padding-right:10px;"
                    v-if="lastpage==1"
                    @click="GetSubView(lastpage-1)"
                  >上一条</span>
                  <span
                    style="color: #169BD5; padding-right:10px; cursor: pointer;"
                    @click="GetSubView(lastpage+1)"
                  >下一条</span>
                </div>
              </div>
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
                  <button class="confirmBtn" @click="jiedan(shichuang.id)">确定，我要接单联系我吧！</button>
                </div>
              </div>
            </div>-->
            <div v-for="(item,index) in shichuang" :key="index">
              <div class="fengbaoName">
                <span>
                  项目名称：
                  <span>{{item.name}}</span>
                </span>
                <span>
                  酬金：
                  <span style="color:#ff0000">￥100000</span>
                </span>
                <span>
                  预计时间：
                  <span>{{item.created_at}}</span>
                </span>
              </div>
              <div>
                <div>功能需求：</div>
                <div v-html="item.con"></div>
              </div>
              <div style="display: flex; justify-content:space-between">
                <div style="color: #FF9900;">详情</div>
                <div>
                  <span
                    style="padding-right:30px;color: #66CC00; cursor:pointer"
                    @click.stop="ShowHidden"
                  >我要接单</span>
                  <span
                    style="color: #169BD5; padding-right:10px;"
                    v-if="lastpage > 1"
                    @click="GetSubView(lastpage-1)"
                  >上一条</span>
                  <span
                    style="color: #169BD5; padding-right:10px; cursor: pointer;"
                    @click="GetSubView(lastpage+1)"
                  >下一条</span>
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
                  <button class="confirmBtn" @click="jiedan(item.id)">确定，我要接单联系我吧！</button>
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
                  ></el-date-picker>
                </div>
                <div>
                  <span>输入搜索：</span>
                  <input type="text" v-model="suoyin" />
                  <button @click="GetSubcontractPartner()">搜索</button>
                </div>
              </div>
              <div>
                <el-table
                  ref="multipleTable"
                  :data="slist"
                  tooltip-effect="dark"
                  border
                  style="width: 98.3%"
                  :header-cell-style="{background:'rgb(249,250,252)',color:'#666666',fontWeight: '700'}"
                  @selection-change="handleSelectionChange"
                >
                  <el-table-column type="selection" width="40" align="center"></el-table-column>
                  <el-table-column prop="id" label="项目订单编号" width="200" align="center"></el-table-column>
                  <el-table-column prop="entry_name" label="订单名称" width="205" align="center"></el-table-column>
                  <el-table-column prop="created_at" label="承接时间" width="170" align="center"></el-table-column>
                  <el-table-column prop="InviterLevel" label="要求完成时间" width="220" align="center"></el-table-column>
                  <el-table-column prop="amount" label="项目开发文档" width="220" align="center"></el-table-column>
                  <el-table-column prop="reach_money" label="延期扣款" width="180" align="center">
                    <template slot-scope="scope">
                      <div>{{scope.row.reach_money==null?"0":scope.row.reach_money}}</div>
                    </template>
                  </el-table-column>
                  <el-table-column prop="money" label="佣金金额（元）" width="180" align="center">
                    <template slot-scope="scope">
                      <div>{{scope.row.money==null?"0":scope.row.money}}</div>
                    </template>
                  </el-table-column>
                </el-table>
                <div style="text-align: center;margin-top: 30px;" class="sjTiShiBox">
                  <div>
                    <el-checkbox class="quanxuan" @change="toggleSelection(slist)">全选</el-checkbox>
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
                      :total="total"
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
                  :data="slist1"
                  tooltip-effect="dark"
                  border
                  style="width: 98.3%"
                  :header-cell-style="{background:'rgb(249,250,252)',color:'#666666',fontWeight: '700'}"
                >
                  <el-table-column prop="id" label="申请专业技能" width="295" align="center"></el-table-column>
                  <el-table-column prop="dev" label="技能语言" width="280" align="center"></el-table-column>
                  <el-table-column prop="created_at" label="申请时间" width="280" align="center"></el-table-column>
                  <el-table-column prop="money	" label="技能押金" width="280" align="center"></el-table-column>
                  <el-table-column prop="role_type" label="支付方式" width="280" align="center"></el-table-column>
                </el-table>
              </div>
            </div>
          </el-tab-pane>
        </el-tabs>
      </div>
    </div>
    <div @click="GetSubView(true)">测试测试+</div>
    <div @click="GetSubView(false)">测试测试-</div>
  </div>
</template>
<script>
import logginHeader from "@/components/logginHeader";
import {
  GetRoleCenter,
  SubcontractTotal,
  SubcontractPartner,
  SubView,
  Getreceipt
} from "@/api/api";
export default {
  data() {
    return {
      lastpage: 0, //当前页数
      dis: true,
      skillArr: {}, //技能以及过期时间
      multipleSelection: [],
      phone: sessionStorage.getItem("phone"),
      WXnum: "请输入微信号",
      QQnum: "请输入QQ号",
      title: "我承接的项目明细",
      topList: [
        {
          imgUrl: require("../../../assets/images/u8228.png"),
          title: "我的剩余押金",
          num: "invite_user_total"
        },
        {
          imgUrl: require("../../../assets/images/u7231.png"),
          title: "佣金总额",
          num: "reach_user_total"
        }
      ],
      activeName: "first",
      value: undefined,
      // 邀请分页表格
      slist: [],
      slist1: [],
      shichuang: [],
      pagesize: 3,
      currpage: 1,
      total: 100,
      DirectlyTo: 1,
      suoyin: "",
      fbxm: "flex", //控制分包项目位置显示隐藏
      startTime: "",
      endTime: "",
      type:1
    };
  },
  components: {
    logginHeader
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.RoleCenter();
      this.GetSubcontractTotal();
      this.GetSubcontractPartner();
      // this.GetSubcontractPartner1();
      this.GetSubView(true);
    },
    // gb() {
    //   // 修改状态判断是否有索引条件
    //   if (this.suoyin == "" && this.value == "") {
    //     this.dis = true;
    //   } else if (this.value == null && this.suoyin == "") {
    //     this.dis = true;
    //     this.value = "";
    //   } else {
    //     this.dis = false;
    //   }
    // },
    gbTime() {
      console.log(this.value);
      if (this.value != undefined && this.value != null) {
        // console.log(this.value);
        this.startTime = this.value[0].getTime();
        this.endTime = this.value[1].getTime();
      } else {
        this.startTime = "";
        this.endTime = "";
      }
    },
    handleCurrentChange(cpage) {
      this.currpage = cpage;
      this.GetSubcontractPartner();
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
          // console.log(this.$refs.multipleTable)
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
        type: 3
      };
      GetRoleCenter(params).then(res => {
        let { data, msg, code } = res;
        console.log(data);
        // this.showMsg(msg, code);
        if (code === 1) {
          this.skillArr = data;
        }
      });
    },
    // 获取分包商佣金，押金等
    GetSubcontractTotal() {
      SubcontractTotal().then(res => {
        let { data, msg } = res;
        // this.showMsg(msg,code);
        console.log(data);
        if (data.code === 1) {
          const newArr = this.topList.map(item => {
            item.num = data.data[item.num];
            return item;
          });
          this.topList = newArr;
        }
      });
    },
    // 项目明细，申请订单（需要传递参数type类型为int（1为项目明细数据申请，2为申请订单数据申请））
    GetSubcontractPartner() {
      // let params = {};
      // let times = this.value;
      // if (this.dis) {
      //   params = {
      //     type: 1
      //   };
      // } else {
      //   if (this.value == "") {
      //     params = {
      //       type: 1,
      //       title: this.suoyin
      //     };
      //   } else if (this.suoyin == "" && this.value != null) {
      //     let start_time = this.value[0];
      //     let end_time = this.value[1];
      //     params = {
      //       type: 1,
      //       start_time: start_time.getTime(),
      //       end_time: end_time.getTime()
      //     };
      //   } else {
      //     let start_time = this.value[0];
      //     let end_time = this.value[1];
      //     params = {
      //       type: 1,
      //       title: this.suoyin,
      //       start_time: start_time.getTime(),
      //       end_time: end_time.getTime()
      //     };
      //   }
      // }
      // // const params = {
      // //   type: 1
      // // };
      // SubcontractPartner(params).then(res => {
      //   let { data, msg, code } = res;
      //   // this.showMsg(msg, code);
      //   console.log(data);
      //   if (code === 1) {
      //     this.slist = data.data;
      //   }
      // });

      this.gbTime();
      let params = {
        type: this.type,
        title: this.suoyin,
        start_time: this.startTime,
        endTime: this.endTime,
        page: this.currpage
      };
      console.log(params);
      SubcontractPartner(params).then(res => {
        let { data, msg, code } = res;
        // this.showMsg(msg, code);
        if (code === 1) {
          if (this.activeName == "first") {
            this.slist = data.data;
            this.total = data.total;
            this.pagesize = data.per_page;
            this.currpage = data.current_page;
            console.log("first");
          } else {
            this.slist1 = data.data;
            this.total = data.total;
            this.pagesize = data.per_page;
            this.currpage = data.current_page;
            console.log("second");
          }
        }
      });
    },
    // GetSubcontractPartner1() {
    //   const params = {
    //     type: 2
    //   };
    //   SubcontractPartner(params).then(res => {
    //     let { data, msg, code } = res;
    //     // this.showMsg(msg, code);
    //     console.log(data);
    //     if (code === 1) {
    //       this.slist1 = data.data;
    //     }
    //   });
    // },
    // 分包商视窗数据
    GetSubView(num) {
      let page = 0;
      if(num){
        this.lastpage = this.lastpage +1
        page = this.lastpage
      }else{
        this.lastpage = this.lastpage -1
        page = this.lastpage
      }
      // console.log(page);
      let params = {
        page: parseInt(page)
      };
      SubView(params).then(res => {
        let { data, msg, code } = res;
        // this.showMsg(msg,code);
        console.log(data);
        if (data.code === 1) {
          // this.lastpage = data.current_page;
          this.shichuang = data.data.data;
        }
      });
    },
    //分包商接单（两个参数：项目id：xid，phone）
    Receipt(num) {
      const params = {
        xid: num,
        phone: sessionStorage.getItem("phone")
      };
      Getreceipt(params).then(res => {
        let { data, msg, code } = res;
        if (code === 1) {
          this.showMsg(msg, code);
        }
      });
    },
    showMsg(msg, code) {
      this.$message({
        message: msg,
        type: code === 1 ? "success" : "error"
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
        this.type = 1;
        this.GetSubcontractPartner();
        // console.log(this.fbxm)
      } else if (val === "second") {
        this.title = "分包商申请订单";
        this.fbxm = "none";
        this.type = 2;
        this.value = undefined;
        this.suoyin = "";
        this.currpage = 1;
        this.GetSubcontractPartner();
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
  min-height: 81vh;
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
        margin-left: 10px;
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
<template>
  <div>
    <logginHeader>
      <i class="el-icon-edit"></i>
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
          type="monthrange"
          align="right"
          unlink-panels
          range-separator="至"
          start-placeholder="开始月份"
          end-placeholder="结束月份"
          :picker-options="pickerOptions">
        </el-date-picker>
        <span>消费类型</span>
        <el-select v-model="value" placeholder="请选择" style="width:120px;">
          <el-option
            v-for="item in options"
            :key="item.value"
            :label="item.label"
            :value="item.value">
          </el-option>
        </el-select>
        <span>适用范围</span>
        <el-select v-model="value2" placeholder="请选择" style="width:120px;">
          <el-option
            v-for="item in options1"
            :key="item.value"
            :label="item.label"
            :value="item.value">
          </el-option>
        </el-select>
        <el-button type="danger" style="float: right;">确定</el-button>
      </div>
      <div>
        <el-table
          :data="tableData"
          border
          style="width: 100%; font-size:13px;color:#797979"
          :header-cell-style="{background:'rgb(249,250,252)',color:'#666666',fontSize:'14px',fontWeight:700 }">
          <el-table-column
            prop="hqTime"
            label="获得时间"
            width="180"
            align="center">
          </el-table-column>
          <el-table-column
            prop="dqTime"
            label="到期时间"
            width="180"
            align="center">
          </el-table-column>
          <el-table-column
            prop="syTime"
            label="使用时间"
            align="center">
          </el-table-column>
          <el-table-column
            label="优惠券说明"
            align="center">
            <template slot-scope="scope">
              <div>{{scope.row.youhuiquan.name}}</div>
              <div>{{scope.row.youhuiquan.num}}</div>
            </template>
          </el-table-column>
          <el-table-column
            label="获得优惠券"
            align="center">
            <template slot-scope="scope">
              <div>
                <div>{{scope.row.hdYouhuiquan.num}}<span>元</span></div>
                <div>
                  <div>{{scope.row.hdYouhuiquan.leixing}}</div>
                  <div>{{scope.row.hdYouhuiquan.youxiaoqi}}</div>
                  <div>{{scope.row.hdYouhuiquan.shiyongfanwei}}</div>
                  <div>立即使用&gt;&gt;</div>
                </div>
              </div>
              <div></div>
            </template>
          </el-table-column>
        </el-table>
      </div>
    </div>
  </div>
</template>
<script>
import logginHeader from "@/components/logginHeader";
export default {
  data() {
    return {
      // 时间选择器
      pickerOptions: {
          shortcuts: [{
            text: '本月',
            onClick(picker) {
              picker.$emit('pick', [new Date(), new Date()]);
            }
          }, {
            text: '今年至今',
            onClick(picker) {
              const end = new Date();
              const start = new Date(new Date().getFullYear(), 0);
              picker.$emit('pick', [start, end]);
            }
          }, {
            text: '最近六个月',
            onClick(picker) {
              const end = new Date();
              const start = new Date();
              start.setMonth(start.getMonth() - 6);
              picker.$emit('pick', [start, end]);
            }
          }]
        },
        value1: '',
        // select1
        options: [{
          value: '选项1',
          label: '全部'
        }, {
          value: '选项2',
          label: '普通优惠券'
        }, {
          value: '选项3',
          label: '特殊优惠券'
        }],
        value: '选项1',
        // select2
        options1: [{
          value: '选项1',
          label: '全部'
        }, {
          value: '选项2',
          label: '已使用'
        }, {
          value: '选项3',
          label: '未使用'
        }],
        value2: '选项1',
        // 表格数据
        tableData: [{
          hqTime: '2018年6月18日 12:32:45',
          dqTime: '2018年6月18日 12:32:45',
          syTime: '2018年6月18日 12:32:45',
          youhuiquan:{"name":"普通优惠券","num":"（发行数量1000，适用所有商品）"},
          hdYouhuiquan:{
            "num":"100",
            "fanwei":"满任意金额可用",
            "leixing":"新人现金券",
            "youxiaoqi":"永久",
            "shiyongfanwei":"所有会员"
          }
        },{
          hqTime: '2018年6月18日 12:32:45',
          dqTime: '2018年6月18日 12:32:45',
          syTime: '未使用',
          youhuiquan:{"name":"特殊优惠券","num":"（发行数量1000，适用所有商品）"},
          hdYouhuiquan:{
            "num":"100",
            "fanwei":"满任意金额可用",
            "leixing":"新人现金券",
            "youxiaoqi":"永久",
            "shiyongfanwei":"所有会员"
          }
        },{
          hqTime: '2018年6月18日 12:32:45',
          dqTime: '2018年6月18日 12:32:45',
          syTime: '2018年6月18日 12:32:45',
          youhuiquan:{"name":"普通优惠券","num":"（发行数量1000，适用所有商品）"},
          hdYouhuiquan:{
            "num":"100",
            "fanwei":"满任意金额可用",
            "leixing":"新人现金券",
            "youxiaoqi":"永久",
            "shiyongfanwei":"所有会员"
          }
        },{
          hqTime: '2018年6月18日 12:32:45',
          dqTime: '2018年6月18日 12:32:45',
          syTime: '2018年6月18日 12:32:45',
          youhuiquan:{"name":"普通优惠券","num":"（发行数量1000，适用所有商品）"},
          hdYouhuiquan:{
            "num":"100",
            "fanwei":"满任意金额可用",
            "leixing":"新人现金券",
            "youxiaoqi":"永久",
            "shiyongfanwei":"所有会员"
          }
        }]
    };
  },
  components: {
    logginHeader
  },
  mounted() {},
  methods: {}
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
  .shaixuan{
    padding: 10px;
    background: rgb(243,243,243);
    border-left: 3px solid #ff0000;
    >span{
      font-size: 13px;
      color: #666666;
      &:nth-of-type(1){
        padding-right: 10px;
      }
      &:nth-of-type(2){
        padding: 0 10px 0 40px;
      }
      &:nth-of-type(3){
        padding: 0 10px 0 40px;
      }
    }
  }
}
</style>
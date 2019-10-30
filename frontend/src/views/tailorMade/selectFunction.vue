<template>
  <div class="select-function">
    <myheader />
    <div class="select-main">
      <h3 class="title">快捷估价</h3>
      <div class="select-cont clearfix">
        <quickaside />
        <div class="types-right">
          <div class="types-list">
            <div class="types-title">选择开发端（可多选）</div>
            <div
              :class="{'type-item': true, 'on': typeIndex==index}"
              v-for="(item, index) in typeList"
              :key="index"
              @click="chooseType(index, item.plate_from_id)"
            >
              <i :class="item.className"></i>
              <p class="type-name">{{ item.plate_from }}</p>
            </div>
          </div>
          <div class="table-box">
            <el-table
              :data="tableData"
              :span-method="objectSpanMethod"
              border
              style="width: 100%; margin-top: 20px"
            >
              <el-table-column prop="evaluate_type" label="分类" width="180"></el-table-column>
              <el-table-column label="模块">
                <div slot-scope="scope">
                  <el-checkbox
                    v-model="scope.row.checkAll"
                    @change="handleCheckAllChange($event, scope.row)"
                  >{{scope.row.model_name}}</el-checkbox>
                </div>
              </el-table-column>
              <el-table-column label="功能点">
                <el-checkbox-group
                  v-model="scope.row.checkedCities"
                  slot-scope="scope"
                  @change="handleCheckedCitiesChange($event, scope.row)"
                >
                  <el-checkbox
                    v-for="item in scope.row.function_point"
                    :label="item.function_point"
                    :key="item.id"
                  >{{item.function_point}}</el-checkbox>
                </el-checkbox-group>
              </el-table-column>
            </el-table>
          </div>
        </div>
      </div>
    </div>
    <myfooter />
    <!-- 报价窗 -->
    <div class="quoted-price">
      <p class="tit">报价预估：</p>
      <div class="price-interval">￥{{minPrice}}-{{maxPrice}}</div>
      <p>总计工时预估：</p>
      <div class="time-interval">
        <span>{{date}}</span>个工作日
      </div>
    </div>
  </div>
</template>

<script>
import Myheader from "@/components/header";
import Myfooter from "@/components/footer";
import Quickaside from "@/components/quickAside";
import { GetTableData } from "@/api/api";
export default {
  components: {
    Myheader,
    Myfooter,
    Quickaside
  },
  data() {
    return {
      typeList: [],
      typeIndex: 0,
      queryId: [],
      dataList: [],
      tableData: [],
      checkedObj: {}
    };
  },
  mounted() {
    this.getTableData();
  },
  computed: {
    minPrice() {
      return 0;
    },
    maxPrice() {
      return 0;
    },
    date() {
      return 0;
    }
  },
  methods: {
    chooseType(index, id) {
      this.typeIndex = index;
      this.tableData = this.dataList[index];
    },
    objectSpanMethod({ row, column, rowIndex, columnIndex }) {
      if (columnIndex === 0) {
        return {
          rowspan: row.model_num,
          colspan: 1
        };
      }
    },
    handleCheckAllChange(val, row) {
      let arr = [];
      row.function_point.forEach(ele => {
        arr.push(ele.function_point);
      });
      row.checkedCities = val ? arr : [];
      if (val) {
        row.function_point.forEach(v => {
          this.checkedObj[v.id] = v;
        });
      } else {
        row.function_point.forEach(v => {
          delete this.checkedObj[v.id];
        });
      }
      console.log(this.checkedObj)
    },
    handleCheckedCitiesChange(value, row) {
      let checkedCount = value.length;
      row.checkAll = checkedCount === row.function_point.length;
      if (value.length === 0) {
        row.function_point.forEach(v => {
          delete this.checkedObj[v.id];
        });
      } else {
        const function_point = row.function_point;
        for (var i = 0; i < value.length; i++) {
          for (var j = 0; j < function_point.length; j++) {
            if (value[i] == function_point[j].function_point) {
              this.checkedObj[function_point[j].id] = function_point[j];
            }
          }
        }
      }
      console.log(this.checkedObj)
    },
    getTableData() {
      const id = JSON.parse(sessionStorage.getItem("typeidList"));
      GetTableData({
        id: id
      }).then(res => {
        let { code, data, msg } = res.data;
        if (code === 1) {
          data.plate_form.forEach(v => {
            switch (v.plate_from_id) {
              case 1:
                v.className = "iconfont icon-gongyinglian";
                break;
              case 2:
                v.className = "iconfont icon-shezhi-";
                break;
              case 3:
                v.className = "iconfont icon-diannao";
                break;
              case 4:
                v.className = "iconfont icon-h5";
                break;
              case 5:
                v.className = "iconfont icon-pingguo";
                break;
              case 6:
                v.className = "iconfont icon-anzhuologo";
                break;
              case 7:
                v.className = "iconfont icon-weixinxiaochengxu";
                break;
            }
          });
          this.typeList = data.plate_form;
          this.dataList = data.model;
          this.tableData = data.model[0];
        }
      });
    }
  }
};
</script>

<style scoped lang='scss'>
.select-function {
  background-color: rgb(246, 246, 246);
  .select-main {
    width: 1200px;
    margin: 100px auto 0;
    padding-top: 10px;
    h3.title {
      font-size: 28px;
      background-color: #ffffff;
      height: 50px;
      line-height: 50px;
      margin-bottom: 10px;
    }
    .select-cont {
      margin-bottom: 20px;
      .types-right {
        margin-left: 225px;
        .types-list {
          background-color: #ffffff;
          height: 90px;
          display: flex;
          align-items: center;
          padding-left: 30px;
          margin-bottom: 10px;
          .types-title {
            font-size: 14px;
            color: #333333;
            margin-right: 30px;
          }
          .type-item {
            width: 65px;
            height: 60px;
            box-sizing: border-box;
            margin-right: 30px;
            border: 1px solid rgb(215, 215, 215);
            border-radius: 6px;
            background-color: rgb(247, 247, 247);
            text-align: center;
            cursor: pointer;
            color: #797979;
            &.on {
              background-color: rgb(230, 45, 49);
              color: #ffffff;
              border-color: rgb(230, 45, 49);
            }
            .iconfont {
              display: inline-block;
              margin-top: 10px;
              margin-bottom: 5px;
              font-size: 20px;
            }
            .type-name {
              font-size: 13px;
            }
          }
        }
        .table-box {
          background-color: #ffffff;
          min-height: 674px;
          padding: 15px 30px;
        }
      }
    }
  }
  .quoted-price {
    background-color: rgb(198, 230, 248);
    position: fixed;
    right: 0;
    top: 30%;
    width: 180px;
    border-radius: 20px;
    padding: 20px;
    color: #333333;
    z-index: 998;
    p {
      font-size: 14px;
      &.tit {
        font-size: 16px;
        font-weight: 700;
      }
    }
    .price-interval {
      width: 90%;
      margin: 15px auto;
      background-color: #ffffff;
      border-radius: 5px;
      height: 40px;
      line-height: 40px;
      text-align: center;
      color: #ff0000;
      font-size: 16px;
      font-weight: 700;
    }
    .time-interval {
      margin: 15px 0;
      span {
        color: #ff0000;
      }
    }
  }
}
</style>
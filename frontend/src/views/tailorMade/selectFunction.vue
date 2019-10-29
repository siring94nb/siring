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
              @click="chooseType(index)"
            >
              <i :class="item.className"></i>
              <p class="type-name">{{ item.name }}</p>
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
                    @change="handleCheckAllChange($event, scope.row)"
                  >{{scope.row.model_name}}</el-checkbox>
                </div>
              </el-table-column>
              <el-table-column label="功能点">
                <!-- <el-checkbox-group
                  slot-scope="scope"
                  @change="handleCheckedCitiesChange($event, scope.row)"
                >
                  <el-checkbox
                    v-for="item in scope.row.function_point"
                    :label="item.function_point"
                    :key="item.id"
                  >{{item.function_point}}</el-checkbox>
                </el-checkbox-group> -->
              </el-table-column>
            </el-table>
          </div>
        </div>
      </div>
    </div>
    <myfooter />
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
      typeList: [
        {
          className: "iconfont icon-gongyinglian",
          name: "原型UI",
          id: 1
        },
        {
          className: "iconfont icon-shezhi-",
          name: "后台",
          id: 2
        }
      ],
      typeIndex: 0,
      queryId: [],
      dataList: [],
      tableData: [
        {
          name: "基本功能",
          length: 2,
          subname: "注册登录",
          checkedCities: [],
          checkAll: false,
          thrname: [
            {
              name: "账号绑定"
            },
            {
              name: "邮箱"
            },
            {
              name: "手机"
            },
            {
              name: "密码找回"
            }
          ]
        },
        {
          name: "基本功能",
          length: 0,
          subname: "功能列表",
          checkedCities: [],
          checkAll: false,
          thrname: [
            {
              name: "账号绑定"
            }
          ]
        }
      ]
    };
  },
  mounted() {
    this.getTableData();
  },
  methods: {
    chooseType(index) {
      this.typeIndex = index;
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
      // row.thrname.forEach(ele => {
      //   arr.push(ele.name);
      // });
      row.checkedCities = val ? arr : [];
    },
    handleCheckedCitiesChange(value, row) {
      let checkedCount = value.model_num;
      row.checkAll = checkedCount === row.thrname.model_num;
    },
    getTableData() {
      GetTableData({
        id: this.$route.query.id
      }).then(res => {
        let { code, data, msg } = res.data;
        if (code === 1) {
          console.log(data)
          this.tableData = data[1].model;
          data[1].model.forEach((v, i) => {
            v.checkedCities = [];
            v.checkAll = false;
            if(i == 2){
              v.model_num = 2;
            }
          })
          console.log(data[1].model)
          // console.log(data);
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
          padding: 15px 30px 0;
        }
      }
    }
  }
}
</style>
<template>
  <div class="investment">
    <myheader />
    <myaside />
    <div class="middle">
      <div class="mall-box">
        <div class="search-section">
          <div class="search-type">
            <div class="search-title">软件/定制类型</div>
            <div class="search-cont">
              <div :class="{'search-items': true, 'autoHeight': typeListShowMore}">
                <div
                  :class="{'search-item': true, 'curr': -1==typeCurrIndex}"
                  @click="searchType(-1, 0)"
                >
                  <span>全部</span>
                </div>
                <div
                  v-for="(item, index) in typeList"
                  :key="item.id"
                  :class="{'search-item': true, 'curr': index==typeCurrIndex}"
                  @click="searchType(index, item.id)"
                >
                  <span>{{ item.title }}</span>
                </div>
              </div>
              <div class="search-more" @click="showMore">
                更多
                <i :class="[typeListShowMore ? 'el-icon-arrow-up': 'el-icon-arrow-down']"></i>
              </div>
            </div>
          </div>
          <div class="sort-section">
            <div class="sort-type">
              <div
                v-for="(item, index) in sortDataList"
                :key="index"
                :class="['sort-type-item', sortCurIndex==index && up?'desc':'asce', {'sort-on':sortCurIndex==index}]"
                @click="sortEvent(index)"
              >
                {{item}}
                <span v-if="index>0">
                  <i class="el-icon-caret-top caret-top"></i>
                  <i class="el-icon-caret-bottom caret-bot"></i>
                </span>
              </div>
            </div>
            <div class="search-box">
              <el-input v-model="searchCont" prefix-icon="el-icon-search" placeholder="请输入内容"></el-input>
              <el-button type="danger">搜索</el-button>
            </div>
            <div class="collect-order">
              <div>
                <i class="el-icon-star-off"></i>
                <span>我的收藏</span>
              </div>
              <div>
                <i class="el-icon-tickets"></i>
                <span>我的订单</span>
              </div>
            </div>
          </div>
        </div>
        <div class="project-list">
          <el-table :data="tableData" style="width: 100%">
            <template v-for="item in cols">
              <el-table-column
                v-if="item.prop!='option'"
                :prop="item.prop"
                :label="item.label"
                :key="item.id"
                align="center"
              ></el-table-column>
              <el-table-column v-else :label="item.label" :key="item.id" align="center">
                <template slot-scope="scope">
                  <el-button type="primary" @click="handleClick(scope.index, scope.row)">我要投资</el-button>
                  <i :class="scope.row.follow?'el-icon-star-on':'el-icon-star-off'"></i>
                </template>
              </el-table-column>
            </template>
          </el-table>
        </div>
        <div class="pagi-box">
          <el-pagination
            background
            layout="prev, pager, next"
            :hide-on-single-page="true"
            :page-size="goodsData.per_page"
            :total="goodsData.total"
            @current-change="handleCurrentChange"
          ></el-pagination>
        </div>
      </div>
    </div>
    <jsjm />
    <jdyh />
    <myfooter />
  </div>
</template>

<script>
import Myheader from "@/components/header";
import Myfooter from "@/components/footer";
import Myaside from "@/components/aside";
import Jsjm from "@/components/jsjm";
import Jdyh from "@/components/jdyh";
import { GetIndustryField, GetIndustryList } from "@/api/api";
export default {
  components: {
    Myheader,
    Myfooter,
    Myaside,
    Jsjm,
    Jdyh
  },
  data() {
    return {
      searchCont: "", //搜索内容
      typeList: [],
      typeCurrIndex: -1,
      typeListShowMore: false,
      sortCurIndex: 0,
      sortDataList: ["全部排序", "按打赏数量"],
      sortId: 1, // 商品按照按打赏数量升降序ID 1：全部，2：按打赏数量序，3：按打赏数量升序
      typeId: 0, // 商品、软件定制类型ID
      up: false, //控制箭头上下亮
      goodsData: {}, //获取的所有商品数据
      page: 1,
      tableData: [],
      cols: [
        { label: "项目名称", id: 2, prop: "title" },
        { label: "行业领域", id: 3, prop: "industry_field" },
        { label: "项目亮点", id: 4, prop: "bright" },
        { label: "操作", id: 5, prop: "option" }
      ]
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.getIndustryField();
      this.getIndustryList();
    },
    getIndustryField() {
      GetIndustryField().then(res => {
        let { code, data, msg } = res.data;
        if (code === 1) {
          this.typeList = data;
        }
      });
    },
    getIndustryList() {
      let params = {
        type: this.sortId,
        cid: this.typeId,
        title: this.searchCont,
        page: this.page
      };
      GetIndustryList(params).then(res => {
        let { code, data, msg } = res;
        if (code !== 1) {
          this.$message.error(msg);
        } else {
          this.goodsData = data;
          this.tableData = data.data;
        }
      });
    },
    showMore() {
      this.typeListShowMore = !this.typeListShowMore;
    },
    searchType(index, id) {
      this.typeCurrIndex = index;
      this.typeId = id;
    },
    sortEvent(index) {
      if (this.sortCurIndex === 0 && this.sortCurIndex === index) {
        return;
      }
      this.sortCurIndex = index;
      this.up = !this.up;
      switch (index) {
        case 0:
          this.sortId = 1;
          break;
        case 1:
          this.sortId = this.up ? 2 : 3;
          break;
      }
      this.getIndustryList();
    },
    handleClick() {},
    handleCurrentChange(val) {
      this.page = val;
      this.getGoods();
    }
  }
};
</script>


<style lang="css" scoped>
.search-box >>> input {
  border-top-left-radius: 30px;
  border-bottom-left-radius: 30px;
  border-top-right-radius: 0;
  border-bottom-right-radius: 0;
  width: 300px;
}
.search-box >>> button {
  border-top-left-radius: 0;
  border-bottom-left-radius: 0;
  border-top-right-radius: 30px;
  border-bottom-right-radius: 30px;
  height: 30px;
  line-height: 6px;
}
.search-box >>> .el-input__inner {
  height: 30px;
}
.search-box >>> .el-icon-search {
  line-height: 30px;
}
.pagi-box >>> .el-pager .number {
  background-color: rgb(238, 238, 238);
}
</style>
<style scoped lang='scss'>
.middle {
  margin-top: 100px;
  // min-height: 1000px;
  background-color: rgb(246, 246, 246);
  .mall-box {
    width: 1200px;
    margin: 0 auto;
    padding-top: 20px;
    .search-section {
      background-color: #ffffff;
      padding: 15px 10px;
      .search-type {
        position: relative;
        display: table;
        font-size: 14px;
        color: #333;
        margin-bottom: 10px;
        .search-title {
          float: left;
          padding: 4px 14px;
        }
        .search-cont {
          width: 1030px;
          float: left;
          .search-items {
            float: left;
            width: 90%;
            height: 35px;
            overflow: hidden;
            &.autoHeight {
              height: auto;
            }
            .search-item {
              display: inline-block;
              font-size: 14px;
              color: #333;
              margin-right: 5px;
              margin-bottom: 10px;
              cursor: pointer;
              span {
                display: inline-block;
                padding: 4px 14px;
                box-sizing: border-box;
                border: 1px solid transparent;
                border-radius: 3px;
              }
              &.curr {
                span {
                  position: relative;
                  border-color: #e62d31;
                  color: #e62d31;
                  &::before {
                    content: "";
                    position: absolute;
                    top: 0;
                    right: 0;
                    background: url("~@/assets/images/arrow-top.png") no-repeat;
                    width: 14px;
                    height: 14px;
                  }
                }
              }
            }
          }
          .search-more {
            float: right;
            padding: 4px 14px;
            border: 1px solid transparent;
            cursor: pointer;
          }
        }
      }
      .sort-section {
        display: flex;
        align-items: center;
        margin-left: 105px;
        .sort-type {
          display: flex;
          .sort-type-item {
            font-size: 14px;
            height: 30px;
            padding: 4px 14px;
            background-color: #f2f2f2;
            margin-left: 10px;
            box-sizing: border-box;
            line-height: 22px;
            cursor: pointer;
            user-select: none;
            &.asce {
              .caret-bot {
                color: #9f0010;
              }
            }
            &.desc {
              .caret-top {
                color: #9f0010;
              }
            }
            span {
              display: inline-block;
              position: relative;
              width: 16px;
              height: 100%;
              vertical-align: bottom;
              line-height: 1;
              color: #fbb;
              .caret-top {
                position: absolute;
                right: 0;
                top: 0;
                font-size: 14px;
              }
              .caret-bot {
                position: absolute;
                right: 0;
                bottom: 0;
                font-size: 14px;
              }
            }
            &.sort-on {
              background-color: #ff0000;
              color: #ffffff;
            }
          }
        }
        .search-box {
          position: relative;
          display: flex;
          align-items: center;
          margin-left: 30px;
        }
        .collect-order {
          & > div {
            display: inline-block;
            color: #333;
            font-size: 12px;
            text-align: center;
            margin-left: 30px;
            i {
              display: block;
              font-size: 30px;
            }
          }
        }
      }
    }
    .project-list {
      background-color: #ffffff;
      margin: 20px 0;
      min-height: 700px;
      .el-icon-star-off {
        color: rgb(212, 212, 212);
      }
      .el-icon-star-on {
        color: rgb(244, 234, 42);
      }
      .el-icon-star-off,
      .el-icon-star-on {
        font-size: 24px;
        cursor: pointer;
        margin-left: 10px;
      }
    }
    .pagi-box {
      display: flex;
      justify-content: center;
      .el-pagination {
        margin-bottom: 20px;
      }
    }
  }
}
</style>
<template>
  <div class="goods">
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
                  <span>{{ item.category_name }}</span>
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
              <el-button type="danger" @click="getGoods">搜索</el-button>
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
        <div class="rjdz-goods">
          <div class="goods-list">
            <div class="goods-item" v-for="item in goodsData.data" :key="item.id">
              <router-link
                :to="{name: 'goods-detail', params: {id: item.id}}"
                tag="div"
                class="goods-img"
              >
                <img :src="item.img" width="260" height="165" alt />
              </router-link>
              <div class="model_mall_info_box">
                <div class="name_box">
                  <div class="top">
                    <div class="single-dot">
                      <i class="iconfont icon-hotchunse" v-if="item.sign == 1"></i>
                      <i class="iconfont icon-cu" v-if="item.sign == 2"></i>
                      <span class="goods_name">{{ item.goods_name }}</span>
                    </div>
                    <i class="el-icon-star-off el-icon-star-on" @click="favoriteGood"></i>
                  </div>
                  <div class="bottom">
                    <span class="desc_span">APP|小程序|公众号|H5</span>
                    <span class="ljgm">
                      <router-link
                        :to="{name: 'goods-detail', params: {id: item.id}}"
                        href="javascript:;"
                      >&gt;&gt;立即购买</router-link>
                    </span>
                  </div>
                </div>
                <div class="time_box">
                  <div class="brand">
                    <i class="iconfont icon-fenleishouye"></i>
                    <span>{{item.category_title}}</span>
                  </div>
                  <p>
                    <i class="el-icon-time"></i>
                    <span>{{item.period}}天</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="goods-item-holder"></div>
            <div class="goods-item-holder"></div>
            <div class="goods-item-holder"></div>
          </div>
        </div>
        <div class="pagi-box">
          <el-pagination
            background
            layout="prev, pager, next"
            :hide-on-single-page="true"
            :page-size="goodsData.per_page"
            :total="goodsData.total"
            @current-change	="handleCurrentChange"
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
import { GetDevlopType, GetGoods } from "@/api/api";
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
      asceOrDesc: false,
      sortDataList: ["全部排序", "按价格", "按销量"],
      sortId: 1, // 商品按照价格、销量升降序ID 1：全部，2：价格降序，3：价格升序，4：销量降序，5：销量升序
      typeId: 0, // 商品、软件定制类型ID
      up: false, //控制箭头上下亮
      goodsData: {},
      page: 1,
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.getDevlopType();
      this.getGoods();
    },
    getDevlopType() {
      GetDevlopType().then(res => {
        let { code, data, msg } = res.data;
        if (code === 1) {
          this.typeList = data;
        }
      });
    },
    getGoods() {
      let params = {
        type: this.sortId,
        category_id: this.typeId,
        title: this.searchCont,
        page: this.page
      };
      GetGoods(params).then(res => {
        let { code, data, msg } = res;
        // console.log(data)
        if (code !== 1) {
          this.$message.error(msg);
        } else {
          this.goodsData = data;
        }
      });
    },
    showMore() {
      this.typeListShowMore = !this.typeListShowMore;
    },
    searchType(index, id) {
      this.typeCurrIndex = index;
      this.typeId = id;
      this.getGoods();
    },
    favoriteGood() {},
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
        case 2:
          this.sortId = this.up ? 4 : 5;
          break;
      }
      this.getGoods();
    },
    handleCurrentChange(val){
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
}
.pagi-box >>> .el-pager .number {
  background-color: rgb(238, 238, 238);
}
</style>
<style scoped lang='scss'>
.middle {
  margin-top: 100px;
  min-height: 1000px;
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
    }
    .sort-section {
      display: flex;
      align-items: center;
      margin-left: 132px;
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
    .rjdz-goods {
      width: 100%;
      background-color: rgb(244, 245, 249);
      padding: 20px 0;
      height: 910px;
      .goods-list {
        width: 1200px;
        margin: 0 auto;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        .goods-item {
          background-color: #fff;
          box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);
          margin-bottom: 40px;
          .goods-img {
            overflow: hidden;
            cursor: pointer;
            &:hover img {
              transform: scale(1.2);
            }
            img {
              transition: transform 0.8s;
            }
          }
          .name_box {
            width: 100%;
            border-bottom: 1px solid #999;
            padding: 10px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            .top,
            .bottom {
              width: 100%;
              display: flex;
              justify-content: space-between;
              align-items: center;
            }
            .top {
              margin-bottom: 5px;
              .single-dot{
                max-width: 210px;
              }
              .icon-hotchunse {
                color: #ff0000;
                font-size: 10px;
                vertical-align: middle;
                margin-right: 3px;
              }
              .icon-cu {
                color: rgb(255, 102, 0);
                vertical-align: middle;
                margin-right: 3px;
                font-size: 10px;
              }
              .el-icon-star-off {
                font-size: 20px;
                color: #999999;
              }
              .el-icon-star-on {
                font-size: 20px;
                color: rgb(244, 234, 42);
              }
              span {
                vertical-align: middle;
              }
            }
            .bottom {
              .desc_span {
                font-size: 14px;
                color: #6b6b6b;
                width: 130px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
              }
              .ljgm a {
                text-decoration: none;
                font-size: 14px;
                color: #ff0000;
              }
            }
          }
          .time_box {
            position: relative;
            padding: 8px;
            .brand {
              position: absolute;
              left: 5px;
              top: 50%;
              transform: translateY(-50%);
              span {
                display: inline-block;
                width: 100px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                vertical-align: middle;
                color: #6B6B6B;
                font-size: 16px;
              }
              i {
                vertical-align: middle;
                margin-right: 5px;
              }
            }
            p {
              width: 100%;
              text-align: right;
              span {
                color: #666;
              }
              .el-icon-time{
                margin-right: 5px;
              }
            }
          }
        }
        .goods-item-holder {
          width: 260px;
          height: 0;
          margin: 0;
          padding: 0;
        }
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
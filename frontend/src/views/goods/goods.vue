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
              <div class="search-items">
                <div class="search-item curr">
                  <span>全部</span>
                </div>
                <div class="search-item">
                  <span>区块链电商</span>
                </div>
              </div>
              <div class="search-more">
                更多
                <i class="iconfont icon-changyongtubiao-xianxingdaochu-zhuanqu-1"></i>
              </div>
            </div>
          </div>
          <div class="sort-section">
            <div class="sort-type">
              <div class="sort-all sort-on">全部排序</div>
              <div class="desc">
                按价格
                <span>
                  <i class="iconfont icon-quanxianfuzhi caret-top"></i>
                  <i class="iconfont icon-sanjiaodown caret-bot"></i>
                </span>
              </div>
              <div class="asce">
                按销量
                <span>
                  <i class="iconfont icon-quanxianfuzhi caret-top"></i>
                  <i class="iconfont icon-sanjiaodown caret-bot"></i>
                </span>
              </div>
            </div>
            <div class="search-box">
              <el-input v-model="input" prefix-icon="el-icon-search" placeholder="请输入内容"></el-input>
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
      </div>
    </div>
    <sjhy />
    <jdyh />
    <myfooter />
  </div>
</template>

<script>
import Myheader from "@/components/header";
import Myfooter from "@/components/footer";
import Myaside from "@/components/aside";
import Sjhy from "@/components/sjhy";
import Jdyh from "@/components/jdyh";
export default {
  components: {
    Myheader,
    Myfooter,
    Myaside,
    Sjhy,
    Jdyh
  },
  data() {
    return {
      input: ""
    };
  },
  methods: {}
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
        div {
          font-size: 14px;
          height: 30px;
          padding: 4px 14px;
          background-color: #f2f2f2;
          margin-left: 10px;
          box-sizing: border-box;
          line-height: 22px;
          cursor: pointer;
          user-select: none;
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
}
</style>
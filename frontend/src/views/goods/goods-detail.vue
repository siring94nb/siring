<template>
  <div class="goods-detail">
    <myheader />
    <div class="container">
      <h3>软件/定制</h3>
      <div class="cont clearfix">
        <div class="info-comment">
          <div class="info-box">
            <div class="img-box">
              <img :src="goodsDetail.img" alt />
            </div>
            <div class="info-list">
              <div class="info-item">
                <p class="name single-dot">{{ goodsDetail.goods_name}}</p>
                <p class="numbering">编号：{{ goodsDetail.goods_number }}</p>
              </div>
              <div class="info-item">
                <p class="price" v-if="ifLogin">
                  <span class="marking-price">原价：￥{{selectType.bottom_price}}</span>
                  <span class="true-price">现价：￥{{selectType.price}}</span>
                </p>
                <p class="cantsee" v-else>登陆后可查看</p>
                <p class="collect">
                  <i class="el-icon-star-off el-icon-star-on"></i>收藏
                </p>
              </div>
              <div class="info-item">
                <div class="type">商品类型：{{goodsDetail.category_title}}</div>
                <div class="time">
                  <i class="el-icon-time"></i>
                  <span>{{selectType.cycle_time}}</span>天
                </div>
              </div>
              <div class="info-item">
                <div class="terminal">
                  终端版本：
                  <el-select
                    v-model="selectType"
                    value-key="id"
                    @change="chooseType"
                    placeholder="请选择"
                    size="small"
                  >
                    <el-option
                      v-for="item in goodsDetail.special"
                      :key="item.id"
                      :label="item.attr_title"
                      :value="item"
                    ></el-option>
                  </el-select>
                </div>
              </div>
              <div class="btns">
                <router-link
                  :to="{name: 'demonstration', params: {id: goodsId}}"
                  class="btn show-btn"
                >演示</router-link>
                <router-link to="/hints" class="btn made-like-btn">定制类似</router-link>
                <router-link to="/fillDemand" class="btn made-btn">定制需求</router-link>
              </div>
              <div class="tips">
                <i class="iconfont icon-shengyin_shiti"></i>
                <span style="padding-left:5px;padding-top:4px;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;">如与演示雷同，请直接点击【定制类似】，完全不同点击【定制需求】</span>
                <!-- <el-carousel
                  height="20px"
                  indicator-position="none"
                  direction="vertical"
                  :autoplay="true"
                >
                  <el-carousel-item v-for="(item, index) in tipList" :key="index">
                    <h3 class="single-dot">{{ item }}</h3>
                  </el-carousel-item>
                </el-carousel> -->
              </div>
            </div>
          </div>
          <div class="comment-box">
            <el-tabs type="border-card">
              <el-tab-pane label="功能描述">
                <div class="desc-box" v-html="goodsDetail.goods_des"></div>
              </el-tab-pane>
              <el-tab-pane label="会员评价">
                <div class="comment-list">
                  <div class="comment-item" v-for="item in commentList" :key="item.id">
                    <div class="user-comment">
                      <div class="user-box">
                        <el-avatar :size="50" :src="item.img"></el-avatar>
                        <p class="phone">{{translateStar(item.phone)}}</p>
                        <div class="user-level">
                          <img :src="require('@/assets/images/u1930.png')" alt />
                          <span v-if="item.grade===0" class="member-a">普通会员</span>
                          <span v-else-if="item.grade===1" class="member-b">金牌代理</span>
                          <span v-else-if="item.grade===2" class="member-c">钻石代理</span>
                          <span v-else-if="item.grade===3" class="member-d">皇冠代理</span>
                        </div>
                      </div>
                      <div class="comment-div">
                        <div class="comment-cont">{{item.con}}</div>
                        <div class="comment-time">{{item.create_at}}</div>
                      </div>
                    </div>
                    <div class="seller-comment" v-for="i in item.reply" :key="i.id">
                      <div class="reply-cont">
                        <span class="seller-title">【官方回复】</span>
                        {{i.con}}
                      </div>
                      <div class="reply-time">{{i.create_at}}</div>
                    </div>
                  </div>
                </div>
              </el-tab-pane>
            </el-tabs>
          </div>
        </div>
        <div class="recommend">
          <div class="recommend-title">
            <i class="iconfont icon-remen"></i>
            推荐产品
          </div>
          <div class="recommend-list">
            <div class="recommend-item" v-for="item in recommendList" :key="item.id" @click.stop="tiaozhuan(item.id)">
               <!-- <router-link
                :to="{name: 'goods-detail', params: {id: item.id}}"
              > -->
              <div class="recommend-img">
                <img :src="item.img" alt />
              </div>
              <div class="recommend-info">
                <div class="name single-dot">{{ item.goods_name }}</div>
                <div class="time">
                  <i class="el-icon-time"></i>
                  <span>{{ item.period }}</span>天
                </div>
                <div class="desc single-dot">{{ item.category_name }}</div>
              </div>
              <!-- </router-link> -->

            </div>
          </div>
          <div class="more">
            <router-link to="/goods">更多&gt;</router-link>
          </div>
        </div>
      </div>
    </div>
    <jdyh />
    <myfooter />
  </div>
</template>

<script>
import Myheader from "@/components/header";
import Myfooter from "@/components/footer";
import Jdyh from "@/components/jdyh";
import { GetGoodsDetail, GetRecommend, GetComment } from "@/api/api";
export default {
  components: {
    Myheader,
    Myfooter,
    Jdyh
  },
  data() {
    return {
      goodsId: this.$route.params.id,
      // tipList: [
      //   "11如与演示雷同，请直接点击【定制类似】，完全不同点击【定制需求】1",
      //   "如与演示雷同，请直接点击【定制类似】，完全不同点击【定制需求】2",
      //   "如与演示雷同，请直接点击【定制类似】，完全不同点击【定制需求】3"
      // ],
      goodsDetail: {},
      ifLogin: false,
      recommendList: [],
      selectType: {},
      commentList: []
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.ifLogin = this.$store.state.user_id ? true : false;
      this.getGoodsDetail();
      this.getRecommend();
      this.getComment();
    },
    tiaozhuan(id){
      this.$router.push({
        name:"goods-detail",
        params:{
          id:id
        }
      })
      this.goodsId = this.$route.params.id;
      this.getGoodsDetail();
    },
    getGoodsDetail() {
      GetGoodsDetail({
        goods_id: this.goodsId
      }).then(res => {
        let { code, data, msg } = res;
        console.log("商品详情", data);
        if (code === 1) {
          this.goodsDetail = data;
          this.selectType = data.special[0];
        }
      });
    },
    getRecommend() {
      GetRecommend().then(res => {
        let { code, data, msg } = res.data;
        if (code === 1) {
          this.recommendList = data;
        }
      });
    },
    chooseType(value) {
      // console.log(this.goodsDetail);
      this.selectType = value;
    },
    getComment() {
      GetComment({
        goods_id: this.goodsId
      }).then(res => {
        let { code, data, msg } = res;
        if (code === 1) {
          this.commentList = data;
        }
      });
    },
    translateStar(num) {
      return num.replace(/(\d{3})\d{4}(\d{3})/, "$1****$2");
    }
  }
};
</script>

<style scoped lang='scss'>
.goods-detail {
  margin-bottom: 50px;
  margin-top: 100px;
  .container {
    width: 1200px;
    margin: 0 auto;
    > h3 {
      font-size: 32px;
      text-align: center;
      // margin-top: 40px;
      padding: 40px 0;
      border-bottom: 18px solid rgb(246, 246, 246);
    }
    .cont {
      min-height: 1000px;
      margin-top: 20px;
      .info-comment {
        float: left;
        width: 880px;
        .info-box {
          display: flex;
          justify-content: space-between;
          height: 250px;
          margin-bottom: 20px;
          .img-box {
            width: 400px;
            img {
              width: 100%;
              height: 100%;
            }
          }
          .info-list {
            width: 480px;
            border: 1px solid #e1e1e1;
            border-left: 0;
            padding: 0 20px;
            box-sizing: border-box;
            .info-item {
              display: flex;
              justify-content: space-between;
              align-items: center;
              height: 40px;
              .name {
                max-width: 340px;
                font-size: 18px;
                color: #333333;
                font-weight: 700;
              }
              .numbering {
                font-size: 13px;
                color: #5e5e5e;
              }
              .price {
                .marking-price {
                  color: #5e5e5e;
                  text-decoration: line-through;
                  margin-right: 5px;
                }
                .true-price {
                  color: #ff0000;
                }
              }
              .cantsee {
                color: #ff0000;
              }

              .collect {
                color: #333333;
                font-size: 13px;
                cursor: pointer;
                i {
                  font-size: 24px;
                  vertical-align: sub;
                }
                .el-icon-star-on {
                  color: #f4ea2a;
                }
              }
              .type {
                font-size: 13px;
                color: #333333;
              }
              .time {
                font-size: 13px;
                span {
                  color: #ff0000;
                }
                i {
                  font-size: 24px;
                  margin-right: 8px;
                  vertical-align: sub;
                }
              }
              .terminal {
                font-size: 13px;
                color: #333333;
                .el-select {
                  width: 250px;
                }
              }
            }
            .btns {
              display: flex;
              justify-content: space-between;
              margin-bottom: 10px;
              margin-top: 10px;
              .btn {
                width: 120px;
                height: 40px;
                line-height: 40px;
                color: #ffffff;
                border-radius: 4px;
                border: 0;
                text-align: center;
              }
              .show-btn {
                background-color: rgb(22, 155, 213);
              }
              .made-like-btn {
                background-color: rgb(246, 46, 46);
              }
              .made-btn {
                background-color: rgb(255, 153, 0);
              }
            }
            .tips {
              font-size: 13px;
              color: #ff0000;
              display: flex;
              .iconfont {
                font-size: 20px;
              }
              .el-carousel--vertical {
                flex: 1;
                line-height: 20px;
                margin-left: 5px;
              }
            }
          }
        }
        .comment-box {
          .desc-box{
            height: 700px;
            overflow: auto;
          }
          .cm-p {
            line-height: 28px;
          }
          .comment-list {
            height: 700px;
            overflow: auto;
            .comment-item {
              border-bottom: 1px solid #e1e1e1;
              margin-bottom: 28px;
              padding-bottom: 16px;
              &:last-of-type {
                border-bottom: 0;
                margin-bottom: 0;
              }
              .user-comment {
                display: flex;
                .user-box {
                  text-align: center;
                  margin-right: 20px;
                  width: 100px;
                  .phone {
                    font-size: 13px;
                    color: #434343;
                    margin: 5px 0;
                  }
                  .user-level {
                    font-size: 12px;
                    img {
                      width: 20px;
                      height: 20px;
                      vertical-align: middle;
                    }
                    .member-a {
                      color: #bfbfbf;
                    }
                    .member-b {
                      color: #e1b80d;
                    }
                    .member-c {
                      color: #49bbfb;
                    }
                    .member-d {
                      color: #ffb103;
                    }
                  }
                }
                .comment-div {
                  position: relative;
                  flex: 1;
                  .comment-cont {
                    font-size: 18px;
                    color: #5e5e5e;
                    line-height: 28px;
                    margin-bottom: 20px;
                  }
                  .comment-time {
                    position: absolute;
                    bottom: 0;
                    font-size: 16px;
                    color: #aeaeae;
                  }
                }
              }
              .seller-comment {
                margin: 12px 0 0 120px;
                border-top: 1px solid #e1e1e1;
                .reply-cont {
                  margin-top: 12px;
                  margin-bottom: 20px;
                  color: #5e5e5e;
                  line-height: 28px;
                  .seller-title {
                    color: #ff99cc;
                  }
                }
                .reply-time {
                  color: #aeaeae;
                }
              }
            }
          }
        }
      }
      .recommend {
        position: relative;
        float: right;
        width: 300px;
        border: 1px solid #e1e1e1;
        box-sizing: border-box;
        .recommend-title {
          height: 42px;
          line-height: 42px;
          padding-left: 14px;
          background-color: rgb(246, 246, 246);
          .icon-remen {
            color: #ff0000;
          }
        }
        .recommend-list {
          .recommend-item {
            display: flex;
            justify-content: space-between;
            height: 88px;
            padding: 20px 12px;
            border-bottom: 1px solid #e1e1e1;
            &:last-of-type {
              border-bottom: 0;
            }
            .recommend-img {
              width: 130px;
              height: 86px;
              img {
                width: 100%;
                height: 100%;
              }
            }
            .recommend-info {
              width: 135px;
              color: #333333;
              font-size: 14px;
              .name {
                font-weight: 700;
                margin: 8px 0;
              }
              .time {
                margin-bottom: 10px;
                .el-icon-time {
                  font-size: 20px;
                  vertical-align: sub;
                }
                span {
                  color: #ff0000;
                }
              }
            }
          }
        }
        .more {
          position: absolute;
          right: 10px;
          bottom: -28px;
          font-size: 14px;
          a {
            color: #333333;
          }
        }
      }
    }
  }
}
</style>
<template>
  <div class="index">
    <div class="line line-marst">基础信息</div>
    <div class="main-top">
      <table>
        <tr>
          <td class="td-one">用户账号：</td>
          <td>{{information.phone}}</td>
          <td class="td-one">项目编号</td>
          <td>{{information.no}}</td>
        </tr>
        <tr>
          <td class="td-one">投融类型</td>
          <td>{{information.order_amount}}</td>
          <td class="td-one">项目名称</td>
          <td>{{information.lexing}}</td>
        </tr>
        <tr>
          <td class="td-one">行业领域</td>
          <td>{{information.created_at}}</td>
          <td class="td-one">赏金</td>
          <td>￥{{information.money}}</td>
        </tr>
      </table>
    </div>
    <div class="line line-marst">内容回复</div>
    <orderDetail :statusData="statusData" :status="status" />
    <div class="line line-vice">内容/合同/协议/确认文书</div>
    <!-- 我要发稿 -->
    <div class="determine-box">
      <div class="dzxq-main" v-if="status == 1">
        <Form :label-width="200">
          <FormItem>
            <div style="font-size:13px;color:#333333">
              <i></i>
              <span>温馨提示：为避免个人隐私泄露，以及获得更多打赏金，建议提交资料前，暂时保密联系方式！</span>
            </div>
          </FormItem>
          <FormItem label="项目名称：">
            <span>*</span>
            <br />
            <div>智慧摇摇车</div>
          </FormItem>
          <!-- <FormItem>
            <div class="dsjBox">
              <div>
                <div>行业领域：<span>*</span></div>
                <div>智慧仪器</div>
              </div>
              <div>
                <div>期待打赏金：</div>
                <div><span>30</span><span>元</span></div>
              </div>
            </div>
          </FormItem>-->
          <FormItem label="行业领域">
            <div class="dsjBox">
              <div>
                <span>*</span>
                <br />
                <div>智慧仪器</div>
              </div>
              <div class="dsjSmBox">
                <div>期待打赏金：</div>
                <div>
                  <span>30</span>
                  <span>元</span>
                </div>
              </div>
            </div>
          </FormItem>
          <FormItem label="项目定位：">
            <span>*</span>
            <br />
            <div>摇摇车又称摇摆机、摇摆车、儿童投币摇摇机、摇篮车等，是游乐设备中的一种。摇摆机是会摇的，前部可加有屏幕，在摇摆的同时有音乐伴奏。摇摇车又称摇摆机、摇摆车、儿童投币摇摇机、摇篮车等，是游乐设备中的一种。摇摆机是会摇的，前部可加有屏幕，在摇摆的同时有音乐伴奏。</div>
          </FormItem>
          <FormItem label="项目亮点：">
            <span>*</span>
            <br />
            <div>摇摇车又称摇摆机、摇摆车、儿童投币摇摇机、摇篮车等，是游乐设备中的一种。摇摆机是会摇的，前部可加有屏幕，在摇摆的同时有音乐伴奏。摇摇车又称摇摆机、摇摆车、儿童投币摇摇机、摇篮车等，是游乐设备中的一种。摇摆机是会摇的，前部可加有屏幕，在摇摆的同时有音乐伴奏。</div>
          </FormItem>
          <FormItem label="营收模式：">
            <span>*</span>
            <br />
            <div>摇摇车又称摇摆机、摇摆车、儿童投币摇摇机、摇篮车等，是游乐设备中的一种。摇摆机是会摇的，前部可加有屏幕，在摇摆的同时有音乐伴奏。摇摇车又称摇摆机、摇摆车、儿童投币摇摇机、摇篮车等，是游乐设备中的一种。摇摆机是会摇的，前部可加有屏幕，在摇摆的同时有音乐伴奏。</div>
          </FormItem>
          <FormItem label="目前用户数据：">
            <span>*</span>
            <br />
            <div>摇摇车又称摇摆机、摇摆车、儿童投币摇摇机、摇篮车等，是游乐设备中的一种。摇摆机是会摇的，前部可加有屏幕，在摇摆的同时有音乐伴奏。摇摇车又称摇摆机、摇摆车、儿童投币摇摇机、摇篮车等，是游乐设备中的一种。摇摆机是会摇的，前部可加有屏幕，在摇摆的同时有音乐伴奏。</div>
          </FormItem>
          <FormItem label="目前融资阶段，资金需求，估值：">
            <span>*</span>
            <br />
            <div>摇摇车又称摇摆机、摇摆车、儿童投币摇摇机、摇篮车等，是游乐设备中的一种。摇摆机是会摇的，前部可加有屏幕，在摇摆的同时有音乐伴奏。摇摇车又称摇摆机、摇摆车、儿童投币摇摇机、摇篮车等，是游乐设备中的一种。摇摆机是会摇的，前部可加有屏幕，在摇摆的同时有音乐伴奏。</div>
          </FormItem>
          <FormItem label="创始人背景：">
            <span>*</span>
            <br />
            <div>摇摇车又称摇摆机、摇摆车、儿童投币摇摇机、摇篮车等，是游乐设备中的一种。摇摆机是会摇的，前部可加有屏幕，在摇摆的同时有音乐伴奏。摇摇车又称摇摆机、摇摆车、儿童投币摇摇机、摇篮车等，是游乐设备中的一种。摇摆机是会摇的，前部可加有屏幕，在摇摆的同时有音乐伴奏。</div>
          </FormItem>
        </Form>
      </div>
      <div class="xxjmh" v-if="status == 2">
        <div class="contentBoxA" v-for="(item,index) in dataArr" :key="index">
          <div class="lefthuichang">
            <div>
              <span class="lBlue">
                <i class="iconfont icon-zhuti"></i>
                <span>主题：</span>
              </span>
              <span>{{item.title}}</span>
            </div>
            <div>
              <span class="lBlue">
                <i class="iconfont icon-dizhi"></i>
                <span>地址：</span>
              </span>
              <span>{{item.region}}</span>
            </div>
            <div>
              <span class="lBlue">
                <i class="iconfont icon-shijian"></i>
                <span>时间：</span>
              </span>

              <span>
                {{item.add_time}}
                <span class="lBlue" style="padding:0 20px">到</span>
                <span>{{item.end_time}}</span>
              </span>
            </div>
            <div>
              <span class="lBlue">
                <i class="iconfont icon-renshu"></i>
                <span>上限人数：</span>
              </span>
              <span>{{item.upper_num}}人</span>
              <span class="lBlue" style="padding-left:30px;">
                <span>已报名人数：</span>
              </span>
              <span>30人</span>
            </div>
            <div>
              <img v-for="(item1,index1) in item.map_img" :key="index1" :src="item1" alt />
            </div>
            <div>
              <span class="lBlue">
                <i class="iconfont icon-guanli"></i>
                <span>已报名项目：</span>
              </span>
              <span>
                <span style="color:#ff0000">10</span>
                <span>项</span>
              </span>
            </div>
          </div>
          <div class="righthuichang">
            <div class="huanjinBox">
              <span class="lBlue">会务环境一览</span>
              <span class="lBlue">{{nowTiem >( new Date(item.end_time))?"活动回顾>":"未开始>"}}</span>
            </div>
            <div>
              <img :src="item.field_img" alt />
            </div>
          </div>
        </div>
      </div>
      <div class="httg" v-if="status == 3"></div>
      <div class="httg" v-if="status == 4"></div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import config from "../../../build/config";
import orderDetail from "../main_components/order/orderDetail.vue";
import qs from "qs";
const apiPost = (url, params) => {
  return axios.post(url, qs.stringify(params)).then(res => res.data);
};

export default {
  components: {
    orderDetail
  },
  data() {
    return {
      id: 0,
      title: "",
      duixiang: "",
      information: {
        //基础信息
        phone: "12345678912",
        no: "213123123123",
        order_amount: "123123",
        lexing: "代写稿件",
        created_at: "123123123",
        money: "12123123"
      },
      // 流程模块
      statusData: [
        {
          url: "",
          name: "线上沟通",
          tips: "等待确认"
        },
        {
          url: "",
          name: "线下见面会",
          tips: "等待确认"
        },
        {
          url: "",
          name: "合同托管",
          tips: "等待确认"
        },
        {
          url: "",
          name: "委托检测Ⅰ ",
          tips: "等待确认"
        },
        {
          url: "",
          name: "委托检测Ⅱ ",
          tips: "等待确认"
        }
      ],
      status: 1,
      // 单选框
      animalArr: [
        "自由型",
        "采访型",
        "评论型",
        "广告型",
        "炒作型",
        "故事型 ",
        "热点型",
        "新闻型"
      ],
      animal: "自由型",
      dengji: "1",
      zishu: "1",
      // 线下见面会
      dataArr: [
        {
          id: 4,
          title: "3254235",
          region: "天津市,市辖区,和平区",
          address: "3242342",
          add_time: "2019-11-26 00:00:00",
          end_time: "2019-11-30 00:00:00",
          upper_num: 1,
          cost: "1.00",
          field_img: "http://qiniu.siring.com.cn/ce37120191127115011466.jpg",
          map_img: [
            "http://qiniu.siring.com.cn/ce37120191127115011466.jpg",
            "http://qiniu.siring.com.cn/79cf3201911271150115253.png"
          ]
        },
        {
          id: 4,
          title: "3254235",
          region: "天津市,市辖区,和平区",
          address: "3242342",
          add_time: "2019-11-26 00:00:00",
          end_time: "2019-11-30 00:00:00",
          upper_num: 1,
          cost: "1.00",
          field_img: "http://qiniu.siring.com.cn/ce37120191127115011466.jpg",
          map_img: [
            "http://qiniu.siring.com.cn/ce37120191127115011466.jpg",
            "http://qiniu.siring.com.cn/79cf3201911271150115253.png"
          ]
        },
        {
          id: 4,
          title: "3254235",
          region: "天津市,市辖区,和平区",
          address: "3242342",
          add_time: "2019-11-26 00:00:00",
          end_time: "2019-11-30 00:00:00",
          upper_num: 1,
          cost: "1.00",
          field_img: "http://qiniu.siring.com.cn/ce37120191127115011466.jpg",
          map_img: [
            "http://qiniu.siring.com.cn/ce37120191127115011466.jpg",
            "http://qiniu.siring.com.cn/79cf3201911271150115253.png"
          ]
        },
        {
          id: 4,
          title: "3254235",
          region: "天津市,市辖区,和平区",
          address: "3242342",
          add_time: "2019-11-26 00:00:00",
          end_time: "2019-11-30 00:00:00",
          upper_num: 1,
          cost: "1.00",
          field_img: "http://qiniu.siring.com.cn/ce37120191127115011466.jpg",
          map_img: [
            "http://qiniu.siring.com.cn/ce37120191127115011466.jpg",
            "http://qiniu.siring.com.cn/79cf3201911271150115253.png"
          ]
        }
      ]
    };
  },
  created() {
    this.init();
  },
  methods: {
    init() {
      this.status = this.$route.params.status;
      this.id = this.$route.params.id;
    }
  }
};
</script>
<style>
.pt-bj .ivu-upload-drag {
  border: 0;
}
</style>
<style lang="less" scoped>
.index {
  width: 100%;
  background-color: #fff;
  padding: 10px 20px;
  font-style: normal;
  .line {
    font-weight: 700;
    margin-top: 20px;
    font-size: 16px;
  }
  .line-marst {
    background-color: rgb(242, 242, 242);
    color: #000;
  }
  .line-vice {
    background-color: rgb(207, 234, 239);
    color: rgb(47, 121, 164);
  }
  .determine-box {
    height: 600px;
    border: 1px solid rgb(240, 248, 250);
    overflow-y: scroll;
    color: #999999;
    .dzxq-main {
      padding: 30px;
      display: flex;
      justify-content: center;
    }
  }
  .main-top {
    table {
      width: 100%;
    }
    table,
    td {
      border: 1px solid rgb(242, 242, 242);
      border-collapse: collapse;
      border-spacing: 0;
      text-align: center;
      line-height: 28px;
    }
    .td-one {
      width: 20%;
      font-weight: 700;
      font-size: 12px;
    }
  }
  .dsjBox {
    display: flex;
    justify-content: space-between;
    > div {
      width: 50%;
    }
    .dsjSmBox {
      > div {
        &:nth-of-type(1) {
        }
        &:nth-of-type(2) {
          display: flex;
          justify-content: space-between;
        }
      }
    }
  }
}
.lefthuichang {
  width: 60%;
  margin-right: 10%;
  img {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    padding-right: 10px;
  }
  > div {
    margin-bottom: 10px;
  }
  i {
    padding-right: 10px;
  }
}
.righthuichang {
  img {
    display: inline-block;
    width: 274px;
    height: 213px;
  }
}
.redColor {
  color: #ff0000;
  font-size: 18px;
}
.redColorB {
  border: 1px solid #797979;
  padding: 5px 10px;
}
.huichangTitle {
  font-size: 24px;
  color: #000000;
  font-weight: 700;
  text-align: center;
  margin-bottom: 10px;
}
.yuyue {
  text-align: center;
  color: #ff0000;
  margin-bottom: 10px;
  i {
    font-weight: 700;
    font-size: 18px;
    padding-right: 5px;
  }
}
.lBlue {
  color: #169bd5;
}
.contentBoxA {
  margin: 20px auto;
  display: flex;
  padding: 10px 10px;
  width: 1200px;
  border: 1px dashed;
  justify-content: space-between;
}
.huanjinBox {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}
</style>

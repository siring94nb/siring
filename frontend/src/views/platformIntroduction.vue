<template>
  <div>
    <Myheader />
    <div class="bigBox">
      <div>
        <div>
          <div v-for="(item,index) in dataArr1" :key="index">
            <span v-if="dataIndex1 == index">{{dataArr1[dataIndex1]}}</span>
          </div>
        </div>
        <div>多重平台，多重服务</div>
      </div>
      <!-- 三个模板 -->
      <div class="mubanBox">
        <div v-for="(item,index) in mubanArr" :key="index" @click.stop="gbMuBan(index)">
          <div :class="{'bag1':index==0,'bag2':index==1,'bag3':index==2}">
            <i :class="item.icon"></i>
            <div>{{item.title}}</div>
            <i :class="item.icon"></i>
          </div>
          <div :class="{'bs1':index==0,'bs2':index==1,'bs3':index==2}">
            <ul>
              <li v-for="(item1,index1) in item.neirong" :key="index1">{{item1}}</li>
            </ul>
            <div style="display:flex;justify-content: center">
              <button :class="{'bag1':index==0,'bag2':index==1,'bag3':index==2}">立即登录</button>
            </div>
          </div>
        </div>
      </div>
      <!-- 模板对应内容介绍 -->
      <div class="muBanContent">
        <!-- 指向箭头 -->
        <div class="imgBox"><div v-for="(item,index) in imgArr" :key="index" ><img v-if="index == dataIndex1" :src="item" :alt="index" /></div></div>
        <!-- 内容 -->
        <div class="neirongBigBox">
          <!-- 内容1 -->
          <div class="neirongBox1" v-if="dataIndex1 == 0">
            <div>定制开发服务是思锐Siring针对不同层次企业对移动互联网应用不同需求的专业化定制开发建设服务。提供优质的移动互联网应用服务，互惠共赢，是我们长期追求的理想。</div>
            <div>思锐Siring是中国最早从事互联网服务的企业之一，已为几十家上市公司、几百家国内外知名企业提供服务。思锐Siring的移动互联网经验，客户运用效果、经营业绩，在全国名列前茅。 凭借思锐Siring的技术和经验，我们将成为您移动互联网应用的坚实合作伙伴，和客户一起把移动互联网应用开发做得更好！</div>
            <div class="imgBox1">
              <div><img :src="ruanjianImgArr[0]" alt="软件定制"></div>
              <div style="padding-bottom:20px;"><img src="../assets/images/hen.png" alt=""></div>
              <div><img :src="ruanjianImgArr[1]" alt="软件定制"></div>
            </div>
          </div>
          <div class="neirongBox2" v-if="dataIndex1 == 1">
            <div>小程序SaaS平台是全平台商业应用服务商,无门槛可视化拖拽制作,向商家提供海量应用及小程序注册及运营平台,灵活的编辑功能助力千万商户引流增长,无需懂代码一键生成发布...</div>
            <div>思锐Siring是中国最早从事互联网服务的企业之一，已为几十家上市公司、几百家国内外知名企业提供服务。思锐Siring的移动互联网经验，客户运用效果、经营业绩，在全国名列前茅。 凭借思锐Siring的技术和经验，我们将成为您移动互联网应用的坚实合作伙伴，和客户一起把移动互联网应用开发做得更好！</div>
            <div class="imgBox1">
              <div><img :src="xiaochengxuImgArr[0]" alt="小程序定制"></div>
              <div><img :src="xiaochengxuImgArr[1]" alt="小程序定制"></div>
              <div style="margin-top:-30px;"><img :src="xiaochengxuImgArr[2]" alt="小程序定制"></div>
            </div>
          </div>
          <div class="neirongBox3" v-if="dataIndex1 == 2">
            <div>近年来，随着国内程序化购买市场日趋升温，各大巨头企业纷纷抓住构建程序化广告平台。作为国内AI智能领域的技术专家，Siring自主人工智能研发团队孵化智能营销平台AI推广运营投放平台，以人工智能技术赋能广告投放，为国内市场带来新一轮的营销升级</div>
            <div> AI推广运营投放平台 通过先进的人工智能机器学习算法与第三方DMP进行媒体受众覆盖率分析，受众及受众来源的媒介流量筛选，并且通过AI智能系统实时优化数据，可以根据DMP的判别达成“不同人群匹配不同创意”，来达到更加贴合消费者的沟通效果，增加对品牌的认知度的同时提升ROI</div>
            <div class="imgBox1">
              <div><img :src="toufangImgArr[0]" alt="小程序定制"></div>
              <div style="margin-top:-60px;"><img :src="toufangImgArr[1]" alt="小程序定制"></div>
              <div><img :src="toufangImgArr[2]" alt="小程序定制"></div>
              <div><img :src="toufangImgArr[3]" alt="小程序定制"></div>
              <div style="margin-top:-40px;"><img :src="toufangImgArr[4]" alt="小程序定制"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <Myfooter />
  </div>
</template>
<script>
import Myheader from "@/components/header";
import Myaside from "@/components/aside";
import Jsjm from "@/components/jsjm";
import Jdyh from "@/components/jdyh";
import Myfooter from "@/components/footer";
import Myswiper from "@/components/mySwiper";
export default {
  components: {
    Myheader,
    Myaside,
    Jsjm,
    Jdyh,
    Myfooter,
    Myswiper
  },
  data() {
    return {
      dataArr1: [
        "20年沉淀，一站式定制开发推广运营领航者",
        "20年沉淀，IOE应用开发领航者",
        "描述未知"
      ],
      dataIndex1: 0,
      mubanArr: [
        {
          icon: "iconfont icon-dingzhi",
          title: "软件/定制开发平台",
          neirong: [
            "以优惠的收费标准,根据您的要求为您订做适合自己管理需求的软件",
            "模版化产品订购"
          ]
        },
        {
          icon: "iconfont icon-SaaS",
          title: "小程序SaaS平台",
          neirong: [
            "无需懂代码,您也可自由拼装模块即可完成, 帮助千万商户轻松搭建电商、建站、零售等全行业"
          ]
        },
        {
          icon: "iconfont icon-kongzhitai",
          title: "AI推广运营平台",
          neirong: [
            "以优惠的收费标准,根据您的要求为您订做适合自己管理需求的软件",
            "模版化产品订购"
          ]
        }
      ],
      imgArr: [
        require("../assets/images/u5216.png"),
        require("../assets/images/u5292.png"),
        require("../assets/images/u5438.png")
      ],
      // 软件定制模板图片
      ruanjianImgArr: [
        require("../assets/images/u5219.png"),
        require("../assets/images/u5228.png"),
      ],
      // 小程序模板图片
      xiaochengxuImgArr:[
        require("../assets/images/xiaochengxu1.png"),
        require("../assets/images/xiaochengxu2.png"),
        require("../assets/images/xiaochengxu3.png"),
      ],
      // 投放图片
      toufangImgArr:[
        require("../assets/images/toufang1.png"),
        require("../assets/images/toufang2.png"),
        require("../assets/images/toufang3.png"),
        require("../assets/images/toufang4.png"),
        require("../assets/images/toufang5.png"),
      ]
    };
  },
  methods: {
    gbMuBan(num) {
      this.dataIndex1 = num;
    }
  }
};
</script>
<style lang="scss" scoped>
.bigBox {
  margin-top: 100px;
  border-top: 10px solid rgb(242, 242, 242);
  min-width: 1470px;
  > div {
    &:nth-of-type(1) {
      text-align: center;
      padding: 50px 0;
      > div {
        font-size: 40px;
        color: #333333;
        &:nth-of-type(2) {
          font-size: 28px;
          color: #6b6b6b;
          padding-top: 10px;
        }
      }
    }
  }
  .mubanBox {
    display: flex;
    justify-content: space-between;
    margin: 0 10% 50px 10%;
    .bag1 {
      background-color: rgb(118, 100, 253); /* 不支持线性的时候显示 */
      background-image: linear-gradient(
        to bottom right,
        rgb(118, 100, 253),
        rgb(72, 69, 253)
      );
    }
    .bag2 {
      background-color: rgb(255, 108, 103); /* 不支持线性的时候显示 */
      background-image: linear-gradient(
        to bottom right,
        rgb(255, 108, 103),
        rgb(253, 88, 83)
      );
    }
    .bag3 {
      background-color: rgb(29, 216, 211); /* 不支持线性的时候显示 */
      background-image: linear-gradient(
        to bottom right,
        rgb(29, 216, 211),
        rgb(29, 216, 211)
      );
    }
    .bs1 {
      box-shadow: 0px 10px 10px rgb(118, 100, 253);
    }
    .bs2 {
      box-shadow: 0px 10px 10px rgb(255, 108, 103);
    }
    .bs3 {
      box-shadow: 0px 10px 10px rgb(29, 216, 211);
    }
    > div {
      max-width: 468px;
      margin: 0 20px;
      position: relative;
    }
    button {
      position: absolute;
      bottom: 20px;
      padding: 8px 50px;
      // left: 70px;
      color: #ffffff;
      font-size: 28px;
      font-weight: 700;
      border-radius: 3px;
      border: 0.5px solid #ffffff;
    }
    > div > div {
      &:nth-of-type(1) {
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        height: 160px;
        color: #ffffff;
        padding: 3px;
        font-size: 36px;
        font-weight: 700;
        > div {
          text-align: center;
        }
        i {
          font-weight: normal;
          color: rgb(191, 191, 191);
          &:nth-of-type(1) {
            font-size: 60px;
          }
          &:nth-of-type(2) {
            display: block;
            text-align: right;
            font-size: 30px;
            padding-top: 15px;
          }
        }
      }
      &:nth-of-type(2) {
        min-height: 290px;
        box-sizing: border-box;
        ul {
          font-size: 18px;
          color: #999999;
          font-weight: 700;
          padding: 30px 15px;
          margin-left: 30px;
        }
        li {
          padding: 10px 0;
          line-height: 30px;
          list-style: disc;
        }
      }
    }
  }
  .muBanContent {
    width: 100%;
    .imgBox {
      display: flex;
      justify-content: space-between;
      margin: 0 15% 0 15%;
      border-bottom: 1px solid rgb(174,174,174);
      img{
        display: block;
      }
    }
    .neirongBigBox{
      border: 1px solid rgb(174,174,174);
      border-top: 0;
      margin: 0 15% 50px 15%;
      padding:30px 30px 0 30px;
      font-size: 16px;
      color: #333333;
      text-indent:2em;
      .neirongBox1,.neirongBox2,.neirongBox3{
        >div{
          line-height: 22px;
          margin-bottom: 20px;
          &:nth-last-child(1){
            margin-bottom: 0;
          }
          img{
            width: 99%;
          }
        }
        .imgBox1{
          width: 100%;
          background: rgb(247,247,247);
          padding: 0 60px 0 0;
          margin-left: -30px;
          text-align: center;
          padding-bottom: 30px;
        }
      }
    }
  }
}
</style>
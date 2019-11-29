<template>
  <div class="index">
    <myheader />
    <div class="index">
      <div class="title-top">
        <img src="../assets/images/un123.jpg" alt />
      </div>
      <div class="h-title">核心团队</div>
      <div class="core-team">
        <div class="team-list">
          <div
            class="team-member"
            v-for="(item, index) in teamList"
            :key="index"
            :class="{'team-member-sel': selOne === index}"
            @click="mouseSel(index)"
          >
            <img :src="item.images" alt />
            <div class="eg-name">{{item.egName}}</div>
            <div>{{item.name}}</div>
          </div>
        </div>
        <div class="personal-profile">
          <div class="personal-top">
            <img :src="personal.images" alt />
            <div class="name">{{personal.position}}：{{personal.name}}</div>
            <div class="egname">{{personal.egName}}</div>
          </div>
          <div class="personal-bottom">
            <div>
              <span>个人介绍：</span>
              {{personal.introduce}}
            </div>
            <div>
              <span>涉及领域：</span>
              {{personal.field}}
            </div>
            <div>
              <span>服务过的品牌：</span>
              {{personal.brand}}
            </div>
          </div>
        </div>
      </div>
      <div class="h-title">各项荣誉及证书</div>
      <div class="sweep-box">
        <el-carousel :interval="4000" type="card" height="500px" arrow="always">
          <el-carousel-item v-for="item in 3" :key="item">
            <div class="sweep-main">
              <img src="../assets/images/un123.jpg" alt />
              <div style="text-align:center;line-height:90px;background-color: #fff;">2016年最佳服务商</div>
            </div>
          </el-carousel-item>
        </el-carousel>
      </div>
    </div>
    <div class="h-title">联系地址及留言</div>
    <div class="contact">
      <div class="contact-address">
        <p>联系我们</p>
        <p>zhq@siring.com.cn</p>
        <p>0755-36609873</p>
        <p>深圳市福田区新闻路1号中电信息大厦1518室</p>
        <img src="../assets/images/u5629.png" alt />
      </div>
      <div class="contact-message">
        <div class="message-title">留言反馈</div>
        <el-form
          label-position="top"
          label-width="80px"
          :model="ruleForm"
          style="width:90%;margin:auto;"
        >
          <el-form-item label="留言主题">
            <el-input type="textarea" v-model="ruleForm.desc"></el-input>
          </el-form-item>
          <el-form-item label="留言内容">
            <el-input type="textarea" v-model="ruleForm.desc1" class="texts"></el-input>
          </el-form-item>
          <el-form-item style="float:right;">
            <el-button type="primary">发送</el-button>
          </el-form-item>
        </el-form>
      </div>
    </div>
    <myfooter />
  </div>
</template>

<script>
// @ is an alias to /src
import Myheader from "@/components/header";
import Myaside from "@/components/aside";
import Jsjm from "@/components/jsjm";
import Jdyh from "@/components/jdyh";
import Myfooter from "@/components/footer";
import Myswiper from "@/components/mySwiper";
export default {
  name: "index",
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
      teamList: [
        {
          name: "张总",
          egName: "MR.ZHANG",
          position: "总经理",
          images: "https://teahouse.siring.cn/u9898.jpg",
          introduce:
            "思锐网络创始人、思锐网络总经理、思锐首席产品构架师、思锐首席产品体验官",
          field: "企业转型、品牌打造、企业运营",
          brand: "有着10年经验的自身网络营销策划专家，累计服务企业1200多家"
        },
        {
          name: "啊禄",
          egName: "MR.LU",
          position: "技术总监",
          images:
            "https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1574917857051&di=5e2dc1bd744babc71f3ba3c7f0758382&imgtype=0&src=http%3A%2F%2Fn.sinaimg.cn%2Fsinacn%2Fw1080h1350%2F20180224%2Fcfde-fyrwsqh7599857.jpg",
          introduce:
            "思锐网络创始人、思锐网络总经理、思锐首席产品构架师、思锐首席产品体验官",
          field: "企业转型、品牌打造、企业运营",
          brand: "有着10年经验的自身网络营销策划专家，累计服务企业1200多家"
        },
        {
          name: "啊康",
          egName: "MR.KANG",
          position: "技术顾问",
          images:
            "https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1574917931504&di=af13b0a4db82e0eca82afe59b222fe81&imgtype=0&src=http%3A%2F%2Fimage001.tlzhao.com%2F20170526%2F2e80cb8e82a01a9900239b8d7706b733.jpg",
          introduce:
            "思锐网络创始人、思锐网络总经理、思锐首席产品构架师、思锐首席产品体验官",
          field: "企业转型、品牌打造、企业运营",
          brand: "有着10年经验的自身网络营销策划专家，累计服务企业1200多家"
        },
        {
          name: "啊杨",
          egName: "MR.YANG",
          position: "技术副总监",
          images:
            "http://img0.imgtn.bdimg.com/it/u=1169160340,3834197503&fm=214&gp=0.jpg",
          introduce:
            "思锐网络创始人、思锐网络总经理、思锐首席产品构架师、思锐首席产品体验官",
          field: "企业转型、品牌打造、企业运营",
          brand: "有着10年经验的自身网络营销策划专家，累计服务企业1200多家"
        },
        {
          name: "啊杰",
          egName: "MR.JIE",
          position: "打工仔",
          images:
            "http://img3.yxlady.com/yl/UploadFiles_5361/2016087/20160807103705609.jpg",
          introduce:
            "思锐网络创始人、思锐网络总经理、思锐首席产品构架师、思锐首席产品体验官",
          field: "企业转型、品牌打造、企业运营",
          brand: "有着10年经验的自身网络营销策划专家，累计服务企业1200多家"
        },
        {
          name: "啊伟",
          egName: "MR.WEI",
          position: "前端技术总监",
          images:
            "https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1574918432254&di=2696aa1a3a18faa60e36d09371280613&imgtype=0&src=http%3A%2F%2Fimgwx4.2345.com%2Fdianyingimg%2Fimg%2F9%2F46%2Fs138395.jpg",
          introduce:
            "思锐网络创始人、思锐网络总经理、思锐首席产品构架师、思锐首席产品体验官",
          field: "企业转型、品牌打造、企业运营",
          brand: "有着10年经验的自身网络营销策划专家，累计服务企业1200多家"
        }
      ],
      personal: {
        name: "",
        egName: "",
        position: "",
        images: "",
        introduce: "",
        field: "",
        brand: ""
      },
      selOne: 0,
      ruleForm: {
        desc: "",
        desc1: ""
      }
    };
  },
  created() {
    this.personal = this.teamList[0];
  },
  methods: {
    mouseSel(index) {
      this.selOne = index;
      this.personal = this.teamList[index];
    }
  }
};
</script>
<style>
.sweep-main {
  width: 75%;
  box-shadow: 0 0 10px -0 rgb(204, 204, 204);
  margin: auto;
}
.sweep-main img {
  height: 400px;
  width: 100%;
}
.texts textarea {
  height: 250px;
}
/* .el-carousel__item:nth-child(2n) {
    background-color: #99a9bf;
  }
  
  .el-carousel__item:nth-child(2n+1) {
    background-color: #fff;
    box-shadow: 10px 10px 10px -0 rgb(204, 204, 204);
  } */
</style>
<style lang="scss" scoped>
.index {
  margin-top: 100px;
  .title-top {
    img {
      width: 100%;
    }
  }
  .h-title {
    font-size: 33px;
    text-align: center;
    margin: 40px auto;
  }
  .core-team {
    background-color: rgb(228, 228, 228);
    padding: 30px;
    display: flex;
    justify-content: center;
    .team-list {
      display: flex;
      flex-wrap: wrap;
      background-color: rgb(232, 232, 232);
      width: 60%;
      margin-right: 10px;
      box-shadow: 0 0 10px -5px;
      .team-member {
        margin: 0 1px 1px 0;
        width: 220px;
        height: 300px;
        text-align: center;
        background-color: #fff;
        line-height: 30px;
        .eg-name {
          color: rgb(149, 166, 187);
        }
        img {
          width: 190px;
          height: 200px;
          margin-top: 20px;
        }
      }
      .team-member-sel {
        box-shadow: 10px 10px 10px -0 rgb(204, 204, 204);
        z-index: 666;
      }
    }

    .personal-profile {
      width: 25%;
      background-color: rgb(99, 99, 99);
      color: #fff;
      line-height: 26px;
      .personal-top {
        text-align: center;
        margin-top: 20px;
        div {
          font-weight: 700;
          font-size: 20px;
        }
        .egname {
          color: rgb(246, 147, 73);
        }
        img {
          width: 230px;
          height: 230px;
        }
      }
      .personal-bottom {
        margin-top: 10px;
        padding: 0 30px;
      }
    }
  }
  .contact {
    display: flex;
    justify-content: center;
    margin-bottom: 30px;
    .contact-address {
      background-color: rgb(242, 242, 242);
      padding: 30px;
      p {
        font-size: 13px;
        color: #333333;
        line-height: 23px;
      }
      img {
        width: 774px;
        height: 500px;
      }
    }
    .contact-message {
      border: 1px solid rgb(228, 228, 228);
      border-top-right-radius: 5px;
      border-bottom-right-radius: 5px;
      width: 500px;
      .message-title {
        font-size: 18px;
        text-align: center;
        margin: 50px 0;
      }
      .contact-btn {
        width: 90%;
      }
    }
  }
}
</style>
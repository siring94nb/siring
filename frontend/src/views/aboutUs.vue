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
          <div class="team-member" v-for="(item, index) in teamList" :key="index">
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
          name: "李禄",
          egName: "GENERAL MANAGER",
          position: "总经理",
          images: "https://teahouse.siring.cn/u9898.jpg",
          introduce:
            "思锐网络创始人、思锐网络总经理、思锐首席产品构架师、思锐首席产品体验官",
          field: "企业转型、品牌打造、企业运营",
          brand: "有着10年经验的自身网络营销策划专家，累计服务企业1200多家"
        },
        {
          name: "李禄",
          egName: "GENERAL MANAGER",
          position: "总经理",
          images: "https://teahouse.siring.cn/u9898.jpg",
          introduce:
            "思锐网络创始人、思锐网络总经理、思锐首席产品构架师、思锐首席产品体验官",
          field: "企业转型、品牌打造、企业运营",
          brand: "有着10年经验的自身网络营销策划专家，累计服务企业1200多家"
        },
        {
          name: "李禄",
          egName: "GENERAL MANAGER",
          position: "总经理",
          images: "https://teahouse.siring.cn/u9898.jpg",
          introduce:
            "思锐网络创始人、思锐网络总经理、思锐首席产品构架师、思锐首席产品体验官",
          field: "企业转型、品牌打造、企业运营",
          brand: "有着10年经验的自身网络营销策划专家，累计服务企业1200多家"
        },
        {
          name: "李禄",
          egName: "GENERAL MANAGER",
          position: "总经理",
          images: "https://teahouse.siring.cn/u9898.jpg",
          introduce:
            "思锐网络创始人、思锐网络总经理、思锐首席产品构架师、思锐首席产品体验官",
          field: "企业转型、品牌打造、企业运营",
          brand: "有着10年经验的自身网络营销策划专家，累计服务企业1200多家"
        },
        {
          name: "李禄",
          egName: "GENERAL MANAGER",
          position: "总经理",
          images: "https://teahouse.siring.cn/u9898.jpg",
          introduce:
            "思锐网络创始人、思锐网络总经理、思锐首席产品构架师、思锐首席产品体验官",
          field: "企业转型、品牌打造、企业运营",
          brand: "有着10年经验的自身网络营销策划专家，累计服务企业1200多家"
        },
        {
          name: "李禄",
          egName: "GENERAL MANAGER",
          position: "总经理",
          images: "https://teahouse.siring.cn/u9898.jpg",
          introduce:
            "思锐网络创始人、思锐网络总经理、思锐首席产品构架师、思锐首席产品体验官",
          field: "企业转型、品牌打造、企业运营",
          brand: "有着10年经验的自身网络营销策划专家，累计服务企业1200多家"
        }
      ],
      personal: {
        name: "李禄",
        egName: "GENERAL MANAGER",
        position: "总经理",
        images: "https://teahouse.siring.cn/u9898.jpg",
        introduce:
          "思锐网络创始人、思锐网络总经理、思锐首席产品构架师、思锐首席产品体验官",
        field: "企业转型、品牌打造、企业运营",
        brand: "有着10年经验的自身网络营销策划专家，累计服务企业1200多家"
      }
    };
  },
  methods: {}
};
</script>
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
}
</style>
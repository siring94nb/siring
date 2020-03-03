<template>
  <div class="index">
    <myheader />
    <div class="index">
      <div class="title-top">
        <img src="../assets/images/aboutUs.jpg" alt />
      </div>
      <div class="h-title">核心团队</div>
      <div class="core-team">
        <div>
          <div class="team-list">
          <div
            class="team-member"
            v-for="(item, index) in teamList"
            :key="index"
            :class="{'team-member-sel': selOne === index}"
            @click="mouseSel(index)"
          >
            <img :src="item.img" alt />
            <div class="eg-name">{{item.name}}</div>
            <div>{{item.position}}</div>
          </div>
        </div>
        <div class="personal-profile">
          <div class="personal-top">
            <img :src="personal.img" alt />
            <!-- <div class="name">{{personal.position}}：{{personal.name}}</div> -->
            <div class="name">{{personal.position}}</div>
            <div class="egname">{{personal.name}}</div>
          </div>
          <div class="personal-bottom">
            <div>
              <!-- <span>个人简历：</span> -->
              <!-- {{personal.introduce}} -->
              <div v-html="personal.con"></div>
            </div>
            <!-- <div>
              <span>专长领域：</span>
              {{personal.field}}
            </div> -->
            <!-- <div>
              <span>服务过的品牌：</span>
              {{personal.brand}}
            </div>-->
          </div>
        </div>
        </div>
        
      </div>
      <div class="h-title">各项荣誉及证书</div>
      <div class="sweep-box">
        <el-carousel :interval="4000" type="card" height="450px" arrow="always">
          <el-carousel-item v-for="(item, index) in honorImage" :key="index">
            <div class="sweep-main">
              <img :src="item.img" alt />
              <div style="text-align:center;line-height:90px;background-color: #fff;">{{item.title}}</div>
            </div>
          </el-carousel-item>
        </el-carousel>
      </div>
    </div>
    <div class="h-title">发展历程&留言反馈</div>
    <div class="contact">
      <!-- <div class="contact-address">
        <p>联系我们</p>
        <p>zhq@siring.com.cn</p>
        <p>0755-36609873</p>
        <p>深圳市福田区新闻路1号中电信息大厦西座701室</p>
        <img src="../assets/images/u5629.png" alt />
      </div>-->
      <div class="development-course">
        <div class="course-main">
          <img src="../assets/images/u5723.png" alt />
          <div class="course-line"></div>
        </div>
        <div class="course-title">
          <div class="title-box" v-for="(item, index) in courseTitle" :key="index">
            <img src="../assets/images/u5726.png" alt />
            <div class="line"></div>
            <div class="title-text">{{item.name}}</div>
          </div>
        </div>
      </div>
      <div class="contact-message">
        <div class="message-title">留言反馈</div>
        <el-form
          label-position="top"
          label-width="80px"
          :model="ruleForm"
          style="width:90%;margin:auto;"
        >
          <div class="float-title">
            <i class="iconfont icon-lianxifangshi" />联系方式：
          </div>
          <el-form-item>
              <el-input style="margin-bottom:10px;" type="text" placeholder="您的联系方式" v-model.number="ruleForm.desc"></el-input>
          </el-form-item>
          <div class="float-title">
            <i class="iconfont icon-liuyan" />留言反馈：
          </div>
          <el-form-item>
            <el-input  type="textarea" placeholder="您的需求或反馈，我们将在48个小时内，联系您" v-model="ruleForm.desc1" class="texts"></el-input>
          </el-form-item>
          <el-form-item style="float:right;">
            <el-button type="danger" style="background-color: #b83733;border-color:#b83733; margin-top:10px;">发送</el-button>
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
import {Member,Honor,GetRoleCenterGetRoleCenter} from "@/api/api"
export default {
  name: "index",
  components: {
    Myheader,
    Myaside,
    Jsjm,
    Jdyh,
    Myfooter,
    Myswiper,
  },
  data() {
    return {
      teamList: [
        {
          name: "Product Manager",
          egName: "Ronnie Zhang",
          position: "总经理",
          images: require("../assets/images/a1.jpg"),
          introduce:
            "1997年本科毕业武汉科技大学机械自动化专业，曾就职深圳茁壮网络、梦网科技等多家大型互联网公司及上市公司高管 ，历任产品部经理、移动增值业务部总经理等职务，在广泛接触着终端设备厂家、软件方案公司，通讯运营商，拥有富的带团队开发、运营推广实战经验。",
          field:
            "从技术到产品到管理岗位的转变，多年来一直领导并参与公司大部分重要集团项目的产品设计开发，包括腾讯智能语音项目、 高端慕思床垫项目，智慧共享型儿童摇摇车运营系统，中国移动积分商城系统，岭南优品APP等项目，精通物联网、大型综合电商、区块链防伪等项目领域"
          // brand: "有着10年经验的自身网络营销策划专家，累计服务企业1200多家"
        },
        {
          name: "Structural Engineer",
          egName: "Mark Li",
          position: "技术总监",
          images: require("../assets/images/b.jpg"),
          introduce:
            "2010年本科毕业于青岛科技大学软件工程专业，曾就职海南财富，担任研发工程师，主要从事软件开发工作，曾参与华星OA、金融证券等大/中型企业的业务系统和管理系统的研发。",
          field:
            "能独立的解决技术难题，热爱技术，积极主动研究技术及行业发展方向。熟练Windows，Linux平台以及Linux服务器的运维部署，熟练PHP ,.Net 以及分布式架构合理运用，熟练Mysql、Oracle、SqlServer，MongoDB等数据库。"
          // brand: "有着10年经验的自身网络营销策划专家，累计服务企业1200多家"
        },
        {
          name: "Senior Engineer",
          egName: "Iverson Guo",
          position: "技术顾问",
          images: require("../assets/images/c.jpg"),
          introduce:
            "2013年本科毕业于桂林师范大学电子信息工程专业，毕业后加入深圳市思锐信息技术有限公司，担任研发工程师。",
          field:
            "对跨境电商行业的商业模式和运营套路有深刻认识，对行业发展能深入的研究、理解，全球思维，出色的分析抽象的逻辑问题和数据分析，产品逻辑思维较严谨，善于将产品规划落地。B端C端经验兼顾，SAAS软件、To C折扣平台产品策划和运营。"
          // brand: "有着10年经验的自身网络营销策划专家，累计服务企业1200多家"
        },
        {
          name: "Development Engineer",
          egName: "Jeff Zheng",
          position: "技术副总监",
          images: require("../assets/images/e.jpg"),
          introduce:
            "2007年本科毕业于吉林大学软件工程专业，毕业后加入深圳市思锐信息技术有限公司，担任研发工程师。",
          field:
            "10年以上互联网和移动互联网、WIFI、金融、地产、电玩行业开发管理经验。精通项目管理、敏捷开发Scrum、瀑布开发、企业IT管理、分布式架构，精通WIFI互联网技术，深刻理解互联网&移动互联网平台产品，熟悉金融产品、地产系统、电玩系统、数据平台的开发和区块链技术。"
          // brand: "有着10年经验的自身网络营销策划专家，累计服务企业1200多家"
        },
        {
          name: "Application Developer",
          egName: "Ken Feng",
          position: "技术人员",
          images: require("../assets/images/f.jpg"),
          introduce:
            "2010年本科毕业于湖南农业大学东方科技学院计算机科学于技术专业，毕业后加入京东集团，担任研发工程师，不久转入深圳市思锐信息技术有限公司，主要从事软件开发工作。",
          field:
            "8年以上软件开发经验；互联网行业10年以上从业经验，5年物联网、智能家居软硬件研发管理经验；熟练使用java熟练dubbo,spring cloud等,C#；精通ORACLE、SQL SERVER、mysql等数据库设计；精通数据库设计、系统架构设计，设计模式PowerDesigner、Visio等；熟悉物联网、智能家居行业、互联网行业。"
          // brand: "有着10年经验的自身网络营销策划专家，累计服务企业1200多家"
        },
        {
          name: "R & D Engineer",
          egName: "Peter Lan",
          position: "前端技术总监",
          images: require("../assets/images/d.jpg"),
          introduce:
            "毕业于深圳大学软件工程专业，曾就职甲骨文研究开发中心（深圳）有限公司，2018年转入深圳市思锐信息技术有限公司，主要从事软件开发工作。",
          field:
            "对互联网与云计算行业有清晰的认知和激情，理解客户的业务需求和痛点，熟悉泛互联网行业，如跨境电商，游戏，互联网教育等领域技术架构。具有丰富的企业架构设计或上云实施服务经验；熟悉云计算，大数据，人工智能等领域，熟悉计算，存储，网络，数据库等领域，熟悉分布式计算，分布式存储，虚拟化技术。"
          // brand: "有着10年经验的自身网络营销策划专家，累计服务企业1200多家"
        },
        {
          name: "Senior Designer",
          egName: "Linda Qiu",
          position: "UI",
          images: require("../assets/images/g.jpg"),
          introduce:
            "毕业于华南理工大学艺术设计专业，曾就腾讯公司，2018年转入深圳市思锐信息技术有限公司，主要从事软件开发工作。",
          field:
            "熟练运动ps，Ai，sketch设计软件进行海报，banner，图标，的制作。 熟练使用RP，墨刀，进行交互设计。 利用Ae进行动效图制作。 利用C4D进行简单的建模和基础的渲染。"
          // brand: "有着10年经验的自身网络营销策划专家，累计服务企业1200多家"
        },
        {
          name: "Marketing Manager",
          egName: "Candy Cai",
          position: "销售经理",
          images: require("../assets/images/h.jpg"),
          introduce:
            "毕业于广州外语学院市场营销专业，曾就腾讯公司，2017年转入深圳市思锐信息技术有限公司，主要从事软件开发工作。",
          field:
            "具有5年及以上营销策划类经验或4A广告公司文案策划经验，熟悉各类营销理念，对腾讯、抖音信息流市场、商业化产品有深刻理解，熟悉并擅长撰写各种创意形式文案；拥有出色逻辑思维能力、敏锐的行业洞察能力、以及PPT撰写能力，懂得分配时间，灵活多变，追求结果，对数据敏感。"
          // brand: "有着10年经验的自身网络营销策划专家，累计服务企业1200多家"
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
      },
      honorImage: [
        {
          url: require("../assets/images/image536143.jpeg"),
          name: "众创服务平台创新创业基地"
        },
        {
          url: require("../assets/images/image536144.jpeg"),
          name: "中华人民共和国增值电信业务经营许可证"
        },
        {
          url: require("../assets/images/image536145.jpeg"),
          name: "质量·服务·诚信AAA企业"
        },
        {
          url: require("../assets/images/image536146.jpeg"),
          name: "安全联盟信誉企业"
        },
        {
          url: require("../assets/images/image536147.jpg"),
          name: "深圳市福田区人民政府英才证"
        },
        {
          url: require("../assets/images/image536148.jpeg"),
          name: "中国科技创新优秀企业"
        },
        {
          url: require("../assets/images/qkl.jpg"),
          name: "中国最具价值区块链企业"
        }
      ],
      courseTitle: [
        "2019年公司核心领导获得中共福田区委、福田区人民政府颁发的人才福卡福田英才证书",
        "2018年成为深圳大数据协会、物联网协会会员单位",
        "2017年荣获产业创新领域优质服务商奖",
        "2017年通过中国移动ITC严格评审，成为优质合作伙伴，承接各类定制开发业务",
        "2015年为企业级用户提供包括APP等手机移动端开发业务",
        "2010年开发短信群发系统，为国内4万多家企业用户免费使用",
        "2006年开发移动增值服务“百事通”推向市场，最高300万用户",
        "2000年开发Siring思锐办公OA办公系统开发成熟推广市场",
        "1996年深圳市思锐信息技术有限公司成立"
      ]
    };
  },
  // created() {
  //   this.personal = this.teamList[0];
  // },
  mounted(){
    this.init()
  },
  methods: {
    init(){
      this.getMember();
      this.getHonor();
      this.getCourse()
    },
    mouseSel(index) {
      this.selOne = index;
      this.personal = this.teamList[index];
    },
    // 获取核心成员列表
    getMember(){
      Member().then(res=>{
        let {data,code,msg} = res;
        if(code == 1){
          this.teamList = data;
          this.mouseSel(0);
        }
      })
    },
    // 各项荣誉及证书
    getHonor(){
      Honor().then(res=>{
        let {data,code,msg} = res;
        console.log(data);
        if(code == 1){
          this.honorImage = data
        }
      })
    },
    // 发展历程
    getCourse(){
      GetRoleCenterGetRoleCenter().then(res=>{
         let {data,code,msg} = res;
        console.log(data)
        if(code == 1){
          this.courseTitle = data.reverse()
        }
      })
    }
  }
};
</script>
<style>
.sweep-box {
  width: 80%;
  margin: auto;
}
.sweep-main {
  width: 75%;
  box-shadow: 0 0 10px -0 rgb(204, 204, 204);
  margin: auto;
}
.sweep-main img {
  height: 350px;
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
    >div{
      display: flex;
      justify-content: center;
      margin: 0 auto;
      max-width: 1600px;
    }
    .team-list {
      display: flex;
      flex-wrap: wrap;
      background-color: rgb(232, 232, 232);
      max-width: 884px;
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
      height: 600px;
      overflow-y:scroll;
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
    .personal-profile::-webkit-scrollbar{
	display:none
}
  }
  .contact {
    display: flex;
    justify-content: center;
    margin-bottom: 30px;
    // .contact-address {
    //   background-color: rgb(242, 242, 242);
    //   padding: 30px;
    //   p {
    //     font-size: 13px;
    //     color: #333333;
    //     line-height: 23px;
    //   }
    //   img {
    //     width: 774px;
    //     height: 500px;
    //   }
    // }
    .development-course {
      width: 800px;
      height: 627px;
      overflow-y: scroll;
      background-color: rgb(242, 242, 242);
      position: relative;
      .course-main {
        height: 96%;
        width: 80px;
        margin-left: 5%;
        img {
          margin-left: 1px;
          width: 80px;
          height: 80px;
        }
        .course-line {
          width: 10px;
          background-color: rgb(228, 228, 228);
          height: 87%;
          margin: auto;
          margin-top: -10px;
        }
      }
      .course-title {
        position: absolute;
        left: 2.5%;
        top: 15%;
        // margin-bottom: -30%;
        .title-box {
          display: flex;
          margin-left: 50px;
          margin-bottom: 40px;
          &:last-of-type{
            margin-bottom: 0;
          }
          img {
            width: 20px;
            height: 20px;
          }
          .line {
            height: 2px;
            width: 25px;
            background-color: #bcbcbc;
            margin: 8px 20px 0 20px;
          }
          .title-text {
            font-size: 18px;
            color: rgb(188, 199, 216);
          }
        }
      }
    }
    .development-course::-webkit-scrollbar{
      display: none
    }
    .contact-message {
      border: 1px solid rgb(228, 228, 228);
      border-top-right-radius: 5px;
      border-bottom-right-radius: 5px;
      width: 500px;
      height: 625px;
      .message-title {
        font-size: 18px;
        text-align: center;
        margin: 50px 0;
      }
      .float-title {
        font-size: 16px;
        color: #b83733;
        margin-bottom: 10px;
        font-weight: 700;
        line-height: 22px;
        i{
          font-size: 22px;
          margin-right: 5px;
        }
      }
      .contact-btn {
        width: 90%;
      }
    }
  }
}
</style>
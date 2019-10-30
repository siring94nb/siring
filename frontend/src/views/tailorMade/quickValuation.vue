<template>
  <div class="quickval">
    <myheader />
    <div class="quick-main">
      <h3 class="title">快捷估价</h3>
      <div class="quick-cont clearfix">
        <quickaside />
        <div class="types-right">
          <div class="types-list">
            <div class="types-title">选择开发端（可多选）</div>
            <div
              :class="{'type-item': true, 'on': item.ifchoose}"
              v-for="(item, index) in typeList"
              :key="index"
              @click="chooseType(item.id, index)"
            >
              <i :class="item.className"></i>
              <p class="type-name">{{ item.name }}</p>
            </div>
            <el-button type="primary" @click="next">下一步</el-button>
          </div>
          <div class="base-cont">
            <p class="base-title">开发前需要哪些方面的基础认识：</p>
            <el-collapse v-model="activeName" accordion>
              <el-collapse-item title="一、假如我要开发一款APP，需要选择哪些开发端？" name="1">
                <div>1、原型UI设计</div>
                <div>2、后台开发：一个APP要登录保存和获取数据，就需要将这些数据放到服务器的数据库中，通过后台去查询数据库，再返回结果给前台，因而这就要求APP要进行后台开发。</div>
                <div>3、接口开发：APP的接口开发即调用程序的接口，可以连接两个软件系统，起到调节程序的作用。</div>
                <div>4、APP端开发</div>
              </el-collapse-item>
              <el-collapse-item title="二、为什么开发需要做原型UI设计？" name="2">
                <div>1.UI设计源于对其产品名称和产品理念的创意，UI设计的三大具体分类——图形设计、交互设计和用户测试/研究的工作职能——分别对应的是美术设计的专业知识，软件工程师背景和相应的编程能力，以及社会学心理学等人文学科储备。当然，实际工作中，这几种职能也不是截然分开的。而今，这一涵盖诸多领域的职位，也越来越要求从业人员同时具备跨学科、综合性的理论素养和实际操作能力。</div>
                <div>2.在工作能力和实践经验上，一是要求从业人员精通Photoshop、AI、Axure、Flash等图形软件，Html、Dreamweaver等网页制作工具，能够独立完成静态网页设计工作；熟练操作常用办公软件，且具备其他软件应用能力；熟悉Html，CSS，Javascript，Ajax。二是要求对通用类软件或互联网应用产品的人机交互有自己的理解和认识。三是具备良好的审美能力、深厚的美术功底，有较强的平面设计和网页设计能力。四是具有敏锐的用户体验观察力，富有创新精神。</div>
              </el-collapse-item>
              <el-collapse-item title="三、后台开发是做什么的？" name="3">
                <div>1.网站/软件的组成由：网站后台程序+前端页面+域名+服务器+数据库，这几大项组合在一起，才是我们平常所访问的平台。</div>
                <div>2.一般我们访问一个平台的时候，所看到的基本都是前端内容，而前端内容又通过用户点击，然后触发后台的功能和数据库。所以我们可以访问浏览很多很多网页或者使用一些平台上特定的功能。</div>
                <div>3.前台是视图界面层，后台就是指软件的逻辑层和数据层。主要负责处理软件的逻辑业务关系、实现功能内部控制以及功能与功能之间的跳转切换控制、数据的读取和存储以及操作等等。</div>
              </el-collapse-item>
              <el-collapse-item title="四、PC端和移动端的区别有哪些？" name="4">
                <div>前端开发中PC端和移动端网站的区别，主要是：</div>
                <div>1、PC端在开发过程中考虑的是浏览器兼容性，移动端开发中考虑的是手机兼容性问题，做移动端开发，更多考虑的是手机分辨率的自适应和不同手机操作系统的略微差异化；</div>
                <div>2、在部分事件的处理上，移动端自然是偏向于触屏的，另外包括移动端弹出的手机键盘该如何处理，这样的问题在PC上肯定不会遇到，但在移动端，如果你没有经验，处理起来是相当麻烦的；</div>
                <div>3、布局上，移动端开发是要做到页面布局自适应的，而PC端页面布局的比例会相对固定；</div>
                <div>4、在动画效果处理上，PC端要考虑IE的兼容性，通常用JS做动画的通用性会好一些，但相比CSS3却牺牲了较大的性能，而在手机端，如果要做一些动画、特效等，第一选择肯定是CSS3，既简单，效率又高。</div>
                <div>总结：以上是移动端和PC端比较突显的区别，在实际的开发应用过程中，还会有更多的差异化区别。</div>
              </el-collapse-item>
              <el-collapse-item title="五、APP何为原生开发?何为混合开发?" name="5">
                <div>1.原生开发(Native App开发):像盖房子一样，先打地基然后浇地梁、房屋结构、一砖一瓦、钢筋水泥、电路走向等，原生APP同理:通过代码从每个页面、每个功能、每个效果、每个逻辑、每个步骤全部用代码写出来，一层层，一段段全用代码写出来，此种APP的数据都保存在本地，APP能及时调取，所以相应速度及流畅性有保障。</div>
                <div>2.混合开发(HTML5开发):这个就相当于一种框架开发，说白了就是网页;该模式通常由“HTML5云网站+APP应用客户端”两部份构成，APP应用客户端只需安装应用的框架部份，而应用的数据则是每次打开APP的时候，去云端取数据呈现给手机用户。虽然是APP能安装到手机上，但是每个界面，全部是网页，此种APP数据都保存在云端，用户每次访问都需要从云端调取全部内容，这样就容易导致反应慢，每打开一个网页或点一个按钮都需要等半天。</div>
              </el-collapse-item>
              <el-collapse-item title="六、APP、小程序的优劣势有哪些?" name="6">
                <div>1.首先，手机APP：</div>
                <div>优势：APP可实现功能多，而且是自己的平台，自己做主，不用太担心第三方的审核等问题。而且不需要花费多余的营销费用，从前期的引流、蓄客，到后期的老用户的维护，都有专门的手段，变现手段多种多样。在使用上，用户的体验最佳，流畅度高、反应速度快。目前，手机APP已经是企业移动电商最极致的体验，作用已经超过传统的电商。</div>
                <div>劣势：开发成本比较高，开发周期较长。另外就是APP的推广需要企业花费一定的功夫。</div>
                <div>2.其次：小程序</div>
                <div>优势：小程序作为微信电商的重量级产品，最大的优势就是与微信深度对接，嫁接微信9亿日活用户，而且小程序不需要下载，用户门槛低；微信逐步开放多个小程序入口，与微信深度绑定；超轻推广模式，获客成本低。扫一扫、搜一搜、发现周边小程序，即可使用；非常适合线下门店近场景营销使用。结合微信公众号等，打通形成微信商业闭环。</div>
                <div>劣势：因为嫁接的微信，所以入口较深。而且微信对小程序的限制比较多</div>
              </el-collapse-item>
            </el-collapse>
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
import Quickaside from '@/components/quickAside';
export default {
  components: {
    Myheader,
    Myfooter,
    Quickaside
  },
  data() {
    return {
      activeName: "1",
      typeList: [
        {
          className: "iconfont icon-gongyinglian",
          name: "原型UI",
          id: 1,
          ifchoose: false
        },
        {
          className: "iconfont icon-shezhi-",
          name: "后台",
          id: 2,
          ifchoose: false
        },
        {
          className: "iconfont icon-diannao",
          name: "PC",
          id: 3,
          ifchoose: false
        },
        {
          className: "iconfont icon-h5",
          name: "移动H5",
          id: 4,
          ifchoose: false
        },
        {
          className: "iconfont icon-pingguo",
          name: "APP苹果",
          id: 5,
          ifchoose: false
        },
        {
          className: "iconfont icon-anzhuologo",
          name: "APP安卓",
          id: 6,
          ifchoose: false
        },
        {
          className: "iconfont icon-weixinxiaochengxu",
          name: "小程序",
          id: 7,
          ifchoose: false
        }
      ],
      selectTypeList: [],
      hasChooseType: 0
    };
  },
  methods: {
    chooseType(id, index) {
      this.typeList[index].ifchoose = !this.typeList[index].ifchoose;
      if (this.typeList[index].ifchoose) {
        this.$set(this.selectTypeList, index, id);
      } else {
        this.$set(this.selectTypeList, index);
      }
    },
    next() {
      this.hasChooseType = 0;
      this.typeList.forEach(ele => {
        if (ele.ifchoose) {
          this.hasChooseType++
        }
      });
      if (this.hasChooseType) {
        this.$router.push('/selectFunction')
        sessionStorage.setItem('typeidList', JSON.stringify(this.selectTypeList));
      } else {
        this.$message.error("请选择开发类型");
      }
    }
  }
};
</script>

<style scoped lang='scss'>
.quickval {
  background-color: rgb(246, 246, 246);
  .quick-main {
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
    .quick-cont {
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
        .base-cont {
          background-color: #ffffff;
          padding: 20px 0 0 30px;
          height: 654px;
          .base-title {
            font-size: 14px;
            color: #797979;
            margin-bottom: 20px;
          }
          .el-collapse {
            margin-right: 30px;
            font-size: 12px;
            line-height: 1.5;
          }
        }
      }
    }
  }
}
</style>
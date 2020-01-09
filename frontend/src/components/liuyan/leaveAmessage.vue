<template>
  <div class="service">
    <div class="boxTitle">
      <span>平台顾问信息互动</span>
      <span>新消息（{{newxiaoxi}}）</span>
    </div>
    <div class="contentBox">
      <div v-for="(item,index) in data" :key="index">
        <!-- <div v-for="(item1,index1) in ceshiList" :key="index1">
          <span>{{index}}</span>
        </div> -->
        <div v-if="item.inside==1" class="guanfang">
          <div class="touxiangbox">
            <div>
              <img :src="item.img" :alt="item.name" />
            </div>
            <div>{{item.name}}</div>
          </div>
          <div class="demo">
            {{item.content}}
            <div class="out"></div>
            <div class="in"></div>
          </div>
        </div>
        <!-- <div v-if="(new Date(data[index].create_time).getTime())-(new Date(data[index-1>0?index:0].create_time).getTime())> 180000">{{data[index].create_time}}</div> -->
        <!-- <div >{{(new Date(data[index].create_time).getTime())-(new Date(data[index-1>0?index:0].create_time).getTime())}}</div> -->
        <!-- <div>{{new Date(data[index].create_time).getTime()}}</div>
        <div>{{new Date(data[index-1>0?index:0].create_time).getTime()}}</div>-->
        <div v-if="item.inside==0" class="guanfang" style="justify-content:flex-end">
          <div class="demo1">
            {{item.content}}
            <div class="out1"></div>
            <div class="in1"></div>
          </div>
          <div class="touxiangbox">
            <div>
              <img :src="item.img" :alt="item.name" />
            </div>
            <div>{{item.name}}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="btnValueBox">
      <input class="xiaoxiC" v-model="xiaoxiContent" @input="gbDis" />
      <i class="el-icon-circle-plus-outline"></i>
      <button :class="{'yButton':dis,'wuButton':!dis}" @click.stop="dis == true?setaddMessage():''">发送</button>
    </div>
  </div>
</template>
<script>
import { msgList, addMessage } from "@/api/api";
export default {
  name: "liuyan",
  data() {
    return {
      // pid:"",//产品id
      // uid:"",//用户id
      xiaoxiContent: "", //
      dis: false, //控制柜按钮样式
      newxiaoxi: 0, //未读消息
      nowTime: "", //当前时间
      // 样式调整数据
      data: [
        {
          id: 5,
          pid: 9,
          uid: 4,
          rid: 1,
          content: "测试留言2",
          type: 0,
          inside: 0,
          create_time: "2020-01-06 14:19:41",
          name: "刘德华",
          img: "http://qiniu.siring.com.cn/0c429202001021830547871.jpg"
        },
        {
          id: 1,
          pid: 9,
          uid: 4,
          rid: 1,
          content: "测试留言",
          type: 0,
          inside: 1,
          create_time: "2020-01-06 11:43:35",
          name: "平台顾问",
          img: "http://qiniu.siring.com.cn/0c429202001021830547871.jpg"
        },
        {
          id: 5,
          pid: 9,
          uid: 4,
          rid: 1,
          content: "测试留言2",
          type: 0,
          inside: 0,
          create_time: "2020-01-06 14:19:41",
          name: "刘德华",
          img: "http://qiniu.siring.com.cn/0c429202001021830547871.jpg"
        },
        {
          id: 5,
          pid: 9,
          uid: 4,
          rid: 1,
          content: "测试留言2",
          type: 0,
          inside: 0,
          create_time: "2020-01-06 14:19:41",
          name: "刘德华",
          img: "http://qiniu.siring.com.cn/0c429202001021830547871.jpg"
        },
        {
          id: 1,
          pid: 9,
          uid: 4,
          rid: 1,
          content: "测试留言",
          type: 0,
          inside: 1,
          create_time: "2020-01-06 11:43:35",
          name: "平台顾问",
          img: "http://qiniu.siring.com.cn/0c429202001021830547871.jpg"
        },
        {
          id: 1,
          pid: 9,
          uid: 4,
          rid: 1,
          content: "测试留言",
          type: 0,
          inside: 1,
          create_time: "2020-01-06 11:43:35",
          name: "平台顾问",
          img: "http://qiniu.siring.com.cn/0c429202001021830547871.jpg"
        },
        {
          id: 1,
          pid: 9,
          uid: 4,
          rid: 1,
          content: "测试留言",
          type: 0,
          inside: 1,
          create_time: "2020-01-06 11:43:35",
          name: "平台顾问",
          img: "http://qiniu.siring.com.cn/0c429202001021830547871.jpg"
        },
        {
          id: 5,
          pid: 9,
          uid: 4,
          rid: 1,
          content: "测试留言2",
          type: 0,
          inside: 0,
          create_time: "2020-01-06 14:19:41",
          name: "刘德华",
          img: "http://qiniu.siring.com.cn/0c429202001021830547871.jpg"
        },
        {
          id: 5,
          pid: 9,
          uid: 4,
          rid: 1,
          content: "测试留言2",
          type: 0,
          inside: 0,
          create_time: "2020-01-06 14:19:41",
          name: "刘德华",
          img: "http://qiniu.siring.com.cn/0c429202001021830547871.jpg"
        },
        {
          id: 5,
          pid: 9,
          uid: 4,
          rid: 1,
          content: "测试留言2",
          type: 0,
          inside: 0,
          create_time: "2020-01-06 14:19:41",
          name: "刘德华",
          img: "http://qiniu.siring.com.cn/0c429202001021830547871.jpg"
        },
        {
          id: 5,
          pid: 9,
          uid: 4,
          rid: 1,
          content: "测试留言2",
          type: 0,
          inside: 0,
          create_time: "2020-01-06 14:19:41",
          name: "刘德华",
          img: "http://qiniu.siring.com.cn/0c429202001021830547871.jpg"
        },
        {
          id: 5,
          pid: 9,
          uid: 4,
          rid: 1,
          content: "测试留言2",
          type: 0,
          inside: 0,
          create_time: "2020-01-06 14:19:41",
          name: "刘德华",
          img: "http://qiniu.siring.com.cn/0c429202001021830547871.jpg"
        },
        {
          id: 5,
          pid: 9,
          uid: 4,
          rid: 1,
          content: "测试留言2",
          type: 0,
          inside: 0,
          create_time: "2020-01-06 14:19:41",
          name: "刘德华",
          img: "http://qiniu.siring.com.cn/0c429202001021830547871.jpg"
        },
        {
          id: 5,
          pid: 9,
          uid: 4,
          rid: 1,
          content: "测试留言2",
          type: 0,
          inside: 0,
          create_time: "2020-01-06 14:19:41",
          name: "刘德华",
          img: "http://qiniu.siring.com.cn/0c429202001021830547871.jpg"
        },
        {
          id: 5,
          pid: 9,
          uid: 4,
          rid: 1,
          content: "测试留言2",
          type: 0,
          inside: 0,
          create_time: "2020-01-06 14:19:41",
          name: "刘德华",
          img: "http://qiniu.siring.com.cn/0c429202001021830547871.jpg"
        },
        {
          id: 2,
          pid: 9,
          uid: 4,
          rid: 1,
          content: "测试留言",
          type: 0,
          inside: 0,
          create_time: "2020-01-06 11:43:35",
          name: "刘德华",
          img: "http://qiniu.siring.com.cn/0c429202001021830547871.jpg"
        }
      ],
      msgListArr: [],
      ceshiList: []
    };
  },
  props: {
    uid: 0,
    pid: 0
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      document.getElementsByClassName("xiaoxiC")[0].focus();
      this.getmsgList();
      this.ceshi();
    },
    showMsg(msg, code) {
      this.$message({
        message: msg,
        type: code === 1 ? "success" : "error"
      });
    },
    getmsgList() {
      console.log(this.uid);
      console.log(this.pid);
      let params = {
        pid: parseInt(this.uid),
        uid: parseInt(this.uid)
      };
      msgList(params).then(res => {
        let { code, data, msg } = res;
        console.log(res);
        if (code == 1) {
          this.msgListArr = data.data;
          if (this.msgListArr.type == 0) {
            this.newxiaoxi = this.newxiaoxi + 1;
          }
          // for(let i=0;i<this.msgListArr.length;i++){
          //   if(i>0){
          //     let nowTiem = new Date(this.msgListArr[i].create_time).getTime;
          //     let end  = new Date(this.msgListArr[i-1].create_time).getTime;
          //     nowTiem - end >180000
          //     this.ceshiList.push(end);
          //   }
          // }
        }
      });
    },
    // 控制发送按钮样式
    gbDis() {
      if (this.xiaoxiContent != "") {
        this.dis = true;
      } else {
        this.dis = false;
      }
    },
    // 用户留言
    setaddMessage() {
      // 处理用户快速发送消息的情况
      // clearTimeout(timeOut);
      // let timeOut =  setTimeout(()=>{
      //   console.log("一分钟已经到了")
      // },60000)
      let params = {
        pid: parseInt(this.pid),
        uid: parseInt(this.uid),
        rid: 1,
        content: this.xiaoxiContent
      };
      addMessage(params).then(res => {
        let { code, msg } = res;
        console.log(1212123,res)
        if (code == 1) {
          this.showMsg(msg, code);
          this.getmsgList();
          // this.data.push({
          //   id: 5,
          //   pid: this.pid,
          //   uid: this.uid,
          //   rid: this.rid,
          //   content: this.xiaoxiContent,
          //   inside: 0,
          //   create_time: "2020-01-06 14:19:41",
          //   name: ,
          //   img: "http://qiniu.siring.com.cn/0c429202001021830547871.jpg"
          // })
        }
      });
    },
    ceshi() {
      for (let i = 0; i < this.data.length; i++) {
        if (i > 0) {
          let nowTiem = new Date(this.data[i].create_time).getTime();
          let end = new Date(this.data[i - 1].create_time).getTime();
          if( nowTiem - end > 180000){
             this.ceshiList.push({
               create_time:this.data[i-1].create_time,
               inside:this.data[i-1].inside,
               i:i
             });
          }
        }
      }
      console.log(this.ceshiList);
    }
  }
};
</script>
<style lang="scss" scoped>
.service {
  border-left: 2px solid rgb(240, 248, 250);
  border-bottom: 2px solid rgb(240, 248, 250);
  border-right: 2px solid rgb(240, 248, 250);
  margin-bottom: 10px;
  width: 100%; //之后解开，调用时给他外部包裹div设置宽度
  // width: 800px;
}
.contentBox {
  height: 350px;
  overflow-y: scroll;
  background: rgb(242, 242, 242);
  padding: 15px 20px 15px 20px;
}
.boxTitle {
  padding: 5px;
  background: rgb(207, 234, 239);
  color: rgb(47, 121, 140);
  font-weight: 700;
  display: flex;
  justify-content: space-between;
}
img {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  margin-bottom: 5px;
}
// 带箭头div
.demo {
  width: 300px;
  // min-height: 52px;
  border: 1px solid rgb(188, 188, 188);
  position: relative;
  margin-left: 10px;
  padding: 10px 20px 10px 20px;
  font-size: 16px;
  display: flex;
  align-items: center;
  background: rgb(255, 255, 255);
}
.out,
.in {
  position: absolute;
  width: 0;
  height: 0px;
}
.out {
  border: 11px solid transparent;
  border-right-color: rgb(
    188,
    188,
    188
  ); /*这里的颜色一定要跟上面demo边框颜色一样*/
  top: 7px;
  left: -23px;
}
.in {
  border: 10px solid transparent;
  border-right-color: #fff; /*这里的颜色一定要跟demo背景颜色一样*/
  top: 8px;
  left: -20px;
}
.demo1 {
  width: 300px;
  // min-height: 52px;
  border: 1px solid rgb(188, 188, 188);
  position: relative;
  margin-right: 10px;
  padding: 10px 20px 10px 20px;
  font-size: 16px;
  display: flex;
  align-items: center;
  background: rgb(255, 255, 255);
}
.out1,
.in1 {
  position: absolute;
  width: 0;
  height: 0px;
}
.out1 {
  border: 11px solid transparent;
  border-left-color: rgb(
    188,
    188,
    188
  ); /*这里的颜色一定要跟上面demo边框颜色一样*/
  top: 7px;
  right: -23px;
}
.in1 {
  border: 10px solid transparent;
  border-left-color: #fff; /*这里的颜色一定要跟demo背景颜色一样*/
  top: 8px;
  right: -20px;
}
.guanfang {
  display: flex;
  margin-bottom: 20px;
  font-size: 13px;
}
.touxiangbox {
  width: 60px;
  text-align: center;
  height: 53px;
}
.btnValueBox {
  background: rgb(247, 247, 247);
  padding: 20px 50px;
  display: flex;
  align-items: center;
  input {
    height: 45px;
    border-radius: 5px;
    border: 0.5px solid rgb(247, 247, 247);
    width: 80%;
    margin-right: 30px;
    padding: 0 20px;
  }
  i {
    font-size: 36px;
    color: rgb(121, 121, 121);
    margin-right: 30px;
  }
  .wuButton {
    background: #ffffff;
    color: rgb(102, 204, 0);
  }
  .yButton {
    background: rgb(102, 204, 0);
    color: #ffffff;
  }
  button {
    border-radius: 5px;
    border: 1px solid rgb(102, 204, 0);
    padding: 10px 0;
    width: 18%;
  }
}
</style>
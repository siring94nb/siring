<template>
  <div class="service">
    <div class="boxTitle">
      <span>平台顾问信息互动</span>
      <span>新消息（{{newxiaoxi}}）</span>
    </div>
    <div class="contentBox">
      <div v-for="(item,index) in msgListArr" :key="index">
        <!-- <div v-for="(item1,index1) in ceshiList" :key="index1">
          <span>{{index}}</span>
        </div>-->
        <div v-if="item.inside==0" class="guanfang">
          <div class="touxiangbox">
            <div class="imgs">
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
        <div v-if="item.inside==1" class="guanfang" style="justify-content:flex-end">
          <div class="demo1">
            {{item.content}}
            <div class="out1"></div>
            <div class="in1"></div>
          </div>
          <div class="touxiangbox">
            <div class="imgs">
              <img :src="item.img" :alt="item.name" />
            </div>
            <div>{{item.name}}</div>
          </div>
        </div>
      </div>
    </div>
    <div class="btnValueBox">
      <!-- <inout @keydown="huiche($event)" class="xiaoxiC" v-model="xiaoxiContent" @input="gbDis" /> -->
      <textarea
        rows="1"
        @keydown="huiche($event)"
        class="xiaoxiC"
        v-model="xiaoxiContent"
        @input="gbDis"
      ></textarea>
      <!-- <el-upload
        name="image"
        action="https://manage.siring.com.cn/api/file/qn_upload"
        :on-success="handleAvatarSuccess"
        :before-upload="beforeAvatarUpload"
        :show-file-list="qb"
      >
        <i class="el-icon-circle-plus-outline"></i>
      </el-upload>-->
      <button
        :class="{'yButton':dis,'wuButton':!dis}"
        @click.stop="dis == true?setaddMessage():''"
      >发送</button>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import config from "../../../../build/config";
// import { msgList, addMessage, codeAdd } from "@/api/api";
import qs from "qs";
const apiPost = (url, params) => {
  return axios.post(url, qs.stringify(params)).then(res => res.data);
};
export default {
  name: "liuyan",
  props: ["rid", "pid"],
  data() {
    return {
      qb: false,
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
        }
      ],
      msgListArr: [],
      ceshiList: [],
      pdfile: false, //判读文件是图片还是其他文件，默认为文件
      url: "",
      userName: "",
      touxiangImg: "",
      Uid: 0,
      Pid: 0,
      Rid: 0,
      imageUrl: ""
    };
  },
  mounted() {
    this.init();
  },
  computed: {},
  watch: {
    pid: function(newVal, oldVal) {
      this.Pid = newVal; //newVal就是获取的动态新数据，赋值给newdata)
      this.getmsgList();
    },
    rid: function(newVal, oldVal) {
      this.Rid = newVal; //newVal就是获取的动态新数据，赋值给newdata)
      this.getmsgList();
    }
  },
  // 13260676780
  methods: {
    init() {
      document.getElementsByClassName("xiaoxiC")[0].focus();
      // this.getmsgList();
      // this.ceshi();
      //   this.getcodeAdd();
    },
    showMsg(msg, code) {
      this.$message({
        message: msg,
        type: code === 1 ? "success" : "error"
      });
    },
    getmsgList() {
      let vm = this,
        params;
      axios
        .get("Chat/msg_list", {
          params: {
            pid: parseInt(vm.pid)
          }
        })
        .then(function(response) {
          let res = response.data;
          console.log(res);
          let { code, data, msg } = res;
          console.log(data.data.data);
          if (code == 1 && data.data.data.length > 0) {
            console.log(vm.msgListArr);
            //   if(data.data.length != 0){
            vm.msgListArr = data.data.data;
            for (let i = 0; i < vm.msgListArr.length; i++) {
              if (vm.msgListArr.type == 0) {
                vm.newxiaoxi = vm.newxiaoxi + 1;
              }
              if (i > 0 && vm.msgListArr[i].inside == 0) {
                vm.userName = vm.msgListArr[i].name;
                vm.touxiangImg = vm.msgListArr[i].img;
              }
            }
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
        // uid: parseInt(sessionStorage.getItem("user_id")),
        uid: 1,
        rid: this.Rid,
        content: this.xiaoxiContent,
        url: this.url,
        inside: 1
      };
      apiPost("Chat/add_message", params).then(res => {
        let { code, msg } = res;
        console.log(1212123, res);
        if (code == 1) {
          // this.showMsg(msg, code);
          this.getmsgList();
          // this.msgListArr.push({
          //   id: 5,
          //   pid: this.pid,
          //   uid: this.uid,
          //   rid: this.rid,
          //   content: this.xiaoxiContent,
          //   inside: 0,
          //   create_time: this.formatDate(new Date),
          //   name: this.userName,
          //   img: this.touxiangImg
          // });
          this.xiaoxiContent = "";
          // this.dis = false;
          // document.getElementsByClassName("xiaoxiC")[0].focus();
        }
      });
    },
    //
    handleAvatarSuccess(res, file) {
      console.log(res.data.filePath);
      this.url = res.data.filePath;
      this.$message({
        message: "文件上传成功",
        type: "success"
      });
      // if(!this.pdfile){

      // }
    },
    beforeAvatarUpload(file) {
      console.log(file.type);
      const isJPG = file.type === "image/jpeg";
      const isJPG2 = file.type === "image/png";
      const isLt2M = file.size / 1024 / 1024 < 2;

      // if (!isJPG || !isJPG2) {
      //   // this.$message.error("上传头像图片只能是 JPG 格式或者 PNG格式");
      //   this.pdfile = false;
      // }else{
      //   this.pdfile = true
      // }
      // if (!isLt2M) {
      //   this.$message.error("上传头像图片大小不能超过 2MB!");
      // }
      // return isJPG && isLt2M;
    },

    // 时间格式转换
    formatDate(now) {
      var year = now.getFullYear(); //取得4位数的年份
      var month = now.getMonth() + 1; //取得日期中的月份，其中0表示1月，11表示12月
      var date = now.getDate(); //返回日期月份中的天数（1到31）
      var hour = now.getHours(); //返回日期中的小时数（0到23）
      var minute = now.getMinutes(); //返回日期中的分钟数（0到59）
      var second = now.getSeconds(); //返回日期中的秒数（0到59）
      return (
        year +
        "-" +
        month +
        "-" +
        date +
        " " +
        hour +
        ":" +
        minute +
        ":" +
        second
      );
    },
    // 绑定回车事件
    huiche(event) {
      if (event.which == 13 && this.dis) {
        this.setaddMessage();
      }
      // else if(event.ctrlKey && event.keyCode == 13){
      //   // ctrl+回车换行
      //   this.xiaoxiContent = this.xiaoxiContent +"123123123123123"
      // }
    },
    // 获取关注二维码
    getcodeAdd() {
      let vm = this;
      apiPost("", "").then(res => {
        console.log(res);
        if (res.code == 1) {
          vm.imageUrl = res.data;
        }
      });
    }
  }
};
</script>
<style lang="less">
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
.imgs {
  img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-bottom: 5px;
  }
}
// 带箭头div
.demo {
  max-width: 300px;
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
  max-width: 300px;
  // min-height: 52px;
  border: 1px solid rgb(188, 188, 188);
  position: relative;
  margin-right: 10px;
  padding: 10px 20px 10px 20px;
  font-size: 16px;
  display: flex;
  align-items: center;
  background: rgb(255, 255, 255);
  line-height: 22px;
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
  textarea {
    height: 45px;
    border-radius: 5px;
    border: 0.5px solid rgb(247, 247, 247);
    width: 80%;
    margin-right: 30px;
    overflow: hidden;
    resize: none;
    box-sizing: border-box;
    padding: 10px 20px 0 20px;
    // padding-top: 10px;
    font-size: 18px;
    line-height: 22px;
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
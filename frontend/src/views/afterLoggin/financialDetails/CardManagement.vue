<template>
  <div>
    <logginHeader>
      <i class="iconfont icon--zijinguanli"></i>
      <span>资金管理</span>
      <span>&gt;</span>
      <span>银行卡管理</span>
    </logginHeader>
    <div class="bottomBox">
      <!-- <input type="checkbox" name="name" id="1"> -->
      <div ref="card" class="card" v-for="(item,index) in cardImage" :key="index">
        <div>
          <el-checkbox v-model="checked[index]" @change="xuanzhogn(index)">设为默认</el-checkbox>
        </div>
        <div>
          <span>开户名：</span>
          <span>{{item.card_name}}</span>
        </div>
        <div>
          <span>开户行：</span>
          <span>{{item.bank_name}}</span>
        </div>
        <div>
          <span>卡号：</span>
          <span>{{item.card_number.replace(item.card_number.substring(5,11),"******")}}</span>
          <i class="el-icon-delete" @click.stop="deleteList(item.id)"></i>
        </div>
      </div>
      <div class="addCard" @click.stop="dk">
        <i class="el-icon-bank-card"></i>
        <span>添加银行卡</span>
      </div>
      <el-dialog :visible.sync="dialogVisible" width="700px">
        <div class="addCardList" >
        <div>
          <!-- <i class="el-icon-circle-close" @click.stop="dk"></i> -->
        </div>
        <div>添加银行卡</div>
        <div>
          <span>开户名：</span>
          <el-input v-model="input" placeholder="请输入内容" style="width:300px"></el-input>
        </div>
        <div>
          <span>银行：</span>
          <el-select v-model="value" placeholder="请选择">
            <el-option
              v-for="item in options"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            ></el-option>
          </el-select>
        </div>
        <div>
          <span>开户地区：</span>
          <v-region @values="regionChange" class="form-control"></v-region>
        </div>
        <div>
          <span>银行账号：</span>
          <el-input v-model="input1" placeholder="请输入账号" style="width:300px"></el-input>
        </div>
        <div>
          <span>开户支行：</span>
          <el-input v-model="input2" placeholder="请输入支行名" style="width:300px"></el-input>
        </div>
        <div>
          <el-button
            type="danger"
            style="width:320px;"
            @click.stop="getBankcardAdd"
            @keyup.enter="ceshi"
          >确定</el-button>
        </div>
      </div>
      </el-dialog>
      
    </div>
  </div>
</template>
<script>
import logginHeader from "@/components/logginHeader";
import {BankcardList,BankcardAdd,BankcardDel} from "@/api/api";
export default {
  data() {
    return {
      dialogVisible :false,
      moren: 0,
      // 测试卡号
      // cardId: "4567712345666666",
      // 默认选中值
      checked: [true, false, false],
      // 开户名
      input: "",
      // 银行账号
      input1: "",
      // 支行名
      input2: "",
      // 添加银行卡面板，控制参数
      kzCanshu: "none",
      // select选择器银行
      options: [
        {
          value: "南京银行",
          label: "南京银行"
        },
        {
          value: "中国人民银行",
          label: "中国人民银行"
        }
      ],
      value: "南京银行",
      // 银行卡信息 ,当前写死，测试数据
      cardImage: [],
    };
  },
  components: {
    logginHeader
  },
  mounted() {
    this.xuanzhogn(0);
    this.getBankcardList();
  },
  methods: {
    // 银行卡信息
    getBankcardList(){
      BankcardList().then(res=>{
        let { data, msg } = res;
        console.log(data);
        //  this.showMsg(msg, code);
          if (data.code === 1) {
            this.cardImage = data.data;
          }
      })
    },
    // 添加银行卡
    getBankcardAdd(){
      let params = {
        card_number:this.input1,
        bank_name:this.value,
        card_name:this.input,
        bank_branch:this.input2,
        province:this.province,
        city:this.city,
        area:this.area
      };
      BankcardAdd(params).then(res=>{
         let { data, msg, code } = res;
         this.showMsg(msg, code);
          if (code === 1) {
            this.getBankcardList();
            this.dk();
          }
      })
    },
    showMsg(msg, code) {
      this.$message({
        message: msg,
        type: code === 1 ? "success" : "error"
      });
    },
    // 默认选中银行卡
    xuanzhogn(num) {
      let aDiv = document.getElementsByClassName("card");
      // let aDiv = this.$refs.card
      if(aDiv.length != 0){
        if (this.checked[num] === true) {
          aDiv[num].classList.add("active");
          // console.log(classList);
          for (let i = 0; i < this.checked.length; i++) {
            if (i !== num) {
              this.checked[i] = false;
              aDiv[i].classList.remove("active");
            }
          }
        } else {
          aDiv[0].classList.add("active");
          aDiv[num].classList.remove("active");
          this.checked[0] = true;
        }
      }
    },
    // 城市三级联动插件
    regionChange(data) {
      this.province = data.province === null ? "" : data.province.value;
      this.city = data.city === null ? "" : data.city.value;
      this.area = data.area === null ? "" : data.area.value;
    },
    // 打开添加银行卡面板
    dk() {
      this.dialogVisible = true;
    },
    // 删除，后继加接口，目前暂时将样式删除
    deleteList(num) {
      BankcardDel({id:num}).then(res=>{
        let { data, msg, code } = res;
         this.showMsg(msg, code);
          if (code === 1) {
            this.getBankcardList();
          }
      })
      // this.$confirm("此操作将永久删除该银行卡, 是否继续?", "提示", {
      //   confirmButtonText: "确定",
      //   cancelButtonText: "取消",
      //   type: "warning"
      // })
      //   .then(() => {
      //     this.cardImage.splice(num, 1);
      //     this.$message({
      //       type: "success",
      //       message: "删除成功!"
      //     });
      //   })
      //   .catch(() => {
      //     this.$message({
      //       type: "info",
      //       message: "已取消删除"
      //     });
      //   });
    },
  },
  created(){
    // 键盘事件直接绑定到document中，否则，需要光标选中控件才能触发键盘事件
    // document.onkeydown = function(e){
    //   // 处理键盘事件兼容性
    //   var key = window.event.keyCode ? window.event.keyCode:window.event.which
    //   e.altKey判断alt是否处于按下状态
    //   // 阻止默认事件 ，此处不能随意使用，若使用，则键盘全部默认事件都无法使用
    //   e.preventDefault()
    // }
  }
};
</script>
<style lang="scss" scoped>
.bottomBox {
  background: #ffffff;
  padding: 20px 0 30px 50px;
  margin: 10px 0 0 20px;
  display: flex;
  flex-wrap: wrap;
  min-height: 77vh;
  > div {
    margin-right: 20px;
  }
  .card {
    width: 280px;
    border: 1px solid rgba(202, 149, 142, 1);
    border-radius: 5px;
    padding: 5px 10px;
    height: 120px;
    margin-bottom: 15px;
    > div {
      span {
        font-size: 14px;
        display: inline-block;
        &:nth-of-type(1) {
          width: 56px;
          text-align: right;
        }
        &:nth-of-type(2) {
          color: #868686;
        }
      }
      &:nth-of-type(1) {
        text-align: right;
      }
      &:nth-of-type(2) {
        padding: 0 0 10px 0;
        border-bottom: 1px solid rgba(238, 221, 219, 1);
        margin-bottom: 10px;
      }
      &:nth-of-type(3) {
        padding: 0 0 10px 0;
        border-bottom: 1px solid rgba(238, 221, 219, 1);
        margin-bottom: 10px;
      }
      &:nth-of-type(4) {
        margin-bottom: 10px;
        i {
          float: right;
        }
      }
    }
  }
  .active {
    border: 1px solid #409eff;
  }
  .addCard {
    width: 280px;
    border: 1px solid rgba(161, 161, 161, 1);
    border-radius: 5px;
    height: 130px;
    padding: 0px 10px;
    font-size: 13px;
    color: #a1a1a1;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    i {
      font-size: 40px;
      padding-right: 20px;
    }
  }
  .addCardList {
    // border-radius: 5px;
    // position: absolute;
    // background: #ffffff;
    // border: 1px solid rgba(0, 0, 0, 0.1);
    // padding: 5px;
    // z-index: 50;
    // width: 695px;
    // left: 50%;
    // margin-left: -347px;
    // top: 260px;
    > div {
      margin-bottom: 20px;
      > span {
        &:nth-of-type(1) {
          display: inline-block;
          width: 80px;
          text-align: right;
          margin: 0 30px 0 80px;
        }
      }
      &:nth-of-type(1) {
        text-align: right;
        margin-bottom: 20px;
        i {
          font-size: 32px;
          cursor: pointer;
        }
      }
      &:nth-of-type(2) {
        text-align: center;
        font-size: 28px;
        color: #363636;
        margin-bottom: 30px;
      }
      &:nth-of-type(3) {
        display: flex;
        align-items: center;
      }
      &:nth-last-child(1) {
        text-align: center;
      }
    }
  }
}
</style> 
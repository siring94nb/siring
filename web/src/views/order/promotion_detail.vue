<template>
  <div class="index">
    <div class="line line-marst">基础信息</div>
    <div class="main-top">
      <table>
        <tr>
          <td class="td-one">用户账号：</td>
          <td>{{information.phone}}</td>
          <td class="td-one">订单号：</td>
          <td>{{information.no}}</td>
        </tr>
        <tr>
          <td class="td-one">套餐费用：</td>
          <td>￥{{information.order_amount}}</td>
          <td class="td-one">稿件类型：</td>
          <td>{{information.lexing}}</td>
        </tr>
        <tr>
          <td class="td-one">创建时间：</td>
          <td>{{information.created_at}}</td>
          <td class="td-one">总计费用</td>
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
          <FormItem label="文章标题">
            <Input placeholder="请输入" v-model="title" style="width: 450px;"/>
            <br/>
            <span>不超过15个字</span>
          </FormItem>
          <FormItem label="推广对象">
            <Input placeholder="推广的产品或者公司名称" v-model="duixiang" style="width: 450px;"/>
            <br/>
            <span>不超过20个字</span>
          </FormItem>
          <FormItem label="上传您要推广的要求">
            <Input placeholder="例如：结合世界杯帮我出个软文" v-model="duixiang" style="width: 450px;"/>
            <br/>
            <span>不超过200字</span>
          </FormItem>
           <FormItem label="内容">
            <RadioGroup v-model="animal">
                <Radio v-for="(item,index) in animalArr" :key="index" :label="item"></Radio>
            </RadioGroup>
          </FormItem>
           <FormItem label="参考文章链接">
            <Input placeholder="供写手参考的文章地址" v-model="duixiang" style="width: 450px;"/>
          </FormItem>
           <FormItem label="选择高手等级">
            <RadioGroup v-model="dengji">
                <Radio label="1">
                  <div>
                    <span>普通</span>
                    <span>300元/500字</span>
                    <span>出稿时间1-2工作日，稿件不满意最多只能修改一次，下单前请看好备注！</span>
                  </div>
                </Radio>
            </RadioGroup>
          </FormItem>
          <FormItem label="字数">
            <RadioGroup v-model="zishu">
                <Radio label="1">0到500</Radio>
            </RadioGroup>
          </FormItem>
        </Form>
      </div>
      <!-- 确认稿件 -->
      <div class="dzxq-main" style="padding-top:180px;" v-if="status == 2">
        <img src="../../images/u9830.png" alt="">
      </div>
       <!-- 未完成，接口未接 -->
    </div>
    <!-- 聊天界面 -->
    <div class="line line-vice">平台顾问信息互动</div>
    <div style=" background:rgb(242,242,242);height:300px;"></div>
    <!-- 聊天界面下方 -->
    <div class="wzBox">
      <div v-if="status==0">
        <div>*请确认收到双方最后合同后，在此上传</div>
      </div>
      <div v-if="status==3" class="shengheBox">
        <div>*请确认客户真实需求，上传对应的检测报告</div>
        <!-- <div class="jcbg">上传检测报告</div> -->
        <!-- 通过:on-success=""成功回调判断按钮按钮状态 -->
        <Upload 
        :show-upload-list="false" 
        action="//jsonplaceholder.typicode.com/posts/"
        
        >
          <Button class="jcbg">上传检测报告</Button>
        </Upload>
        <div class="jiantouBox">
          <div class="zuojiantou"></div>
          <div class="henggang"></div>
        </div>
        
        <div class="shenghe">等待审核</div>
        <div  class="jiantouBox"> 
           <div class="henggang"></div>
            <div class="youjiantou"></div>
        </div>
       
        <div class="jiancf">检测费：</div>
        <div style="display:flex;align-items: center;"><Input v-model="jiancefei"/><span style="color:#363636;padding-left:10px">元</span></div>
      </div>
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
      jiancefei:0,
      id:0,
      title:"",
      duixiang:'',
      information: {
        //基础信息
        phone: "12345678912",
        no:"213123123123",
        order_amount:"123123",
        lexing:"代写稿件",
        created_at:"123123123",
        money:"12123123",
      },
      // 流程模块
      statusData: [
        {
          url: "",
          name: "我要发稿",
          tips: "等待需求确认"
        },
        {
          url: "",
          name: "确认稿件",
          tips: "代写中"
        },
        {
          url: "",
          name: "智推状态",
          tips: "智推中"
        }
      ],
      status:1,
      // 单选框
      animalArr:[
        "自由型",
        "采访型",
        "评论型",
        "广告型",
        "炒作型",
        "故事型 ",
        "热点型",
        "新闻型"
      ],
      animal:"自由型",
      dengji:"1",
      zishu:"1"
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
    // overflow-y: scroll;
    color: #999999;
    .dzxq-main {
      padding: 30px 0;
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
      text-align: center ;
      line-height: 28px;
    }
    .td-one {
      width: 20%;
      font-weight: 700;
      font-size: 12px;
    }
  }
}
.wzBox{
  margin-top: 10px;
  border-bottom: 1px solid rgb(148,148,148);
}
.shengheBox{
  display: flex;
  font-size: 14px;
  color: #333333;
  align-items: center;
  padding-bottom: 10px;
  .jcbg{
    font-size: 13px;
    color: #ffffff;
    background: rgb(161,161,161);
    display: flex;
    align-items: center;
    padding: 10px 30px;
    border-radius: 30px;
    margin: 0 -10px 0 20px;
  }
  .jcbgActive{
    background: rgb(255,153,0)
  }
  .shenghe{
    padding: 10px 30px;
    background: rgb(161,161,161);
    font-size: 13px;
    color: #ffffff;
  }
  .jiancf{
    padding-left: 20px;
  }
  .jiantouBox{
    display: flex;
    align-content: center;
  }
  .henggang{
    height: 3px;
    width: 50px;
    background: rgb(161,161,161);
    margin-top: 8px;
  }
  .zuojiantou{
			border-top:10px transparent dashed;
			border-right: 10px solid rgb(161,161,161);
			border-bottom: 10px transparent dashed;
      border-left: 10px  transparent dashed ;
  }
  .youjiantou{
			border-top:10px transparent dashed;
			border-right: 10px transparent dashed;
			border-bottom: 10px transparent dashed;
      border-left: 10px solid rgb(161,161,161) ;
  }
}
</style>

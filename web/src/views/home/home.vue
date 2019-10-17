<style lang="less">
@import "./home.less";
@import "../../styles/common.less";
</style>
<template>
  <div class="home-main" style="display:flex;align-items:center;justify-content:center;">
    <img src="../../images/index.jpg" alt style="width:100%;height:auto;">
    <!--<Button type="primary" @click="modal1 = true">Display dialog box</Button>-->
   <!--  <Modal
            v-model="modal1"
            title="缺货提醒"
            @on-ok="ok"
            @on-cancel="cancel">
      <p>暂无</p>
      <p>暂无</p>
      <p>暂无</p>
    </Modal> -->
  </div>
  
</template>

<script>
  // import axios from 'axios';
  //   export default {
  //       data () {
  //           return {
  //               todos:[],
  //               modal1: true
  //           }
  //       },
  //       mounted(){
  //         axios.get('Goods/msg').then(response =>{
  //             this.todos = response.data
  //             console.log(response.data)
  //         })
  //       },
  //       methods: {
  //           ok () {
  //               this.$Message.info('已确认');
  //           },
  //           cancel () {
  //               this.$Message.info('已关闭');
  //           }
  //       },
  //   }
</script>

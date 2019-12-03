<template>
  <div class="demonstration">
    <myheader />
    <myswiper />
    <div class="container">
      <section v-html="htmlStr"></section>
    </div>
    <jdyh />
    <myfooter />
  </div>
</template>

<script>
import Myheader from "@/components/header";
import Myswiper from "@/components/mySwiper";
import Jdyh from '@/components/jdyh';
import Myfooter from '@/components/footer';
import { GetDemonstration } from "@/api/api";
export default {
  components: {
    Myheader,
    Myswiper,
    Jdyh,
    Myfooter
  },
  data() {
    return {
      goodsId: this.$route.params.id,
      htmlStr: ''
    }
  },
  mounted() {
    this.getDemonstration();
  },
  methods: {
    getDemonstration() {
      GetDemonstration({
        goods_id: this.goodsId
      }).then(res => {
        let {code, data, msg} = res;
        if(code === 1){
          this.htmlStr = data;
        }
      })
    }
  }
};
</script>

<style scoped lang='scss'>
.container{
  width: 1200px;
  margin: 50px auto 0;
  // height: 200px;
  text-align: center;
  color: #333;
}
</style>
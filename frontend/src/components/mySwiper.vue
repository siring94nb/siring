<template>
  <div class="my-swiper">
    <el-carousel class="swiper" height="400px">
      <el-carousel-item v-for="item in swiperlist" :key="item.id">
        <a :href="`https://`+item.url" target="_blank">
          <img :src="item.img" alt />
        </a>
      </el-carousel-item>
    </el-carousel>
  </div>
</template>

<script>
import { GetBannerList } from '@/api/api';
export default {
  data() {
    return {
      swiperlist: [
        require("@/assets/images/img1.png"),
        require("@/assets/images/img2.png"),
        require("@/assets/images/img3.png")
      ]
    }
  },
  mounted() {
    this.getBannerList();
  },
  methods: {
     getBannerList() {
      GetBannerList().then(res => {
        let { code, msg, data } = res;
        if(code === 1){
          this.swiperlist = data;
        }
      })
    },
  }
};
</script>

<style scoped lang='scss'>
.my-swiper{
  margin-top: 100px;
}
</style>
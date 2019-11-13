<template>
  <div class="index">
    <myheader />
    <div class="index">
        <div class="title-top">
            <img src="../assets/images/u65658.jpg" alt="">
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
    return {};
  },
  methods: {}
};
</script>
<style lang="scss" scoped>
.index {
  margin-top: 100px; 
    .title-top {
      img{width: 100%;}
    }
    
}
.footer .footer_info .footer_info_inner{display: none;}
</style>
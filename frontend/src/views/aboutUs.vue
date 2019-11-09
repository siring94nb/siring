<template>
  <div class="index">
    <myheader />
    <div class="index">
        <div class="title-top">
            <h1>20年沉淀，一站式定制开发推广运营领航者</h1>
            <p>多重平台，多重服务</p>
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
    .title-top {
        text-align: center;
    }
    .title-top h1 {
        font-size: 40px;
    }
}
.footer .footer_info .footer_info_inner{display: none;}
</style>
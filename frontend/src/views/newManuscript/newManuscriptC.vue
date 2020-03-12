<template>
  <div class="quickval">
    <myheader />
    <div class="anlixiangxi">
      <div class="xxSmBox">
        <div class="xiangxiBox">201803期 投融介见面会</div>
      </div>
    </div>
    <div class="footer">
      <Jdyh/> 
      <myfooter />
    </div>
  </div>
</template>

<script>
import Myheader from "@/components/header";
import Myfooter from "@/components/footer";
import Jdyh from "@/components/jdyh";
export default {
  components: {
    Myheader,
    Myfooter,
    Jdyh
  },
  data() {
    return {
    };
  },
  mounted() {
  },
  methods: {
  }
};
</script>
<style></style>
<style scoped lang='scss'>
.quickval{
  margin: 100px 0 0  0 ;
  .anlixiangxi{
    padding: 0 100px;
  }
  .xxSmBox{
    .xiangxiBox{
      font-size: 36px;
      text-align: center;
      padding: 50px 0;
    }
  }

}
</style>
<template>
  <div style="width:1300px;">
    <logginHeader>
      <i class="el-icon-edit"></i>
      <span>软件/定制</span>
      <span>&gt;</span>
      <span>我的订单</span>
    </logginHeader>
    <div class="index">
        <div>
            <div>
                <i class="el-icon-warning"></i>
                <div style="border:1px solid;">22</div>
            </div>
        </div>
    </div>
  </div>
</template>
<script>
import logginHeader from "@/components/logginHeader";
import { needOrderList } from "@/api/api";
export default {
  data() {
    return {
      userId: "",
      
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      this.userId = JSON.parse(sessionStorage.getItem("user_id"));
    }
  },
  components: {
    logginHeader
  }
};
</script>

<style lang="scss" scoped>
.index {
  background: #ffffff;
  margin: 10px 0 0 20px;
  padding: 15px;
 
}
</style>
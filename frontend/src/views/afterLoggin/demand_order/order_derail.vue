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
                <!-- <i class="el-icon-warning"></i> -->
                <span style="border:1px solid red;color:red;border-radius:50%;">！</span>
            </div>
            <div>
              <ul>
                <li>每项流程确认完成</li>
              </ul>
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
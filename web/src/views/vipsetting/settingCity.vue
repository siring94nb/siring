<template>
  <div>
    <Row>
      <Col span="24">
        <Card class="card">
          <div class="container">
            <div class="prov">
              <h4 class="title">省份</h4>
              <div class="prov-list" v-for="(item, index) in prov" :key="item">
                <div
                  :class="{'area-item': true, 'area-on': choosedProv==index}"
                  @click="getCity(index)"
                >{{ item }}</div>
              </div>
            </div>
            <div class="spec">
              <h4 class="title">特级城市</h4>
            </div>
            <div class="primary">
              <h4 class="title">一级城市</h4>
            </div>
            <div class="secondary">
              <h4 class="title">二级城市</h4>
            </div>
            <div class="tertiary">
              <h4 class="title">三级县市</h4>
            </div>
          </div>
        </Card>
      </Col>
    </Row>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  data() {
    return {
      prov: ["广东", "广西", "湖南", " 湖北", "江西"],
      choosedProv: null
    };
  },
  created() {
    this.getAllProv();
  },
  methods: {
    getCity(index) {
      this.choosedProv = index;
    },
    getAllProv() {
      axios.get("RoleJoin/city_index").then(function(data) {
        console.log(data);
      });
    }
  }
};
</script>

<style scoped lang="less">
.container {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  > div {
    flex-basis: 18%;
    .title {
      background-color: rgb(242, 242, 242);
      height: 30px;
      line-height: 30px;
      padding-left: 10px;
      font-weight: 500;
      color: #999999;
      margin-bottom: 10px;
    }
    .area-item {
      height: 38px;
      border: 1px solid transparent;
      line-height: 40px;
      color: #333333;
      font-size: 12px;
      padding-left: 10px;
      cursor: pointer;
      &.area-on {
        border-top-color: rgb(26, 188, 156);
        border-bottom-color: rgb(26, 188, 156);
      }
    }
  }
}
</style>
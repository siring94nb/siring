<template>
  <div>
    <Row>
      <Col span="24">
        <Card class="card">
          <div class="container">
            <div class="prov">
              <h4 class="title">省份</h4>
              <div class="prov-list" v-for="(item, index) in provList" :key="item.id">
                <div
                  :class="{'area-item': true, 'area-on': choosedProv==index}"
                  @click="getCity(index)"
                  data-id="item.id"
                >{{ item.name }}</div>
              </div>
            </div>
            <div class="spec">
              <h4 class="title">特级城市</h4>
              <div class="spec-list" v-for="(item, index) in specList" :key="item.id">
                <div
                  :class="{'area-item': true, 'area-on': choosedSpec==index}"
                  @click="operatSpec(index)"
                >
                  {{ item.name }}
                  <div class="operating">
                    <Dropdown trigger="click" @on-click="moveCity">
                      <span class="move">移动</span>
                      <DropdownMenu slot="list">
                        <DropdownItem name="0">特级城市</DropdownItem>
                        <DropdownItem name="1">一级城市</DropdownItem>
                        <DropdownItem name="2">二级城市</DropdownItem>
                        <DropdownItem name="3">三级城市</DropdownItem>
                      </DropdownMenu>
                    </Dropdown>
                    <!-- <span class="del" @click="remove">删除</span> -->
                    <Poptip
                      confirm
                      title="您确定要删除这条内容吗？"
                      @on-ok="remove"
                    >
                      <span class="del">删除</span>
                    </Poptip>
                  </div>
                </div>
              </div>
              <div class="add" @click="add">新增</div>
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
import axios from "axios";
export default {
  data() {
    return {
      provList: [],
      specList: [{ name: "深圳", id: 1 }, { name: "广州", id: 2 }],
      choosedProv: null,
      choosedSpec: null
    };
  },
  created() {
    this.getAllProv();
  },
  methods: {
    getCity(index) {
      this.choosedProv = index;
    },
    operatSpec(index) {
      this.choosedSpec = index;
    },
    moveCity(name) {
      console.log(name);
    },
    remove() {
      console.log('删除成功')
    },
    add() {},
    getAllProv() {
      var _this = this;
      axios.get("RoleJoin/city_index").then(function(res) {
        let { data, msg, code } = res.data;
        if (code !== 1) {
          this.$Message.error(msg);
        } else {
          _this.provList = data.list;
        }
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
    min-width: 200px;
    .title {
      background-color: rgb(242, 242, 242);
      height: 30px;
      line-height: 30px;
      padding-left: 10px;
      font-weight: 500;
      font-size: 14px;
      color: #999999;
      margin-bottom: 10px;
    }
    .area-item {
      height: 38px;
      border: 1px solid transparent;
      line-height: 40px;
      color: #333333;
      font-size: 14px;
      padding-left: 10px;
      cursor: pointer;
      .operating {
        display: none;
        float: right;
        span{
          color: #1abc9c;
        }
        .del {
          margin-left: 10px;
        }
      }
      &.area-on {
        border-top-color: rgb(26, 188, 156);
        border-bottom-color: rgb(26, 188, 156);
        .operating {
          display: block;
        }
      }
    }
    .add {
      border: 1px dashed #999999;
      color: #999999;
      text-align: center;
      margin-top: 20px;
      cursor: pointer;
      height: 30px;
      line-height: 30px;
    }
  }
}
</style>
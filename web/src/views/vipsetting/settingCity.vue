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
                  @click="getCity(index, item.id)"
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
                    <Poptip
                      confirm
                      title="您确定要删除这条内容吗？"
                      @on-ok="remove(item.id)"
                    >
                      <span class="del">删除</span>
                    </Poptip>
                  </div>
                </div>
              </div>
              <div class="addcity-box">
                <input type="text" v-model="addCity.spec">
                <span class="cancel">取消</span>
                <span class="save">保存</span>
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
      choosedSpec: null,
      addCity:{
        spec: '',
        primary: '',
        secondary: '',
        tertiary: ''
      }
    };
  },
  created() {
    this.getAllProv();
  },
  methods: {
    getCity(index, id) {
      this.choosedProv = index;
      axios.post("RoleJoin/city_save", {
        pid: id
      }).then(function(res) {
        console.log(res)
      });
    },
    operatSpec(index) {
      this.choosedSpec = index;
    },
    moveCity(name) {
      console.log(name);
    },
    remove(id) {
      console.log(id)
    },
    add() {
      // axios.get("RoleJoin/city_create").then(function(res) {
      //   let { data, msg, code } = res.data;
      //   if (code !== 1) {
      //     this.$Message.error(msg);
      //   } else {
      //     _this.provList = data.list;
      //   }
      // });
    },
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
  user-select: none;
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
    .addcity-box{
      display: none;
      border: 1px solid #1abc9c;
      height: 38px;
      line-height: 38px;
      margin-top: 10px;
      input{
        width: 100px;
        border: 0;
        outline: none;
        padding-left: 10px;
        background-color: transparent;
      }
      span{
        float: right;
        cursor: pointer;
        color: #1abc9c;
        margin-right: 5px;
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
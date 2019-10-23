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
                  :class="{'area-item': true, 'area-on': chooseProv==index}"
                  @click="getCity(index, item.id)"
                >{{ item.name }}</div>
              </div>
            </div>

            <div v-for="(items, index) in cityList">
              <h4 class="title">{{ items.title }}</h4>
              <!-- 城市列表 -->
              <div v-for="(item, idx) in items.list" :key="idx">
                <div
                  :class="{'area-item': true, 'area-on': chooseCity[index]==idx}"
                  @click.self="operation(index, idx)"
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
                      placement="bottom"
                      title="您确定要删除这条内容吗？"
                      @on-ok="remove(item.id)"
                    >
                      <span class="del">删除</span>
                    </Poptip>
                  </div>
                </div>
              </div>
              <div :class="{'addcity-box': true, 'show': addCity[index].show}">
                <input type="text" v-model="addCity[index].name" />
                <span class="cancel" @click="cancel(index)">取消</span>
                <span class="save" @click="save(index)">保存</span>
              </div>
              <div class="add" @click="showAddBox(index)">新增</div>
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
      provId: null,
      cityList: [
        {
          title: "特级城市",
          list: []
        },
        {
          title: "一级城市",
          list: []
        },
        {
          title: "二级城市",
          list: []
        },
        {
          title: "三级县市",
          list: []
        }
      ],
      chooseProv: null,
      chooseCity: [],
      addCity: [
        {
          show: false,
          name: ""
        },
        {
          show: false,
          name: ""
        },
        {
          show: false,
          name: ""
        },
        {
          show: false,
          name: ""
        }
      ]
    };
  },
  created() {
    this.init();
  },
  methods: {
    init() {
      this.getAllProv();
      this.getCity(0, 2);
    },
    getCity(index, id) {
      this.chooseProv = index;
      this.provId = id;
      axios
        .post("RoleJoin/city_screen", {
          pid: id
        })
        .then(res => {
          console.log(res.data);
          let { data, msg, code } = res.data;
          if (code !== 1) {
            this.$Message.error(msg);
          } else {
            if (data.list) {
              this.cityList[0].list = data.list.zero;
              this.cityList[1].list = data.list.one;
              this.cityList[2].list = data.list.two;
              this.cityList[3].list = data.list.three;
            }
          }
        });
    },
    operation(index, idx) {
      if (this.chooseCity[index] == idx) {
        this.$set(this.chooseCity, index, null);
      } else {
        this.$set(this.chooseCity, index, idx);
      }
    },
    moveCity(name) {
      console.log(name);
    },
    remove(id) {
      axios.post('RoleJoin/city_delete', {
        cid: id
      }).then(res => {
        let {data, code, msg} = res.data;
        console.log(data)
        if(code !== 1){
          this.$Message.error(msg);
        }else{
          this.$Message.success(msg);
          this.getCity(this.chooseProv, this.provId);
        }
      })
    },
    showAddBox(index) {
      this.addCity[index].show = true;
    },
    cancel(index) {
      this.addCity[index].show = false;
    },
    save(index) {
      axios
        .post("RoleJoin/city_create", {
          pid: this.provId,
          name: this.addCity[index].name,
          type: index
        })
        .then(res => {
          let { data, msg, code } = res.data;
          if (code !== 1) {
            this.$Message.error(msg);
          } else {
            this.$Message.success(msg);
            this.getCity(this.chooseProv, this.provId);
            this.addCity[index].name = "";
          }
        });
    },
    getAllProv() {
      axios.get("RoleJoin/city_index").then(res => {
        let { data, msg, code } = res.data;
        if (code !== 1) {
          this.$Message.error(msg);
        } else {
          this.provList = data.list;
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
        span {
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
    .addcity-box {
      display: none;
      border: 1px solid #1abc9c;
      height: 38px;
      line-height: 38px;
      margin-top: 10px;
      &.show {
        display: block;
      }
      input {
        width: 100px;
        border: 0;
        outline: none;
        padding-left: 10px;
        background-color: transparent;
      }
      span {
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
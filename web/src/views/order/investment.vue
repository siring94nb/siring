<template>
  <div>
    <Row>
      <Col span="24">
        <Card style="margin-bottom: 10px">
          <Form inline>
            <FormItem>
              <span>请搜索</span>
              <Input v-model="searchConf.title" placeholder="订单编号/用户名/用户账号" style="width:200px;" />
            </FormItem>
            <FormItem>
              <span>订单类型：</span>
              <Select v-model="model1" style="width:200px">
                <Option
                  v-for="item in gaojianList"
                  :value="item.value"
                  :key="item.value"
                >{{ item.label }}</Option>
              </Select>
            </FormItem>
            <FormItem style="margin-bottom: 0">
              <span>开始时间</span>
              <DatePicker
                type="datetime"
                v-model="searchConf.start_time"
                placeholder="请输入开始时间"
                style="width: 200px"
              ></DatePicker>
            </FormItem>
            <FormItem style="margin-bottom: 0">
              <DatePicker
                type="datetime"
                v-model="searchConf.end_time"
                placeholder="请输入结束时间"
                style="width: 200px"
              ></DatePicker>
            </FormItem>
            <FormItem style="margin-bottom: 0">
              <Button type="primary" @click="search">查询</Button>
            </FormItem>
          </Form>
        </Card>
      </Col>
    </Row>

    <Card style="margin-bottom: 10px">
      <Row>
        <Col span="2">
          <Button type="primary" class="btns btn-qb">全部</Button>
        </Col>
        <Col span="2">
          <Button type="primary" class="btns btn-xsgt">线上沟通</Button>
        </Col>
        <Col span="2">
          <Button type="primary" class="btns btn-xxjmh">线下见面会</Button>
        </Col>
        <Col span="2">
          <Button type="primary" class="btns btn-htxt">合同托管</Button>
        </Col>
        <Col span="2">
          <Button type="primary" class="btns btn-xmwtjs">项目委托检视</Button>
        </Col>
        <Col span="2">
          <Button type="primary" class="btns btn-xmzz">项目中止</Button>
        </Col>
      </Row>
    </Card>
    <!-- <Modal
      v-model="modalSetting.show"
      title="温馨提示"
      width="668"
      :styles="{top: '100px'}"
      @on-visible-change="doCancel"
    >
      <div
        style="font-size: 20px;color: #666666;text-align: center;line-height: 48px;margin:50px 0;"
      >我已在SaaS平台上给用户开了账户</div>
      <div slot="footer" style="text-align:center;">
        <Button type="primary" @click="submit" :loading="modalSetting.loading">确定</Button>
      </div>
    </Modal>-->
    <Row>
      <Col span="24">
        <Card>
          <!-- <p slot="title" style="height: 32px">
            <Button type="primary" @click="alertAdd" icon="md-add">添加案例</Button>
          </p>-->
          <div>
            <Table :columns="columnsList" :data="tableData" border disabled-hover></Table>
          </div>
          <div class="margin-top-15" style="text-align: center">
            <Page
              :total="tableShow.listCount"
              :current="tableShow.page"
              :page-size="tableShow.size"
              @on-change="changePage"
              @on-page-size-change="changeSize"
              show-elevator
              show-sizer
              show-total
            ></Page>
          </div>
        </Card>
      </Col>
    </Row>
  </div>
</template>

<script>
import axios from "axios";
import config from "../../../build/config";

export default {
  data() {
    return {
      tableData: [],
      tableShow: {
        currentPage: 1,
        size: 10,
        listCount: 0
      },
      searchConf: {
        title: "",
        // order_status: "",
        start_time: "",
        end_time: ""
      },
      selID: 0,
      modalSetting: {
        show: false,
        loading: false,
        index: 0
      },
      columnsList: [
        {
          title: "稿件编号",
          type: "index",
          width: 65,
          align: "center",
          key: "id"
        },
        {
          title: "标题",
          align: "center",
          key: "no",
          width: 200
        },
        {
          title: "稿件类型",
          align: "center",
          key: "name",
          render: (h, param) => {
            if (param.row.need_category == "1") {
              return h("div", "自撰稿件");
            } else if (param.row.need_category == "2") {
              return h("div", "委托代写");
            } else {
              return h("div", "");
            }
          }
        },
        {
          title: "套餐费用",
          align: "center",
          key: "need_category",
        },
        {
          title: "稿件费用",
          align: "center",
          key: "terminal",
          width: 200
        },
        {
          title: "总计费用",
          align: "center",
          key: "phone"
        },
        {
          title: "创建时间",
          align: "center",
          key: "order_amount"
        },
        {
          title: "操作",
          align: "center",
          key: "handle",
          width: 130,
          render: (h, param) => {
            let status, color;
            switch (param.row.need_status) {
              case 1:
                status = "线上沟通";
                color = "rgb(255,0,0)";
                break;
              case 2:
                status = "线下见面会";
                color = "rgb(102,153,0)";
                break;
              case 3:
                status = "合同托管";
                color = "rgb(87,163,243)";
                break;
              case 4:
                status = "项目委托检视";
                color = "rgb(171,147,48)";
                break;
              case 5:
                status = "项目中止";
                color = "rgb(134,134,134)";
                break;
            }
            return h(
              "Button",
              {
                props: {
                  type: "primary"
                },
                style: {
                  "background-color": color,
                  border: "0"
                },
                on: {
                  click: () => {
                    this.$router.push({
                      name: "investment_detail",
                      params: {
                        id: param.row.id,
                        status: param.row.need_status
                      }
                    });
                  }
                }
              },
              status
            );
          }
        }
      ],
      gaojianList: [
        {
          value: "请选择",
          label: "请选择"
        },
        {
          value: "自撰稿件",
          label: "自撰稿件"
        },
        {
          value: "代写稿件",
          label: "代写稿件"
        }
      ],
      model1:""
    };
  },
  created() {
    this.init();
    this.getMade();
  },
  methods: {
    init() {
      let vm = this;
      this.columnsList.forEach(item => {
        if (item.handle) {
          item.render = (h, param) => {
            let currentRowData = vm.tableData[param.index];
            // return h("div", [behalfButton(vm, h, currentRowData, param.index)]);
          };
        }
      });
    },
    getMade() {
      let vm = this;
      axios
        .get("NeedOrder/need_index", {
          params: {
            page: vm.tableShow.page,
            size: vm.tableShow.size,
            title: vm.searchConf.title,
            // order_status: vm.searchConf.order_status,
            start_time: vm.searchConf.start_time,
            end_time: vm.searchConf.end_time
          }
        })
        .then(function(response) {
          let res = response.data;
          if (res.code === 1) {
            vm.tableData = res.data.data;
            vm.tableShow.listCount = res.data.listCount;
          }
        });
    },
    changePage(page) {
      this.tableShow.page = page;
      this.getMade();
    },
    changeSize(size) {
      this.tableShow.size = size;
      this.getMade();
    },
    search() {
      this.tableShow.page = 1;
      this.getMade();
    }
  },
  mounted() {}
};
</script>

<style lang="less" scoped>
.btns {
  width: 100px;
  border: 0;
}
.btn-qb {
  background-color: rgb(140, 218, 255);
}
.btn-xsgt {
  background-color: rgb(255,0,0);
}
.btn-xxjmh{
  background-color: rgb(102,153,0);
}
.btn-httg {
  background-color: rgb(0,51,255);
}
.btn-xmwtjs {
  background-color: rgb(171,147,48);
}
.btn-xmzz {
  background-color: rgb(134,134,134);
}
</style>

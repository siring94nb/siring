<template>
  <div>
    <Row>
      <Col span="24">
        <Card style="margin-bottom: 10px">
          <Form inline>
            <FormItem>
              <span>请搜索</span>
              <Input
                v-model="searchConf.title"
                placeholder="订单编号/用户名/用户账号/模板"
                style="width:250px;"
              />
            </FormItem>
            <FormItem style="margin-bottom: 0">
              <span>审核</span>
              <Select
                v-model="searchConf.order_status"
                clearable
                placeholder="全部"
                style="width:100px"
              >
                <Option :value="-1">等待开通</Option>
                <Option :value="0">确认开通</Option>
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
const behalfButton = (vm, h, currentRow, index) => {
  return h(
    "Button",
    {
      props: {
        type: "primary"
      },
      style: {
        margin: "0 5px"
      },
      on: {
        click: () => {
          vm.$router.push({
            name: "goods_add",
            params: {
              goods_id: currentRow.id
            }
          });
        }
      }
    },
    "待开通"
  );
};
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
        order_status: "",
        start_time: "",
        end_time: ""
      },
      columnsList: [
        {
          title: "序号",
          type: "index",
          width: 65,
          align: "center",
          key: "id"
        },
        {
          title: "订单编号",
          align: "center",
          key: "plate_form"
        },
        {
          title: "行业模板",
          align: "center",
          key: "evaluate_type"
        },
        {
          title: "模板套餐",
          align: "center",
          key: "model"
        },
        {
          title: "用户账号",
          align: "center",
          key: "function_point"
        },
        {
          title: "订单金额",
          align: "center",
          key: "work_hours"
        },
        {
          title: "付款账号",
          align: "center",
          key: "price_down"
        },
        {
          title: "下单时间",
          align: "center",
          key: "price_up"
        },
        {
          title: "套餐到期时间",
          align: "center",
          key: "price_up"
        },
        {
          title: "操作",
          align: "center",
          key: "handle",
          width: 400,
          handle: ["comments"]
        }
      ]
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
            return h("div", [behalfButton(vm, h, currentRowData, param.index)]);
          };
        }
      });
    },
    getMade() {
      let vm = this;
      axios
        .get("ModelOrder/index", {
          params: {
            page: vm.tableShow.currentPage,
            size: vm.tableShow.size,
            title: vm.searchConf.title,
            order_status: vm.searchConf.order_status,
            start_time: vm.searchConf.start_time,
            end_time: vm.searchConf.end_time
          }
        })
        .then(function(response) {
          let res = response.data;
          console.log(res);
          if (res.code === 1) {
            vm.tableData = res.data.data.data;
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
</style>
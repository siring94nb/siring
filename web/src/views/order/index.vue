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

    <Modal
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
    </Modal>
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
      selID: 0,
      modalSetting: {
        show: false,
        loading: false,
        index: 0
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
          key: "order_number",
          width: 200
        },
        {
          title: "行业模板",
          align: "center",
          key: "model_type"
        },
        {
          title: "模板套餐",
          align: "center",
          key: "model_meal_type"
        },
        {
          title: "用户账号",
          align: "center",
          key: "member_account"
        },
        {
          title: "订单金额",
          align: "center",
          key: "order_amount"
        },
        {
          title: "付款账号",
          align: "center",
          key: "pay_detail",
          width: 300,
          render: (h, param) => {
            let bankNumber, pay_detail;
            if (param.row.pay_type == 1) bankNumber = "支付宝支付";
            else if (param.row.pay_type == 2) bankNumber = "微信支付";
            else if (param.row.pay_type == 4) bankNumber = "余额支付";
            if (param.row.pay_type == 3) {
              pay_detail = JSON.parse(param.row.pay_detail);
              bankNumber = pay_detail.bank_name + ":" + pay_detail.bank_number;
            }
            return h("div", bankNumber);
          }
        },
        {
          title: "下单时间",
          align: "center",
          key: "create_time"
        },
        {
          title: "套餐到期时间",
          align: "center",
          key: "meal_end_time"
        },
        // 1：未支付，2：待开通，3：已完成，4：已关闭
        {
          title: "操作",
          align: "center",
          key: "handle",
          render: (h, param) => {
            let status;
            if (param.row.order_status == 2) {
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
                      this.selID = param.row.id;
                      this.modalSetting.show = true;
                    }
                  }
                },
                "待开通"
              );
            } else {
              if (param.row.order_status == 1) status = "未支付";
              else if (param.row.order_status == 3) status = "已完成";
              else if (param.row.order_status == 4) status = "已关闭";
              return h("div", status);
            }
          }
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
            page: vm.tableShow.page,
            size: vm.tableShow.size,
            title: vm.searchConf.title,
            order_status: vm.searchConf.order_status,
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
    },

    doCancel(data) {},
    submit() {
      let vm = this;
      axios
        .post("ModelOrder/change_order_status", {
          id: vm.selID,
          order_status: 3
        })
        .then(function(response) {
            console.log(response)
          if (response.data.code === 1) {
          }
        });
    }
  },
  mounted() {}
};
</script>

<style lang="less" scoped>
</style>
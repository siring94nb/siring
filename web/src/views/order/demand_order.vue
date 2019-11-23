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
            <!-- <FormItem style="margin-bottom: 0">
              <span>订单类型</span>
              <Select
                v-model="searchConf.order_status"
                clearable
                placeholder="全部"
                style="width:100px"
              >
                <Option :value="2">定制需求</Option>
                <Option :value="3">定制类型</Option>
                <Option :value="4">项目新增</Option>
              </Select>
            </FormItem>-->
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
          <Button type="primary" class="btns btn-qb" @click="toOrder">全部</Button>
        </Col>
        <Col span="2">
          <Button type="primary" class="btns btn-dzxq">定制需求</Button>
        </Col>
        <Col span="2">
          <Button type="primary" class="btns btn-ptbj">平台报价</Button>
        </Col>
        <Col span="2">
          <Button type="primary" class="btns btn-qdht">签订合同</Button>
        </Col>
        <Col span="2">
          <Button type="primary" class="btns btn-yxqr">原型确认</Button>
        </Col>
        <Col span="2">
          <Button type="primary" class="btns btn-xmsx">项目上线</Button>
        </Col>
        <Col span="2">
          <Button type="primary" class="btns btn-xmys">项目验收</Button>
        </Col>
        <Col span="2">
          <Button type="primary" class="btns btn-xmnfw">项目年服务</Button>
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
          title: "序号",
          type: "index",
          width: 65,
          align: "center",
          key: "id"
        },
        {
          title: "合同编号",
          align: "center",
          key: "need_order",
          width: 200
        },
        {
          title: "项目名称",
          align: "center",
          key: "need_name"
        },
        {
          title: "订单类型",
          align: "center",
          key: "need_category"
        },
        {
          title: "终端类型",
          align: "center",
          key: "need_terminal",
          render: (h, param) => {
            //   param.row.need_terminal = JSON.parse(param.row.need_terminal);
            //   param.row.need_terminal = JSON.stringify(param.row.need_terminal);
            return h("div", param.row.need_terminal);
          }
        },
        {
          title: "用户账号",
          align: "center",
          key: "need_phone",
          width: 120
        },
        {
          title: "合同金额",
          align: "center",
          key: "need_money"
        },
        {
          title: "付款金额",
          align: "center",
          key: "need_order_money"
        },
        {
          title: "付款账号",
          align: "center",
          key: "need_pay_account",
          width: 250,
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
          key: "create_time",
          width: 120
        },
        {
          title: "剩余款",
          align: "center",
          key: "need_surplus"
        },
        {
          title: "剩余天数",
          align: "center",
          key: "meal_end_time"
        },
        {
          title: "用户最新消息",
          align: "center",
          key: "need_new_info"
        },
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
                    margin: "0 5px",
                    "background-color": "rgb(204,0,204)",
                    border: "0"
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
    },
    toOrder() {
      this.$router.push({
        name: "demand_order_detail",
        params: {
          id: 22,
          status:2
        }
      });
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
.btn-dzxq {
  background-color: rgb(204, 51, 102);
}
.btn-ptbj {
  background-color: rgb(204, 0, 204);
}
.btn-qdht {
  background-color: rgb(255, 0, 0);
}
.btn-yxqr {
  background-color: rgb(102, 153, 0);
}
.btn-xmsx {
  background-color: rgb(204, 153, 0);
}
.btn-xmys {
  background-color: rgb(0, 102, 255);
}
.btn-xmnfw {
  background-color: rgb(255, 102, 0);
}
.btn-xmzz {
  background-color: rgb(174, 174, 174);
}
</style>
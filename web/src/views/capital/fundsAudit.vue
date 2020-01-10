<style lang="less" scoped>
</style>
<template>
  <div>
    <Row>
      <Col span="24">
        <Card style="margin-bottom: 10px">
          <Form inline>
            <FormItem style="margin-bottom: 0">
              <Input v-model="searchConf.name" placeholder="请输入名称"></Input>
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
          <div>
            <Table :columns="columnsList" :data="tableData" border disabled-hover></Table>
          </div>
          <div class="margin-top-15" style="text-align: center">
            <Page
              :total="tableShow.listCount"
              :current="tableShow.currentPage"
              :page-size="tableShow.pageSize"
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
    <Modal
      v-model="modalSetting.show"
      width="500"
      :styles="{top: '30px'}"
      @on-visible-change="doCancel"
    >
      <p slot="header" style="font-size:18px;text-align:center;">
        <span>审核</span>
      </p>
      <Form ref="myForm" :model="formItem" :label-width="80">
        <div style="width:200px;margin:auto;">
          <RadioGroup v-model="formItem.type">
            <div style="margin-bottom: 20px;">
              <Radio :label="2">通过</Radio>
              <div style="display:inline-block;vertical-align: top;">
                <p>审核通过，款项已到帐</p>
                <p style="color:rgb(148,148,148);">*弹框以及短信内容</p>
              </div>
            </div>
            <div>
              <Radio :label="3">驳回</Radio>
              <div style="display:inline-block;vertical-align: top;">
                <p>审核通过，款项已到帐</p>
                <p style="color:rgb(148,148,148);">*弹框以及短信内容</p>
              </div>
            </div>
          </RadioGroup>
        </div>
      </Form>
      <div slot="footer" style="text-align:center;">
        <Button type="text" @click="cancel" style="margin-right: 8px">返回</Button>
        <Button type="primary" @click="toQue">确定</Button>
      </div>
    </Modal>
    <Modal
      v-model="modalSetting.twoShow"
      width="500"
      :styles="{top: '30px'}"
      @on-visible-change="tCancel"
    >
      <p slot="header" style="font-size:18px;text-align:center;">
        <span>温馨提示</span>
      </p>
      <div style="text-align:center;margin:50px 0;">
        确定
        <span
          style="font-weight:700;"
          :style="formItem.type == 2 ? 'color:rgb(102,204,0);':'color:red;'"
        >{{formItem.type == 2 ? '已收到':'未收到'}}</span>
        款项么？！
      </div>
      <div slot="footer" style="text-align:center;">
        <Button type="text" @click="twoCancel" style="margin-right: 8px">返回</Button>
        <Button type="primary" @click="submit" :loading="modalSetting.loading">确定</Button>
      </div>
    </Modal>
  </div>
</template>
<script>
import axios from "axios";
import config from "../../../build/config";
const editButton = (vm, h, currentRow, index) => {
  if (currentRow.order_status == 1) {
    return h(
      "Button",
      {
        props: {
          type: "primary"
        },
        style: {
          margin: "0 5px",
          "background-color": "rgb(255,153,0)",
          "border-color": "rgb(255,153,0)"
        },
        on: {
          click: () => {
            vm.modalSetting.show = true;
            vm.formItem.id = currentRow.id;
          }
        }
      },
      "待审核"
    );
  } else {
    let status_font, color;
    if (currentRow.order_status == 2) {
      status_font = "已到账";
      color = "rgb(102,204,0)";
    } else {
      status_font = "已驳回";
      color = "red";
    }
    return h(
      "div",
      {
        style: {
          color: color
        }
      },
      status_font
    );
  }
};

export default {
  name: "system_user",
  data() {
    return {
      columnsList: [
        {
          title: "序号",
          type: "index",
          width: 65,
          align: "center",
          key: "id"
        },
        {
          title: "订单号",
          align: "center",
          width: 200,
          key: "order_number"
        },
        {
          title: "用户账号",
          align: "center",
          key: "phone"
        },
        {
          title: "支付类型",
          align: "center",
          key: "pay_type"
        },
        {
          title: "支付账号",
          align: "center",
          width: 200,
          key: "bank_number"
        },
        {
          title: "支付金额",
          align: "center",
          key: "pay_money"
        },
        {
          title: "支付时间",
          width: 180,
          align: "center",
          key: "create_time"
        },
        {
          title: "用户留言",
          align: "center",
          key: "comment"
        },
        {
          title: "收款账号",
          align: "center",
          key: "account_number"
        },
        {
          title: "操作",
          align: "center",
          key: "handle",
          width: 260,
          handle: ["edit"]
        }
      ],
      tableData: [],
      groupList: [],
      tableShow: {
        currentPage: 1,
        pageSize: 10,
        listCount: 0
      },
      searchConf: {
        name: ""
      },
      modalSetting: {
        show: false,
        loading: false,
        index: 0,
        twoShow: false
      },
      formItem: {
        id: 0,
        type: ""
      },
      ruleValidate: {
        // type: [{ required: true, message: "请输入名称", trigger: "blur" }]
      }
    };
  },
  created() {
    this.init();
    this.getList();
  },
  methods: {
    init() {
      let vm = this;
      this.columnsList.forEach(item => {
        if (item.handle) {
          item.render = (h, param) => {
            let currentRowData = vm.tableData[param.index];

            return h("div", [
              editButton(vm, h, currentRowData, param.index)
              //   deleteButton(vm, h, currentRowData, param.index)
            ]);
          };
        }
      });
    },
    alertAdd() {
      this.modalSetting.show = true;
    },
    submit() {
      let self = this;
      self.modalSetting.loading = true;
      axios.post("CapitalCard/upd", this.formItem).then(function(response) {
        if (response.data.code === 1) {
          self.$Message.success(response.data.msg);
          self.getList();
          self.cancel();
          self.twoCancel();
        } else {
          self.modalSetting.loading = false;
          self.$Message.error(response.data.msg);
        }
      });
    },
    cancel() {
      this.modalSetting.show = false;
      this.formItem.id = 0;
      this.formItem.type = "";
    },
     doCancel(data) {
      if (!data) {
        this.formItem.id = 0;
        this.modalSetting.loading = false;
        this.modalSetting.index = 0;
        this.cancel();
      }
    },
    twoCancel() {
      this.modalSetting.twoShow = false;
    },
    toQue() {
      this.modalSetting.twoShow = true;
    },
    tCancel(data) {
      if (!data) {
        this.twoCancel();
      }
    },
    changePage(page) {
      this.tableShow.currentPage = page;
      this.getList();
    },
    changeSize(size) {
      this.tableShow.pageSize = size;
      this.getList();
    },
    search() {
      this.tableShow.currentPage = 1;
      this.getList();
    },
    getList() {
      let vm = this;
      axios
        .get("CapitalCard/index", {
          params: {
            page: vm.tableShow.currentPage,
            size: vm.tableShow.pageSize,
            name: vm.searchConf.name
          }
        })
        .then(function(response) {
          let res = response.data;
          if (res.code === 1) {
            vm.tableData = res.data.list;
            vm.tableShow.listCount = res.data.count;
          } else {
            if (res.code === -14) {
              vm.$store.commit("logout", vm);
              vm.$router.push({
                name: "login"
              });
            } else {
              vm.$Message.error(res.msg);
            }
          }
        });
    }
  },
  mounted() {}
};
</script>

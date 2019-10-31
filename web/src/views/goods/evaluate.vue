<template>
  <div>
    <Row>
      <Col span="24">
        <Card>
          <!-- <p slot="title" style="height: 32px">
            <Button type="primary" @click="alertAdd" icon="md-add">添加案例</Button>
          </p> -->
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
      columnsList: [
        {
          title: "序号",
          type: "index",
          width: 65,
          align: "center",
          key: "id"
        },
        {
          title: "开发端",
          align: "center",
          key: "plate_form"
        },
        {
          title: "分类",
          align: "center",
          key: "evaluate_type"
        },
        {
          title: "模块",
          align: "center",
          key: "model"
        },
        {
          title: "功能点",
          align: "center",
          key: "function_point"
        },
        {
          title: "每模块工时（日）",
          align: "center",
          key: "work_hours"
        },
        {
          title: "工时报价（低）",
          align: "center",
          key: "price_down"
        },
        {
          title: "工时报价（高）",
          align: "center",
          key: "price_up"
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
    //   this.columnsList.forEach(item => {});
    },
    getMade() {
      let vm = this;
      axios.post("Goods/evaluate", vm.tableShow).then(function(response) {
        let res = response.data;
            console.log(res)
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
    },
    
  },
  mounted() {}
};
</script>

<style lang="less" scoped>
@import "./goods.less";
</style>
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
  </div>
</template>

<script>
import axios from "axios";
import config from "../../../build/config";

export default {
  data() {
    return {
      tableData: [],
      uploadList: [],
      iconList: [],
      typeList: [],
      UploadAction: "",
      tableShow: {
        currentPage: 1,
        pageSize: 10,
        listCount: 0
      },
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
      this.columnsList.forEach(item => {});
    },
    getMade(data) {
      let vm = this;
      axios.post("Goods/evaluate", data).then(function(response) {
        let res = response.data;
        if (res.code === 1) {
          vm.tableData = res.data.list.data;
          vm.tableShow.listCount = res.data.listCount;
        }
      });
    },
    changePage(page) {
      this.tableShow.currentPage = page;
      this.getMade(this.tableShow);
    },
    changeSize(size) {
      this.tableShow.pageSize = size;
      this.getMade(this.tableShow);
    },
    search() {
      this.tableShow.currentPage = 1;
      this.getMade(this.tableShow);
    },
    
  },
  mounted() {}
};
</script>

<style lang="less" scoped>
@import "./goods.less";
</style>
<style lang="less" scoped>
@import "./advertising.less";
</style>
<template>
  <div class="guanggaoBox">
    <div class="guanggaoSmBox">
      <span>
        <span style="width:100px">广告名称：</span>
        <Input v-model="GGName" size="large" placeholder="广告名称" />
      </span>
      <span>
        <span>广告位置：</span>
        <Select v-model="selectw" style="width: 200px;">
          <Option :value="-1">全部</Option>
          <Option v-for="(item, index) in selectC" :value="item.id" :key="index">{{item.name}}</Option>
        </Select>
      </span>
    </div>
    <div class="addguanggao">添加广告</div>
    <div>
      <div>
        <Table :columns="columnsList" :data="tableData" border disabled-hover></Table>
      </div>
      <div class="margin-top-15" style="text-align: center">
        <Page
          :total="tableShow.listCount"
          :current="tableShow.currentPage"
          :page-size="tableShow.pageSize"
          show-elevator
          show-sizer
          show-total
          @on-change="changePage"
          @on-page-size-change="changeSize"
        ></Page>
        <!--  @on-change="changePage"
          @on-page-size-change="changeSize" -->
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";  
const editButton = (vm, h, currentRow, index) => {
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
    "编辑"
  );
};
const deleteButton = (vm, h, currentRow, index) => {
  return h(
    "Poptip",
    {
      props: {
        confirm: true,
        title: "您确定要删除这条数据吗? ",
        transfer: true
      },
      on: {
        "on-ok": () => {
          axios
            .post("Goods/del", {
              id: currentRow.id
            })
            .then(function(response) {
              currentRow.loading = false;
              if (response.data.code === 1) {
                vm.tableData.splice(index, 1);
                vm.$Message.success(response.data.msg);
              } else {
                vm.$Message.error(response.data.msg);
              }
            });
        }
      }
    },
    [
      h(
        "Button",
        {
          style: {
            margin: "0 5px"
          },
          props: {
            type: "error",
            placement: "top",
            loading: currentRow.isDeleting
          }
        },
        "删除"
      )
    ]
  );
};
export default {
  data() {
    return {
      GGName: "",
      selectw: -1,
      selectC: [
        { name: "APP首页轮播", id: 1 },
        { name: "PC端首页轮播", id: 2 },
        { name: "PC端分类广告", id: 3 }
      ],
      columnsList: [
        {
          title: "编号",
          type: "index",
          width: 65,
          align: "center",
          key: "id"
        },
        {
          title: "广告名称",
          align: "center",
          key: "goods_name"
        },
        {
          title: "广告位置",
          align: "center",
          key: "goods_number"
        },
        {
          title: "广告图片",
          align: "center",
          key: "goods_images",
          width: 150,
          render: (h, param) => {
            return h("img", {
              attrs: {
                src: param.row.goods_images
              },
              style: {
                width: "100px",
                height: "90px",
                padding: "5px 0 0 0"
              }
            });
          }
        },
        {
          title: "上线/下线",
          align: "center",
          key: "category_id",
          render: (h, param) => {
                  if (param.row.category_id == "1") {
                      return h("div", "上线");
                  } else if (param.row.vest == "2") {
                      return h("div", "下线");
                  }
              }
        },
        {
          title: "点击次数",
          align: "center",
          key: "goods_number",
        },
        {
          title: "操作",
          align: "center",
          key: "handle",
          width: 400,
          handle: ["edit", "delete"]
        }
      ],
      tableData:[],
      tableShow: {
        currentPage: 1,
        pageSize: 10,
        listCount: 0
      },
      searchConf: {
        title: "",
        status: "",
        category_id: -1
      },
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
              editButton(vm, h, currentRowData, param.index),
              deleteButton(vm, h, currentRowData, param.index)
            ]);
          };
        }
      });
    },
    tableRemove(index) {
      this.formItem.special.splice(index, 1);
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
    alertAdd() {
      let vm = this;
      vm.$router.push({
        name: "goods_add",
        params: {
          goods_id: 0
        }
      });
    },
    submit() {
      let self = this;
      this.$refs["myForm"].validate(valid => {
        if (valid) {
          self.modalSetting.loading = true;
          let target = "";
          if (this.formItem.id) {
            target = "Goods/add";
          } else {
            target = "Goods/add";
          }
          // data.formItem = this.formItem;
          // data.special = this.special;
          axios.post(target, this.formItem).then(function(response) {
            self.modalSetting.loading = false;
            console.log(response);
            if (response.data.code === 1) {
              self.$Message.success(response.data.msg);
              self.getList();
              self.cancel();
            } else {
              self.$Message.error(response.data.msg);
            }
          });
        }
      });
    },
    getList() {
      let vm = this;
      axios
        .get("Goods/index", {
          params: {
            page: vm.tableShow.currentPage,
            size: vm.tableShow.pageSize,
            goods_name: vm.searchConf.title,
            category_id: vm.searchConf.category_id,
            status: vm.searchConf.status
          }
        })
        .then(function(response) {
          let res = response.data;
          if (res.code === 1) {
            for (let i = 0; i < res.data.list.length; i++) {
              var str = res.data.list[i].goods_images.split(",");
              res.data.list[i].goods_images = str[0];
            }
            vm.tableData = res.data.list;
            vm.tableShow.listCount = res.data.listcount;
          }
        });
    },
    // 图片上传
    handleView(file) {
      this.visible = true;
    },
    // handleRemove(file) {
    //   const fileList = this.$refs.upload.fileList;
    //   this.$refs.upload.fileList.splice(fileList.indexOf(file), 1);
    //   this.formItem.data.goods_images = "";
    // },
    handleSuccess(res, file) {
      // file.url = res.data;
      // this.formItem.img = res.data.substr( res.data.indexOf( 'upload' ) );
      file.url = res.data.filePath; //获取图片路径
      this.formItem.data.goods_images = res.data.filePath;
    },
    handleFormatError(file) {
      this.$Message.error("文件格式不正确, 请选择jpg或者png.");
    },
    handleMaxSize(file) {
      this.$Message.error("文件大小不能超过10M");
    },
    handleBeforeUpload() {
      const check = this.uploadList.length < 1;
      if (!check) {
        this.$Message.error("只能上传一张品牌图");
      }
      return check;
    }
  }
};
</script>

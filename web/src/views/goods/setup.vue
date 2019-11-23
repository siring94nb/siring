<style lang="less" scoped>
</style>
<template>
  <div>
      <Modal v-model="modalSetting.sortShow" width="598" :styles="{top: '30px'}">
      <p slot="header">
        <Icon type="md-add"></Icon>
        <span>添加分类</span>
      </p>
      <p style="font-size:18px;margin-left:15px;">分类编辑</p>
      <div
        v-for="(item, index) in sortData"
        :value="item.id"
        :key="index"
        style="margin: 0 0 10px 80px;"
      >
        <Input v-model="item.category_name" style="width: 300px;margin-right:20px;" />
        <Button type="primary" @click="editSort(index, item.id)">编辑</Button>
      </div>
      <p style="font-size:18px;margin:30px 0 0 15px;">分类添加</p>
      <Form ref="sortForm" :rules="ruleValidate" :model="sortMain" :label-width="80">
        <FormItem label="分类名称" prop="category_name">
          <Input v-model="sortMain.category_name" placeholder="请输入" style="width: 400px;" />
        </FormItem>
      </Form>
      <div slot="footer">
        <Button @click="sortCancel">取消</Button>
        <Button type="primary" @click="submit_sort" :loading="modalSetting.loading">确定</Button>
      </div>
    </Modal>
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
          <p slot="title" style="height: 32px">
            <Button type="primary" @click="alertAdd" icon="md-add">新增</Button>
          </p>
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
      width="900"
      :styles="{top: '30px'}"
      @on-visible-change="doCancel"
    >
      <p slot="header" style="color:#2d8cf0;">
        <Icon type="md-information-circle"></Icon>
        <span>{{formItem.id ? '编辑' : '新增'}}</span>
      </p>
      <Form ref="myForm" :rules="ruleValidate" :model="formItem" :label-width="80">
        <FormItem label="发布费用" prop="name">
          <Input style="width: 300px" v-model="formItem.name" placeholder="元" />
        </FormItem>
        <FormItem label="赏金设置" prop="price">
          <Input style="width: 150px" v-model="formItem.price" placeholder="元" />
        </FormItem>
      
        <FormItem label="行业分类">
          <Select v-model="formItem.category_id" style="width: 400px;">
            <Option
              v-for="(item, index) in sortData"
              :value="item.id"
              :key="index"
            >{{ item.category_name }}</Option>
          </Select>
          <Button
            type="text"
            @click="addSort"
            ghost
            icon="md-add"
            style="color:rgb(51,204,255);"
          >添加分类</Button>
          <p>*可添加、修改分类，也可删除分类，分类名称按照顺序显示在前端页面</p>
        </FormItem>
      </Form>
      <div slot="footer">
        <Button type="text" @click="cancel" style="margin-right: 8px">取消</Button>
        <Button type="primary" @click="submit" :loading="modalSetting.loading">确定</Button>
      </div>
    </Modal>
  </div>
</template>
<script>
import axios from "axios";
import config from "../../../build/config";
import wangEditor from "wangeditor";
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
          vm.formItem.id = currentRow.id;
          vm.formItem.name = currentRow.name;
          vm.formItem.sort = currentRow.sort;
          vm.formItem.price = currentRow.price;
          vm.formItem.money = currentRow.money;
          vm.formItem.con = currentRow.con;
          vm.editor.txt.html(vm.formItem.con);
          vm.formItem.status = currentRow.status;

          vm.modalSetting.show = true;
          vm.modalSetting.index = index;
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
            .post("Extension/del", {
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
          title: "发布费用",
          align: "center",
          key: "name"
        },
        {
          title: "赏金",
          align: "center",
          key: "price"
        },
        {
          title: "行业分类",
          align: "center",
          key: "sort"
        },
        {
          title: "操作",
          align: "center",
          key: "handle",
          width: 260,
          handle: ["edit", "delete"]
        }
      ],
      tableData: [],
      sortData:[],
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
        sortShow:false
      },
      formItem: {
        id: 0,
        name: "",
        sort: 1,
        price: 1,
        money: 1,
        status: 1
      },
      sortMain: {
        category_name: ""
      },
      ruleValidate: {
        name: [{ required: true, message: "请输入名称", trigger: "blur" }]
        // add_time: [
        //     { required: true, message: '请选择开始时间', trigger: 'blur' }
        // ],
        // end_time: [
        //     { required: true, message: '请选择结束时间', trigger: 'blur' }
        // ],
        // type: [
        //     { required: true, message: '请选择范围', trigger: 'change' }
        // ],
      }
    };
  },
  created() {
    this.init();
    this.getList();
    this.getSort();
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
    alertAdd() {
      this.modalSetting.show = true;
    },
    getSort() {
      let vm = this;
      axios.post("Goods/category_index", {}).then(function(response) {
        let res = response.data;
        if (res.code === 1) {
          vm.sortData = res.data.list;
        }
      });
    },
     addSort() {
      this.modalSetting.sortShow = true;
    },
    editSort(index, id) {
      let self = this;
      axios
        .post("Goods/category_edit", {
          id: id,
          category_name: self.sortData[index].category_name
        })
        .then(function(response) {
          console.log(response);
          if (response.data.code === 1) {
            self.$Message.success(response.data.msg);
          } else {
            self.$Message.error(response.data.msg);
          }
        });
    },
    submit_sort() {
      let self = this;

      this.$refs["sortForm"].validate(valid => {
        if (valid) {
          self.modalSetting.loading = true;
          axios
            .post("Goods/category_add", this.sortMain)
            .then(function(response) {
              self.modalSetting.loading = false;
              console.log(response);
              if (response.data.code === 1) {
                self.$Message.success(response.data.msg);
                setTimeout(function() {
                  self.sortCancel();
                }, 1000);
              } else {
                self.$Message.error(response.data.msg);
              }
            });
        }
      });
    },
    sortCancel() {
      this.sortMain.category_name = "";
      this.modalSetting.sortShow = false;
    },
    submit() {
      let self = this;
      this.$refs["myForm"].validate(valid => {
        if (valid) {
          self.modalSetting.loading = true;
          let target = "";
          if (this.formItem.id === 0) {
            target = "Extension/add";
          } else {
            target = "Extension/upd";
          }
          axios.post(target, this.formItem).then(function(response) {
            if (response.data.code === 1) {
              self.$Message.success(response.data.msg);
              self.getList();
              self.cancel();
            } else {
              self.modalSetting.loading = false;
              self.$Message.error(response.data.msg);
            }
          });
        }
      });
    },
    cancel() {
      this.modalSetting.show = false;
      this.formItem.id = 0;
      this.formItem.name = "";
      this.formItem.sort = 1;
      this.formItem.price = "";
      this.formItem.money = "";
      this.formItem.con = "";
      this.editor.txt.html("");
      this.formItem.status = 1;
    },
    doCancel(data) {
      if (!data) {
        this.formItem.id = 0;
        this.$refs["myForm"].resetFields();
        this.modalSetting.loading = false;
        this.modalSetting.index = 0;
        this.cancel();
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
        .get("Extension/index", {
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
  mounted() {
    let vm = this;
    this.editor = new wangEditor("#wangeditor");
    this.editor.customConfig.uploadFileName = "image";
    this.editor.customConfig.uploadImgMaxLength = 1;
    this.editor.customConfig.uploadImgServer =
      config.front_url + "file/qn_upload";
    this.editor.customConfig.uploadImgHooks = {
      customInsert: function(insertImg, result, editor) {
        if (result.code == 1) {
          insertImg(result.data.filePath);
        }
      }
    };
    this.editor.customConfig.onchange = function(html) {
      vm.formItem.con = html;
    };
    this.editor.create();
  }
};
</script>

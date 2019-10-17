<template>
  <div>
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
      width="668"
      :styles="{top: '30px'}"
      @on-visible-change="doCancel"
    >
      <p slot="header" style="color:#2d8cf0;">
        <Icon type="md-information-circle"></Icon>
        <span>{{formItem.id ? '编辑' : '新增'}}用户</span>
      </p>
      <Form ref="myForm" :rules="ruleValidate" :model="formItem" :label-width="120">
        <FormItem label="城市等级" prop="realname">
          <Input v-model="formItem.realname" placeholder="请输入会员等级" style="width: 300px;"></Input>
        </FormItem>
        <FormItem label="费用标准（元/年）">
          <Input v-model="formItem.phone" placeholder="请输入费用标准" style="width: 300px;"></Input>
        </FormItem>
        <FormItem label="等级政策描述">
          <Input
            v-model="formItem.textarea"
            type="textarea"
            :autosize="{minRows: 2,maxRows: 5}"
            placeholder="请输入等级政策描述"
          ></Input>
        </FormItem>
        <FormItem label="收益预测">
          <Input v-model="formItem.phone" placeholder="请输入收益预测" style="width: 300px;"></Input>
        </FormItem>
        <FormItem label="保底佣金比例（0~99%）">
          <Input v-model="formItem.phone" placeholder="请输入保底佣金比例" style="width: 300px;"></Input>
        </FormItem>
        <FormItem label="达标佣金比例">
          <Input v-model="formItem.phone" placeholder="请输入达标佣金比例" style="width: 300px;"></Input>
        </FormItem>
        <FormItem label="达标要求（个）">
          <Input v-model="formItem.phone" placeholder="请输入达标要求" style="width: 300px;"></Input>
          <div>*发展等级会员（除普通会员外）数</div>
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
          vm.formItem.realname = currentRow.realname;
          vm.formItem.img = currentRow.img;
          vm.formItem.remark = currentRow.remark;
          vm.formItem.type = currentRow.type;
          vm.formItem.phone = currentRow.phone;
          vm.modalSetting.show = true;
          vm.modalSetting.index = index;

          //图片
          if (currentRow.img != "") {
            vm.iconList = [{ name: "", url: currentRow.img }];
          }
          // vm.$nextTick(() => {
          //   vm.uploadList = vm.$refs.upload.fileList;
          // });
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
            .post("UserManage/Delete", {
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
  name: "UserManage_list",
  data() {
    const validatePhone = (rule, value, callback) => {
      var reg = /^1\d{10}$/;
      if (!reg.test(value)) {
        callback(new Error("手机号码格式不正确"));
      }
      callback();
    };
    return {
      UploadAction: "",
      UploadHeader: "",
      uploadList: [],
      DefaultList: [],
      confirmRefresh: false,
      columnsList: [
        {
          title: "等级名称",
          align: "center",
          key: "invitation"
        },
        {
          title: "费用标准",
          align: "center",
          key: "other_code"
        },
        {
          title: "等级政策",
          align: "center",
          key: "other_code"
        },
        {
          title: "年收益预测",
          align: "center",
          key: "status",
        },
        {
          title: "操作",
          align: "center",
          key: "handle",
          width: 200,
          handle: ["edit", "delete"]
        }
      ],
      tableData: [],
      tableShow: {
        currentPage: 1,
        pageSize: 10,
        listCount: 0
      },
      formItem: {
        img: ""
      },
      searchConf: {
        title: "",
        keywords: "",
        status: "",
        start_time: "",
        end_time: ""
      },
      modalSetting: {
        show: false,
        loading: false,
        index: 0
      },
      ruleValidate: {
        realname: [
          { required: true, message: "姓名不能为空", trigger: "blur" }
        ],
        phone: [
          { required: true, message: "手机号码不能为空", trigger: "blur" },
          { validator: validatePhone, trigger: "blur" }
        ]
      },
      // 图片
      UploadAction: "",
      visible: false,
      uploadList: [],
      iconList: []
      // 图片
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
    alertAdd() {
      //图片
      // this.$nextTick(() => {
      //   this.uploadList = this.$refs.upload.fileList;
      // });
      this.modalSetting.show = true;
    },
    submit() {
      let self = this;
      this.$refs["myForm"].validate(valid => {
        if (valid) {
          self.modalSetting.loading = true;
          let target = "";
          if (this.formItem.id) {
            target = "UserManage/Edit";
          } else {
            target = "UserManage/Add";
          }
          axios.post(target, self.formItem).then(function(response) {
            self.modalSetting.loading = false;
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
      // 移除图片
      this.visible = false;
      for (var i = 0; i < this.uploadList.length; i++) {
        this.handleRemove(this.uploadList[i]);
      }
      this.modalSetting.show = false;
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
        .get("UserManage/index", {
          params: {
            page: vm.tableShow.currentPage,
            size: vm.tableShow.pageSize,
            keywords: vm.searchConf.keywords,
            title: vm.searchConf.title,
            start_time: vm.searchConf.start_time,
            end_time: vm.searchConf.end_time
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
    },
    doCancel(data) {
      if (!data) {
        this.cancel();
        this.formItem.id = 0;
        this.$refs["myForm"].resetFields();
        this.modalSetting.loading = false;
        this.modalSetting.index = 0;
      }
    },
    // 图片上传
    handleView(file) {
      this.visible = true;
    },
    handleRemove(file) {
      // const fileList = this.$refs.upload.fileList;
      // this.$refs.upload.fileList.splice(fileList.indexOf(file), 1);
      this.formItem.img = "";
    },
    handleSuccess(res, file) {
      //file.url = config.front_url + 'uploads/img/' + res.data.fileName;//直接拼后缀
      file.url = res.data.filePath; //获取图片路径
      this.formItem.img = res.data.filePath;
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
        this.$Message.error("只能上传一张照片");
      }
      return check;
    }
  },
  mounted() {
    //照片
    //this.UploadAction = config.front_url+'api/upload';
    this.UploadAction = config.front_url + "file/qn_upload";
    // this.uploadList = this.$refs.upload.fileList;
  }
};
</script>

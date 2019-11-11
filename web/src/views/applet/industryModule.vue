<template>
  <div>
    <Row>
      <Col span="24">
        <Card style="margin-bottom: 10px">
          <Form ref="myForm" :model="tableShow" inline>
            <FormItem style="margin-bottom: 0">
              <Input v-model="tableShow.model_name" placeholder="请输入模板名称" />
            </FormItem>
            <FormItem style="margin-bottom: 0">
              <Button type="primary" @click="search">立即搜索</Button>
            </FormItem>
          </Form>
        </Card>
      </Col>
    </Row>
    <Row>
      <Col span="24">
        <Card>
          <p slot="title" style="height: 32px">
            <Button type="primary" @click="alertAdd" icon="md-add">添加行业模块</Button>
          </p>
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

    <Modal v-model="modalSetting.show" width="998" :styles="{top: '30px'}">
      <Form ref="forms" :model="formValidate" :rules="ruleValidate" :label-width="100">
        <FormItem label="模板分类" prop="model_type">
          <RadioGroup v-model="formValidate.model_type">
            <Radio label="1">DIY样式</Radio>
            <Radio label="2">固定样式</Radio>
          </RadioGroup>
        </FormItem>
        <FormItem label="行业模板名称" prop="model_name">
          <Input v-model="formValidate.model_name" placeholder="请输入商品名称" style="width:400px;" />
        </FormItem>
        <FormItem label="商品主图" prop="img">
          <div class="demo-upload-list" v-for="(item, index) in uploadList" :key="index">
            <template v-if="item.status === 'finished'">
              <img :src="item.url" />
              <div class="demo-upload-list-cover">
                <Icon type="ios-trash-outline" @click.native="handleRemove(item)"></Icon>
              </div>
            </template>
            <template v-else>
              <Progress v-if="item.showProgress" :percent="item.percentage" hide-info></Progress>
            </template>
          </div>
          <Upload
            ref="upload"
            :show-upload-list="false"
            :default-file-list="iconList"
            :on-success="handleSuccess"
            :format="['jpg','jpeg','png']"
            :max-size="10240"
            :on-format-error="handleFormatError"
            :on-exceeded-size="handleMaxSize"
            :before-upload="handleBeforeUpload"
            type="drag"
            name="image"
            :action="UploadAction"
            style="display: inline-block;width:58px;"
          >
            <div style="width: 58px;height:58px;line-height: 58px;">
              <Icon type="ios-camera" size="20"></Icon>
            </div>
          </Upload>
        </FormItem>
        <FormItem label="模板简介" prop="model_des">
          <Input
            v-model="formValidate.model_des"
            type="textarea"
            :autosize="{minRows: 4,maxRows: 8}"
            style="width:500px;"
          />
        </FormItem>
        <FormItem label="排序">
          <InputNumber :min="1" v-model="formValidate.model_rank" style="width: 400px;"></InputNumber>
        </FormItem>
        <FormItem label="状态" prop="model_status">
          <RadioGroup v-model="formValidate.model_status">
            <Radio label="1">展示</Radio>
            <Radio label="2">不展示</Radio>
          </RadioGroup>
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
          vm.formValidate = currentRow;
          vm.modalSetting.show = true;
          //图片
          if (currentRow.model_image != "") {
            vm.iconList = [{ name: "", url: currentRow.model_image }];
          }
          vm.$nextTick(() => {
            vm.uploadList = vm.$refs.upload.fileList;
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
            .post("AppletManage/del", {
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
      tableData: [],
      uploadList: [],
      iconList: [],
      typeList: [],
      UploadAction: "",
      tableShow: {
        currentPage: 1,
        size: 10,
        listCount: 0,
        model_name: ""
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
          title: "模板分类",
          align: "center",
          key: "model_type",
          render: (h, param) => {
            let types;
            param.row.model_type == "1"
              ? (types = "diy")
              : (types = "固定样式");
            return h("div", [types]);
          }
        },
        {
          title: "行业模板名称",
          align: "center",
          key: "model_name"
        },
        {
          title: "模板展示图",
          align: "center",
          key: "model_images",
          width: 150,
          render: (h, param) => {
            let model_image = param.row.model_image.split(",")[0];
            return h("img", {
              attrs: {
                src: model_image
              },
              style: {
                width: "100px",
                height: "150px",
                padding: "5px 0 0 0"
              }
            });
          }
        },
        {
          title: "模板简介",
          align: "center",
          key: "model_des"
        },
        {
          title: "状态",
          align: "center",
          key: "status",
          width: 100
        },
        {
          title: "排序",
          align: "center",
          key: "model_rank",
          width: 100
        },
        {
          title: "操作",
          align: "center",
          key: "handle",
          width: 300,
          handle: ["edit", "delete"]
        }
      ],
      formValidate: {
        id: 0,
        model_name: "",
        model_image: "",
        model_type: "1",
        model_des: "",
        model_status: "1",
        model_rank: 1
      },
      ruleValidate: {
        model_name: [
          {
            required: true,
            message: "模板名称不能为空",
            trigger: "blur"
          }
        ],
        model_des: [
          {
            required: true,
            message: "简介不能为空",
            trigger: "blur"
          }
        ]
      }
    };
  },
  created() {
    this.init();
    this.getMade(this.tableShow);
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
        if (item.key === "status") {
          item.render = (h, param) => {
            let currentRowData = vm.tableData[param.index];
            return h(
              "i-switch",
              {
                attrs: {
                  size: "large"
                },
                props: {
                  "true-value": "1",
                  "false-value": "0",
                  value: currentRowData.model_status
                },
                on: {
                  "on-change": function(status) {
                    axios
                      .post("AppletManage/change_model_status", {
                        model_status: status,
                        id: currentRowData.id
                      })
                      .then(function(response) {
                        let res = response.data;
                        if (res.code === 1) {
                          vm.$Message.success(res.msg);
                        } else {
                          vm.$Message.error(res.msg);
                        }
                      });
                  }
                }
              },
              [
                h(
                  "span",
                  {
                    slot: "open"
                  },
                  "启用"
                ),
                h(
                  "span",
                  {
                    slot: "close"
                  },
                  "禁用"
                )
              ]
            );
          };
        }
      });
    },
    cancel() {
      this.formValidate = {
        id: 0,
        model_name: "",
        model_image: "",
        model_type: "1",
        model_des: "",
        model_status: "1",
        model_rank: 1
      };
      this.visible = false;
      for (var i = 0; i < this.uploadList.length; i++) {
        this.handleRemove(this.uploadList[i]);
      }
      this.iconList = [];
      this.modalSetting.show = false;
    },
    submit() {
      let self = this;
      this.$refs["forms"].validate(valid => {
        if (valid) {
          self.modalSetting.loading = true;
          let target = "";
          if (self.formValidate.id == 0) {
            target = "AppletManage/add";
          } else {
            target = "AppletManage/edit";
          }
          axios.post(target, self.formValidate).then(function(response) {
            self.modalSetting.loading = false;
            if (response.data.code === 1) {
              self.$Message.success(response.data.msg);
              self.cancel();
              self.getMade(self.tableShow);
            } else {
              self.$Message.error(response.data.msg);
            }
          });
        }
      });
    },
    getMade(data) {
      let vm = this;
      axios.post("AppletManage/index", data).then(function(response) {
        let res = response.data;
        if (res.code === 1) {
          vm.tableData = res.data.data.data;
          vm.tableShow.listCount = res.data.listCount;
        }
      });
    },
    changePage(page) {
      this.tableShow.page = page;
      this.getMade(this.tableShow);
    },
    changeSize(size) {
      this.tableShow.size = size;
      this.getMade(this.tableShow);
    },
    search() {
      this.tableShow.page = 1;
      this.getMade(this.tableShow);
    },
    alertAdd() {
      //图片
      this.$nextTick(() => {
        this.uploadList = this.$refs.upload.fileList;
      });
      this.modalSetting.show = true;
    },
    // 图片上传
    handleView(file) {
      this.visible = true;
    },
    handleRemove(file) {
      const fileList = this.$refs.upload.fileList;
      // console.log(this.$refs.upload.fileList.splice(fileList.indexOf(file)));
      this.$refs.upload.fileList.splice(fileList.indexOf(file), 1);
      this.formValidate.model_image = "";
    },
    handleSuccess(res, file) {
      // file.url = res.data;
      // this.formItem.img = res.data.substr( res.data.indexOf( 'upload' ) );
      file.url = res.data.filePath; //获取图片路径
      this.formValidate.model_image = res.data.filePath;
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
  },
  mounted() {
    let vm = this;
    this.UploadAction = config.front_url + "file/qn_upload";
    this.uploadList = this.$refs.upload.fileList;
  }
};
</script>

<style lang="less" scoped>
@import "./applet.less";
</style>
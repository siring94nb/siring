<template>
  <div>
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
        <FormItem label="模板分类" prop="model_meal_category">
          <RadioGroup v-model="formValidate.model_meal_category">
            <Radio label="1">DIY样式</Radio>
            <Radio label="2">固定样式</Radio>
          </RadioGroup>
        </FormItem>
        <FormItem label="套餐版本" prop="mode_grade">
            <Select v-model="formValidate.mode_grade" style="width: 400px;">
                <Option value="1">普通套餐</Option>
                <Option value="2">精装套餐</Option>
                <Option value="3">豪华套餐</Option>
            </Select>
        </FormItem>
        <FormItem label="套餐价格" prop="model_meal_price">
          <span style="color: rgb(197,200,206);">年套餐价</span>  <Input v-model="formValidate.model_meal_price" style="width:200px;" />  元
        </FormItem>
        <FormItem label="套餐排序">
          <InputNumber :min="1" v-model="formValidate.model_rank" style="width: 400px;"></InputNumber>
          <div style="color: rgb(197,200,206);">*填写正整数，从大到小排序</div>
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
            .post("AppletManage/model_meal_del", {
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
      },
      modalSetting: {
        show: false,
        loading: false,
        index: 0
      },
      columnsList: [
        
        {
          title: "模板分类",
          align: "center",
          key: "model_meal_category",
          render: (h, param) => {
              let types;
              param.row.model_meal_category == "1" ? types = "diy" : types="固定样式";
              return h("div", [types])
          }
        },
        {
          title: "等级名称",
          align: "center",
          key: "mode_grade"
        },
        {
          title: "等级价格（年费）",
          align: "center",
          key: "model_meal_price"
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
        mode_grade: "",
        model_meal_category: "1",
        model_meal_price: "",
        model_rank: 1,
      },
      ruleValidate: {
        mode_grade: [
          {
            required: true,
            message: "套餐版本不能为空",
            trigger: "blur"
          }
        ],
        model_meal_category: [
          {
            required: true,
            message: "模板分类不能为空",
            trigger: "blur"
          }
        ],
        model_meal_price: [
          {
            required: true,
            message: "套餐价格不能为空",
            trigger: "blur"
          }
        ],
      }
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
        mode_grade: "",
        model_meal_category: "1",
        model_meal_price: "",
        model_rank: 1,
      };
      this.modalSetting.show = false;
    },
    submit() {
      let self = this;
      this.$refs["forms"].validate(valid => {
        if (valid) {
          self.modalSetting.loading = true;
          let target = "";
          if (self.formValidate.id == 0) {
            target = "AppletManage/model_meal_add";
          } else {
            target = "AppletManage/model_meal_edit";
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
    //列表
    getMade(data) {
      let vm = this;
      axios
        .get("AppletManage/model_meal", {
          params: {
            page: vm.tableShow.currentPage,
            size: vm.tableShow.size,
            listCount: vm.tableShow.listCount,
          }
        })
        .then(function(response) {
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
      this.getMade(this.tableShow);
    },
    changeSize(size) {
      this.tableShow.size = size;
      this.getMade(this.tableShow);
    },
    alertAdd() {
      this.modalSetting.show = true;
    },
   
  }
};
</script>

<style lang="less" scoped>
@import "./applet.less";
</style>
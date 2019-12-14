<style lang="less" scoped>
</style>
<style>
.w-e-menu {
  z-index: 2 !important;
}
.w-e-text-container {
  z-index: 1 !important;
}
.add {
  border: 1px solid rgb(14, 144, 210);
  width: 77%;
  color: rgb(14, 144, 210);
  text-align: center;
  cursor: pointer;
}
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
      width="1000"
      :styles="{top: '30px'}"
      @on-visible-change="doCancel"
    >
      <p slot="header" style="color:#2d8cf0;">
        <Icon type="md-information-circle"></Icon>
        <span>{{formItem.id ? '编辑' : '新增'}}</span>
      </p>

      <Form
        ref="myForm"
        :rules="ruleValidate"
        :model="formItem"
        :label-width="120"
        style="z-index:9999;"
      >
        <FormItem label="项目名称" prop="name">
          <Input style="width: 500px" v-model="formItem.name" placeholder="请输入项目名称" />
        </FormItem>
        <FormItem
          :label="index > 0 ?'': '分包技能和酬金'"
          v-for=" (item, index) in formItem.skills"
          :key="index"
        >
          <Row>
            <Col span="6">
              <Select
                v-model="item.major"
                clearable
                placeholder
                style="width:200px;"
                @on-change="selChange($event,index)"
              >
                <Option
                  v-for="(item, index) in skillsList"
                  :value="item.id"
                  :key="index"
                >{{ item.title }}</Option>
              </Select>
            </Col>
            <Col span="6">
              <Select v-model="item.language" clearable placeholder style="width:200px">
                <Option
                  v-for="(item, index) in resList[selIndex]"
                  :value="item"
                  :key="index"
                >{{ item }}</Option>
              </Select>
            </Col>
            <Col span="6">
              <Input style="width: 200px" v-model="item.money" placeholder />
            </Col>
            <Col span="1">
              <span>元</span>
            </Col>
            <Col span="5" v-if="index != 0">
              <Button type="error" @click="delSkills(index)" icon="md-close" ghost></Button>
            </Col>
          </Row>
        </FormItem>
        <FormItem label>
          <div class="add" @click="addSkills">继续添加</div>
        </FormItem>
        <!--<FormItem label="发行数量" prop="num" >-->
        <!--<InputNumber  :min="1" v-model="formItem.num"></InputNumber>-->
        <!--</FormItem>-->
        <FormItem label="项目需求" prop="con">
          <div id="wangeditor" v-model="formItem.con"></div>
        </FormItem>
        <FormItem label="分包发布" prop="type">
          <RadioGroup v-model="formItem.type">
            <Radio :label="0">立即发布</Radio>
            <Radio :label="1">暂不发布</Radio>
            <Radio :label="2">自开发</Radio>
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
          //vm.formItem.num = currentRow.num;
          vm.formItem.type = currentRow.type;
          vm.formItem.con = currentRow.con;
          vm.editor.txt.html(vm.formItem.con);
          vm.html = vm.formItem.con;
          vm.modalSetting.show = true;
          vm.modalSetting.index = index;
          // let a = JSON.parse(JSON.stringify(currentRow.skills));
          delete vm.formItem.skills;
          vm.formItem.skills = JSON.parse(JSON.stringify(currentRow.skills));
          vm.formItem.skills = vm.formItem.skills.map((item, index, input) => {
            item.major = Number(item.major);
            vm.skillsList.map((items, indexs, inputs) => {
              if (item.major == items.id) {
                vm.selIndex = indexs;
              }
            });
            return item;
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
            .post("Subcontract/del", {
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
      uploadList: [],
      uploadListSlt: [],
      UploadAction: "",
      columnsList: [
        {
          title: "序号",
          type: "index",
          width: 65,
          align: "center",
          key: "id"
        },
        {
          title: "项目名称",
          align: "center",
          key: "name"
        },
        {
          title: "分包语言/酬金",
          align: "center",
          key: "dev_name"
        },
        // {
        //   title: "项目功能描述",
        //   align: "center",
        //   key: "con"
        // },
        {
          title: "发布状态",
          align: "center",
          key: "status",
          render: (h, param) => {
            if (param.row.status == 1) {
              return h("div", ["正常"]);
            } else {
              return h("div", ["失效"]);
            }
          }
        },
        {
          title: "发布时间",
          align: "center",
          key: "created_at"
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
        index: 0
      },
      formItem: {
        id: 0,
        skills: [
          {
            major: 0,
            language: 0,
            money: ""
          }
        ],
        con: "",
        type: 0
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
      },
      skillsList: [],
      resList: [],
      selIndex: 0
    };
  },
  created() {
    this.init();
    this.getList();
    this.getSkills();
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
    submit() {
      let self = this;
      //   this.$refs["myForm"].validate(valid => {
      // if (valid) {
      self.modalSetting.loading = true;
      let target = "";
      if (this.formItem.id === 0) {
        target = "Subcontract/add";
      } else {
        target = "Subcontract/upd";
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
      // }
      //   });
    },
    cancel() {
      this.modalSetting.show = false;
      this.formItem.id = 0;
      this.formItem.name = "";
      this.formItem.skills = [
        {
          major: this.formItem.skills[0].major,
          language: this.formItem.skills[0].language,
          money: ""
        }
      ];
      this.formItem.con = "";
      this.formItem.type = 0;
      this.editor.txt.html(this.formItem.con);
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
        .get("Subcontract/index", {
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
    },
    getSkills() {
      let vm = this;
      axios.get("Subcontract/classify").then(function(response) {
        if (response.data.code === 1) {
          vm.skillsList = response.data.data.list;
          vm.formItem.skills[0].major = response.data.data.list[0].id;
          vm.formItem.skills[0].language = response.data.data.list[0].res[0][0];
          for (let i = 0; i < vm.skillsList.length; i++) {
            vm.resList.push(vm.skillsList[i].res);
          }
        }
      });
    },
    //添加分包技能和酬金
    addSkills() {
      this.formItem.skills.push({
        major: this.formItem.skills[0].major,
        language: this.formItem.skills[0].language,
        money: ""
      });
      this.$forceUpdate();
    },
    //删除分包技能和酬金
    delSkills(index) {
      let vm = this;
      vm.formItem.skills.splice(vm.formItem.skills.indexOf(index), 1);
      this.$forceUpdate();
    },
    selChange(event, index) {
      for (let i = 0; i < this.skillsList.length; i++) {
        if (this.skillsList[i].id == event) {
          this.selIndex = i;
          this.formItem.skills[index].language = this.resList[i][0];
        }
      }
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

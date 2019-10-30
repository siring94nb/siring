<style lang="less" scoped>
@import "./goods.less";
</style>
<template>
  <div>
    <Row>
      <Col span="24">
        <Card style="margin-bottom: 10px">
          <Form ref="myForm" :model="searchConf" inline>
            <FormItem style="margin-bottom: 0">
              <Input v-model="searchConf.title" placeholder="请输入商品名称" />
            </FormItem>
            <FormItem style="margin-bottom: 0">
              <span>商品分类</span>

              <Select v-model="searchConf.category_id" style="width: 200px;">
                <Option :value="-1">全部</Option>
                <Option
                  v-for="(item, index) in sortList"
                  :value="item.id"
                  :key="index"
                >{{ item.category_name }}</Option>
              </Select>
            </FormItem>
            <FormItem style="margin-bottom: 0">
              <span>商品状态</span>
              <Select v-model="searchConf.status" style="width: 200px;">
                <Option :value="1">推荐</Option>
                <Option :value="2">不推荐</Option>
              </Select>
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
            <Button type="primary" @click="alertAdd" icon="md-add">添加商品</Button>
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
    <Modal v-model="modalSetting.show" width="998" :styles="{top: '30px'}">
      <Tabs value="name1">
        <TabPane label="添加评论" name="name1">
          <Form ref="myComment" :model="myComment" :label-width="100">
            <FormItem label="马甲会员账号">
              <Select v-model="myComment.data.user_id" style="width: 400px;">
                <Option
                  v-for="(item, index) in horseList"
                  :value="item.id"
                  :key="index"
                >{{ item.realname }}</Option>
              </Select>
            </FormItem>

            <FormItem label="会员评论">
              <Input
                v-model="myComment.data.con"
                type="textarea"
                :autosize="{minRows: 4,maxRows: 8}"
                style="width:500px;"
              />
            </FormItem>
            <FormItem label>
              <DatePicker
                type="datetime"
                v-model="myComment.data.create_at"
                placeholder="请选择时间"
                style="width: 200px"
                @on-change="dataCreate"
              ></DatePicker>
            </FormItem>
            <FormItem label="官方回复">
              <Input
                v-model="myComment.special.con"
                type="textarea"
                :autosize="{minRows: 4,maxRows: 8}"
                style="width:500px;"
              />
              <p style="color: rgb(197,200,206);">*非必填项</p>
            </FormItem>
            <FormItem label>
              <DatePicker
                type="datetime"
                v-model="myComment.special.create_at"
                placeholder="请选择时间"
                style="width: 200px"
                @on-change="specialCreate"
              ></DatePicker>
            </FormItem>
            <FormItem>
              <Button type="text" @click="cancel" style="margin-right: 8px">取消</Button>
              <Button type="primary" @click="submitComment" :loading="modalSetting.loading">确定</Button>
            </FormItem>
          </Form>
        </TabPane>
        <TabPane label="历史评论" name="name2">
          <Row
            type="flex"
            justify="center"
            align="middle"
            class="row-box"
            v-for="(item, index) in commentsList"
            :key="index"
          >
            <Col span="4" style="text-align:center;">
              <Poptip
                confirm
                title="确定删除吗？"
                @on-ok="commentDel(item.id)"
                @on-cancel="cancel"
              >
                <Button type="error">删除</Button>
              </Poptip>
            </Col>
            <Col span="4" style="text-align:center;line-height:30px;">
              <Avatar :src="item.img" size="large" />
              <div>{{geTel(item.phone)}}</div>
              <div>
                <img style="width:20px;height:20px;display:inline-block;" :src="item.icn" />皇冠会员
              </div>
            </Col>
            <Col span="16">
              <div class="comments">
                {{item.ico}}
                <div style>{{item.create_at}}</div>
              </div>
              <div class="comments comments-gf" v-if="item.relpay != ''">
                <span style="color:rgb(255,153,204);">【官方回复】</span>
                {{item.relpay[0].con}}
                <div>{{item.relpay[0].create_at}}</div>
              </div>
            </Col>
          </Row>
        </TabPane>
      </Tabs>
      <div slot="footer">
        <Button type="warning" @click="cancel" style="margin-right: 8px">取消</Button>
      </div>
    </Modal>
  </div>
</template>
<script>
import axios from "axios";
import config from "../../../build/config";
import wangEditor from "wangeditor";

const addCommentButton = (vm, h, currentRow, index) => {
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
          vm.commentList(currentRow.id);
          vm.getHorse();
          vm.myComment.data.goods_id = currentRow.id;
          vm.myComment.special.goods_id = currentRow.id;
          vm.modalSetting.show = true;
        }
      }
    },
    "添加评论"
  );
};
const copyButton = (vm, h, currentRow, index) => {
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
        click: () => {}
      }
    },
    "复制"
  );
};
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
              console.log(response);
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
      theme1: "light",
      UploadHeader: "",
      DefaultList: [],
      // 图片
      UploadAction: "",
      visible: false,
      uploadList: [],
      iconList: [],
      sortList: [],
      horseList: [],
      commentsList: [],
      sd: true,
      // 图片
      columnsList: [
        {
          title: "序号",
          type: "index",
          width: 65,
          align: "center",
          key: "id"
        },
        {
          title: "商品名称",
          align: "center",
          key: "goods_name"
        },
        {
          title: "缩略图",
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
          title: "商品编号",
          align: "center",
          key: "goods_number"
        },
        {
          title: "商品分类",
          align: "center",
          key: "category_id"
        },
        {
          title: "终端版本",
          align: "center",
          key: "attr_title"
        },
        {
          title: "开发周期",
          align: "center",
          key: "cycle_time"
        },
        {
          title: "价格",
          align: "center",
          key: "price"
        },
        {
          title: "排序",
          align: "center",
          key: "goods_sort"
        },
        {
          title: "状态",
          align: "center",
          key: "status",
          width: 100
        },
        {
          title: "操作",
          align: "center",
          key: "handle",
          width: 400,
          handle: ["comments", "copy", "edit", "delete"]
        }
      ],
      myComment: {
        data: {
          goods_id: "",
          user_id: "",
          con: "",
          create_at: "",
          cid: 0,
          type: 1
        },
        special: {
          user_id: 0,
          con: "",
          create_at: "",
          goods_id: "",
          type: 1
        }
      },
      tableData: [],
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
      modalSetting: {
        show: false,
        loading: false,
        index: 0
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
              addCommentButton(vm, h, currentRowData, param.index),
              copyButton(vm, h, currentRowData, param.index),
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
                  value: currentRowData.goods_recommend_status
                },
                on: {
                  "on-change": function(status) {
                    axios
                      .get("User/changeStatus", {
                        params: {
                          status: status,
                          id: currentRowData.id
                        }
                      })
                      .then(function(response) {
                        let res = response.data;
                        if (res.code === 1) {
                          vm.$Message.success(res.msg);
                        } else {
                          if (res.code === -14) {
                            vm.$store.commit("logout", vm);
                            vm.$router.push({
                              name: "login"
                            });
                          } else {
                            vm.$Message.error(res.msg);
                            vm.getList();
                          }
                        }
                        vm.cancel();
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
      // 移除图片
      this.visible = false;
      for (var i = 0; i < this.uploadList.length; i++) {
        this.handleRemove(this.uploadList[i]);
      }
      this.iconList = [];
      (this.myComment = {
        data: {
          goods_id: "",
          user_id: "",
          con: "",
          create_at: "",
          cid: 0,
          type: 1
        },
        special: {
          user_id: 0,
          con: "",
          create_at: "",
          goods_id: "",
          type: 1
        }
      }),
        (this.modalSetting.show = false);
    },
    onMenuSelect(name) {
      // console.log(name);
    },
    //分类
    getSort() {
      let vm = this;
      axios.post("Goods/category_index", {}).then(function(response) {
        let res = response.data;
        if (res.code === 1) {
          vm.sortList = res.data.list;
        }
      });
    },
    //马甲会员列表
    getHorse() {
      let vm = this;
      axios.post("Goods/get_horse_member", {}).then(function(response) {
        let res = response.data;
        console.log(res.data);
        if (res.code === 1) {
          vm.horseList = res.data[0];
        }
      });
    },
    handleAdd() {
      // this.index++;
      this.formItem.special.push({
        attr_title: "",
        price: "",
        bottom_price: "",
        cycle_time: ""
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
    //添加评论
    submitComment(name) {
      let self = this;
      self.modalSetting.loading = true;
      axios.post("Goods/add_comment", self.myComment).then(function(response) {
        self.modalSetting.loading = false;
        console.log(response);
        if (response.data.code === 1) {
          self.$Message.success(response.data.msg);
          setTimeout(function() {
            self.cancel();
          }, 1000);
        } else {
          self.$Message.error(response.data.msg);
        }
      });
    },
    //评论历史
    commentList(id) {
      let self = this;
      axios.post("Goods/comment_list", { id: id }).then(function(response) {
        let res = response.data;
        console.log(res.data);
        if (res.code === 1) {
          self.commentsList = res.data.data;
        } else {
          self.commentsList = [];
        }
      });
    },
    //删除评论
    commentDel(id) {
      let self = this;
      axios.post("Goods/comment_del", { id: id }).then(function(response) {
        let res = response.data;
        if (res.code === 1) {
          self.$Message.success(response.data.msg);
        } else {
          self.$Message.error(response.data.msg);
        }
      });
    },
    geTel(tel) {
      var reg = /^(\d{3})\d{4}(\d{4})$/;
      return tel.replace(reg, "$1****$2");
    },
    dataCreate(time) {
      this.myComment.data.create_at = time;
    },
    specialCreate(time) {
      this.myComment.special.create_at = time;
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
            vm.tableShow.listCount = res.data.count;
          } else {
          }
        });
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
  },
  mounted() {
    // this.UploadAction = config.front_url + "file/qn_upload";
    // this.uploadList = this.$refs.upload.fileList;
  }
};
</script>

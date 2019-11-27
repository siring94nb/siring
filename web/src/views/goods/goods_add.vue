<style lang="less" scoped>
@import "./goods.less";
</style>
<template>
  <div style="background-color:#fff;padding-top:30px;font-size:30px">
    <!-- <Button type="primary" @click="alertAdd" icon="md-add">添加商品</Button> -->

    <Modal v-model="modalSetting.show" width="598" :styles="{top: '30px'}">
      <p slot="header">
        <Icon type="md-add"></Icon>
        <span>添加分类</span>
      </p>
      <p style="font-size:18px;margin-left:15px;">分类编辑</p>
      <div
        v-for="(item, index) in tableData"
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

    <Form ref="myForm" :model="formItem" :label-width="120">
      <FormItem label="商品名称" prop="goods_name">
        <Input v-model="formItem.data.goods_name" placeholder="请输入" style="width: 500px;"></Input>
      </FormItem>
      <FormItem label="商品编号" prop="goods_number">
        <Input v-model="formItem.data.goods_number" placeholder="请输入" style="width: 500px;" />
        <p>*模板化产品，规则按照MB+4位数字设定</p>
      </FormItem>
      <FormItem label="归属分类">
        <Select v-model="formItem.data.category_id" style="width: 400px;">
          <Option
            v-for="(item, index) in tableData"
            :value="item.id"
            :key="index"
          >{{ item.category_name }}</Option>
        </Select>
        <Button type="text" @click="addSort" ghost icon="md-add" style="color:rgb(51,204,255);">添加分类</Button>
        <p>*可添加、修改分类，也可删除分类，分类名称按照顺序显示在前端页面</p>
      </FormItem>
      <FormItem label="商品排序">
        <InputNumber :min="1" v-model="formItem.data.goods_sort" style="width: 500px;"></InputNumber>
      </FormItem>
      <FormItem label="标记">
        <RadioGroup v-model="formItem.data.sign">
          <Radio label="1">促销</Radio>
          <Radio label="2">hot</Radio>
        </RadioGroup>
        <p>*填写正整数，从大到小排序</p>
      </FormItem>
      <FormItem label="SEO设置关键字" prop="seo">
        <Input v-model="formItem.data.seo" placeholder="请输入" style="width: 500px;" />
        <p>*关键字中间用半角逗号,隔开</p>
      </FormItem>
      <FormItem label="终端版本">
        <template>
          <Table border :columns="columns1" :data="formItem.special" width="1000"></Table>
        </template>
        <Button type="primary" @click="handleAdd" icon="md-add" style="margin-top:10px;">添加规格项</Button>
      </FormItem>

      <FormItem
        v-for="(item, index) in formItem.special"
        :key="index"
        :label="'规格-' + index"
        :prop="'item'+ index"
      >
        <div style="display:flex;">
          <Input v-model="item.attr_title" placeholder="请输入" style="width: 150px;">
            <span slot="prepend">终端版本</span>
          </Input>
          <Input v-model="item.price" placeholder="请输入" style="width: 150px;">
            <span slot="prepend">价格（元）</span>
          </Input>
          <Input v-model="item.bottom_price" placeholder="请输入" style="width: 150px;">
            <span slot="prepend">划线价</span>
          </Input>
          <Input v-model="item.cycle_time" placeholder="请输入" style="width: 150px;">
            <span slot="prepend">开发周期</span>
          </Input>
          <Button @click="tableRemove(index,item.id)" type="error" style="margin-left:10px;">删除</Button>
        </div>
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
          multiple
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
        <p>*建议图片尺寸 260*170，主图链接到演示</p>
      </FormItem>
      <FormItem label="演示">
        <div id="wangeditor" v-model="formItem.data.goods_detail" style="width:1000px;"></div>
      </FormItem>
      <FormItem label="功能描述">
        <div id="wangeditor1" v-model="formItem.data.goods_des" style="width:1000px;"></div>
      </FormItem>
 
      <FormItem label="推荐商品">
        <RadioGroup v-model="formItem.data.goods_recommend_status">
          <Radio label="1">推荐</Radio>
          <Radio label="0">不推荐</Radio>
        </RadioGroup>
      </FormItem>
    </Form>
    <div slot="footer" style="margin-left:100px;padding:30px;">
      <Button>取消</Button>
      <Button type="primary" @click="submit" :loading="modalSetting.loading">确定</Button>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import config from "../../../build/config";
import wangEditor from "wangeditor";

export default {
  data() {
    return {
      UploadHeader: "",
      // DefaultList: [],
      // 图片
      UploadAction: "",
      visible: false,
      uploadList: [],
      iconList: [],
      // 图片

      columns1: [
        {
          title: "终端版本",
          key: "attr_title"
        },
        {
          title: "价格（元）",
          key: "price"
        },
        {
          title: "划线价",
          key: "bottom_price"
        },
        {
          title: "开发周期",
          key: "cycle_time"
        }
      ],
      tableData: [],
      modalSetting: {
        show: false,
        loading: false,
        index: 0
      },
      sortMain: {
        category_name: ""
      },
      goods_id: 0,
      formItem: {
        data: {
          id: 0,
          goods_images: "",
          goods_number: "",
          category_id: "",
          goods_name: "",
          goods_sort: 0,
          seo: "",
          goods_recommend_status: "1",
          goods_detail: "",
          goods_des: "",
          sign: ""
        },
        special: []
      },
      ruleValidate: {
        category_name: [
          { required: true, message: "分类名称不能为空", trigger: "blur" }
        ]

        // goods_name: [{ required: true, message: "商品名称不能为空", trigger: "blur" }],
        // goods_number: [{ required: true, message: "商品编号不能为空", trigger: "blur" }],
        // seo: [{ required: true, message: "SEO关键字不能为空", trigger: "blur" }],
        // img: [{ required: true, message: "商品图片不能为空", trigger: "blur" }],
      },
      html: "",
      html1: ''
    };
  },
  created() {
    this.init();
    this.getList();
    this.getSort();
  },
  methods: {
    init() {
      // let vm = this;
      this.goods_id = this.$route.params.goods_id;
    },
    cancel() {
      this.formItem = {
        data: {
          id: 0,
          goods_images: "",
          goods_number: "",
          goods_name: "",
          category_id: "",
          goods_sort: 0,
          seo: "",
          goods_recommend_status: "1",
          goods_detail: "",
          goods_des: "",
          sign: ""
        },
        special: []
      };

      // this.special = {terminal_version:"",pic:"",develop_cycle:"",h_pic:""}
      // 移除图片
      this.visible = false;
      for (var i = 0; i < this.uploadList.length; i++) {
        this.handleRemove(this.uploadList[i]);
      }
      this.iconList = [];

      // this.modalSetting.show = false;
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
    tableRemove(index, id) {
      let self = this;
      this.formItem.special.splice(index, 1);
      if (this.formItem.data.id != 0) {
        axios
          .post("Goods/goods_special_del", { id: id })
          .then(function(response) {
            // console.log(response);
            if (response.data.code === 1) {
              self.$Message.success(response.data.msg);
            } else {
              self.$Message.error(response.data.msg);
            }
          });
      }
    },

    submit() {
      let self = this;
      this.$refs["myForm"].validate(valid => {
        if (valid) {
          self.modalSetting.loading = true;
          let target = "";
          if (this.formItem.data.id == 0) {
            target = "Goods/add";
          } else {
            target = "Goods/edit";
          }
          axios.post(target, this.formItem).then(function(response) {
            self.modalSetting.loading = false;
            // console.log(response);
            if (response.data.code === 1) {
              self.$Message.success(response.data.msg);
              self.cancel();
              self.$router.push({
                name: "develop_goods"
              });
            } else {
              self.$Message.error(response.data.msg);
            }
          });
        }
      });
    },

    getList() {
      let vm = this;

      if (vm.goods_id != 0) {
        axios
          .post("Goods/get_goods", {
            id: vm.goods_id
          })
          .then(function(response) {
            let res = response.data;

            if (res.code === 1) {
              vm.editor.txt.html(res.data.data.goods_detail);
              vm.html = res.data.data.goods_detail;

              vm.editor1.txt.html(res.data.data.goods_des);
              vm.html1 = res.data.data.goods_des;

              //图片
              if (res.data.data.goods_images != "") {
                var str = res.data.data.goods_images.split(",");
                for (let i = 0; i < str.length; i++) {
                  if (str[i] != "") {
                    vm.iconList.push({ name: "", url: str[i] });
                  }
                }
                // vm.iconList = [{ name: "", url: res.data.data.goods_images }];
              }
              vm.$nextTick(() => {
                vm.uploadList = vm.$refs.upload.fileList;
              });
              vm.formItem = res.data;
            }
          });
      }
    },
    getSort() {
      let vm = this;
      axios.post("Goods/category_index", {}).then(function(response) {
        let res = response.data;
        if (res.code === 1) {
          vm.tableData = res.data.list;
        }
      });
    },
    addSort() {
      this.modalSetting.show = true;
    },
    editSort(index, id) {
      let self = this;
      axios
        .post("Goods/category_edit", {
          id: id,
          category_name: self.tableData[index].category_name
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
      this.modalSetting.show = false;
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
    handleRemove(file) {
      const fileList = this.$refs.upload.fileList;
      // console.log(this.$refs.upload.fileList.splice(fileList.indexOf(file)));
      this.$refs.upload.fileList.splice(fileList.indexOf(file), 1);
      var str = this.formItem.data.goods_images.split(","),arr=[];
      this.formItem.data.goods_images = "";
      for (let i = 0; i < str.length; i++) {
        if(str[i] != file) {
          i < 1 ? this.formItem.data.goods_images = "" : (this.formItem.data.goods_images == ""
        ? (this.formItem.data.goods_images += str[i])
        : (this.formItem.data.goods_images += "," + str[i]))
        }
      }
      // this.formItem.data.goods_images = "";
    },
    handleSuccess(res, file) {
      // file.url = res.data;
      // this.formItem.img = res.data.substr( res.data.indexOf( 'upload' ) );
      file.url = res.data.filePath; //获取图片路径
      this.formItem.data.goods_images == ""
        ? (this.formItem.data.goods_images += res.data.filePath)
        : (this.formItem.data.goods_images += "," + res.data.filePath);
    },
    handleFormatError(file) {
      this.$Message.error("文件格式不正确, 请选择jpg或者png.");
    },
    handleMaxSize(file) {
      this.$Message.error("文件大小不能超过10M");
    },
    handleBeforeUpload() {
      const check = this.uploadList.length < 6;
      if (!check) {
        this.$Message.error("只能上传五张品牌图");
      }
      return check;
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
      vm.formItem.data.goods_detail = html;
    };
    this.editor.create();
    //第二个编辑器
    this.editor1 = new wangEditor("#wangeditor1");
    this.editor1.customConfig.uploadFileName = "image";
    this.editor1.customConfig.uploadImgMaxLength = 1;
    this.editor1.customConfig.uploadImgServer =
      config.front_url + "file/qn_upload";
    this.editor1.customConfig.uploadImgHooks = {
      customInsert: function(insertImg, result, editor1) {
        if (result.code == 1) {
          insertImg(result.data.filePath);
        }
      }
    };
    this.editor1.customConfig.onchange = function(html) {
      vm.formItem.data.goods_des = html;
    };
    this.editor1.create();
    this.UploadAction = config.front_url + "file/qn_upload";
    this.uploadList = this.$refs.upload.fileList;
    
  }
};
</script>

<template>
  <div v-html="apply">{{apply}}</div>
</template>
 
<script>
export default {
  name: "alipay",
  data() {
    return {
      apply: ""
    };
  },
  mounted() {
    this.apply = this.$route.query.pdf;
    console.log(this.apply);
    this.$nextTick(() => {
      document.forms[0].acceptCharset = "UTF-8";
      document.forms[0].submit();
    });
  }
};
</script>
 
<style>
</style>
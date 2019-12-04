<template>
    <div class="box">
        <div>
            <!-- <i class="el-icon-edit"></i>
         <span>控制中心</span>
         <span>&gt;</span>
         <span>控制台</span> -->
         <slot></slot>
        </div>
         
    </div>    
</template>
<script>
export default {
    
}
</script>
<style lang="scss" scoped>
    .box{
        margin-left: 20px;
        background: rgb(255, 255, 255);
        div:nth-of-type(1){
            padding: 10px;
            i{
                padding-right: 10px 15px
            }
        }
    }
</style>
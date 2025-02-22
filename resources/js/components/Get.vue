<script>
export default {
    name: "Get",
    mounted() {
        this.getData()
    },
    methods:{
        getData(){
            axios.get('/api/get')
                .then(response => {
                    console.log(response);
                })
        }
    }
}
</script>

<template>
    <div>
        Get
    </div>
</template>

<style scoped>

</style>

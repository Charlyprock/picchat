<template>
    <router-view/>
</template>


<script>

    export default{
        
        data(){
            return{

            }
            
        },

        created(){

            if (this.$store.state.token) {

                this.axios.defaults.headers.common.Authorization = `Bearer ${this.$store.state.token}`
                this.axios.get(this.$store.state.url + '/get_user')
                .then(({data}) => {

                    this.$store.state.user = data.user

                }).catch(e=>console.log(e))
                
            }

        },

        mounted(){

           

        },

        methods: {

        }
        

        
    }
</script>
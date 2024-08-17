<template>
    <div class="flex justify-center items-center h-screen bg-slate-300">
        <form @submit.prevent="connect" action="" class="bg-white shadow-2xl rounded-lg flex justify-center items-center gap-3 flex-col p-12 w-96 h-96">
            <h1 class="font-bold text-2xl capitalize">Login</h1>
            <div class="input flex relative flex-col gap-1 w-64">
                <label  for="email">email</label>
                <input v-model="form.email" required type="email" name="" id="email" class="w-full focus:border-blue-600 valid:border-blue-600 duration-300 border border-gray-300 px-1 h-10 rounded-md outline-none">
            </div>
            <div class="input flex relative flex-col gap-1 w-64">
                <label for="password">password</label>
                <input v-model="form.password" required type="password" name="" id="password" class="w-full focus:border-blue-600 valid:border-blue-600 duration-300 border border-gray-300 px-1 h-10 rounded-md outline-none">
            </div>
            <button class="bg-blue-500 px-3 py-1 rounded-md capitalize hover:bg-blue-600 duration-300 hover:text-white">envoyer</button>
        
            <div>
                vous n'avez pas encore un compte?
                <router-link :to="{name: 'register'}" class="text-blue-500">Register</router-link>
            </div>
        </form>
    </div>
</template>


<script>

    export default{
        
        data(){
            return{
                
                form:{
                    email:'',
                    password:''
                }
                  
            }
            
        },

        mounted(){
        

        },

        methods: {

            connect(){

                this.axios.post(this.$store.state.url + '/login', this.form)
                .then(response =>{

                    if (response.data.success) {

                        localStorage.setItem('token',response.data.token)
                        this.$store.state.user = response.data.user
                        this.$store.state.token = localStorage.getItem('token')

                        this.$router.push({
                            name: 'chat'
                        })
                    }
 
                }).catch(e=>console.log(e))
            },

        }
        

        
    }
</script>

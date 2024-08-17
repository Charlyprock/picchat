<template>
    <div class="flex justify-center items-center h-screen bg-slate-300">
        <form @submit.prevent="register" class="bg-white shadow-2xl rounded-lg flex justify-center items-center gap-3 flex-col p-12 w-[25%] h-[70%]">
            
            <h1 class="font-bold text-2xl capitalize">Register</h1>

            <div class="input flex relative flex-col gap-1 w-64">
                <label  for="name">Name</label>
                <input v-model="form.name" required type="text" id="name" class="w-full focus:border-blue-600 valid:border-blue-600 duration-300 border border-gray-300 px-1 h-10 rounded-md outline-none">
            </div>

            <div class="input flex relative flex-col gap-1 w-64">
                <label  for="email">email</label>
                <input v-model="form.email" required type="email" name="" id="email" class="w-full focus:border-blue-600 valid:border-blue-600 duration-300 border border-gray-300 px-1 h-10 rounded-md outline-none">
            </div>

            <div class="input flex relative flex-col gap-1 w-64">
                <label for="password">password</label>
                <input v-model="form.password" required type="password" name="" id="password" class="w-full focus:border-blue-600 valid:border-blue-600 duration-300 border border-gray-300 px-1 h-10 rounded-md outline-none">
            </div>

            <div class="input flex relative flex-col gap-1 w-64">
                <label for="password_confirmation">confirmer votre mot de passe</label>
                <input v-model="form.password_confirmation" required type="password" id="password_confirmation" class="w-full focus:border-blue-600 valid:border-blue-600 duration-300 border border-gray-300 px-1 h-10 rounded-md outline-none">
            </div>

            <button class="bg-blue-500 px-3 py-1 rounded-md capitalize hover:bg-blue-600 duration-300 hover:text-white">envoyer</button>
        
            <div>
                vous avez deja un compte?
                <router-link :to="{name: 'login'}" class="text-blue-500">login</router-link>
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
                    password:'',
                    name: "",
                    status: this.$fonct.get_date() + " " + this.$fonct.get_heure(),
                    password_confirmation: "",
                }
                  
            }
            
        },

        mounted(){
     

        },

        methods: {

            register(){
                this.axios.post(this.$store.state.url + '/register',this.form)
                .then(({data})=>{

                    localStorage.setItem('token',data.token)
                    this.$store.state.user = data.user
                    this.$store.state.token = localStorage.getItem('token')
                    this.$router.push('chat')

                }).catch(e=>console.log(e))
            },

        }
        

        
    }
</script>

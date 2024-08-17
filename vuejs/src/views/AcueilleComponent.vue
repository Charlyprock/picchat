<template>
    <div class="flex justify-center items-center h-screen relative">
        <img src="/img/bg1.png"  class="w-full h-full">

        <div class="absolute w-full h-full flex justify-center items-center">
            <router-link :to="{name: 'login'}" class="bg-blue-500 hover:bg-blue-600 p-2 text-white">Se Connecter</router-link>
        </div>
    </div>
</template>


<script>

    export default{
        
        data(){
            return{
                
                  
            }
            
        },

        mounted(){
        

        },

        methods: {


        }
        

        
    }
</script>


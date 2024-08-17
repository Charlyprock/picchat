<template>
    <!-- la sidebar -->
    <section class="resize-component h-screen min-w-[30%] max-w-[60%] bg-white dark:bg-zinc-900 dark:text-white relative">

        <!-- la barre de redimentionnent -->
        <div class="resize-bar absolute right-0 top-0 bottom-0 w-1 bg-gray-300 hover:bg-blue-300 dark:bg-black dark:hover:bg-blue-500 cursor-e-resize"></div>

        <!-- le haut du contact -->
        <section class="h-[18%]">

            <!-- les parametres et le logo -->
            <section class="p-2 flex justify-between">

                <!-- parametres -->
                <div class="hover:bg-green-500 duration-200 rounded-md dark:hover:bg-green-500 hover:text-white p-1 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </div>
                {{ $store.state.user.name }} {{ $store.state.user.id }}
                <!-- logo -->
                <div class="uppercase italic pt-1">
                    picChat
                </div>

            </section>

            <!-- barre de recherche-->
            <div class="flex justify-center m-3">

                <div class="w-full border-2 p-2 relative rounded-md">
                    <input type="text" placeholder="Etrer votre recherche..." class="w-full h-full dark:placeholder:text-gray-300 dark:bg-zinc-900 pl-5 outline-none">
                
                    <div class="absolute top-3 left-1 text-slate-400 dark:text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </div>
                
                </div>
            </div>
        
        </section>

        <!-- les contacts -->
        <section class="h-[80%] pr-1">
            <section class="overflow-y-scroll dark:scrollbar dark:scrollbar-track-zinc-900 dark:scrollbar-thumb-black h-full">

                <div @click="send_id(user.user.id)" v-for="user in users.users" :key="user" :class="user.user.id == actif_user_id ? 'border-blue-500' :'border-gray-300 dark:border-slate-900'" class="bg-white dark:bg-zinc-900 duration-500 p-2 m-3 flex space-x-2 border-b hover:shadow-md dark:hover:shadow-xl cursor-pointer">

                    <!-- photo de profil et nombre de message nom lu --> 
                    <div class="relative w-14">
                        <div class="w-12 h-12 rounded-lg overflow-hidden border">
                            <img :src="$store.state.url_images + user.user.image" class="w-full h-full object-cover">
                        </div>

                        <div v-if="user.nombre > 0" class="w-fit min-h-[20px] min-w-[20px] h-fit p-1 text-xs text-center text-white rounded-full bg-blue-500 absolute -top-2 -left-1">
                            {{ user.nombre }}
                        </div>
                    </div>
                
                    <!-- le -->
                    <div class="w-[80%]">

                        <!-- le nom et la date du en ligne -->
                        <div class="flex justify-between">

                            <!-- le nom -->
                            <div class="text-lg font-medium whitespace-nowrap">
                                {{ user.user.name }}
                            </div>

                            <!-- la date -->
                            <div class="flex text-xs dark:text-gray-300f text-blue-500 pt-2 justify-end pr-1 w-full">
                                en ligne
                            </div>

                        </div>

                        <!-- le dernier message et s'il est en ligne-->
                        <div class="flex justify-between items-center">

                            <div class="text-sm whitespace-nowrap dark:text-gray-300 w-[40%] overflow-hidden text-ellipsis">
                                {{ user.lastMessage.message }}
                            </div>

                            <!-- la date du dernier message et le statut du message -->
                            <div class="flex items-center">
                                <!-- la date -->
                                <div class="text-xs dark:text-gray-300 pr-1">
                                    {{ user.lastMessage.heure.slice(0, 5) }}
                                </div>

                                <!-- statut -->
                                <div class="w-2 h-2 mt-[1.5px] rounded-full bg-blue-400"></div>
                            </div>

                        </div>
                    
                    </div>

                </div>
            </section>
            
        </section>

        <!-- le plus et le nombre de discusion non lus -->
        <div @click="all_user" class=" bg-green-500 text-white flex justify-center items-center p-2 fixed bottom-2 left-2 rounded-md hover:bg-green-600 cursor-pointer">
            
            <!-- le nombre de discusion non lus -->
            <div v-if="users.nombre_discussion > 0" class="bg-blue-500 text-white text-center rounded-full absolute w-6 h-6 -top-2 -left-2">
                {{ users.nombre_discussion}}
            </div>
            
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
            </svg>
        </div>

        <!-- liste des users -->
        <section @click="visibleAllUser = false" v-if="visibleAllUser" class="w-full h-full absolute top-0 right-0 left-0 bottom-0 flex justify-center items-center">

            <div class="w-[80%] h-fit max-h-[80%] border border-blue-500 rounded-md bg-white dark:bg-zinc-900">

                <div @click="send_id(user.id)" v-for="user in allUsers" :key="user" class="bg-white dark:bg-zinc-900 p-2 m-3 flex space-x-2 border-b dark:border-none border-gray-300 hover:shadow-md dark:hover:shadow-xl cursor-pointer">

                    <!-- photo de profil et nombre nom lu --> 
                    <div class="relative">
                        <div class="w-10 h-10 rounded-lg overflow-hidden border">
                            <img :src="$store.state.url_images + user.image" class="w-full h-full object-cover">
                        </div>
                    </div>
                

                    <div class="w-full">

                        <!-- le nom et la date -->
                        <div class="flex justify-between">

                            <!-- le nom -->
                            <div class="text-lg pt-2 font-medium whitespace-nowrap">
                                {{ user.name }}
                            </div>

                        </div>
                    
                    </div>

                </div>

            </div>

        </section>

    </section>
</template>


<script>

    export default{

        props:{
            obseveur_read: null,
        },
        
        data(){
            return{
                users: {
                    nombre_discussion: 0
                },
                allUsers: '',
                visibleAllUser: false,

                actif_user_id: localStorage.getItem('recepteur_id') // le recepteur courant
            }
            
        },

        watch:{
            obseveur_read(){
                this.get_all_user()
            }
        },

        created(){
            
            setTimeout(() => {

                const resizeBar = document.querySelector('.resize-bar');
                const resizeCompnent = document.querySelector('.resize-component');
                // const voisin = this.$store.state.voisin

                let isResizing = false;
                let max_size = parseInt(getComputedStyle(resizeCompnent).maxWidth)

                // lorsque j'enfonce le bouton gauche de la sourie
                resizeBar.addEventListener('mousedown', (e) => {
                    e.preventDefault();
                    isResizing = true;
                });

                // lorsque je bouge la sourie
                document.addEventListener('mousemove', (e) => {
                    if (!isResizing){
                        return
                    }
                    
                    const width = ((e.pageX + 2) * 100) / window.innerWidth;

                    if (width < max_size) {
                        resizeCompnent.style.width = `${width}%`;
                        this.$store.state.voisin.style.width = `${100 - width}%`;

                        resizeCompnent.style.cursor = `e-resize`
                        this.$store.state.voisin.style.cursor = `e-resize`
                    }
                    
                });

                // lorsque je lache le boutton gauche de la sourie
                document.addEventListener('mouseup', () => {
                    if (!isResizing) {
                        return
                    }
                    
                    isResizing = false;

                    resizeCompnent.style.cursor = `auto`
                    if (this.$store.state.voisin) {
                        this.$store.state.voisin.style.cursor = `auto`
                    }
                    
                });
                
            }, 1000);

        },

        mounted(){
            
            this.get_all_user()

        },

        methods: {

            send_id(id){
                this.actif_user_id = id
                this.$emit('get_id', id)
                this.visibleAllUser = false
            },

            // pour recuper tous les utilisateurs de la base de donné
            all_user(){

                this.axios.defaults.headers.common.Authorization = `Bearer ${this.$store.state.token}`
                this.axios.get(this.$store.state.url + '/all_user')
                .then(({data}) => {

                    this.allUsers = data.users

                }).catch(e=>console.log(e))

                this.visibleAllUser = true

            },

            // pour recuperer les utilisateur a qui il a ecrit
            get_all_user(){

                this.axios.defaults.headers.common.Authorization = `Bearer ${this.$store.state.token}`
                this.axios.get(this.$store.state.url + '/get_all_user')
                .then(({data}) => {

                    this.users = data

                }).catch(e=>console.log(e))

            }

        }
        

        
    }
</script>
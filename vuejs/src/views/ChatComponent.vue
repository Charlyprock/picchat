<template>
    <div> 
        <section class="flex w-full h-screen fixed top-0 bottom-0 right-0 left-0">

            <!-- la sidebar -->
            <Contact v-bind:obseveur_read="detec_read.change" @get_id="affiche_user"></Contact>

            <!-- la partie message -->
            <section class="voisin h-screen w-[70%] py-3 bg-white dark:bg-zinc-800">

                <!-- le filtre au deçu de l'ecran -->
                <div @click="close_all"  v-if="visibleFiltre" class="fixed top-0 right-0 bottom-0 left-0 z-50"></div>

                <!-- la mini navbar -->
                <section class="flex justify-between space-x-2 pb-2 pl-2 w-full shadow-md">

                    <!-- le profil du destinataire -->
                    <section class="flex space-x-2">

                        <div class="w-10 h-10 overflow-hidden rounded-lg border">
                            <img :src="$store.state.url_images + recepteur.image" class="w-full h-full object-cover">
                        </div>

                        <!-- le en ligne et le nom -->
                        <section class="">

                            <div class="font-semibold dark:text-white">
                                {{ recepteur.name }}
                            </div>

                            <div class="text-blue-500 text-sm">
                                en ligne
                            </div>

                        </section>

                    </section>

                    <!-- les appels -->
                    <section class="flex space-x-2 h-fit mt-1">

                        <!-- appel vocal -->
                        <div class="p-1 flex justify-center items-center cursor-pointer text-white hover:text-white hover:bg-green-600 bg-green-500 rounded-md duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                            </svg>
                        </div>

                        <!-- appel video -->
                        <div class="p-1 flex justify-center items-center cursor-pointer text-white hover:text-white hover:bg-green-600 bg-green-500 rounded-md duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </div>

                    </section>

                    <!-- les parametres du destinataire -->
                    <section class="pr-3">
                        <div class="p-1 mt-1 flex justify-center items-center cursor-pointer dark:text-white hover:text-white hover:bg-green-500 rounded-md duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                    </section>

                </section>

                <!-- le corps -->
                <section class="containt-messages overflow-y-scroll pr-5c pt-5 pl-5 h-[85%] dark:scrollbar dark:scrollbar-track-zinc-800 dark:scrollbar-thumb-black">

                    <section v-for="message in messages" :key="message" class="pb-[2px]">

                        <section :class="message.emetteur_id == recepteur.id ? 'justify-start': 'justify-end'" class="w-full flex">

                            <!-- le message -->
                            <div :class="message.emetteur_id == recepteur.id ? 'bg-blue-500 rounded-tr-xl my-2 mr-3': 'bg-green-500 rounded-tl-xl'" class="click-message text-white p-2 w-fit min-w-[100px] max-w-[400px] rounded-bl-xl rounded-br-xl">

                                <!-- le texte -->
                                <div>
                                    {{ message.message }}
                                </div>

                                <!-- la date et le statut -->
                                <div class="flex justify-end items-center space-x-2 pt-1">

                                    <!-- la date -->
                                    <div class="text-xs">
                                        {{ String(message.heure).slice(0, 5) }}
                                    </div>

                                    <!-- le statut -->
                                    <div v-if="message.emetteur_id != recepteur.id" class="bg-white w-1 h-1 p-2 rounded-full flex justify-center items-center">
                                        <div :class="{'bg-blue-500': message.status == 2, 'bg-green-500': message.status == 1, 'bg-white': message.status == null} " class=" rounded-full p-1"></div>
                                    </div>

                                </div>

                            </div>

                        </section>
                        
                    </section>
                </section>

                <!-- le barre de message -->
                <section class="py-2 flex w-full px-4 border-t-4 border-gray-300 dark:border-black relative">

                    <!-- les autres -->
                    <section class="flex space-x-2 w-[15%]">

                        <!-- les emojits -->
                        <section>

                            <!-- son contenue -->
                            <div :class="emoji.visible" class="shadow-lg absolute z-[1000] -top-2 duration-500">
                                <Picker @select="select_emoji" :data="emoji.init" set="apple" />
                            </div>

                            <div  @click="open_emoji" class="text-blue-500 hover:bg-blue-500 hover:text-white dark:bg-zinc-900 dark:border-black duration-500 p-1 border border-gray-300 cursor-pointer rounded-md flex justify-center items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7">
                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm-2.625 6c-.54 0-.828.419-.936.634a1.96 1.96 0 00-.189.866c0 .298.059.605.189.866.108.215.395.634.936.634.54 0 .828-.419.936-.634.13-.26.189-.568.189-.866 0-.298-.059-.605-.189-.866-.108-.215-.395-.634-.936-.634zm4.314.634c.108-.215.395-.634.936-.634.54 0 .828.419.936.634.13.26.189.568.189.866 0 .298-.059.605-.189.866-.108.215-.395.634-.936.634-.54 0-.828-.419-.936-.634a1.96 1.96 0 01-.189-.866c0-.298.059-.605.189-.866zm2.023 6.828a.75.75 0 10-1.06-1.06 3.75 3.75 0 01-5.304 0 .75.75 0 00-1.06 1.06 5.25 5.25 0 007.424 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            
                        </section>

                        <!-- les menus -->
                        <section>

                            <!-- son contenue -->
                            <div :class="menu.visible" class="flex justify-between flex-wrap w-64 p-3 border-2 border-blue-500 rounded-md shadow-lg bg-white dark:bg-zinc-900 absolute z-[1000] -top-2 duration-500">

                                <!-- la camera -->
                                <div class="flex flex-col items-center justify-center cursor-pointer hover:scale-105 duration-75">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                                    </svg>

                                    <div class="text-slate-700 dark:text-slate-200">
                                        Caméra
                                    </div>

                                </div>

                                <!-- la galerie -->
                                 <div class="flex flex-col items-center justify-center cursor-pointer hover:scale-105 duration-75">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>

                                    <div class="text-slate-700 dark:text-slate-200">
                                        Galerie
                                    </div>

                                </div>

                                <!-- les document -->
                                <div class="flex flex-col items-center justify-center cursor-pointer hover:scale-105 duration-75">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-blue-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>

                                    <div class="text-slate-700 dark:text-slate-200">
                                        Document
                                    </div>

                                </div>

                            </div>

                            <div @click="menu.visible = '-translate-y-full', visibleFiltre = true " class="text-blue-500 hover:bg-blue-500 hover:text-white duration-500 p-1 border border-gray-300 dark:bg-zinc-900 dark:border-black cursor-pointer rounded-md flex justify-center items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7">
                                    <path fill-rule="evenodd" d="M18.97 3.659a2.25 2.25 0 00-3.182 0l-10.94 10.94a3.75 3.75 0 105.304 5.303l7.693-7.693a.75.75 0 011.06 1.06l-7.693 7.693a5.25 5.25 0 11-7.424-7.424l10.939-10.94a3.75 3.75 0 115.303 5.304L9.097 18.835l-.008.008-.007.007-.002.002-.003.002A2.25 2.25 0 015.91 15.66l7.81-7.81a.75.75 0 011.061 1.06l-7.81 7.81a.75.75 0 001.054 1.068L18.97 6.84a2.25 2.25 0 000-3.182z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            
                        </section>
                    </section>

                    <!-- le textarea -->
                    <div v-show="textArea.visible" class="h-fit w-96 py-1 bg-white dark:bg-zinc-900 dark:text-white shadow-2xl overflow-hidden rounded-md border-2 border-blue-500 absolute -top-2 right-6 -translate-y-full z-[1000]">

                        <svg @click="close_textarea" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 absolute top-0 right-0 text-blue-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>

                        <textarea @input="keyup_textarea" @blur="stop_focus" class="text-area w-full h-full dark:bg-zinc-900 max-h-64 p-2 resize-none outline-none dark:scrollbar dark:scrollbar-track-zinc-900 dark:scrollbar-thumb-black" v-model="textMessage"></textarea>

                    </div>

                    <!-- la barre de message -->
                    <form @submit.prevent="send_message" class="flex space-x-2 w-[95%]">

                        <!-- l'input -->
                        <div class="border border-gray-300 dark:border-black rounded-md overflow-hidden w-full relative text-white">
                            <input @focus="open_textarea" type="text" placeholder="Message..." class="input-message w-full h-full pl-10 p-2 dark:bg-zinc-900 outline-none rounded-md">

                            <div class="absolute top-2 left-2 text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                </svg>
                            </div>
                        </div>

                        <!-- le bouton envoyer -->
                        <button type="submit" class="text-blue-500 hover:bg-blue-500 hover:text-white dark:bg-zinc-900 dark:border-black duration-500 p-1 border border-gray-300 cursor-pointer rounded-md flex justify-center items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7">
                                <path d="M3.478 2.405a.75.75 0 00-.926.94l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.405z" />
                            </svg>
                        </button>
                    </form>
                </section>

            </section>
        
        </section>

        <!-- le modal du click droit des messages -->
        <div class="modal-message hidden w-32 h-36 fixed p-2 space-y-2 text-slate-700 dark:text-slate-200 bg-white dark:bg-zinc-900 border-2 border-blue-500 rounded-md shadow-lg">

            <!-- copier -->
            <div class="flex space-x-2 p-1 cursor-pointer hover:scale-105">

                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 8.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v8.25A2.25 2.25 0 006 16.5h2.25m8.25-8.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-7.5A2.25 2.25 0 018.25 18v-1.5m8.25-8.25h-6a2.25 2.25 0 00-2.25 2.25v6" />
                    </svg>
                </div>

                <div>
                    Copier
                </div>

            </div>

            <!-- le trai -->
            <div class="w-full border-b dark:border-blue-500"></div>

            <!-- repondre -->
            <div class="flex space-x-2 p-1 cursor-pointer hover:scale-105">

                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                    </svg>
                </div>

                <div>
                    Repondre
                </div>

            </div>

            <!-- transferer -->
            <div class="flex space-x-2 p-1 cursor-pointer hover:scale-105">

                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 15l6-6m0 0l-6-6m6 6H9a6 6 0 000 12h3" />
                    </svg>
                </div>

                <div>
                    Transferer
                </div>

            </div>

        </div>

    </div>
</template>


<script>

    import { Picker, EmojiIndex } from 'emoji-mart-vue-fast/src'
    import data from 'emoji-mart-vue-fast/data/all.json'
    import 'emoji-mart-vue-fast/css/emoji-mart.css'

    import Contact from '../components/ContactComponent.vue'

    export default{

        components: {
            Picker,
            Contact
        },
        
        data(){
            return{
                messages: '',   // les messages recuperer
                user: "",       // l'utilisateur connecter
                recepteur: {    // le recepteur courant
                    id: localStorage.getItem('recepteur_id'),
                },

                boucle: 15,      // pour tester mes boucles for, cette variable est temporaire
                textArea: {
                    visible: false,
                    taille: '',
                    objet: '',
                },

                visibleFiltre: false,

                menu: {
                    visible: 'translate-y-full',
                },

                emoji: {
                    visible: 'translate-y-full',
                    init: new EmojiIndex(data)
                },
                
                textMessage: '',  // le message ecrit dans l'input

                detec_read: {   // pour actualiser la partie des contacts
                    read: false,
                    change: ""
                },

            }
            
        },

        created(){

            if (this.recepteur.id) {
                this.get_recepteur(this.recepteur.id)
                this.get_all_messages(this.recepteur.id)
            }

            // this.scroll_all()   // pour faire sroller le conteneur de message jusqu'a la fin
        },

        async mounted(){

            // pour recuperer les donners de l'utilisateur connecter
            if (this.$store.state.token) {

                this.axios.defaults.headers.common.Authorization = `Bearer ${this.$store.state.token}`
                await this.axios.get(this.$store.state.url + '/get_user')
                .then(({data}) => {

                    this.$store.state.user = data.user
                    this.user = data.user

                }).catch(e=>console.log(e))
                
            }

            setTimeout(() => {
                this.$store.state.voisin = document.querySelector('.voisin')     // pour le redimentionnement de la section contact
            }, 1000);

            

            window.Echo.channel('public').listen('Hello',(e)=>{
                console.log('go public' + e);
                // this.messages = e.welcome
            })


            window.Echo.private('test-channel-' + this.user.id).listen('TestName',(e)=>{
 
                // requette pour marquer les message en 
                var form = {
                    status: 0,
                    recepteur_id: this.recepteur.id
                }
               
                // on verifier si c'est la page de l'emetteur qui est ouverte cote recepteur
                if (e.emetteur_id == this.recepteur.id) { // l'utilisateur a vue (on marque 2)
                    // this.affiche_message(e.messages.messages)
                    form.status = 2
                    this.statut_messages(form) // retourne deja le message actualiser

                } else {  // l'utilisateur a reçu(on marque 1, // dans l'ideal: 0 pour quant il n'a par recus mais c'est parti)
                    console.log("je ne suis pas sur ta page");
                    
                    form.status = 1
                    form.recepteur_id = e.emetteur_id
                    this.statut_messages(form)

                    this.actualise_contact() // on reactualise la partie contact
                }

            }).listen('SetVueMessagesEv',(e)=>{
                this.affiche_message(e.messages)
                console.log("set_vue_messages")

            })

        },

        methods: {

            scroll_all(){
                
                setTimeout(() => {
                    var containtMessages = document.querySelector('.containt-messages')
                    var lastMessage = containtMessages.lastElementChild

                    // containtMessages.scrollBottom = containtMessages.scrollHeight
                    if(lastMessage){
                        lastMessage.scrollIntoView(
                            {
                                behavior: 'smooth',
                                block: 'end',
                                inline: 'nearest'
                            }
                        )
                    }
                    
                }, 10);

                
            },

            // elle se declenche lorsque l'on veut ouvrir le textarea pour saisir le message
            open_textarea(){

                this.textArea.visible = true

                setTimeout(() => {

                    this.textArea.objet = document.querySelector('.text-area')
                    var input = document.querySelector('.input-message')

                    this.textArea.objet.focus()
                    input.blur()

                    this.textArea.objet.style.height = this.textArea.taille
                }, 10);

            },

            // elle se declenche lorsqu'on ferme le textarea
            close_textarea(){
                this.textArea.visible = false
            },

            // elle se declanche lorsque l'on saisir dans le textarea
            keyup_textarea(){

                this.textArea.objet.style.height = ''

                this.textArea.objet.style.height = this.textArea.objet.scrollHeight + "px"

                this.textArea.taille = this.textArea.objet.scrollHeight + "px"
            },

            stop_focus(e){
                e.preventDefault()
                setTimeout(() => {
                    this.textArea.objet.focus()
                }, 10);
            },

            // elle se declange lorsqu'on clike sur le flour
            close_all(){
                this.visibleFiltre = false              // pour fermer la div du filtre
                this.menu.visible = 'translate-y-full'  // pour fermer le menu epingle
                this.emoji.visible = 'translate-y-full' // pour fermer la boite des emojis

            },
            
            open_emoji(){
                this.emoji.visible = '-translate-y-full', this.visibleFiltre = true
            },

            // pour inserer l'emoji ou se situe le focus
            add_emojie_focus(emoji){

                var position = this.textArea.objet.selectionStart

                this.textMessage = this.textMessage.slice(0, position) + emoji + this.textMessage.slice(position)
            },

            select_emoji(emoji){

                if(this.textArea.visible){
                    this.add_emojie_focus(emoji.native)
                }
                else{
                    this.open_textarea()
                    this.add_emojie_focus(emoji.native)
                }

            },

            get_recepteur(id){

                this.axios.defaults.headers.common.Authorization = `Bearer ${this.$store.state.token}`
                this.axios.get(this.$store.state.url + '/get_recepteur/' + id)
                .then(({data}) => {

                    this.recepteur = data.recepteur

                }).catch(e=>console.log(e))

            },

            get_all_messages(id){

                this.axios.defaults.headers.common.Authorization = `Bearer ${this.$store.state.token}`
                this.axios.get(this.$store.state.url + '/get_all_messages/' + id)
                .then(({data}) => {

                    this.affiche_message(data.messages)

                }).catch(e=>console.log(e))

            },

            affiche_message(messages){
                this.messages = messages

                this.actualise_contact()  // pour actualiser la partie des contacts

                this.scroll_all()   // pour faire sroller le conteneur de message jusqu'a la fin
                this.$fonct.click_droit("modal-message", "click-message")   // pour le click droit sur les messages
            },

            // methode qui ce declanche lorsqu'on clique sur le contact d'une personne
            affiche_user(id){

                if(id != this.recepteur.id){
                    this.recepteur.id = id
                    localStorage.setItem('recepteur_id', id)
                    this.get_recepteur(id)

                    // pour mettre tous les message nom vu à vu
                    // requette pour marquer les message en 
                    var form = {
                        status: 2,
                        recepteur_id: id
                    }
                    this.statut_messages(form)

                }
                

            },

            send_message(){

                if (this.textArea.visible && this.textMessage != '') {

                    this.textArea.visible = false

                    const form = new FormData
                    form.append('message', this.textMessage)
                    form.append('heure', this.$fonct.get_heure())
                    form.append('date', this.$fonct.get_date())
                    form.append('status', 1)
                    form.append('recepteur_id', this.recepteur.id)
                    form.append('emetteur_id', this.user.id)

                    this.messages.push(form)

                    this.textMessage = ''

                    this.axios.defaults.headers.common.Authorization = `Bearer ${this.$store.state.token}`
                    this.axios.post(this.$store.state.url + '/send_message', form)
                    .then(({data}) => {

                        this.affiche_message(data.messages)

                    }).catch(e=>console.log(e))

                    
                }

            },

            // on reactualise la partie contact
            actualise_contact(){
                this.detec_read.read = !this.detec_read.read
                this.detec_read.change = this.detec_read.read
            },

            // pour le statut des messages
            statut_messages(form){

                this.axios.defaults.headers.common.Authorization = `Bearer ${this.$store.state.token}`
                this.axios.post(this.$store.state.url + '/statut_messages/', form)
                .then(({data}) => {
                    
                    

                    if (data.emetteur_id == this.recepteur.id) { // on affiche les messages car, cette utilisateur est sur la page de l'emetteur
                        console.log("il", data)
                        this.affiche_message(data.messages)

                    }

                }).catch(e=>console.log(e))
            },

            publics(){

                this.axios.get(this.$store.state.url + "/test_public")
                    .then(response => {
                        console.log(response)
                    })
            },

            priver(){

                this.axios.get(this.$store.state.url + "/test_priver/2")
                    .then(response => {
                        console.log(response)
                    })
            },

            deconnect(){
                
                this.axios.defaults.headers.common.Authorization = `Bearer ${this.$store.state.token}`
                this.axios.get(this.$store.state.url + '/logout')
                    .then(response => {
                        
                        if (response.data.success) {
                            
                            localStorage.removeItem('token')
                            this.$store.state.user = ""
                            this.$store.state.token = ""

                            this.$router.push({
                                name: 'login'
                            })
                            
                        }

                    })
            }
        }
        
    }
</script>
<template>
    <div>

        <section class="w-full h-screen bg-white  md:flex absolute top-0 right-0 bottom-0 left-0 z-[97]">

            <!-- boutton quitter -->
            <div @click="quitter" class="absolute top-0 right-0 cursor-pointer z-[99] m-4 md:m-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>

            <!-- pour les minis afficharge -->
            <section v-if="miniAfficharge.visible && nombreArticle != null" class="fixed z-20 w-64 m-2 shadow-2xl border rounded-lg overflow-hidden text-white bg-black/30">

                <video v-if="article.type == 'video'" :src="miniAfficharge.src" muted autoplay loop class="w-full h-full"></video>

                <img  v-if="article.type == 'image'" :src="miniAfficharge.src" class="w-full h-full">

                <!-- boutton quitter -->
                <div @click="miniAfficharge.visible = false" class="absolute top-0 right-0 z-[99] flex justify-center items-center p-1 m-1 rounded-lg bg-black/50 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </section>
           



            <!-- la partie afficharge -->
            <section class="md:w-[50%] p-5 bg-white">

                <!-- le grand cadre -->
                <section class="min-w-full min-h-[250px]  max-h-[250px] md:min-h-[300px] md:max-h-[300px] lg:min-h-[350px] lg:max-h-[350px] overflow-hidden border-2 rounded-lg relative">

                    <!-- si c'est l'image -->
                    <div v-if="article.type == 'image' && nombreArticle != null" class="min-w-full min-h-full max-h-full overflow-hidden">
                        <img src="" class="grande-image min-w-full min-h-[250px] md:min-h-[300px] lg:min-h-[350px]  max-h-full object-coverk">
                    </div>

                    <!-- si c'est la video -->
                    <div v-if="article.type == 'video' && nombreArticle != null" class="min-w-full min-h-full max-h-full overflow-hidden">
                        <video src="" muted autoplay loop class="grande-video min-w-full min-h-[250px] md:min-h-[300px] lg:min-h-[350px]  max-h-full object-cover"></video>
                    </div>

                    <!-- l'icone pour afficher le mini afficharge -->
                    <div v-if="article.type != ''  && nombreArticle != null"  @click="miniAfficharge.visible = true" title="afficher la video en fixed" class="absolute top-0 right-0 flex justify-center items-center p-1 m-1 rounded-lg cursor-pointer text-white bg-black/50">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 3.75H6A2.25 2.25 0 003.75 6v1.5M16.5 3.75H18A2.25 2.25 0 0120.25 6v1.5m0 9V18A2.25 2.25 0 0118 20.25h-1.5m-9 0H6A2.25 2.25 0 013.75 18v-1.5M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>

                    <!-- pour le logo -->
                    <div class="w-full h-full flex items-center justify-center">
                        <img src="image/logo/logo_sans_coleurpng.png" class="h-72 opacity-50">
                    </div>

                </section>

                <!-- les petites cardre -->
                <section class="my-3 w-full min-h-[150px] max-h-[150px] border-2 overflow-hidden">

                    <!-- si c'est l'image -->
                    <section  v-if="article.type == 'image'" class="min-w-full min-h-full max-h-full overflow-x-scroll scrollbar-none flex space-x-2">

                        <div v-for="nbr in nombreArticle" :key="nbr" class="min-w-[34%] max-w-[33%] min-h-full max-h-full overflow-hidden group relative">

                            <img src="" class="petite-image min-w-full min-h-[150px] max-h-[150px] object-coverl">

                            <div @click.stop="affiche_file(nbr - 1)" class="bg-black/10 p-1 w-full h-full text-red-500 hidden justify-end absolute top-0 group-hover:flex">
                                <svg @click.stop="effacer_file(nbr - 1)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>

                        </div>

                    </section>

                    <!-- si c'est la video -->
                    <section v-if="article.type == 'video'" class="min-w-full min-h-full max-h-full overflow-x-scroll scrollbar-none flex space-x-2">

                        <div v-for="nbr in nombreArticle" :key="nbr" class="min-w-[34%] max-w-[33%] min-h-full max-h-full overflow-hidden group relative">

                            <video src="" muted autoplayh class="petite-video min-w-full min-h-[150px] max-h-[150px] object-cover"></video>

                            <div @click.stop="affiche_file(nbr - 1)"  class="bg-black/10 p-1 w-full h-full text-red-500 hidden justify-end absolute top-0 group-hover:flex">
                                <svg @click.stop="effacer_file(nbr - 1)"  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>

                        </div>

                        
                    </section>

                    <!-- l'iconne pour l'image -->
                    <div v-if="article.type == 'image' && nombreArticle == null" class="w-full min-h-full flex justify-center mt-8">
                        <label for="file" class=" opacity-50 grid justify-center">
                            <div class="w-full flex justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                            </div>
                            <div class="text-center">
                                choisisez une ou des Images.
                            </div>
                        </label>
                    </div>

                    <!-- l'iconne pour les videos -->
                    <div v-if="article.type == 'video' && nombreArticle == null" class="w-full min-h-full flex justify-center mt-8">
                        <label for="file" class=" opacity-50 grid justify-center">
                            <div class="w-full flex justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12">
                                    <path stroke-linecap="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </div>
                            <div class="text-center">
                                choisisez une ou des Video.
                            </div>
                        </label>
                    </div>
        
                </section>

                <!-- pour le nombre d'article -->
                <section v-if="nombreArticle > 0">
                    <div class="text-green-500">{{ nombreArticle + " " + article.type }}<span v-if="nombreArticle > 1">s</span></div>
                </section>

                <!-- le bouton pour reselectioner -->
                <section class="flex justify-center">

                    <input @change="article_file" type="file" id="file" hidden :accept="article.type == 'image' ? '.jpg, .png, .gif, .jpeg' : '.mp4, avi'" multiple>

                    <label v-if="nombreArticle != null" for="file" class="bg-green-500 px-3 py-1 mt-5 rounded-sm cursor-pointer text-center text-white hover:bg-green-600">
                        Resélectionnez
                    </label>

                </section>

            </section>


            <!-- les entrées -->
            <section class="md:w-[50%] text-slate-700 p-5 bg-white">
                <form @submit.prevent="publication" class="">

                    <!-- le type d'article -->
                    <section class="space-y-3 py-3">
                        <div class="text-center">
                            Quel type d'article souhaitez vous publier ?
                        </div>

                        <section class="flex space-x-3 justify-center">

                            <div @click="type_article('image')" :class="{'bg-blue-500 text-white' : article.type == 'image'}" class="border text-blue-500 duration-200 hover:bg-blue-500 hover:text-white text-center cursor-pointer rounded-md p-1 px-3">Image</div>

                            <div @click="type_article('video')" :class="{'bg-blue-500 text-white' : article.type == 'video'}" class="border text-blue-500 duration-200 hover:bg-blue-500 hover:text-white text-center cursor-pointer rounded-md p-1 px-3">Video</div>

                        </section>
                    </section>

                    <!-- la catégorie de l'article, le nom ou le theme -->
                    <section class="flex justify-between my-3">

                        <!-- la catégorie -->
                        <div class="w-[48%] space-y-3">

                            <div class="ml-2 whitespace-nowrap">
                                Catégorie de {{ article.type }}. <span class="text-xl text-red-500">*</span>
                            </div>
                            
                            <div>
                                <select-component @choisir="categorie" v-bind="select"></select-component>
                            </div>

                        </div>

                        <!-- le nom ou le terme -->
                        <div class="w-[48%] space-y-3">
                            <div class="ml-2 whitespace-nowrap">
                                <label for="nom">Nom ou Theme <span class="text-xl text-red-500">*</span></label>
                            </div>
                            <div>
                                <input type="text" id="nom" required maxlength="40" placeholder="ex: chart ou 'tous contre le sida.'" v-model="article.theme"
                                class="p-2 w-full outline-none border rounded-md duration-500 placeholder:text-slate-400 focus:border-blue-500">
                            </div>
                        </div>

                    </section>

                    <!-- la destription -->
                    <section class="space-y-3">

                        <div class="ml-2">
                            Destription <span class="text-xl text-red-500">*</span>
                        </div>

                        <div>
                            <textarea v-model="article.destription" required maxlength="255" placeholder="petite description de votre publication" class="p-2 w-full h-full overflow-scroll scrollbar-none resize-none outline-none border rounded-md duration-300 focus:border-blue-500"></textarea>
                        </div>
                    </section>

                    <!-- la partie statut -->
                    <section class=" my-3 flex space-x-3">

                        <div class="flex items-center z-10">
                            <label for="statut" class="p-2 mr-3">Payante</label>
                            <input type="checkbox" id="statut" class="w-6 h-6 duration-300" v-model="article.payant">
                        </div>

                        <!-- prix -->
                        <div :class="{'translate-x-0 opacity-100' : article.payant}" class="w-28 flex opacity-0 z-0 duration-500 -translate-x-full">
                            <input type="number" id="nom" placeholder="prix" v-model="article.prix"
                            class="p-2 w-full outline-none border border-blue-500 rounded-md duration-500 placeholder:text-slate-400">

                            <div class="text-green-500 text-sm mt-3 ml-3">xaf</div>
                        </div>
                    </section>

                    <!-- le message si l'article est gratuit -->
                    <div v-if="!article.payant" class="ml-2 text-green-500">
                        Toutes les articles gratuites seront depourvus de filigrane et leurs téléchargements sera libre et partageable sur les reseaux sociaux.
                    </div>

                    <!-- le message si l'article est payant -->
                    <div v-if="article.payant" class="ml-2 text-green-500">
                        Toutes les articles payantes seront pourvus d'un filigrane portant notre signature. leurs téléchargements contribura a une rémunération 
                        qui sera vesée dans votre conpte orange ou mtn money. Elle aussi elle sera publirable sur les reseaux sociau.
                    </div>
                    
                    <!-- le bouton publier -->
                    <section class="flex justify-end mb-3">
                        <button type="submit" class="bg-blue-500 px-3 py-1 mt-5 rounded-sm text-center text-white hover:bg-blue-600">
                            Publier
                        </button>
                    </section>

                </form>
            </section>

            <!-- la barre de progression -->
            <div v-if="progression > 0 && progression < 100" class="fixed w-screen flex items-center justify-center top-0 right-0 bottom-0 left-0 z-50 bg-black/50">

                <div class="p-5 bg-white rounded-lg w-[80%] md:w-[50%]">

                    <div class="h-10 mb-3">
                        <img src="/image/logo/logo1png.png" class="h-full object-cover">
                    </div>

                    <progress class="w-full" id="progressBar" value="0" max="100"></progress>

                    <!-- poucentage -->
                    <div class="text-center text-green-500">{{ progression }} %</div>
                </div>
                
            </div>


            <!-- pour le modal de confirmation -->
            <div v-if="visibleConfirmation" class="fixed w-screen flex items-center justify-center top-0 right-0 bottom-0 left-0 z-50 bg-black/50">
                <section class="bg-white w-[80%] md:w-[50%] h-fit rounded-lg p-3">
                    
                    <!-- le logo -->
                    <section>
                        <div class="h-10">
                            <img src="/image/logo/logo1png.png" class="h-full">
                        </div>
                    </section>

                    <!-- le message -->
                    <section class="text-center my-3">
                        <div>
                            {{messageConfirmation}}
                        </div>
                    </section>

                    <!-- les bouton -->
                    <section class="mt-2 flex space-x-3 justify-end">

                        <!-- le bouton oui -->
                        <div>
                            <button id="oui" class="py-1 px-4 bg-blue-500 hover:bg-blue-600 text-white rounded-md">oui</button>
                        </div>

                        <!-- le bouton non -->
                        <div>
                            <button id="non" class="py-1 px-4 bg-slate-500 hover:bg-slate-600 text-white rounded-md">non</button>
                        </div>
                    </section>

                </section>
            </div>

        </section>


        <modal-error @click="visibleError = false" v-if="visibleError" :message-error="messageError"></modal-error>
        
    </div>
</template>


<script>

    import selectComponent from "../../components/SelectComponent.vue"
    import modalError from "../../components/ModalerrorComponent.vue"
    import fonction from "@/function/function"

    export default{

        components: {

            selectComponent,
            modalError,
            
        },

        data(){

            return{

                // pour le modal de confirmation
                messageConfirmation: '',
                visibleConfirmation: false,

                // pour les valeurs du select
                select: {
                    valeurSelect : null,
                    valeurDefaut: "Catégorie de l'article"
                },

                // pour le mini affichage
                miniAfficharge: {       
                    visible: false,
                    src: null,
                },

                // pour la barre de progrssion
                progression: 0,

                // pour les message d'erreur (le modal error)
                messageError: 'encore de message et toujour des messages.',
                visibleError: false,
                

                // pour l'afficharge de article
                nombreArticle: null,        // le nombre d'article
                file: null,                 // les fichier selectionnés

                // pour la sauvegarde de l'article
                article: {
                    type: '',
                    payant: false,
                    theme:null,
                    destription: null,
                    categorie: null,
                    prix: null
                }
                

            }
        },


        created(){
            
            // pour la recuperation des elements toutes les categories d'article
            this.axios.defaults.headers.common.Authorization = `Bearer ${this.$store.state.token}`
            this.axios.get("http://127.0.0.1:8000/api/reglage")
                .then(Response => {
     
                    var categorie = []
                    
                    for (let i = 0; i < Response.data.categorie.length; i++) {
                        const element = Response.data.categorie[i];
                        categorie[i] = element.name
                    }

                    this.select.valeurSelect = categorie

                    console.log(categorie);
                })

                .catch(error => {
                    console.log(error)
                })

        },

        methods: {

            publication(){

                // pour verifier s'il a choisir au mois un article
                if (this.file == null || this.file == 0) {
                    
                    this.messageError = 'Vous devez entrer au moins une image ou video.'
                    this.visibleError = true
                    return
                }
                
                // verifiction de la categorie de l'article
                if (this.article.categorie == null) {
                    
                    this.messageError = 'Vous devez entrer une catégorie pour cette article.'
                    this.visibleError = true
                    return
                }

                // verification du prix
                if (this.article.prix > 50000) {
                    
                    this.messageError = 'Vous ne pouvez pas entrer un montant de plus de 50000.'
                    this.visibleError = true
                    return
                }

                // determiner la taille total de tour les articles
                var tailleKo = 0

                for (let i = 0; i < this.file.length; i++) {
                    const element = this.file[i];

                    tailleKo = tailleKo + element.size / 1024
                }

                var tailleMo = tailleKo / 1024

                // determine l'espace memoire restant de l'utilisateur
                var espaceUser = this.$store.state.user.memoire_nette - this.$store.state.user.memoire_utiliser
                
                // pour verifier si l'utilisateur a acces d'expace
                if (tailleMo > espaceUser) {
                    
                    this.messageError = "Stokage insuffisant. il vous reste " + espaceUser + "Mo. Veillez acheter un abornement pour effectuer de nouvelle publication."
                    this.visibleError = true
                    return

                }

                // pour verifier se l'utilisateur est en regle avec l'abonnement
                if (this.$store.state.user.date_fin <= fonction.date_fonction()) {
                    
                    this.messageError = "Vous avez depacez le delait de reabonnement. vous ne pouvez pas effectuer une nouvelle publication. Veillez vous reabonner s'il vous play."
                    this.visibleError = true
                    return

                }

                // pour le prix de l'article
                if (this.article.payant == false) {
                    this.article.prix = null
                }

                if (this.article.payant) {
                    this.article.payant = 1

                    // verification du prix
                    if (this.article.prix < 1) {
                        
                        this.messageError = 'Vous ne pouvez pas entrer un montant inferieur a 1.'
                        this.visibleError = true
                        return
                    }


                }else{
                    this.article.payant = 0
                }


                // l'envoir des données

                const form = new FormData

                form.append('type', this.article.type)
                form.append('theme', this.article.theme)
                form.append('destription', this.article.destription)
                form.append('categorie', this.article.categorie)
                form.append('statut', this.article.payant)
                form.append('prix', this.article.prix)
                form.append('memoire_file', tailleMo)
                form.append('taille_fichier', tailleMo)

                if (this.article.type == 'image') {
                    
                    for(let i = 0; i < this.file.length; i++){
                        form.append("images[]", this.file[i])  
                    }

                }else if (this.article.type == 'video') {
                    
                    for(let i = 0; i < this.file.length; i++){
                        form.append("videos[]", this.file[i])  
                    }

                }

                this.$store.state.chargement = true

                setTimeout(() => {
                    this.$store.state.chargement = false
                    this.$store.state.fin_publication.visible = true
                    this.$router.push('/profil')
                }, 1000);

                this.axios.defaults.headers.common.Authorization = `Bearer ${this.$store.state.token}`
                this.axios.post('http://localhost:8000/api/publication_article', form)
                    .then(response => {
                                
                        localStorage.removeItem('user')
                        localStorage.setItem('user', JSON.stringify(response.data.user))
                        
                        this.$store.state.user = JSON.parse(localStorage.getItem('user'))


                        this.$store.state.fin_publication.message = 'Votre publication a été traitée avec succès. vous pouvez la consulter sur vos pages image ou video.'
                        this.$store.state.fin_publication.class = 'bg-green-500'

                        setTimeout(() => {
                            this.$store.state.fin_publication.visible = false
                            this.$store.state.fin_publication.message = 'Veillez ne pas actualiser la parge, la publication que vous avez faite est en cour de traitement.'
                            this.$store.state.fin_publication.class = 'bg-red-500'
                        }, 8000);
                            

                    })
                    .catch(error => {
                        console.log(error)
                    })


            },

            // pour choisir le type de l'article (image ou video)
            type_article(type){
                this.article.type = type
                
                this.nombreArticle = null
                this.file = null                // pour vider les variables
            
            },

            // pour effacer un article parmis les sélectionners
            effacer_file(indice){
                
                this.file = Array.from(this.file)
                this.file.splice(indice, 1)

                
                this.global_function(this.file)

            },

            // pour afficher la petite image dans le grand cardre losqu'on clique deçus
            affiche_file(indice){

                if (this.nombreArticle != null) {       // affichier s'il ya des article

                    if (this.article.type == 'image') {     // si c'est une image

                        var grandeImage = document.querySelector('.grande-image')
                        const fileReader = new FileReader()

                        fileReader.onload = (e) => {

                            grandeImage.src = e.target.result

                            this.miniAfficharge.src = e.target.result    // pour le mini afficharge
                    
                        }

                        fileReader.readAsDataURL(this.file[indice])
                    }
                    else if (this.article.type == 'video'){     // si c'est une video

                        var grandeVideo = document.querySelector('.grande-video')
                        const fileReader = new FileReader()

                        fileReader.onload = (e) => {

                            grandeVideo.src = e.target.result

                            this.miniAfficharge.src = e.target.result    // pour le mini afficharge
                    
                        }

                        fileReader.readAsDataURL(this.file[indice])
                    }

                    
                }

                
            },


            article_file(fil){

                this.file = fil.target.files
                this.global_function(this.file)
            },
            
            // la fonction global pour affichier les articles choisis
            global_function(e){

                this.file = e

                // pour verifier si le nombre d'image est inferieur ou égale a 5
                if (this.file.length > 5) {

                    this.messageError = "vous ne devez pas choisir plus de 5 fichier."
                    this.visibleError = true        // pour afficher le modale error

                    this.nombreArticle = null
                    this.file = null            // on vide la variable
               
                    return
                }

                if (this.file.length != 0) {
                    this.nombreArticle = this.file.length            // pour boucler sur le nombre d'article
                }
                else{
                    this.nombreArticle = null
                    return
                }

                if (this.article.type == 'video') {
                    this.progression = 1       // ouverture de la progress barre
                }


                var extensionsImage = ['png', 'jpg', 'jpeg', 'gif']
                var extensionsVideo = ['mp4', 'avi']                    // pour definir les extension
                var compatibleImage = false
                var compatibleVideo = false

                setTimeout(() => {

                    var grandeImage = document.querySelector('.grande-image')
                    var petiteImage = document.querySelectorAll('.petite-image')     // selection des balises pour les petite et grandes cardres
                                                                                    
                    var grandeVideo = document.querySelector('.grande-video')
                    var petiteVideo = document.querySelectorAll('.petite-video')


                    // pour la progresse barre                     
                    
                    var fileSize = 0         // Taille du fichier en octets
                    var maxsize = 209715200  // la taille maximale de fichiers a publier (200 Mo)
                    
                    for (let k = 0; k < this.file.length; k++) {
                        const element = this.file[k];

                        if (element.size > maxsize) {
                            this.messageError = "Nous avons detecter un fichier de plus de " + maxsize / 1024 / 1024 + " Mo. Cette taille est trop éléver pour etre accepter."
                            this.visibleError = true        // pour afficher le modale error

                            this.nombreArticle = null
                            this.file = null            // on vide la variable
                            this.progression = 0       // on enléve la barre de progression
                    
                            return

                        } else {
                            fileSize = fileSize + element.size
                        }

                        
                    }
                    
                    const ecarLect = 1024 * 1024;      // Taille des morceaux de lecture (1 Mo dans cet exemple)
                    let tailleTelecharger = 0;          // la taille deja telecharger
                    // fin
                


                    for (let i = 0; i < this.file.length; i++) {    // boucler sur les fichiers
                        
                        compatibleImage = false 
                        compatibleVideo = false     

                        extensionsImage.forEach(extension => {             // voir si le fichier est compatible  aux images

                            if (this.article.type == 'image' && this.file[i].type == "image/" + extension) {
                                compatibleImage = true  
                                
                            }
            
                        });


                        extensionsVideo.forEach(extension => {             // pour voir si c'est compatible aux videos

                            if (this.article.type == 'video' && this.file[i].type == "video/" + extension) {
                                compatibleVideo = true
                            }

                        });

                        if (compatibleImage) {               // si le fichier est une image
                            
                            const fileReader = new FileReader()

                            fileReader.onload = (e) => {

                                if (i == 0) {
                                    grandeImage.src = e.target.result
                                    petiteImage[i].src = e.target.result

                                    this.miniAfficharge.src = e.target.result    // pour le mini afficharge
                                }
                                else{
                                    petiteImage[i].src = e.target.result
                                }
                            
                                        
                            }

                            fileReader.readAsDataURL(this.file[i])
                        } 
                        else if (compatibleVideo) {          // si le fichier est une video

                            // le file reader pour l'afficharge
                            const fileReader = new FileReader()

                            fileReader.onload = (e) => {

                                // pour verifier la duree des videos
                                var video = document.createElement('video')
                                video.src = e.target.result

                                video.addEventListener('loadedmetadata', () => {
                                    
                                    var seconde = 40

                                    if (video.duration > seconde + 1) {
                                        
                                        this.messageError = "Nous avons detectés une video de plus de " + seconde + " seconde. Pour des contenus fiables, nous interdisons cela."
                                        this.visibleError = true
                                        
                                        this.nombreArticle = null
                                        this.file = null                // pour vider les variables
                                        this.progression = 0

                                        return
                                    }
                                })

                                if (i == 0) {
                                    grandeVideo.src = e.target.result
                                    petiteVideo[i].src = e.target.result

                                    this.miniAfficharge.src = e.target.result    // pour le mini afficharge
                                }
                                else{
                                    petiteVideo[i].src = e.target.result
                                }

                            }

                            fileReader.readAsDataURL(this.file[i])



                            
                            const progressBar = document.getElementById('progressBar');  // l'element progress
                            
                            // le file reader pour le chargement
                            const Reader = new FileReader();

                            Reader.onload = () => {

                                if (!this.visibleError) {   // si on a pas rencontrer d'erreur
                                    
                                    if (tailleTelecharger < fileSize) {
                                        
                                        // Mise à jour de la barre de progression
                                        tailleTelecharger += ecarLect;

                                        const poucentage = (tailleTelecharger / fileSize) * 100;

                                        progressBar.value = poucentage;
                                        this.progression = poucentage.toString().slice(0, 3)

                                        // Lecture du prochain morceau du fichier
                                        const blob = this.file[i].slice(tailleTelecharger, tailleTelecharger + ecarLect);
                                        Reader.readAsDataURL(blob);
                                     
                                    }

                                }

                            }

                            // Lecture du premier morceau du fichier
                            const blob = this.file[i].slice(0, ecarLect);
                            Reader.readAsDataURL(blob);

                        } 
                        else {                           // si ça ne correspond à aucun des deux.
                            
                            if (this.article.type == 'image') {

                                this.messageError = "vous devez selectioner des images appartenant aux extensions " + extensionsImage.join(',  ')
                                this.visibleError = true
                                
                                this.nombreArticle = null
                                this.file = null                // pour vider les variables
                                return
                            }
                            else if (this.article.type == 'video') {

                                this.messageError = "vous devez selectioner des videos appartenant aux extensions " + extensionsVideo.join(',  ')
                                this.visibleError = true

                                this.nombreArticle = null
                                this.file = null                // pour vider les variables
                                return
                            }   
                                
                            
                        }
                        
                    }

                }, 20);

            },

            // pour la recupération de la categorie de l'article
            categorie(categ){
                this.article.categorie = categ
            },

            // pour quitter la page
            quitter(){
                
                // pour le modal de confirmation
                this.messageConfirmation = "Voulez vous vraiment quitter cette pages ? Tout votre tavaille sera supprimé."
                this.visibleConfirmation = true


                setTimeout(() => {

                    var oui = document.querySelector('#oui')
                    var non = document.querySelector('#non')        // pour les boutons de confirmation

                    oui.addEventListener('click', () => {           // s'il clique sur oui

                        return this.$router.push('/profil')
                    
                    })

                    non.addEventListener('click', () => {       // s'il clique sur non
                        this.visibleConfirmation = false
                        return

                    })


                }, 20);
            }
        }
    }
</script>
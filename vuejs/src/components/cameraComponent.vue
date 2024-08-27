<template>

    <div v-show="observe_open" class="flex justify-center items-center bg-black/50f backdrop-blur-sm w-screen fixed top-0 right-0 left-0 bottom-0 z-50">

        <section class="bg-white h-[80%] w-[480px] dark:bg-zinc-900 p-2 rounded-md overflow-hidden border border-blue-500">
            
            <section class="bg-gray-400 dark:bg-black/60 w-full h-full overflow-hidden rounded-md flex flex-col justify-between relative">

                <!-- les apperçus -->
                <section class="relative w-full h-[70%]">

                    <video v-show="petiteAffiche.src.length == 0" ref="videoCamera" autoplay class="w-full h-full"></video>
                    
                    <!-- le grand cadre pour les selection-->
                    <section v-if="petiteAffiche.src.length != 0" class="w-full h-full overflow-hidden flex items-center">
                            
                        <!-- si c'est l'image -->
                        <img v-if="grandeAffiche.type == 'image'" :src="grandeAffiche.src" class="w-full object-center">

                        <!-- si c'est la video -->
                        <video v-if="grandeAffiche.type == 'video'" :src="grandeAffiche.src" autoplay loop ref="grandeVideo" class="w-full h-full"></video>

                        <!-- pour mettre la video en play ou en pause -->
                        <div v-if="grandeAffiche.type == 'video'" class="w-full h-full absolute flex justify-center items-center group">

                            <!-- pause et play-->
                            <div class="bg-black/50 rounded-md p-2 text-white justify-center items-center cursor-pointer hidden group-hover:flex">
                                
                                <!-- pause -->
                                <svg v-if="!grandeAffiche.pause" @click="$refs.grandeVideo.pause(), grandeAffiche.pause = true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25v13.5m-7.5-13.5v13.5" />
                                </svg>

                                <!-- play -->
                                <svg v-if="grandeAffiche.pause" @click="$refs.grandeVideo.play(), grandeAffiche.pause = false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-16 h-16">
                                    <path fill-rule="evenodd" d="M4.5 5.653c0-1.426 1.529-2.33 2.779-1.643l11.54 6.348c1.295.712 1.295 2.573 0 3.285L7.28 19.991c-1.25.687-2.779-.217-2.779-1.643V5.653z" clip-rule="evenodd" />
                                </svg>
                            </div>

                        </div>

                    </section>

                    <!-- les elements du deçus pour les aperçus -->
                    <section v-show="petiteAffiche.src.length != 0" :class="{'w-6': !petiteAffiche.isOpen, 'w-[20%]': petiteAffiche.isOpen}" class="h-[75%] overflow-hidden absolute top-2 right-2 flex duration-1000">
                    
                        <!-- le bouton pour faire apparaitre et disparaitre -->
                        <div @click="open_close_miniAff()" class="flex justify-center items-center dark:text-white rounded-tl-md rounded-bl-md h-14 w-6 bg-white dark:bg-zinc-800 cursor-pointer duration-1000">
                            <svg :class="{'rotate-180': !petiteAffiche.isOpen}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 duration-1000">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </div>

                        <section class="mini-image space-y-1 bg-white dark:bg-zinc-800 h-full w-full">

                            <!-- les image ou video -->
                            <section class="h-[80%] overflow-y-scroll scrollbar-none space-y-1">

                                <div @click.stop="click_petit_image(message)" v-for="message in data.messages" :key="message.id" class="overflow-hidden w-full h-[20%] relative">

                                    <img v-show="message.type == 'image'" :src="petiteAffiche.src[message.id]" class="w-full min-h-full">

                                    <video v-show="message.type == 'video'" :src="petiteAffiche.src[message.id]" class="min-w-full min-h-full"></video>

                                    <!-- le boutom pour supprimer une image -->
                                    <div v-if="grandeAffiche.src == petiteAffiche.src[message.id]" class="bg-black/50 text-white flex justify-center items-center absolute top-0 left-0 right-0 bottom-0">
                                        
                                        <div @click.stop="delete_file(message.id)" class="bg-black/50 flex justify-center items-center p-1 cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- le loading -->
                                    <div v-if="petiteAffiche.src[message.id] == undefined" class="bg-black/50 text-white flex justify-center items-center absolute top-0 left-0 right-0 bottom-0">
                                        <div class="bg-black/50 flex justify-center items-center p-1 cursor-pointer">
                                            <div class="w-6 h-6 rounded-full border-b-2 border-white animate-spin duration-500"></div>
                                        </div>
                                    </div>

                                </div>

                            </section>

                            <!-- le plus -->
                            <div class="h-[20%] w-full flex justify-center items-center pb-2">
                                
                                <label for="add-file" class="flex justify-center items-center p-2 text-white bg-black/50 rounded-md cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                        <path fill-rule="evenodd" d="M12 3.75a.75.75 0 01.75.75v6.75h6.75a.75.75 0 010 1.5h-6.75v6.75a.75.75 0 01-1.5 0v-6.75H4.5a.75.75 0 010-1.5h6.75V4.5a.75.75 0 01.75-.75z" clip-rule="evenodd" />
                                    </svg>
                                </label>

                                <input @change="plus_file" multiple type="file" id="add-file" hidden>
                            </div>

                        </section>
                    </section>

                </section>   

                <!-- ce qui s'affiche lorqu'il y a un element a envoyer -->
                <section v-show="petiteAffiche.src.length != 0" class="w-full flex items-center absolute bottom-0 justify-end py-2 px-2">

                    <!-- la zone de saisir -->
                    <textarea @input="saisir_textarea" v-model="textTextarea" ref="textArea" placeholder="Entrer votre message..." class="w-56 absolute bottom-2 left-2 max-h-64 dark:text-white rounded-md dark:bg-zinc-800 py-1 px-2 resize-none outline-none dark:scrollbar dark:scrollbar-track-zinc-900 dark:scrollbar-thumb-black"></textarea>
                  

                    <!-- le nom du recepteur et le boutom d'envoir -->
                    <div class="flex items-center space-x-3 p-2 rounded-md bg-white dark:bg-zinc-800 dark:text-white">
                        
                        <!-- le nom du recepteur -->
                        <div class="max-w-[100px] min-w-[50px] overflow-hidden text-ellipsis">
                            charfsdsdddddddd
                        </div>

                        <!-- le bouton envoyer -->
                        <button type="submit" class="text-blue-500 hover:bg-blue-500 hover:text-white dark:bg-zinc-900 dark:border-black duration-500 p-1 border border-gray-300 cursor-pointer rounded-md flex justify-center items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7">
                                <path d="M3.478 2.405a.75.75 0 00-.926.94l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.405z" />
                            </svg>
                        </button>
                    </div>
                </section>

                <!-- les elements du deçus pour les boutons -->
                <section class="h-fit space-y-3 py-2 bg-black/40f">

                    <!-- pour selectionner dans l'explorteur de fichier -->
                    <div v-if="petiteAffiche.src.length == 0">
                        <label for="select-file" class="text-white dark:bg-zinc-800 flex items-center space-x-2 p-1 rounded-md absolute top-1 left-1 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                            </svg>

                            <div>
                                Galerie
                            </div>
                        </label>

                        <input @change="choice_file" multiple type="file" id="select-file" hidden="hidden">

                    </div>

                    <!-- ce qui saffiche lorsqu'il n y a aucun element a envoyer -->
                    <section v-show="petiteAffiche.src.length == 0" class="space-y-3">

                        <!-- les commandes pour l'enregistrement -->
                        <section class="flex justify-center space-x-3">

                            <!-- stope -->
                            <div @click="stopRecording" v-if="isVideo && video.isRecording" class="dark:bg-zinc-800 rounded-md p-2 text-red-500 flex justify-center items-center cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                    <path fill-rule="evenodd" d="M4.5 7.5a3 3 0 013-3h9a3 3 0 013 3v9a3 3 0 01-3 3h-9a3 3 0 01-3-3v-9z" clip-rule="evenodd" />
                                </svg>
                            </div>

                            <!-- le bouton du demarrage de l'enregistrement video ou image -->
                            <div @click="capture" class="border-2 border-white p-1 rounded-full w-fit h-fit cursor-pointer relative">
                                <div :class="{'p-4' : !isVideo}" class="bg-white rounded-full p-3 duration-500">
                                    <svg v-if="isVideo && video.time == 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-red-500">
                                        <path d="M4.5 4.5a3 3 0 00-3 3v9a3 3 0 003 3h8.25a3 3 0 003-3v-9a3 3 0 00-3-3H4.5zM19.94 18.75l-2.69-2.69V7.94l2.69-2.69c.944-.945 2.56-.276 2.56 1.06v11.38c0 1.336-1.616 2.005-2.56 1.06z" />
                                    </svg>

                                    <div v-if="isVideo && video.time != 1" class="w-4 h-4 text-sm text-center">
                                        {{ video.time }}
                                    </div>
                                </div>

                                <!-- pour le cercle de progression -->
                                <svg v-show="isVideo && video.isRecording" ref="cercleAnimation" class="circle w-12 h-12 bg-green-500d absolute top-0 left-0">
                                    <circle id="progressCircle" cx="24" cy="24" r="26" class="progress" />
                                </svg>
                            </div>

                            <!-- pause et play-->
                            <div v-if="isVideo && video.isRecording" class="dark:bg-zinc-800 rounded-md p-2 text-white flex justify-center items-center cursor-pointer">
                                
                                <!-- pause -->
                                <svg @click="pauseRecording" v-if="!video.isPause" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25v13.5m-7.5-13.5v13.5" />
                                </svg>

                                <!-- play -->
                                <svg @click="playRecording" v-if="video.isPause" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                    <path fill-rule="evenodd" d="M4.5 5.653c0-1.426 1.529-2.33 2.779-1.643l11.54 6.348c1.295.712 1.295 2.573 0 3.285L7.28 19.991c-1.25.687-2.779-.217-2.779-1.643V5.653z" clip-rule="evenodd" />
                                </svg>
                            </div>

                        </section>

                        <!-- les bouton photo et video -->
                        <div v-if="!video.isRecording" class="flex justify-center space-x-3 w-full">

                            <!-- photo -->
                            <div @click="bouton_image" :class="{'dark:bg-zinc-800' : !isVideo}" class="flex space-x-2 text-white p-2 rounded-md cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                                </svg>

                                <div>
                                    photo
                                </div>
                            </div>

                            <!-- video -->
                            <div @click="bouton_video" :class="{'dark:bg-zinc-800' : isVideo}" class="flex space-x-2 text-white p-2 rounded-md cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                    <path d="M4.5 4.5a3 3 0 00-3 3v9a3 3 0 003 3h8.25a3 3 0 003-3v-9a3 3 0 00-3-3H4.5zM19.94 18.75l-2.69-2.69V7.94l2.69-2.69c.944-.945 2.56-.276 2.56 1.06v11.38c0 1.336-1.616 2.005-2.56 1.06z" />
                                </svg>

                                <div>
                                    Video
                                </div>
                            </div>
                        </div>

                    </section>

                </section>


                <!-- au cas ou la camera ne fontione pas -->
                <section v-if="cameraError" class="dark:bg-black bg-gray-400 absolute top-0 bottom-0 right-0 left-0 flex flex-col justify-center items-center space-y-4">
                    <!-- message -->
                    <div class="text-white text-center">

                        <div class="text-3xl">
                            Error !!!
                        </div>

                        <div class="mx-6">
                            Impossible d'acceder a la camera, verifier si elle n'est pas occuper et reesayer !!!
                        </div>

                    </div>
 
                    <!-- le bouton -->
                    <div @click="startCamera(false)" class="p-2 rounded-md bg-white dark:bg-zinc-800 dark:text-white dark:hover:bg-zinc-700 cursor-pointer">
                        Reesayer
                    </div>
                </section>
             
            </section>

        </section>

        <!-- le bouton pour fermer la camera -->
        <div @click="visible = false" class="flex justify-center items-center space-x-1 p-2 rounded-md text-white bg-gray-400 dark:bg-black absolute top-2 right-2 cursor-pointer">

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>

            <div>
                Fermer
            </div>

        </div>

    </div>
</template>

<script>
export default {

    props:{
        observe_open: null
    },

    watch: {
        observe_open(nouv){
            if (nouv) {
                this.visible = true
                this.startCamera(false)
            } else {
                this.visible = false
            }
        }
    },

    data() {
        return {

            video: {
                mediaRecorder: null,
                recordedChunks: [],
                isRecording: false,
                isPause: false,
                time: 1,
                interval: null,
            },

            isVideo: false, // pour savoir si c'est la video qu'on veut enregistrer

            data: {
                nombreFile: null,
                files: null,
                messages: [],
            },

            cameraError: false,
            visible: false,

            grandeAffiche: {
                src: null,
                type: null,
                pause: false
            },

            petiteAffiche : { // contient les url de chaque petite cadre d'image ou video
                src: [],
                isOpen: true,
            },

            cercle_animation: {
                circonference: null,
                interval: null,
                offset: null,
                poucent: 0,
            },

            textTextarea: null,  // contient le texte saisir dans le textarea
            message_id: null,  // contient l'id du petit apperçu actif

        };
    },
    mounted() {
        this.animation()
    },

    methods: {

        // pour acceder a la camera
        startCamera(audio) {
            navigator.mediaDevices.getUserMedia({ video: true, audio: audio })
                .then(stream => {
                    this.$refs.videoCamera.srcObject = stream;

                    // pour la video on ajoute ceci
                    if (audio) {
                       this.video.mediaRecorder = new MediaRecorder(stream);
                        this.video.mediaRecorder.ondataavailable = this.handleDataAvailable; 
                    }

                    this.cameraError = false
                    
                })
                .catch(err => {
                    console.error("Erreur d'accès à la caméra : ", err);
                    this.cameraError = true
                });
        },

        startRecording() {
            this.video.recordedChunks = [];
            this.video.mediaRecorder.start();  // il a ete creer par le new MediaRecorder lors de l'acces a la camerra
            this.video.isRecording = true;  // l'enregistrement est lance
        },

        stopRecording() {
            this.video.mediaRecorder.stop(); // on stop l'enregistrement
            this.video.isRecording = false;
            this.video.isPause = false
            this.video.time = 1
            
            clearInterval(this.video.interval)  // on nettoye le compteur de temp
            clearInterval(this.cercle_animation.interval); // on netoye l'animation
            this.cercle_animation.poucent = 0
            this.$refs.cercleAnimation.style.strokeDashoffset = this.cercle_animation.circonference // Réinitialise
        },

        pauseRecording(){
            this.video.mediaRecorder.pause()
            this.video.isPause = true

            clearInterval(this.video.interval)  // on nettoye le compteur de temp
            clearInterval(this.cercle_animation.interval); // on netoye l'animation
        },

        playRecording(){
            this.video.mediaRecorder.resume()
            this.video.isPause = false

            // pour verifier le temp maximal ici 50 seconde
            this.compteu_durer()

            this.start_animation()
        },

        // la fonction qui s'execute appres que l'enregistrement soit terminer
        async handleDataAvailable(event) {
            if (event.data.size > 0) {
                this.video.recordedChunks.push(event.data);

                var src = URL.createObjectURL(new Blob(this.video.recordedChunks, { type: 'video/webm' })); // on cree l'url
                
                var file = await this.createFile(src, "video.mp4", 'video/mp4')
                var message = {}
                message.file = file
                message.type = 'video'
                message.fileSize = file.size

                this.add_file(message, src)
            }
        },

        // lorsque l'on clique sur le bouton video
        bouton_video(){
            this.isVideo = true
            this.startCamera(true)
        },
        // lorsque l'on clique sur le bouton image
        bouton_image(){
            this.isVideo = false
            this.startCamera(false)
        },

        // pou creer un fichier a parti de son urs(src)
        async createFile(url, name, type){
            const response = await fetch(url)
            const blob = await response.blob()
            const file = new File([blob], name, {type: type})

            return file
        },

        // lorque l'on appuir sur le bouton pour prendre un image ou une video
        async capture(){
            if (!this.isVideo) {
                
                const canvas = document.createElement("canvas")
                const video = this.$refs.videoCamera;

                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                const context = canvas.getContext('2d');
                context.drawImage(video, 0, 0);

                var src = canvas.toDataURL('image/png'); // Convertir en image
                
                var file = await this.createFile(src, "photo.png", "image/png")
                var message = {}
                message.file = file
                message.type = 'image'
                message.fileSize = file.size

                this.add_file(message, src)

            } else if (!this.video.isRecording) {
                this.startRecording()

                // pour l'animation
                this.start_animation()

                // pour verifier le temp maximal ici 50 seconde
                this.compteu_durer()
                
            }
        },

        // pour compter la dure de l'enregistrement video
        compteu_durer(){
            var secondMax = 50
    
            this.video.interval = setInterval(() => {
                this.video.time = this.video.time + 1
                console.log("interval capture")
                if (this.video.time > secondMax) {
                    clearInterval(this.video.interval)
                    this.stopRecording()
                }
            }, 1000);
        },

        // pour l'animation du cercle de la video(l'initialisation des variables)
        animation(){
            const progressCircle = this.$refs.cercleAnimation
            const radius = 26;
            const circumference = 2 * Math.PI * radius;
            this.cercle_animation.circonference = circumference

            progressCircle.style.strokeDasharray = circumference;
            progressCircle.style.strokeDashoffset = circumference;
        },

        // pour l'animation de la progression video
        start_animation(){
            
            let percent = this.cercle_animation.poucent
            let circonference = this.cercle_animation.circonference
            this.$refs.cercleAnimation.style.strokeDashoffset = circonference;
      
            this.cercle_animation.interval = setInterval(() => {
                console.log("interval animation")
                if (percent < 100) {
                    percent += 2; // elle va se remplir en 50 seconde
                    this.cercle_animation.offset = circonference - (percent / 100 * circonference);
                    this.$refs.cercleAnimation.style.strokeDashoffset = this.cercle_animation.offset;

                    this.cercle_animation.poucent = percent
                
                } else {
                    clearInterval(this.cercle_animation.interval);
                }
            }, 1000); // Met à jour toutes les secondes
                   
        },

        // lorsque l'on veux fermer ou ovrir les mini afficharge
        open_close_miniAff(){
            if (this.petiteAffiche.isOpen) {
                this.$animation.close_translate_opacity(".mini-image", 1000, "rigth")
                this.petiteAffiche.isOpen = false
            } else {
                this.$animation.open_translate_opacity(".mini-image")
                this.petiteAffiche.isOpen = true
            }
        },







        saisir_textarea(){

            // permet de redimentionner le textarea
            this.$refs.textArea.style.height = ''
            this.$refs.textArea.style.height = this.$refs.textArea.scrollHeight + "px"
            console.log(this.message_id)
            // on determine de que image ou video il s'agit
            for (let i = 0; i < this.data.messages.length; i++) {
                const element = this.data.messages[i];
                
                if (element.id == this.message_id) {
                    element.msg = this.textTextarea
                    console.log(element)
                }
            }
        },

        // lorsqu'on clique sur l'un des petites image ou video
        click_petit_image(message){
            this.grandeAffiche.src = this.petiteAffiche.src[message.id] 
            this.grandeAffiche.type = message.type
            this.textTextarea = message.msg
            this.message_id = message.id
            console.log(this.data.messages)
        },

        // lorsque l'utilisateur choisir des fichier dans l'explorateur de fichier
        choice_file(e){
            
            if (e.target.files.length == 0) {
                return
            }

            var data = this.global_function(e.target.files)

            setTimeout(() => {
                this.data.messages = data[0]
                this.petiteAffiche.src = data[1]
                this.grandeAffiche.src = this.petiteAffiche.src[0] // on affiche le premier element dans le grand cadre
                this.grandeAffiche.type = this.data.messages[0].type
                this.message_id = this.data.messages[0].id  // on sovegarde id de l'element actif
                console.log(this.data.messages)
            }, 100);
            
        },

        // lorsque l'utilisateur clique sur la croi qui est sur une image
        delete_file(id){
            this.data.messages.splice(id, 1)
            this.petiteAffiche.src.splice(id, 1)
           

            // on reorganise le tableau des messages
            for (let i = 0; i < this.data.messages.length; i++) {   
                this.data.messages[i].id = i
            }

            // on definir l'url de la grande image
            var prec = id - 1
            if (id == 0) {
                prec = id
            }

            if (this.data.messages.length != 0) {
                this.grandeAffiche.src = this.petiteAffiche.src[prec]
                this.grandeAffiche.type = this.data.messages[prec].type
                this.message_id = prec
                this.textTextarea = this.data.messages[prec].msg
            } else {                // cella signifi qu'il n y a plus de message
                this.grandeAffiche.src = null
                this.grandeAffiche.type = null
                this.message_id = null
                this.textTextarea = null    // on vide le textarea
            }

            console.log(this.message_id)
            
        },

        // lorsque l'utilisateur veus ajouter un ficher (il clique sur plus)
        plus_file(e){

            if (e.target.files.length == 0) {
                return
            }

            var data = this.global_function(e.target.files)
            
            setTimeout(() => {
                var message = data[0][0]
                var src = data[1][0]

                if (!this.petiteAffiche.src.includes(src)) {
                    this.add_file(message, src)
                }
                
            }, 100);

        },

        // pour ajouter un fichier dans les variable
        add_file(message, src){
            message.id = this.data.messages.length
            this.data.messages.push(message)
            this.petiteAffiche.src.push(src)
            this.grandeAffiche.src = src
            this.grandeAffiche.type = message.type
            this.message_id = message.id
            this.textTextarea = null
            this.$refs.textArea.style.height = ''
        },

        get_duration(src){
            // pour verifier la duree des videos
            var video = document.createElement('video')
            video.src = src
            var durer = 0

            video.addEventListener('loadedmetadata', () => {
                durer = video.duration
            })
            
            return durer
        },

        // la fonction global pour affichier les articles choisis
        global_function(e){
            var files = e

            // pour verifier si le nombre d'image est inferieur ou égale a 5

            var extensionsImage = ['png', 'jpg', 'jpeg', 'gif']
            var extensionsVideo = ['mp4', 'avi']                    // pour definir les extension

            var petiteAffiche = []
            var messages = []
            
            var maxsize = 209715200  // la taille maximale de fichiers a publier (200 Mo)

            for (let i = 0; i < files.length; i++) {    // boucler sur les fichiers
                const element = files[i]

                var message = {}  // l'objet qui contien l'identiter de tous nos fichier
                message.id = i
                message.file = element

                // pour determiner la taille de chaque fichier
                if (element.size > maxsize) {
                    return
                } else {
                    message.fileSize = element.size // on ajoute la taille du fichier dans son objet
                }
                
                // verification des compatibilites
                if (extensionsImage.includes(element.type.slice(6))) {  // voir si le fichier est compatible  aux images
                    message.type = "image"
                
                } else if (extensionsVideo.includes(element.type.slice(6))) {  // pour voir si c'est compatible aux videos
                    message.type = "video"
                }

                // le file reader pour l'afficharge
                const fileReader = new FileReader()

                fileReader.onload = (e) => {
                    petiteAffiche.push(e.target.result) // on ajoute url dans la liste
                }

                fileReader.readAsDataURL(element)

                // j'ajoute le fichier dans la liste des messages
                message.msg = ""
                messages.push(message)
            }

            return [messages, petiteAffiche]
        },
    }
};
</script>

<style>
    .circle {
        transform: rotate(-90deg);
        overflow: visible;
    }
    .progress {
        stroke: red;
        stroke-width: 4;
        fill: transparent;
        transition: stroke-dashoffset 0.5s linear;
    }
</style>


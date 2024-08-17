import vuex from "vuex"

export default new vuex.Store({

    state: {

        token: localStorage.getItem('token'),
        user: "",
        url: "http://127.0.0.1:8000/api",
        url_images: "http://127.0.0.1:8000/images/",
        
        voisin: null    // pour le redimentionnement de la section contact

    },

})
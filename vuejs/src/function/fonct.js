import store from "@/store/store";

export default {

    click_droit(class_modal, class_click){

        setTimeout(() => {

            var modal = document.querySelector(`.${class_modal}`)
            const click = document.querySelectorAll(`.${class_click}`);

            var fenetre_w = window.innerWidth
            var fenetre_h = window.innerHeight

            var h = parseInt(getComputedStyle(modal).height)
            var w = parseInt(getComputedStyle(modal).width)

            var isOpen = false
            
            for (let index = 0; index < click.length; index++) {
                const element = click[index];
            
                element.addEventListener("contextmenu", (e) => {
                    e.preventDefault()
                    isOpen = true

                    // le normal: en haut a gauche
                    modal.style.top = `${e.clientY}px`
                    modal.style.left = `${e.clientX}px`

                    // en haut a droite
                    if ((fenetre_w - e.clientX) < w) {
                        modal.style.top = `${e.clientY}px`
                        modal.style.left = `${e.clientX - w}px`
                    }
                    // en bas a gauche
                    if (((e.clientX) < w) && ((fenetre_h - e.clientY) < h)) {
                        modal.style.top = `${e.clientY - h}px`
                        modal.style.left = `${e.clientX}px`
                    }
                    // en bas a droite
                    if (((fenetre_w - e.clientX) < w) || ((fenetre_h - e.clientY) < h) ) {
                        modal.style.top = `${e.clientY - h}px`
                        modal.style.left = `${e.clientX - w}px`
                    }

                    modal.style.display = `block`
                });
            }

            document.addEventListener("click", () => {
                if (isOpen) {
                    modal.style.display = "none"
                }
            })

        }, 1000);
    },

    get_heure(){
        var date = new Date()

        // padStart(2, "0") pour que le format tien toujour sur deux chiffres(01, 00, 08)
        var h = String(date.getHours()).padStart(2, "0")
        var m = String(date.getMinutes()).padStart(2, "0")
        var s = String(date.getSeconds()).padStart(2, "0")

        return `${h}:${m}:${s}`
    },

    get_date(){
        var date = new Date()

        // padStart(2, "0") pour que le format tien toujour sur deux chiffres(01, 00, 08)
        var y = String(date.getFullYear()).padStart(2, "0")
        var m = String(date.getMonth() + 1).padStart(2, "0")
        var d = String(date.getDate()).padStart(2, "0")

        return `${y}/${m}/${d}`
    },

    async import_key(k){
        const key = new TextEncoder().encode(k)
        var keyData

        if (key.length > 32) {
            keyData = key.slice(0, 32)
        } else {
            keyData = new Uint8Array(32)
            keyData.set(key)
        }

        return await window.crypto.subtle.importKey(
            "raw",
            keyData,
            {name: "AES-GCM"},
            false,
            ["encrypt", "decrypt"]
        )
    },

    async generate_key(){
        return await window.crypto.subtle.generateKey(
            {
                name: "AES-GCM",
                length: 256,
            },
            true,
            ["encrypt", "decrypt"]
        )
    },

    async encrypt(data, key){

        const iv = window.crypto.getRandomValues(new Uint8Array(12)) // initialisation du vecteur
        const encode = new TextEncoder().encode(data)
        const encryptData = await window.crypto.subtle.encrypt(
            {
                name: "AES-GCM",
                iv: iv
            },
            await this.import_key(key), 
            encode
        )

        return JSON.stringify({"encrypt": Array.from(new Uint8Array(encryptData)), "iv": Array.from(iv)})
    },

    async decrypt(encryptData, iv, key){
        const decryptData = await window.crypto.subtle.decrypt(
            {
                name: "AES-GCM",
                iv: iv
            },
            await this.import_key(key),
            encryptData
        )
        
        return new TextDecoder().decode(decryptData)
    },

    add_attribute(tableau, new_key, new_val){
        
        for (let i = 0; i < tableau.length; i++) {
            const list = tableau[i]["user"]

            list[new_key] = new_val
        }
       
        return tableau
    },

    change_val_att(tableau, test_key, test_val, change_key, new_val){
        
        for (let i = 0; i < tableau.length; i++) {
            const list = tableau[i]["user"];

            if(list[test_key] == test_val){
                list[change_key] = new_val
            }
        }
        
        return tableau
    },

    async get_storage(key){
        var data = localStorage.getItem(key)
                
        if (data) {
            var json = JSON.parse(data)
            var d = await this.decrypt(new Uint8Array(json.encrypt),
                                        new Uint8Array(json.iv), store.state.cles)

            return JSON.parse(d)
        }

        return null
    },

    async set_storage(data, key){
        const encode = await this.encrypt(JSON.stringify(data), store.state.cles)
        localStorage.setItem(key, encode)
    }
}
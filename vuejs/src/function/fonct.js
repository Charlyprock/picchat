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

    close_translate(class_elm, duration=1000, direction="left"){

        var element = document.querySelector(`.${class_elm}`)

        var dir = -1
        var val_x = 100
        var val_y = 0

        setTimeout(() => {
            element.style.display = "none"
        }, duration + 5);

        element.style.transition = `${duration}ms`

        if (direction == "top") {
            dir = -1
            val_x = 0
            val_y = 100
        } else if(direction == "rigth"){
            dir = 1
            val_x = 100
            val_y = 0
        } else if(direction == "bottom"){
            dir = 1
            val_x = 0
            val_y = 100
        }

        element.style.transform = "translate("+ (dir * val_x) +"%, "+ (dir * val_y) +"%)"

    },

    open_translate(class_elm, duration=1000, display="block"){

        var element = document.querySelector(`.${class_elm}`)

        setTimeout(() => {
            element.style.transition = `${duration}ms`
            element.style.transform = "translate(0,0)"
        }, 10);

        element.style.display = display

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
    }
}
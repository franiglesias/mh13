/**
 * Created by miralba on 15/6/17.
 */



var imageSlider = {
    props: [
        'context',
        'alias'
    ],
    data: function () {
        return {
            images: [],
            currentNumber: 0,
            timer: null,
            baseurl: '/api/images',
        }
    },
    created: function () {
        this.getFiles();
        this.startRotation();
    },
    methods: {
        startRotation: function () {
            this.timer = setInterval(this.next, 3000);
        },

        stopRotation: function () {
            clearTimeout(this.timer);
            this.timer = null;
        },

        next: function () {

            this.currentNumber += 1;
            if (this.currentNumber === this.images.length) {
                this.currentNumber = 0;
            }
        },
        prev: function () {
            this.currentNumber -= 1;
            if (this.currentNumber < 0) {
                this.currentNumber = this.images.length - 1;
            }
        },
        getFiles: function () {
            self = this;
            axios.get(this.baseurl, {
                params: {
                    context: this.context,
                    alias: this.alias
                }
            })
                .then(
                    function (response) {
                        self.images = response.data;

                    })
                .catch(
                    function (error) {
                    }
                );
        }

    },
    template: `
        <div class="slideshow" v-if="images.length">
        <p class="navigation">
            <a @click="prev">◀︎</a><a @click="next">▶︎</a>
        </p>
        <transition name="fade">
        <img :src="images[currentNumber].path" v-on:mouseover="stopRotation" v-on:mouseout="startRotation" :key="images[currentNumber].id"/>
        </transition>
        </div>
        <div v-else>No hay imágenes</div>
    `
};

var articleImages = new Vue({
    el: '#mh-images',
    components: {
        'image-slider': imageSlider
    }
});

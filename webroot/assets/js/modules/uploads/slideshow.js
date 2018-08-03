'use strict';

/**
 * Created by miralba on 15/6/17.
 */

var imageSlider = {
    props: ['context', 'alias'],
    data: function data() {
        return {
            images: [],
            currentNumber: 0,
            timer: null,
            baseurl: '/api/images'
        };
    },
    created: function created() {
        this.getFiles();
        this.startRotation();
    },
    methods: {
        startRotation: function startRotation() {
            this.timer = setInterval(this.next, 3000);
        },

        stopRotation: function stopRotation() {
            clearTimeout(this.timer);
            this.timer = null;
        },

        next: function next() {

            this.currentNumber += 1;
            if (this.currentNumber === this.images.length) {
                this.currentNumber = 0;
            }
        },
        prev: function prev() {
            this.currentNumber -= 1;
            if (this.currentNumber < 0) {
                this.currentNumber = this.images.length - 1;
            }
        },
        getFiles: function getFiles() {
            self = this;
            axios.get(this.baseurl, {
                params: {
                    context: this.context,
                    alias: this.alias
                }
            }).then(function (response) {
                self.images = response.data;
            }).catch(function (error) {});
        }

    },
    template: '\n        <div class="slideshow" v-if="images.length">\n        <p class="navigation">\n            <a @click="prev">\u25C0\uFE0E</a><a @click="next">\u25B6\uFE0E</a>\n        </p>\n        <transition name="fade">\n        <img :src="images[currentNumber].path" v-on:mouseover="stopRotation" v-on:mouseout="startRotation" :key="images[currentNumber].id"/>\n        </transition>\n        </div>\n        <div v-else>No hay im\xE1genes</div>\n    '
};

var articleImages = new Vue({
    el: '#mh-images',
    components: {
        'image-slider': imageSlider
    }
});
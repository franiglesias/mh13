'use strict';

/**
 * Created by miralba on 15/6/17.
 */

var ImageItem = {
    props: ['image'],

    template: '\n    <div :data-img="image.path">\n        <p class="photocaption"><strong>{{ image.name }}</strong></p>\n    </div>\n    '

};

var ImagesCollection = {
    props: ['context', 'alias'],
    components: {
        'image-item': ImageItem,
        'vue-images': vueImages.default
    },
    data: function data() {
        return {
            images: [],
            baseurl: '/api/images'
        };
    },
    methods: {
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
    created: function created() {
        this.getFiles();
    },
    template: '\n        <vue-images :imgs="images" :showclosebutton="true" :showimagecount="true" imagecountseparator=" de " :modalclose="true" :showcaption="true"></vue-images>\n    '

};

var images = new Vue({
    el: '#mh-images',
    components: {
        'images-collection': ImagesCollection
    }
});
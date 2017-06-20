/**
 * Created by miralba on 15/6/17.
 */


var ImageItem = {
    props: ['image'],

    template: `
    <div :data-img="image.path">
        <p class="photocaption"><strong>{{ image.name }}</strong></p>
    </div>
    `

};

var ImagesCollection = {
    props: [
        'context',
        'alias'
    ],
    components: {
        'image-item': ImageItem,
        'vue-images': vueImages.default
    },
    data: function () {
        return {
            images: [],
            baseurl: '/api/images',
        }
    },
    methods: {
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
    created: function () {
        this.getFiles();
    },
    template: `
        <vue-images :imgs="images" :showclosebutton="true" :showimagecount="true" imagecountseparator=" de " :modalclose="true" :showcaption="true"></vue-images>
    `


};


var images = new Vue({
    el: '#mh-images',
    components: {
        'images-collection': ImagesCollection
    }
});

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
        'image-item': ImageItem
    },
    data: function () {
        return {
            images: [],
            baseurl: '/api/images',
        }
    },
    methods: {
        getFiles: function () {
            this.$http.get(this.baseurl, {
                params: {
                    context: this.context,
                    alias: this.alias
                }
            }).then(
                function (response) {
                    this.images = response.body;
                },
                function (response) {
                }
            );
        }
    },
    created: function () {
        this.getFiles();
    },
    template: `
    <div class="fotorama" data-nav="thumbs" data-allowfullscreen="native">
        <image-item v-for="image in images" :image="image" :key="image.id"></image-item>     
    </div>    
    `


};


var images = new Vue({
    el: '#mh-images',
    components: {
        'images-collection': ImagesCollection
    }
});

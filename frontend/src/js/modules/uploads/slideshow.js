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
        <vue-images :imgs="images"></vue-images>
    `


};


var images = new Vue({
    el: 'image-slider',
    name: 'image-slider',
    data: {
        images: [
            {path: '/img/Item/588b6807-1a38-4c0d-bda7-c56bac100002/dsc01598.JPG'},
            {path: '/img/Item/588b6807-1a38-4c0d-bda7-c56bac100002/dsc01660.JPG'},
            {path: '/img/Item/588b6807-1a38-4c0d-bda7-c56bac100002/dsc01626.JPG'},
            {path: '/img/Item/588b6807-1a38-4c0d-bda7-c56bac100002/dsc01621.JPG'},
        ],
        currentNumber: 0,
        timer: null
    },
    created: function () {
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
            if (this.currentNumber == this.images.length) {
                this.currentNumber = 0;
            }
        },
        prev: function () {
            this.currentNumber -= 1;
            if (this.currentNumber < 0) {
                this.currentNumber = this.images.length - 1;
            }
        }
    }
});

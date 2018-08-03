'use strict';

/**
 * Created by miralba on 7/6/17.
 */

var Circular = {
    props: ['date', 'label', 'addressee', 'id'],
    computed: {
        shortDate: function shortDate() {
            var theDate = new Date(this.date);
            return theDate.getDate() + '/' + (theDate.getMonth() + 1);
        },
        url: function url() {
            return '/circulars/view/' + this.id;
        }

    },
    template: '\n        <li>\n            <p class="date prefix">{{ shortDate }}</p>\n            <p class="linked"><a :href="url">{{ label }}</a></p>\n            <p class="description">{{ addressee }}</p>\n        </li>\n    '
};

var nextCirculars = new Vue({
    el: '#mh-next-circulars',
    template: '\n        <ul class="mh-vertical-navigation-list">\n              <circular :id="circular.id" :date="circular.pubDate" :label="circular.type + \': \' + circular.title"\n                              :addressee="circular.addressee" v-for="circular in circulars" :key="circular.id"></circular>\n \n        </ul>\n    ',

    components: {
        'circular': Circular

    },
    data: {
        circulars: []
    },
    created: function created() {
        this.load();
        this.timer = setInterval(this.load, 300000);
    },
    methods: {
        load: function load() {
            this.$http.get('/api/circulars').then(function (response) {
                this.circulars = response.body;
            }, function (response) {
                this.circulars = false;
            });
        }
    }
});
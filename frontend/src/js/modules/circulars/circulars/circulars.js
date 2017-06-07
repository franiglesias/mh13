/**
 * Created by miralba on 7/6/17.
 */

var Circular = {
    props: [
        'date',
        'label',
        'addressee',
        'id'
    ],
    computed: {
        shortDate: function () {
            var theDate = new Date(this.date);
            return theDate.getDate() + '/' + (theDate.getMonth() + 1);
        },
        url: function () {
            return '/circulars/view/' + this.id;
        }

    },
    template: `
        <li>
            <p class="date prefix">{{ shortDate }}</p>
            <p class="linked"><a :href="url">{{ label }}</a></p>
            <p class="description">{{ addressee }}</p>
        </li>
    `
};

var nextCirculars = new Vue({
    el: '#mh-next-circulars',
    template: `
        <ul class="mh-vertical-navigation-list">
              <circular :id="circular.id" :date="circular.pubDate" :label="circular.type + ': ' + circular.title"
                              :addressee="circular.addressee" v-for="circular in circulars"></circular>
 
        </ul>
    `,

    components: {
        'circular': Circular

    },
    data: {
        circulars: []
    },
    created: function () {
        this.load();
        this.timer = setInterval(this.load, 300000)
    },
    methods: {
        load() {
            this.$http.get('/api/circulars').then(function (response) {
                this.circulars = response.body;
            }, function (response) {
                this.circulars = false;
            })

        }
    }
});

'use strict';

/**
 * Created by miralba on 7/6/17.
 */

Date.prototype.isToday = function () {
    var today = new Date();
    return today.getDate() == this.getDate() && today.getMonth() == this.getMonth() && today.getFullYear() == this.getFullYear();
};

Date.prototype.daysFromNow = function () {
    var milisecsPerDay = 3600 * 24 * 1000;
    var today = new Date();
    var difference = this.getTime() - today.getTime();
    return Math.round(Math.abs(difference) / milisecsPerDay);
};

var Event = {
    props: ['date', 'label', 'id'],
    computed: {
        shortDate: function shortDate() {
            var theDate = new Date(this.date);
            if (theDate.isToday()) {
                return 'Hoy';
            }
            var day = theDate.getDate();
            var month = theDate.getMonth() + 1;

            return day + "/" + month;
        },
        daysTo: function daysTo() {
            var theDate = new Date(this.date);
            var days = theDate.daysFromNow();

            return days > 1 ? 'Dentro de ' + days + ' días.' : days == 1 ? 'Mañana' : 'Hoy';
        }

    },
    template: '\n        <li>\n            <p class="date prefix">{{ shortDate }}</p>\n            <p class="linked">{{ label }}</p>\n            <p class="description">{{ daysTo }}</p>\n        </li>\n    '
};

var nextEvents = new Vue({
    el: '#mh-next-events',
    template: '\n           <ul class="mh-vertical-navigation-list">\n               <event :id="event.id" :date="event.startDate" :label="event.title" v-for="event in events" :key="event.id"></event>\n           </ul>\n    ',
    components: {
        'event': Event

    },
    data: {
        events: []
    },
    created: function created() {
        this.load();
        this.timer = setInterval(this.load, 300000);
    },
    methods: {
        load: function load() {
            this.$http.get('/api/events').then(function (response) {
                this.events = response.body;
            }, function (response) {
                this.events = false;
            });
        }
    }
});
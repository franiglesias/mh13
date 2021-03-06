'use strict';

/**
 * Created by miralba on 12/6/17.
 */

var publicblogs = new Vue({
    el: '#mh-public-blogs',
    data: {
        blogs: '',
        url: '/api/blogs'
    },
    created: function created() {
        this.getBlogs();
    },
    methods: {
        getBlogs: function getBlogs() {
            this.$http.get(this.url).then(function (response) {
                this.blogs = response.body;
            }, function () {});
        }
    },
    template: '\n<div class="blogsList small-up-1 medium-up-4 large-up-6 row">\n    <div class="column" key="blog.id" v-for="blog in blogs">\n      <a :href="\'/blog/\' + blog.slug">\n        <div  class="media-object button">\n                <div class="media-object-section align-self-center" v-if="blog.icon">\n                    <img :src="blog.icon" :alt="blog.title" width="32"/>\n                </div>\n            <div class="media-object-section main-section text-left">{{ blog.title }}</div>\n        </div>\n      </a>\n    </div>\n</div>\n'

});
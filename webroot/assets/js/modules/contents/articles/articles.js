'use strict';

/**
 * Created by miralba on 7/6/17.
 */

function parse_link_header(header) {
    var parts = header.split(',');
    var links = {};
    for (var i = 0; i < parts.length; i++) {
        var section = parts[i].split(';');
        var url = section[0].replace(/<([^>]+)>/, '$1').trim();
        var name = section[1].replace(/rel=\"([^\"]+)\"/, '$1').trim();
        links[name] = url;
    }
    return links;
}

Vue.component('pagination-bar', {
    props: ['currentPage', 'maxPages'],
    template: '\n     <div class="button-group secondary expanded">\n        <span class="white button">P\xE1gina {{ currentPage }} de {{ maxPages }} </span>\n        <button class="button" v-on:click="firstPage" v-bind:disabled="currentPage == 1">Portada</button>\n        <button class="button" v-on:click="prevPage" v-bind:disabled="currentPage == 1">M\xE1s recientes</button>\n        <button class="button" v-on:click="nextPage" v-bind:disabled="currentPage == maxPages">M\xE1s antiguas</button>\n     </div>\n    ',

    methods: {
        firstPage: function firstPage() {
            this.$emit('first-page-requested');
        },
        nextPage: function nextPage() {
            this.$emit('next-page-requested');
        },
        prevPage: function prevPage() {
            this.$emit('prev-page-requested');
        }
    }

});

var ArticleImage = {
    props: ['path'],
    computed: {
        imageUrl: function imageUrl() {
            return 'url(' + this.path + ')';
        }
    },
    template: '\n        <div class="media-object-section" v-if="path">\n            <div class="mh-image-crop large" v-bind:style="{ backgroundImage: imageUrl }"></div>\n        </div>\n    '
};

var BlogLink = {
    props: ['blog', 'alias'],
    computed: {
        blogUrl: function blogUrl() {
            return '/blog/' + this.alias;
        }
    },
    template: '\n        <span class="channel right">\n            <a v-bind:href="blogUrl">{{ blog }}</a>\n        </span>\n    '
};

Vue.component('article-abstract', {
    props: ['image', 'slug', 'title', 'abstract', 'blogTitle', 'blogSlug', 'pubDate'],
    components: {
        'article-image': ArticleImage,
        'blog-link': BlogLink
    },
    computed: {
        articleUrl: function articleUrl() {
            return '/' + this.slug;
        },
        date: function date() {
            var publicationDate = new Date(this.pubDate.split(" ", 1));
            return publicationDate.getDate() + '/' + (publicationDate.getMonth() + 1) + '/' + publicationDate.getFullYear();
        },
        blogUrl: function blogUrl() {
            return '/blog/' + this.blogSlug;
        }
    },
    template: '\n    <article class="media-object">\n        <article-image v-bind:path="image"></article-image>\n        <div class="media-object-section main-section">\n            <h2><span class="blog"><a :href="blogUrl">{{ blogTitle }}</a>: </span><a :href="articleUrl">{{ title }}</a></h2>\n            <p><span class="date">{{ date }}</span> {{ abstract }}</p>\n            <p><a :href="articleUrl" class="button secondary small">Leer m\xE1s</a></p>\n        </div>\n    </article>\n    '

});

Vue.component('article-list', {
    props: ['articles'],
    template: '\n        <div>\n            <article-abstract v-for="article in articles" :key="article.id" :image="article.image" :slug="article.slug" :title="article.title" :abstract="article.abstract" :blog-slug="article.blog_slug" :blog-title="article.blog_title" :pub-date="article.pubDate"></article-abstract>\n        </div>\n        '
});

Vue.component('articles-view', {
    props: ['element', 'url'],
    data: function data() {
        return {
            selector: this.element,
            articles: [],
            page: 1,
            maxPages: 0,
            links: [],
            remoteUrl: this.url,
            message: ''
        };
    },

    template: '\n        <div class="tabs-panel is-active" id="id">\n            <pagination-bar v-bind:current-page="page" v-bind:max-pages="maxPages" v-on:next-page-requested="getNextPage" v-on:first-page-requested="getFirstPage" v-on:prev-page-requested="getPrevPage"></pagination-bar>\n            <template v-if="articles">\n                <article-list :articles="articles"></article-list>\n            </template>\n            <template v-else>\n            <p>Tenemos un problema en el servidor.</p>\n            <p>{{ message }}</p>\n            </template>\n        </div>\n    ',
    created: function created() {
        this.getArticles(this.remoteUrl);
    },

    methods: {
        getArticles: function getArticles(url) {
            this.$http.get(url).then(function (response) {
                this.articles = response.body;
                this.page = response.headers.get('X-Current-Page');
                this.maxPages = response.headers.get('X-Max-Pages');
                this.links = parse_link_header(response.headers.get('Link'));
            }, function (response) {
                this.message = response.body['message'];
                this.articles = false;
            });
        },
        getNextPage: function getNextPage(event) {
            var url = this.links['rel=next'];
            this.getArticles(url);
        },
        getFirstPage: function getFirstPage(event) {
            var url = this.links['rel=first'];
            this.getArticles(url);
        },
        getPrevPage: function getPrevPage(event) {
            var url = this.links['rel=prev'];
            this.getArticles(url);
        }
    }
});

Vue.component('tabs-bar', {
    props: ['feeds'],
    template: '\n        <ul id="mh-home-page-tabs" class="tabs" data-tabs>\n            <li class="tabs-title" v-for="(feed, index) in feeds" :class="index == 0 ? \'is-active\' : \'\'" :key="feed.id">\n                <a :href="\'#\'+feed.id">{{ feed.title }}</a>\n            </li>\n        </ul>\n    '

});

Vue.component('tabs-content', {
    props: ['feeds'],
    template: '\n        <div class="tabs-content" data-tabs-content="mh-home-page-tabs">\n            <articles-view class="tabs-panel" \n                            :class="index == 0 ? \'is-active\' : \'\'" \n                            :id="feed.id" v-for="(feed, index) in feeds" \n                            :url="feed.url" :key="feed.id"></articles-view>\n        </div>\n    '
});

var app = new Vue({
    el: '#mh-tabbed-articles'
});
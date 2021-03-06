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
    props: [
        'currentPage',
        'maxPages'
    ],
    template: `
     <div class="button-group secondary expanded">
        <span class="white button">Página {{ currentPage }} de {{ maxPages }} </span>
        <button class="button" v-on:click="firstPage" v-bind:disabled="currentPage == 1">Portada</button>
        <button class="button" v-on:click="prevPage" v-bind:disabled="currentPage == 1">Más recientes</button>
        <button class="button" v-on:click="nextPage" v-bind:disabled="currentPage == maxPages">Más antiguas</button>
     </div>
    `,


    methods: {
        firstPage: function () {
            this.$emit('first-page-requested')
        },
        nextPage: function () {
            this.$emit('next-page-requested')
        },
        prevPage: function () {
            this.$emit('prev-page-requested')
        }
    }

});

var ArticleImage = {
    props: [
        'path'
    ],
    computed: {
        imageUrl: function () {
            return 'url(' + this.path + ')';
        }
    },
    template: `
        <div class="media-object-section" v-if="path">
            <div class="mh-image-crop large" v-bind:style="{ backgroundImage: imageUrl }"></div>
        </div>
    `,
};

var BlogLink = {
    props: [
        'blog',
        'alias'
    ],
    computed: {
        blogUrl: function () {
            return '/blog/' + this.alias;
        }
    },
    template: `
        <span class="channel right">
            <a v-bind:href="blogUrl">{{ blog }}</a>
        </span>
    `
};

Vue.component('article-abstract', {
    props: [
        'image',
        'slug',
        'title',
        'abstract',
        'blogTitle',
        'blogSlug',
        'pubDate'
    ],
    components: {
        'article-image': ArticleImage,
        'blog-link': BlogLink
    },
    computed: {
        articleUrl: function () {
            return '/' + this.slug;
        },
        date: function () {
            var publicationDate = new Date(this.pubDate.split(" ", 1));
            return publicationDate.getDate() + '/' + (publicationDate.getMonth() + 1) + '/' + publicationDate.getFullYear();
        },
        blogUrl: function () {
            return '/blog/' + this.blogSlug;
        }
    },
    template: `
    <article class="media-object">
        <article-image v-bind:path="image"></article-image>
        <div class="media-object-section main-section">
            <h2><span class="blog"><a :href="blogUrl">{{ blogTitle }}</a>: </span><a :href="articleUrl">{{ title }}</a></h2>
            <p><span class="date">{{ date }}</span> {{ abstract }}</p>
            <p><a :href="articleUrl" class="button secondary small">Leer más</a></p>
        </div>
    </article>
    `


});

Vue.component('article-list', {
    props: ['articles'],
    template: `
        <div>
            <article-abstract v-for="article in articles" :key="article.id" :image="article.image" :slug="article.slug" :title="article.title" :abstract="article.abstract" :blog-slug="article.blog_slug" :blog-title="article.blog_title" :pub-date="article.pubDate"></article-abstract>
        </div>
        `
});

Vue.component('articles-view', {
    props: ['element', 'url'],
    data: function () {
        return {
            selector: this.element,
            articles: [],
            page: 1,
            maxPages: 0,
            links: [],
            remoteUrl: this.url,
            message: ''
        }
    },

    template: `
        <div class="tabs-panel is-active" id="id">
            <pagination-bar v-bind:current-page="page" v-bind:max-pages="maxPages" v-on:next-page-requested="getNextPage" v-on:first-page-requested="getFirstPage" v-on:prev-page-requested="getPrevPage"></pagination-bar>
            <template v-if="articles">
                <article-list :articles="articles"></article-list>
            </template>
            <template v-else>
            <p>Tenemos un problema en el servidor.</p>
            <p>{{ message }}</p>
            </template>
        </div>
    `,
    created: function () {
        this.getArticles(this.remoteUrl);
    },

    methods: {
        getArticles: function (url) {
            this.$http.get(url).then(function (response) {
                this.articles = response.body;
                this.page = response.headers.get('X-Current-Page');
                this.maxPages = response.headers.get('X-Max-Pages');
                this.links = parse_link_header(response.headers.get('Link'));
            }, function (response) {
                this.message = response.body['message'];
                this.articles = false;
            })
        },
        getNextPage: function (event) {
            var url = this.links['rel=next'];
            this.getArticles(url);
        },
        getFirstPage: function (event) {
            var url = this.links['rel=first'];
            this.getArticles(url);
        },
        getPrevPage: function (event) {
            var url = this.links['rel=prev'];
            this.getArticles(url);
        }
    }
});

Vue.component('tabs-bar', {
    props: ['feeds'],
    template: `
        <ul id="mh-home-page-tabs" class="tabs" data-tabs>
            <li class="tabs-title" v-for="(feed, index) in feeds" :class="index == 0 ? 'is-active' : ''" :key="feed.id">
                <a :href="'#'+feed.id">{{ feed.title }}</a>
            </li>
        </ul>
    `,

});

Vue.component('tabs-content', {
    props: ['feeds'],
    template: `
        <div class="tabs-content" data-tabs-content="mh-home-page-tabs">
            <articles-view class="tabs-panel" 
                            :class="index == 0 ? 'is-active' : ''" 
                            :id="feed.id" v-for="(feed, index) in feeds" 
                            :url="feed.url" :key="feed.id"></articles-view>
        </div>
    `
})

var app = new Vue({
    el: '#mh-tabbed-articles',
});

/**
 * Created by miralba on 12/6/17.
 */

var publicblogs = new Vue({
    el: '#mh-public-blogs',
    data: {
        blogs: '',
        url: '/contents/channels/external'
    },
    created: function () {
        this.getBlogs();
    },
    methods: {
        getBlogs: function () {
            this.$http.get(this.url).then(function (response) {
                this.blogs = response.body;
            }, function () {

            });
        }
    },
    template: `
<div class="blogsList small-up-1 medium-up-4 large-up-6 row">
<div class="column" key="blog.id" v-for="blog in blogs">
    <a :href="'/blog/' + blog.slug">
        <div  class="media-object button">
                <div class="media-object-section align-self-center" v-if="blog.icon">
                    <img :src="blog.icon" :alt="blog.title" width="32"/>
                </div>
            <div class="media-object-section main-section text-left">{{ blog.title }}</div>
        </div>
    </a>
</div>
</div>
`

});

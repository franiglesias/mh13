/**
 * Created by miralba on 15/6/17.
 */

var downloads = new Vue({
    el: 'mh-downloads',
    data: {
        files: '',
        url: '/api/downloads',
    },
    created: function () {
        this.getFiles();
    },
    methods: {
        getFiles: function () {
            this.$http.get(this.url).then(function (response) {
                this.blogs = response.body;
            }, function () {

            });
        }
    },
    template: `
        
        <div class="column" v-for="file in files" :key="file.id">
            <a :href="file.path" class="mh-download-button">
                <div class="card">
                    <div class="card-section">
                        <p class="mh-download-name"><strong>{{ file.name }}</strong></p>    
                    </div>
                    <div class="card-divider">
                        <p class="clearfix">
                            <small class="float-left">{{ file.size }}</small>
                            <small class="float-left">{{ file.type }}</small>
                        </p>
                    </div>
                </div>
            </a>
        </div>
    
    `
});

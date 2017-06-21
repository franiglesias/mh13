/**
 * Created by miralba on 15/6/17.
 */

function humanFileSize(size) {
    var convert = ['B', 'KB', 'MB', 'GB'];
    for (var i = convert.length; i >= 0; i--) {
        var limit = Math.pow(2, i * 10);
        if (size >= limit) {
            return (size / limit).toFixed(2) + ' ' + convert[i];
        }
    }
}

var DownloadItem = {
    props: ['file'],
    computed: {
        humanizedFileSize: function () {
            return humanFileSize(this.file.size);
        }
    },
    template: `
        <a :href="file.path" class="mh-download-button column">
            <div class="card">
                <div class="card-section">
                    <p class="mh-download-name"><strong>{{ file.name }}</strong></p>    
                </div>
                <div class="card-divider">
                    <p class="clearfix">
                        <small class="float-left">{{ humanizedFileSize }}</small>
                        <small class="float-left">{{ file.type }}</small>   
                    </p>
                </div>
            </div>
        </a>
    `

};

var DownloadsCollection = {
    props: [
        'context',
        'alias'
    ],
    components: {
        'download-item': DownloadItem
    },
    data: function () {
        return {
            files: [],
            baseurl: '/api/downloads',
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
                    this.files = response.body;
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
    <div class="small-up-2 large-up-4 row" v-if="files.length">
        <download-item v-for="file in files" :file="file" :key="file.id"></download-item>     
    </div>    
    <div v-else="">No hay elementos para descargar.</div>
    `


};

var downloads = new Vue({
    el: '#mh-downloads',
    components: {
        'downloads-collection': DownloadsCollection
    }
});

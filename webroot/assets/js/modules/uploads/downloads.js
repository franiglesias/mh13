'use strict';

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
        humanizedFileSize: function humanizedFileSize() {
            return humanFileSize(this.file.size);
        }
    },
    template: '\n        <a :href="file.path" class="mh-download-button column">\n            <div class="card">\n                <div class="card-section">\n                    <p class="mh-download-name"><strong>{{ file.name }}</strong></p>    \n                </div>\n                <div class="card-divider">\n                    <p class="clearfix">\n                        <small class="float-left">{{ humanizedFileSize }}</small>\n                        <small class="float-left">{{ file.type }}</small>   \n                    </p>\n                </div>\n            </div>\n        </a>\n    '

};

var DownloadsCollection = {
    props: ['context', 'alias'],
    components: {
        'download-item': DownloadItem
    },
    data: function data() {
        return {
            files: [],
            baseurl: '/api/downloads'
        };
    },
    methods: {
        getFiles: function getFiles() {
            this.$http.get(this.baseurl, {
                params: {
                    context: this.context,
                    alias: this.alias
                }
            }).then(function (response) {
                this.files = response.body;
            }, function (response) {});
        }
    },
    created: function created() {
        this.getFiles();
    },
    template: '\n    <div class="small-up-2 large-up-4 row" v-if="files.length">\n        <download-item v-for="file in files" :file="file" :key="file.id"></download-item>     \n    </div>    \n    <div v-else="">No hay elementos para descargar.</div>\n    '

};

var downloads = new Vue({
    el: '#mh-downloads',
    components: {
        'downloads-collection': DownloadsCollection
    }
});
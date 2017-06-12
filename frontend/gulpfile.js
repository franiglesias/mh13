// Gulp components
var gulp = require("gulp");
var cssnano = require("gulp-cssnano");
var sass = require("gulp-sass");
var rename = require("gulp-rename");
var newer = require("gulp-newer");
var babel = require("gulp-babel");
var uglify = require("gulp-uglify");
var sherpa = require("style-sherpa");
var jquery = require("gulp-jquery");
// Paths
var destination = "../webroot/assets";

// Sources
var sassSource = "src/scss/**/*.scss";
var jsVendorSource = "src/js/vendor";
var jsxSource = "src/js/**/*.jsx";
var jsSource = ["src/js/**/*.js", "!src/js/foundation/*.js", "!src/js/jqueryte/**.*"];
var htmlSource = "src/**/*.html";
var imgSource = ["src/img/**/*.jpg", "src/img/**/*.png"];


var foundationSrc = [
    "node_modules/foundation-sites/dist/js/foundation.js",
    "node_modules/foundation-sites/dist/js/plugins/foundation.util.motion.js",
    "node_modules/foundation-sites/dist/js/plugins/foundation.util.triggers.js",
    "node_modules/foundation-sites/vendor/jquery/dist/jquery.js"
];

var vueSrc = [
    "node_modules/vue/dist/vue.js",
    "node_modules/vue-resource/dist/vue-resource.js",
    "node_modules/vue/dist/vue.min.js",
    "node_modules/vue-resource/dist/vue-resource.min.js"
];

// Tasks

gulp.task("default", [
    "sass",
    "scripts",
    "styleguide",
    "html",
    "watch"
]);

gulp.task("update", [
    "copy-foundation",
    "copy-foundation-icons",
    "copy-images",
    "copy-jquery-te",
    "copy-vue",
    "default"
]);

gulp.task("watch", function () {
    gulp.watch(jsxSource, ["compile-jsx"]);
    gulp.watch(jsSource, ["scripts"]);
    gulp.watch(sassSource, ["sass"]);
    gulp.watch([
        "src/style/index.md", "src/style/template.hbs"
    ], ["styleguide"]);
    gulp.watch(htmlSource, ["html"]);
    gulp.watch(imgSource, ["copy-images"]);
});

// SASS compile to CSS
gulp.task("sass", function () {
    gulp.src(sassSource)
        .pipe(sass({
            style: "expanded"
        }))
        .pipe(gulp.dest(destination + "/css"))
        .pipe(rename({
            suffix: ".min"
        }))
        .pipe(cssnano())
        .pipe(gulp.dest(destination + "/css"))
});

gulp.task("copy-images", function () {
    gulp.src(imgSource)
        .pipe(newer(destination + "/img"))
        .pipe(gulp.dest(destination + "/img"))
});


gulp.task("copy-foundation-icons", function () {
    gulp.src(["src/foundation-icons/**/*"])
        .pipe(newer(destination + "/css"))
        .pipe(gulp.dest(destination + "/css"))
});


// Javascript



gulp.task("copy-foundation", function () {
    gulp.src(foundationSrc)
        .pipe(gulp.dest(jsVendorSource))
});

gulp.task("copy-vue", function () {
    gulp.src(vueSrc)
        .pipe(gulp.dest(destination + "/js/vendor"))
});

gulp.task("copy-jquery-te", function () {
    gulp.src("src/js/jqueryte/*.*")
        .pipe(gulp.dest(destination + "/js"))
});


gulp.task("scripts", function () {
    gulp.src(jsSource)
        .pipe(babel({
            presets: ["es2015"]
        }))
        .pipe(gulp.dest(destination + "/js"))
        .pipe(rename({
            suffix: ".min"
        }))
        .pipe(uglify())
        .pipe(gulp.dest(destination + "/js"));
});

gulp.task("styleguide", function () {
    sherpa("src/style/index.md", {
        output: "src/style.html",
        template: "src/style/template.hbs"
    });
});

gulp.task("html", function () {
    gulp.src(htmlSource)
        .pipe(gulp.dest(destination))
});

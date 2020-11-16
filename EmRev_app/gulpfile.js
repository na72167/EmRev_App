// 環境変数
const setting = {
    scss: {
        watch: "./dev/scss/*/*.scss",
        src: "./dev/scss/*.scss",
        dest: "./root/css"
    }
};

const gulp = require("gulp");

// SCSSプラグインの読み込み
var sass = require("gulp-sass");
// SCSSをまとめて読み込むプラグインの読み込み
var sassGlob = require("gulp-sass-glob");

// SCSSをCSSに変換するタスクを作成
gulp.task("scss", () => {
    return (
        gulp
            // 変換対象のファイル
            .src(setting.scss.src)
            //SCSSをまとめ読み込むことを許可する
            .pipe(sassGlob())
            //SCSS → CSS変換
            .pipe(sass())
            //CSSを出力（保存）
            .pipe(gulp.dest(setting.scss.dest))
    );
});

// ファイルの変更を監視してタスク実行
gulp.task("watch", () => {
    gulp.watch(setting.scss.watch, gulp.series("scss"));
});

// gulp起動時に実行するタスク
gulp.task("default", gulp.series("watch"));

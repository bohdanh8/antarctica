module.exports = {
    // The absolute path of the WordPress themes folder (Ex: /Users/name/Sites/wordpress-starter/wp-content/themes Or C:\\Users\\name\\Sites\\wordpress-starter\\wp-content\\themes). All the theme files will be automatically copies over to this folder upon running the "dev" or "build" scripts.
    themePath: '/Users/kaveengoonawardane/Sites/wordpress-starter/wp-content/themes',

    // Setting this to true will transfer the theme files to the staging server *.lnx.prosekbeta.com when you do a 'git push'. You need to do a 'npm run build' for this to have any effect.

    uploadToStaging: true,

    // Choose to enable or disable BrowserSync in your dev environment (if set to true, browsersyncProxy value must be a valid URL)
    browsersyncEnabled: false,

    // The host:port is where you will access the "live reloading" version of your local site (populates BrowserSyncPlugin host/port/proxy values in ./webpack.config.dev.js)
    browsersyncHost: 'localhost',
    browsersyncPort: 3333,
    browsersyncProxy: 'http://wpstarter.local', // This is your local site's URL
};

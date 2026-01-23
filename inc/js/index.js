// *** DO NOT EDIT ***

// Import function
function importAll(r) {
    return r.keys().map(r);
}

// Import all the images
const images = importAll(require.context('../../src/images', false, /\.(png|svg|jpg|jpeg|gif)$/i));

// Import all CSS
const css = importAll(require.context('../../src/css', false));

// Import all JS except files ending with .localize.js or .localized.js (a separate entry is made in webpack.config.common to handle scripts specified for use with wp_localize_script)
const js = importAll(require.context(
  '../../src/js',
  false,
  /^(?!.*(?:localize|localized)).*\.js$/
));

async function main() {
    const uikit = require('uikit');
    const icons = require('uikit/dist/js/uikit-icons');

    uikit.use(icons);

    require('axios');
    require('hammerjs');

    require('./app');
}

window.addEventListener("DOMContentLoaded", main);

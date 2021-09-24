async function main() {
    require('axios');
    require('hammerjs');

    require('./app');
}

async function registerWorker() {
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/worker.js').then(null, function(err) {
            console.log('ServiceWorker registration failed: ', err);
        });
    }
}

window.addEventListener('load', registerWorker);
window.addEventListener('DOMContentLoaded', main);

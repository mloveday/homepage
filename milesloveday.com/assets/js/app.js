import Vue from 'vue';
import TurbolinksAdapter from 'vue-turbolinks';
Vue.use(TurbolinksAdapter);

require('../css/app.scss');

document.addEventListener('turbolinks:load', () => {
    var app = new Vue({
        el: '#app',
        data: {
            showingNav: false
        },
        methods: {
            toggleNav: function() { this.showingNav = !this.showingNav; }
        },
        delimiters: ['${', '}'],
    });
});

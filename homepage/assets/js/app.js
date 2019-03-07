import Vue from 'vue';

var app = new Vue({
    el: '#app',
    data: {
        showingNav: false
    },
    methods: {
        toggleNav: function() { this.showingNav = !this.showingNav; }
    },
    delimiters: ['${', '}']
});

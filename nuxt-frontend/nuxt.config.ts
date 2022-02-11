import { defineNuxtConfig } from 'nuxt3'
import { resolve } from 'pathe'

// https://v3.nuxtjs.org/docs/directory-structure/nuxt.config
export default defineNuxtConfig({
    modules: [
        // Using package name
        // '@nuxtjs/axios',
    ],
    buildModules: [
        '@pinia/nuxt',
    ],
    alias: {
        '@': resolve(__dirname),
        '~': resolve(__dirname),
    },
    css: ['~/assets/css/tailwind.css'],
    vite: {
        server: {
            hmr: false
        }
    },
    build: {
        postcss: {
            // add Postcss options
            postcssOptions: require('./postcss.config.js'),
        },
    },
    // Restart server when these change
    // watch: ['~/postcss.config.js', '~/tailwind.config.js'],
})

//store.ts
import { defineStore, acceptHMRUpdate} from 'pinia'
import isEmpty from 'lodash/isEmpty';

export const useStore = defineStore('news', {
    // arrow function recommended for full type inference
    state: () => {
        return {
            // all these properties will have their type inferred automatically
            news: {},
            total: 0,
            filters: {},
            last_page: 0,
            per_page: 0,
            has_pages: false,
        }
    },

    getters:{
        getNews:(state)=>state.news,
        getTotal: (state)=> {
            state.total
        },
        getFilters: (state)=> {
            state.filters
        },
    },

    actions:{
        loadNews: function () {
            return useFetch('/api/news').then((res) => {
                const data = res.data.value;

                if(!isEmpty(data.news)) {
                    this.news = data.news
                }
                if(!isEmpty(data.total)) {
                    this.total = data.total
                }
                if(!isEmpty(data.filters)) {
                    this.filters = data.filters
                }
                if(!isEmpty(data.last_page)) {
                    this.last_page = data.last_page
                }
                if(!isEmpty(data.per_page)) {
                    this.per_page = data.per_page
                }
                if(!isEmpty(data.has_pages)) {
                    this.has_pages = data.has_pages
                }
            })
        },
    },
})

if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useStore, import.meta.hot))
}
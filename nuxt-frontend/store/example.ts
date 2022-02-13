//store.ts
import { defineStore, acceptHMRUpdate} from 'pinia'

export const useStore = defineStore('example', {
    // arrow function recommended for full type inference
    state: () => {
        return {
            // all these properties will have their type inferred automatically
            counter: 10,
            name: 'Eduardo',
            isAdmin: true,
        }
    },

    getters:{
        getCount:(state)=>state.counter,
        getUser: (state)=> {
            state.name
        }
    },

    actions:{
        hit(){
            this.counter++;
        }
    },
})

if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useStore, import.meta.hot))
}
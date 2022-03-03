import isEmpty from "lodash/isEmpty";
import isNumber from "lodash/isNumber";
import isBoolean from "lodash/isBoolean";
// @ts-ignore
import api from "@/api/index.js";
import { defineStore } from "pinia";
import apiClient from "@/http-common";

export const useStore = defineStore("news", {
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
      current_page: 1,
    };
  },

  getters: {
    getNews: (state) => state.news,
    getTotal: (state) => {
      state.total;
    },
    getFilters: (state) => {
      state.filters;
    },
  },

  actions: {
    loadNews: function (page) {
      return apiClient(api.getNews(page)).then((res) => {
        const data = res.data;
        if (!isEmpty(data.news)) {
          this.news = data.news;
        }
        if (!isEmpty(data.filters)) {
          this.filters = data.filters;
        }
        if (isNumber(data.total)) {
          this.total = data.total;
        }
        if (isNumber(data.last_page)) {
          this.last_page = data.last_page;
        }
        if (isNumber(data.per_page)) {
          this.per_page = data.per_page;
        }
        if (isBoolean(data.has_pages)) {
          this.has_pages = data.has_pages;
        }
        if (isNumber(data.current_page)) {
          this.current_page = data.current_page;
        }
      });
    },
    filterNews: function (params) {
      return apiClient(api.filterNews(params)).then((res) => {
        const data = res.data;

        if (!isEmpty(data.news)) {
          this.news = data.news;
        }
        if (!isEmpty(data.filters)) {
          this.filters = data.filters;
        }
        if (isNumber(data.total)) {
          this.total = data.total;
        }
      });
    }
  },
});

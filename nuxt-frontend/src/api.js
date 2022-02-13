class Api {
    get(path, data = {}, headers = {}, credentials = false) {
        const requestHeaders = headers || {};

        return {
            url             : path,
            params          : data,
            headers         : requestHeaders,
            withCredentials : credentials,
        };
    }

    getNews(limit = null, page = null) {
        return this.get('/api/news', {
            limit,
            page
        })
    }
}

const api = new Api();

export default api;
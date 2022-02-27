class Api {
  getNews(page = null, limit = null) {
    return this.get("/news", {
      limit,
      page,
    });
  }

  get(path, data = {}, headers = {}, credentials = false) {
    const requestHeaders = headers || {};

    return {
      url: path,
      params: data,
      headers: requestHeaders,
      withCredentials: credentials,
    };
  }

  post(path, data = {}, headers = {}, credentials = false) {
    const requestHeaders = headers || {};

    return {
      url: path,
      method: "post",
      data,
      headers: requestHeaders,
      withCredentials: credentials,
    };
  }
}

const api = new Api();

export default api;

// @ts-ignore
import axios, { AxiosInstance } from "axios";
const apiClient: AxiosInstance = axios.create({
    baseURL: "http://localhost/api",
    headers: {
        "Content-type": "application/json",
    },
});
export default apiClient;
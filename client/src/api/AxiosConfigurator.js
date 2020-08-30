import axios from "axios"

export default {
  configure() {
    axios.defaults.baseURL = process.env.VUE_APP_API_URL
    axios.defaults.headers.common["Content-Type"] = "application/json"
    axios.defaults.headers.common["Accept"] = "application/json"

    axios.interceptors.response.use(function (response) {
      return response
    }, function (error) {
      throw error
    })
  }
}

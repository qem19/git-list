import axios from "axios"

export default {
  index() {
    return axios.get('/repositories')
  },
  commits(repositoryId, page) {
    return axios.get(`/repositories/${repositoryId}`, { params: { page } })
  },
  sync(vendor, repository) {
    return axios.post('/repositories/sync', { vendor, repository })
  },
}

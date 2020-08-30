import axios from "axios"

export default {
  deleteByIds(commit_ids) {
    return axios.delete('/commits', { params: { commit_ids } })
  },
}

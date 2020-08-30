<template lang="pug">
  .commits(v-if="!loading")
    el-checkbox-group(v-model="form.commitIdsForDelete")
      el-row(v-for="commit in commits" :key="commit.id")
        el-checkbox(:label="commit.id") {{ commit.description }} - by {{ commit.author }} - {{ commit.sha }}
    el-pagination(
      :total="meta.total"
      :page-size="meta.per_page"
      :current-page="currentPage"
      layout="prev, pager, next"
      @current-change="changePage"
      )
    el-button(@click="deleteCommits" type="danger" v-if="form.commitIdsForDelete.length > 0") Delete
</template>

<script>
  import Repositories from "@/api/repositories"
  import Commits from "@/api/commits"

  export default {
    data() {
      return {
        commits: [],
        meta: null,
        currentPage: 1,
        form: {
          commitIdsForDelete: []
        },
        loading: true,
      }
    },
    async created() {
      this.fetchData()
    },
    methods: {
      async fetchData() {
        this.loading = true

        const response = (await Repositories.commits(this.$route.params.id, this.currentPage)).data

        this.commits = response.data
        this.meta = response.meta

        this.loading = false
      },
      changePage(newPage) {
        this.currentPage = newPage
        this.fetchData()
      },
      async deleteCommits() {
        const response = (await Commits.deleteByIds(this.form.commitIdsForDelete)).data

        if (response.status === "error") {
          this.$notify.error(response.data.message)
          return
        }

        this.fetchData()

        this.$notify.success("Commits were deleted")
      }
    }
  }
</script>

<style scoped>

</style>

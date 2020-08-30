<template lang="pug">
  .repositories
    el-row(v-for="repo in repositories" :key="repo.id")
      router-link(:to="{ name: 'repository', params: { id: repo.id } }") {{ repo.name }} ({{repo.vendor_name}})
      br
</template>

<script>
  import Repositories from "@/api/repositories"

  export default {
    data() {
      return {
        repositories: [],
      }
    },
    async created() {
      this.repositories = (await Repositories.index()).data.data
    }
  }
</script>

<style scoped>

</style>

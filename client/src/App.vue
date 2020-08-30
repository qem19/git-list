<template lang="pug">
  div(id="app")
    el-row
      el-col
        h1 {{ $route.meta.title }}
        el-row
            router-link(:to="{ name: 'index' }") Main
            span &nbsp; | &nbsp;
            router-link(:to="{ name: 'repositories' }") Repositories
        br
    el-row
      el-col
        router-view
</template>

<script>
  export default {}
</script>

<style>
</style>

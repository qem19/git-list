<template lang="pug">
  .index
    el-form(:inline="true" :model="form" :rules="rules" ref="repositoryForm")
      el-form-item(label="Vendor" prop="vendor")
        el-input(v-model="form.vendor")
      el-form-item(label="Repository" prop="repository")
        el-input(v-model="form.repository")
      el-button(@click="sync") Import
</template>

<script>
  import Repositories from "@/api/repositories"
  const requiredRule = { required: true, message: 'Please fill this field', trigger: 'blur' }

  export default {
    data() {
      return {
        form: {
          vendor: null,
          repository: null
        },
        rules: {
          vendor: requiredRule,
          repository: requiredRule,
        }
      }
    },
    methods: {
      sync() {
        this.$refs['repositoryForm'].validate((valid) => {
          if (valid) {
            this.send()
          } else {
            return false;
          }
        });
      },
      async send() {
        const response = await Repositories.sync(this.form.vendor, this.form.repository)

        if (response.data.status === "error") {
          this.$notify.error(response.data.message)
          return
        }

        this.$notify.success("Import has been started")
      }
    }
  }
</script>

<style scoped>

</style>

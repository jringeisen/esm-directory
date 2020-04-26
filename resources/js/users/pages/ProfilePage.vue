<template>
  <div class="card shadow">
    <div class="card-header">
      <div style="display: flex; justify-content: space-between; align-items: center;">
        <span>Profile</span>
      </div>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="d-flex col-md-4 align-items-center justify-content-center">
          <b-avatar
            v-if="!editAvatar"
            src="https://placekitten.com/300/300"
            size="8rem"
            button
            @click="editAvatar = !editAvatar"
          />
          <div
            class="d-flex flex-column"
            v-if="editAvatar"
          >
            <b-form-file
              v-model="formData.file"
              v-if="editAvatar"
              :state="Boolean(formData.file)"
              placeholder="Upload avatar."
              drop-placeholder="Drop file here..."
            /><br>
            <button
              class="btn btn-sm btn-danger"
              @click.prevent="editAvatar = !editAvatar"
            >
              Cancel
            </button>
          </div>
        </div>
        <div class="col-md-8">
          <div class="form-group">
            <label>Name</label>
            <input
              type="text"
              class="form-control"
              placeholder="Enter your name."
              v-model="formData.name"
            >
          </div>
          <div class="form-group">
            <label>Email</label>
            <input
              type="email"
              class="form-control"
              placeholder="Enter your email."
              v-model="formData.email"
            >
          </div>
          <button class="btn btn-secondary">
            Update
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ProfilePage',
  data () {
    return {
      formData: {},
      editAvatar: false
    }
  },
  mounted () {
    this.formData = this.$user
  }
}
</script>

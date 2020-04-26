<template>
  <b-modal
    id="modal-access-token"
    title="Personal Access Token"
    hide-footer
  >
    <p>
      Here is your new personal access token. This is the only time it will be shown so don't lose it!
      You may now use this token to make API requests.
    </p>
    <textarea
      class="form-control"
      rows="10"
      v-model="accessToken"
    />
  </b-modal>
</template>

<script>
export default {
  name: 'ViewAccessToken',
  data() {
    return {
      accessToken: null
    };
  },

  mounted() {
    this.$root.$on("setAccessToken", token => {
      this.accessToken = token;
    });
  }
};
</script>


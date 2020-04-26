<template>
  <b-modal
    @ok="store"
    title="Create Client"
    :id="$options.name"
  >
    <form role="form">
      <div class="form-group">
        <label class="col-form-label">Name</label>
        <input
          id="create-client-name"
          type="text"
          class="form-control"
          :class="{'is-invalid': formErrors.name}"
          @keyup="formErrors.name = ''"
          v-model="formData.name"
        >
        <div
          v-if="formErrors.name"
          class="invalid-feedback"
        >
          {{ formErrors.name[0] }}
        </div>
        <span
          class="form-text text-muted"
          v-if="!formErrors.name"
        >Something your users will recognize and trust.</span>
      </div>

      <div class="form-group">
        <label class="col-form-label">Redirect URL</label>
        <input
          type="text"
          class="form-control"
          :class="{'is-invalid': formErrors.redirect}"
          name="redirect"
          @keyup="formErrors.redirect = ''"
          v-model="formData.redirect"
        >
        <div
          v-if="formErrors.redirect"
          class="invalid-feedback"
        >
          {{ formErrors.redirect[0] }}
        </div>

        <span
          class="form-text text-muted"
          v-if="!formErrors.redirect"
        >Your application's authorization callback URL.</span>
      </div>

      <!-- Confidential -->
      <div class="form-group">
        <label class="col-form-label">Confidential</label>
        <div class="checkbox">
          <label>
            <input
              type="checkbox"
              v-model="formData.confidential"
            >
          </label>
        </div>

        <span
          class="form-text text-muted"
        >Require the client to authenticate with a secret. Confidential clients can hold credentials in a secure way without exposing them to unauthorized parties. Public applications, such as native desktop or JavaScript SPA applications, are unable to hold secrets securely.</span>
      </div>
    </form>
  </b-modal>
</template>

<script>
import ModalActions from '../../mixins/ModalActions.js'
export default {
  name: 'CreateClientModal',
  mixins: [
    ModalActions
  ],
  methods: {
    store(evt) {
      evt.preventDefault();

      this.createItem('/oauth/clients', this.formData, 'getClients')
    }
  }
};
</script>


<template>
  <b-modal
    id="create-role"
    title="Create Role"
  >
    <form>
      <div class="form-group">
        Name
        <input
          v-model="formData.name"
          type="text"
          class="form-control form-control-sm"
          :class="{ 'is-invalid': formErrors.name }"
          placeholder="Enter the roles name."
          required
          @keyup="formErrors.name = ''"
        >
        <div
          v-if="formErrors.name"
          class="invalid-feedback"
        >
          {{ formErrors.name[0] }}
        </div>
      </div>
      <div class="form-group">
        Guard Name
        <select
          v-model="formData.guard_name"
          class="form-control form-control-sm"
          :class="{ 'is-invalid': formErrors.guard_name }"
          required
          @change="formErrors.guard_name = ''"
        >
          <option
            value
            disabled
          >
            Choose a guard:
          </option>
          <option value="admin">
            Admin Guard
          </option>
          <option value="photographer">
            Photographer Guard
          </option>
          <option value="client">
            Client Guard
          </option>
        </select>
        <div
          v-if="formErrors.guard_name"
          class="invalid-feedback"
        >
          {{ formErrors.guard_name[0] }}
        </div>
      </div>
    </form>
    <div slot="modal-footer">
      <button
        class="btn btn-outline-secondary"
        @click.prevent="hideModal"
      >
        Cancel
      </button>
      <button
        class="btn btn-secondary"
        :disabled="isLoading"
        @click.prevent="submit"
      >
        <b-spinner
          v-if="isLoading"
          small
          type="grow"
        />
        {{ isLoading ? 'Loading...' : 'Submit' }}
      </button>
    </div>
  </b-modal>
</template>

<script>
import ToastMixin from "../../../mixins/ToastMixin.js";
export default {
  mixins: [ToastMixin],
  data() {
    return {
      formData: {
        guard_name: ""
      },
      formErrors: {},
      isLoading: false
    };
  },
  methods: {
    submit(event) {
      event.preventDefault();
      this.isLoading = true;

      axios
        .post("/api/roles", this.formData)
        .then(response => {
          this.isLoading = false;
          this.formData = {};
          this.hideModal();
          this.$root.$emit('getRoles')
          this.toast(
            "success",
            "Success!",
            "The role was created successfully!"
          );
        })
        .catch(error => {
          this.isLoading = false;
          this.formErrors = error.response.data.errors;
        });
    },
    hideModal() {
      this.$root.$emit("bv::hide::modal", "create-role");
    }
  }
};
</script>
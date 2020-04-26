<template>
  <b-modal
    :id="$options.name"
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
        @click.prevent="closeModal"
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
import ModalActions from "../../mixins/ModalActions.js";
export default {
  name: 'CreateRoleModal',
  mixins: [
    ModalActions
  ],
  data() {
    return {
      formData: {
        guard_name: ''
      }
    };
  },
  methods: {
    submit(event) {
      event.preventDefault();
      
      this.createItem('/api/roles', this.formData, 'getRoles')
    }
  }
};
</script>
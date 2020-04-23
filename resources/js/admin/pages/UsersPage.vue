<template>
  <div class="card shadow">
    <div class="card-header">
      Users {{ users.length }}
    </div>
    <div class="card-body p-5">
      <div class="row pb-3">
        <b-form-input
          type="text"
          class="form-control"
          v-model="filter"
          :debounce="400"
        />
      </div>
      <div class="row">
        <b-table
          small
          hover
          :items="users"
          :fields="fields"
          :filter="filter"
          :per-page="perPage"
          :current-page="currentPage"
          tbody-td-class="align-middle"
          responsive
        >
          <template #cell(id)="data">
            {{ data.item.id }}
          </template>

          <template #cell(roles)="data">
            {{ (data.item.roles.length ? data.item.roles[0].name : '----') | capitalize }}
          </template>

          <template #cell(email)="data">
            <a :href="'mailto:'+data.item.email">{{ data.item.email }}</a>
          </template>

          <template #cell(email_verified_at)="data">
            <div
              class="badge badge-success"
              v-if="data.item.email_verified_at"
            >
              {{ data.item.email_verified_at | moment('LLL') }}
            </div>
            <div
              class="badge badge-danger"
              v-if="!data.item.email_verified_at"
            >
              Not Verified
            </div>
          </template>

          <template #cell(created_at)="data">
            {{ data.item.created_at | moment('LLL') }}
          </template>

          <template>
            <b-dropdown
              id="roles-dropdown"
              no-caret
              dropright
              variant="white"
              class="m-md-2"
            >
              <template #button-content>
                <i class="fas fa-ellipsis-v" />
              </template>
              <b-dropdown-item>Edit User</b-dropdown-item>
              <b-dropdown-item>View User</b-dropdown-item>
              <b-dropdown-item>Delete User</b-dropdown-item>
            </b-dropdown>
          </template>
        </b-table>
      </div>
      <div class="row justify-content-center">
        <b-pagination
          v-model="currentPage"
          :total-rows="rows"
          :per-page="perPage"
          aria-controls="my-table"
        />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    users: {
      required: true,
      type: Array
    }
  },
  data() {
    return {
      filter: "",
      perPage: 25,
      currentPage: 1,
      fields: [
        {
          key: "id",
          sortable: true,
          tdClass: "align-middle"
        },
        {
          key: "roles",
          sortable: false,
          tdClass: "align-middle"
        },
        {
          key: "name",
          sortable: true,
          tdClass: "align-middle"
        },
        {
          key: "email",
          sortable: true,
          tdClass: "align-middle"
        },
        {
          key: "email_verified_at",
          sortable: true,
          tdClass: "align-middle"
        },
        {
          key: "created_at",
          sortable: true,
          tdClass: "align-middle"
        },
        {
          key: "actions",
          sortable: false,
          tdClass: "align-middle"
        },
        {
          key: "name",
          label: "Person age",
          sortable: true,
          variant: "danger"
        }
      ]
    };
  },
  computed: {
    rows() {
      return this.users.length
    }
  }
};
</script>
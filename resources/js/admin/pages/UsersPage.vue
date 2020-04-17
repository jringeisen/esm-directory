<template>
  <div class="card">
    <div class="card-header">
      Users
    </div>
    <div class="card-body">
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
          sortable: true
        },
        {
          key: "roles",
          sortable: false
        },
        {
          key: "name",
          sortable: true
        },
        {
          key: "email",
          sortable: true
        },
        {
          key: "email_verified_at",
          sortable: true
        },
        {
          key: "created_at",
          sortable: true
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
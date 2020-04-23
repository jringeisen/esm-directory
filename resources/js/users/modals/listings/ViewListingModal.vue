<template>
  <div>
    <b-modal
      :id="'view-'+listing.id"
      title="View Listing"
      size="lg"
      :hide-footer="true"
      no-stacking
    >
      <div class="d-flex flex-column align-items-center">
        <b-avatar
          :src="listing.avatar"
          variant="secondary"
          size="6rem"
        />
        <h3 class="p-3">
          {{ listing.business_name }}
        </h3>
      </div>
      <b-tabs
        content-class="mt-3"
        align="center"
        lazy
      >
        <b-tab title="Description">
          <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
        </b-tab>
        <b-tab title="Packages">
          <div class="list-group">
            <div v-if="!packages.length">
              <div class="card text-center">
                <div class="card-body">
                  <h5 class="card-title">
                    I have not added my packages yet.
                  </h5>
                  <p class="card-text">
                    If you would like to know my prices please push the button below to email me.
                  </p>
                  <a
                    href="mailto:support@essentialstudiomanager.com"
                    class="btn btn-secondary"
                  >Email Photographer</a>
                </div>
              </div>
            </div>
            <div
              v-for="(item, index) in packages"
              :key="index"
              class="list-group-item"
            >
              <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">
                  {{ item.name }}
                </h5>
                <small><span class="badge badge-success">{{ item.amount | currency }}</span></small>
              </div>
              <p class="mb-1">
                {{ item.description }}
              </p>
              <button
                v-if="user"
                v-b-modal="'edit-package-'+item.id"
                class="btn btn-sm btn-secondary"
                @click.prevent="setModalData(item)"
              >
                <i class="fa fa-edit" /> Edit
              </button>
              <button
                v-if="user"
                v-b-modal="'delete-package-'+item.id"
                class="btn btn-sm btn-danger"
                @click.prevent="setModalData(item)"
              >
                <i class="fa fa-trash" /> Delete
              </button>
            </div>
          </div>
        </b-tab>
        <b-tab title="Gallery">
          <b-container
            fluid
            class="p-4 bg-light"
          >
            <b-row class="mb-3">
              <b-col>
                <b-img
                  thumbnail
                  fluid
                  src="https://picsum.photos/250/250/?image=54"
                  alt="Image 1"
                />
              </b-col>
              <b-col>
                <b-img
                  thumbnail
                  fluid
                  src="https://picsum.photos/250/250/?image=58"
                  alt="Image 2"
                />
              </b-col>
              <b-col>
                <b-img
                  thumbnail
                  fluid
                  src="https://picsum.photos/250/250/?image=59"
                  alt="Image 3"
                />
              </b-col>
            </b-row>
            <b-row>
              <b-col>
                <b-img
                  thumbnail
                  fluid
                  src="https://picsum.photos/250/250/?image=54"
                  alt="Image 1"
                />
              </b-col>
              <b-col>
                <b-img
                  thumbnail
                  fluid
                  src="https://picsum.photos/250/250/?image=58"
                  alt="Image 2"
                />
              </b-col>
              <b-col>
                <b-img
                  thumbnail
                  fluid
                  src="https://picsum.photos/250/250/?image=59"
                  alt="Image 3"
                />
              </b-col>
            </b-row>
          </b-container>
        </b-tab>
        <b-tab title="Calendar">
          <full-calendar-app />
        </b-tab>
      </b-tabs>
    </b-modal>
    <edit-package-modal :item="investment" />
    <delete-package-modal :item="investment" />
  </div>
</template>

<script>
import EditPackageModal from '../packages/EditPackageModal.vue'
import DeletePackageModal from '../packages/DeletePackageModal.vue'
import FullCalendarApp from '../../components/FullCalendarApp.vue'
export default {
  components: {
    EditPackageModal,
    DeletePackageModal,
    FullCalendarApp
  },
  props: {
    listing: {
      required: true,
      type: Object
    },
    packages: {
      required: true,
      type: Array
    },
    user: {
      required: false,
      type: Object,
      default: null
    }
  },
  data () {
    return {
      investment: {}
    }
  },
  methods: {
    setModalData (item) {
      this.investment = item
    }
  }
}
</script>

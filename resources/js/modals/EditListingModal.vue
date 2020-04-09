<template>
    <b-modal @shown="shown" @ok="submit" :id="'edit-'+listing.id" :ref="'edit-'+listing.id+'-modal'" title="Edit Listing">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" v-model="formData.name"> 
        </div>
        <div class="form-group">
            <label for="business_name">Business Name</label>
            <input type="text" class="form-control" v-model="formData.business_name"> 
        </div>
        <div class="form-group">
            <label for="city">City</label>
            <input type="text" class="form-control" v-model="formData.city"> 
        </div>
        <div class="form-group">
            <label for="state">State</label>
            <input type="text" class="form-control" v-model="formData.state"> 
        </div>
        <div class="form-group">
            <label for="starting_package">Starting Package Price</label>
            <input type="number" class="form-control" v-model="formData.starting_package"> 
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" rows="4" v-model="formData.description"></textarea>
        </div>
        <div slot="modal-footer">
            <button class="btn btn-outline-secondary" @click.prevent="hideModal(listing.id)">Cancel</button>
            <button class="btn btn-secondary" :disabled="isLoading" @click.prevent="submit">
                <b-spinner v-if="isLoading" small type="grow"></b-spinner>
                {{ isLoading ? 'Loading...' : 'Submit'}}
            </button>
        </div>
    </b-modal>
</template>

<script>
export default {
    props: {
        listing: {
            required: true
        }
    },
    data () {
        return {
            listings: {},
            formData: {},
            isLoading: false
        }
    },
    methods: {
        shown () {
            this.formData = this.listing
        },
        submit () {
            this.isLoading = true
            axios.put(`/listings/${this.listing.id}`, this.formData).then((response) => {
                this.isLoading = false
                this.hideModal()
                this.toast('success', 'Success!', 'Your listing was deleted successfully!')
            })
        },
        hideModal (id) {
            this.$refs['edit-'+id+'-modal' ].hide()
        },
        toast (variant, title, body) {
            this.$bvToast.toast(body, {
                title: title,
                variant: variant,
                solid: true
            })
        }
    }
}
</script>


<template>
    <b-modal @shown="shown" @ok="submit" :id="'edit-'+listing.id" title="Edit Listing">
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
            formData: {}
        }
    },
    methods: {
        shown () {
            this.formData = this.listing
        },
        submit () {
            axios.put(`/listings/${this.listing.id}`, this.formData).then((response) => {
                console.log('success')
            }).catch((error) => {
                console.log('error')
            })
        }
    }
}
</script>


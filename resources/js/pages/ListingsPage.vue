<template>
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>Business Name</th>
                        <th>Location</th>
                        <th>Description</th>
                        <th>Starting Price</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(listing, index) in listings" :key="index">
                        <td class="align-middle"><b-avatar :src="listing.avatar"></b-avatar></td>
                        <td class="align-middle">{{ listing.business_name }}</td>
                        <td class="align-middle">{{ listing.city + ', ' + listing.state }}</td>
                        <td width="40%" class="align-middle">{{ listing.description | truncate(100) }}</td>
                        <td class="align-middle">{{ listing.starting_package | currency }}</td>
                        <td class="text-right align-middle">
                            <button class="btn btn-sm btn-secondary"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        listings: {
            require: true
        }
    }
}
</script>


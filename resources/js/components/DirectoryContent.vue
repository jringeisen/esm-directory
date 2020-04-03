<template>
    <div class="pt-5">
        <div class="row justify-content-center">
            <div class="col-md-10 pb-3">
                <b-form-input :v-model="formData" placeholder="Search for photographer....."></b-form-input>
            </div>
        </div>
        <div class="row justify-content-center pb-3">
            <div class="col-md-10">
                <b-card no-body :border-variant="getBorder()" class="overflow-hidden shadow" v-b-hover="handleHover" style="cursor:pointer">
                    <b-row no-gutters class="d-flex align-items-center">
                        <b-col md="2" class="d-flex justify-content-center">
                            <b-avatar variant="secondary" src="https://placekitten.com/300/300" :size="getSize()"></b-avatar>
                        </b-col>
                        <b-col md="10">
                            <b-card-body title="Jonathon Ringeisen">
                                <b-card-text size="10rem">
                                    I specialize in Rafting and Kayaking Photos on the Alberton Gorge Section of the Clark Fork River. Hopefully I will see you at the Fang Rapid! Please contact me if you have any questions.
                                </b-card-text>
                            </b-card-body>
                        </b-col>
                    </b-row>
                </b-card>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            formData: {},
            cardHovered: false
        }
    },
    methods: {
        handleHover () {
            this.cardHovered = !this.cardHovered
        },
        getSize () {
            if (this.cardHovered) {
                return '6rem'
            }
            return '5rem'
        },
        getBorder () {
            if (this.cardHovered) {
                return 'secondary'
            }
            return 'light'
        }
    }
}
</script>

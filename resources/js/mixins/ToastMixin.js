export default {
    methods: {
        toast (variant, title, body) {
            this.$bvToast.toast(body, {
                title: title,
                variant: variant,
                solid: true
            })
        }
    }
  };
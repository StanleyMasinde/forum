<template>
    <button class="btn btn-primary border-success" @click.prevent="update()">{{ verb }} <i class="fa fa-feed" aria-hidden="true"></i></button>
</template>

<script>
    export default {
        data() {
            return {
                // if verb is null in the template, the user is probably not logged in..
                verb: null
            }
        },
        props: {
            slug: null
        },
        methods: {
            update() {
                return axios.post('/forum/topics/' + this.slug + '/subscription').then((response) => {
                    this.getStatus();
                });
            },
            getStatus() {
                return axios.get('/forum/topics/' + this.slug + '/subscription/status').then((response) => {
                    if (response.data == 1) {
                        this.verb = 'Unfollow'
                    } else {
                        this.verb = 'Follow'
                    }
                });
            }
        },
        mounted() {
            this.getStatus();
        }
    }
</script>

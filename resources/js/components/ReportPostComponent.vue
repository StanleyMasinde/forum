<template>
    <div>
        <span v-if="reported" class="text-danger">Reported <i class="fa fa-flag-o" aria-hidden="true"></i></span>
        <a href="#" @click.prevent="report()" v-if="!reported && auth">Report <i class="fa fa-warning" aria-hidden="true"></i></a>
    </div>
</template>

<script>
    export default {
        data() {
            return {
               reported: false,
               auth: Forum.auth
            }
        },
        props: {
            topicSlug: null,
            postId: null
        },
        methods: {
            getStatus() {
                return axios.get('/forum/topics/' + this.topicSlug + '/posts/' + this.postId + '/report/status').then((response) => {
                    // type will only exist in returned JSON if a valid report for the given topic exists in the database
                    this.reported = ('type' in response.data) ? true : false;
                });
            },
            report() {
                return axios.post('/forum/topics/' + this.topicSlug + '/posts/' + this.postId + '/report').then((response) => {
                    this.getStatus();
                });
            }
        },
        mounted() {
            this.getStatus();
        }
    }
</script>

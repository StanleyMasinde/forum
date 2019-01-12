<template>
    <span>
        <button v-if="!deleted" @click.prevent="destroy(reportId)" class="btn btn-danger btn-sm"><i class="fa fa-remove" aria-hidden="true"></i> Delete report</button>
        <button v-if="deleted" class="btn btn-success sm" disabled="disabled"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Deleted report</button>
    </span>
</template>

<script>
    export default {
        data() {
            return {
                deleted: false
            }
        },
        props: {
            reportId: null
        },
        methods: {
            destroy(id) {
                this.deleted = true;
                return axios.delete('/moderator/dashboard/reports/' + id);
            }
        }
    }
</script>

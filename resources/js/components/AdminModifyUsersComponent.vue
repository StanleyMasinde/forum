<template>
  <div v-if="users.length">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Change user roles</div>
          <div class="card-body">
            <div v-if="modifySuccess" class="alert alert-success">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <strong>Yippee!</strong> The user's role has been updated!
            </div>
            <div class="form-group col-md-6" v-bind:class="(modifyError.user) ? 'has-error' : ''">
              <label for="user" class="control-label">Select user to modify</label>
              <select v-model="modifyUser.id" id="user" class="form-control">
                <option v-bind:value="null">Select a User</option>
                <option
                  v-for="user in users"
                  v-bind:key="user.id"
                  :value="user.id"
                >{{ user.id }} - {{ user.name }} - {{ user.role }}</option>
              </select>
              <template v-if="modifyError.user">
                <div class="help-block danger">Invalid user.</div>
              </template>
            </div>
            <div class="form-group col-md" v-bind:class="(modifyError.role) ? 'has-error' : ''">
              <label for="role" class="control-label">Select new role</label>
              <select v-model="modifyUser.role" name="role" id="role" class="form-control">
                <option v-bind:value="null">Select a Role</option>
                <option value="user">user</option>
                <option value="moderator">moderator</option>
                <option value="admin">admin</option>
              </select>
              <template v-if="modifyError.role">
                <div class="help-block danger">Invalid role.</div>
              </template>
            </div>
            <div class="col-md">
              <button
                @click.prevent="modifyUser()"
                v-bind:disabled="requestSent && !retrieved"
                class="btn btn-success btn-top-mar pull-right"
              >Modify User</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card header">Delete users</div>
          <div class="card-body">
            <button @click.prevent="order()" class="btn btn-default">
              <span
                v-bind:class="'glyphicon glyphicon-sort-by-attributes' + (orderBy === 'desc' ? '' : '-alt')"
              ></span>
              {{ (orderBy === 'asc' ? 'Newest' : 'Oldest') }}
            </button>
            <table class="table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>User</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(user, index) in users">
                  <td>{{ user.id }}</td>
                  <td>
                    <a v-bind:href="'/user/profile/@' + user.name">{{ user.name }}</a>
                  </td>
                  <td>{{ user.email }}</td>
                  <td>{{ user.role }}</td>
                  <td>
                    <a
                      href="#"
                      class="btn btn-danger btn-xs"
                      @click.prevent="destroy(index, user.name)"
                    >
                      <span class="glyphicon glyphicon-remove"></span> Delete
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      users: [],
      orderBy: "asc",

      // used in v-model with select element
      //modifyUser: {
      //    id: null,
      //    role: null
      //},

      // used to track errors in submission
      modifyError: {
        user: false,
        role: false
      },

      // used to display success message
      modifySuccess: false,

      // available roles
      roles: Forum.roles,

      // used to track status of requests for modification of User
      requestSent: false,
      retrieved: false
    };
  },
  props: {
    usersProp: null
  },
  methods: {
    modifyUser() {
      this.modifyError.user = false;
      this.modifyError.role = false;
      this.requestSent = true;

      return axios
        .post("/admin/dashboard/update", {
          user: this.modifyUser.id,
          role: this.modifyUser.role
        })
        .then(
          response => {
            for (var i = 0; i < this.users.length; i++) {
              // updating user's role in the users array
              this.users[i].id === this.modifyUser.id
                ? (this.users[i].role = this.modifyUser.role)
                : "";
            }

            this.modifySuccess = true;
            this.retrieved = true;
          },
          response => {
            // FormRequest returns appropriate validation response
            if (response.body.user) {
               this.modifyError.user = true;
            }
            if (response.body.role) {
               this.modifyError.role = true;
            }
            console.log(response);
            this.retrieved = true;
          }
        );

      this.requestSent = false;
      this.retrieved = false;
    },
    destroy(index, name) {
      this.users.splice(index, 1);
      return axios.delete("/admin/dashboard/users/" + name);
    },
    order() {
      this.users.reverse();
      this.orderBy = this.orderBy === "asc" ? "desc" : "asc";
    }
  },
  mounted() {
    this.users = JSON.parse(this.usersProp);
  }
};
</script>
